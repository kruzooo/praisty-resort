document.addEventListener('DOMContentLoaded', () => {
    const board = document.getElementById('booking-status');
    const tableBody = board?.querySelector('tbody');

    if (!board || !tableBody) {
        return;
    }

    const isStaticVercel = window.location.hostname.endsWith('.vercel.app');
    const adminCode = '053008';
    const styles = {
        processing: { label: 'Processing', badge: 'bg-amber-50 text-amber-800', active: 'bg-amber-100 text-amber-900 shadow-sm' },
        booked: { label: 'Successfully Booked', badge: 'bg-green-50 text-secondary', active: 'bg-green-100 text-secondary shadow-sm' },
        cancelled: { label: 'Cancelled', badge: 'bg-red-50 text-error', active: 'bg-red-100 text-error shadow-sm' },
    };
    const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (character) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;',
    }[character]));
    const roomName = (reservation) => reservation.room_name || String(reservation.room_slug || 'Selected accommodation')
        .replace(/[-_]+/g, ' ')
        .replace(/\b\w/g, (letter) => letter.toUpperCase());
    const stayDates = (reservation) => {
        const format = (date) => date ? new Intl.DateTimeFormat('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }).format(new Date(`${date}T00:00:00`)) : 'Dates pending';
        return `${format(reservation.check_in)} - ${format(reservation.check_out)}`;
    };
    const updatedAt = (reservation) => reservation.created_at
        ? `Received ${new Intl.DateTimeFormat('en-PH', { month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit' }).format(new Date(reservation.created_at))}`
        : 'Awaiting review';
    const csrfToken = document.querySelector('input[name="_token"]')?.value || '';

    const refreshCounts = (reservations) => {
        const totals = { processing: 0, booked: 0, cancelled: 0 };
        reservations.forEach((reservation) => {
            totals[reservation.status] = (totals[reservation.status] || 0) + 1;
        });
        Object.entries(totals).forEach(([status, count]) => {
            const element = board.querySelector(`[data-status-count="${status}"]`);
            if (element) element.textContent = count;
        });
    };

    const render = (reservations) => {
        refreshCounts(reservations);
        tableBody.innerHTML = reservations.length ? reservations.map((reservation) => {
            const status = styles[reservation.status] ? reservation.status : 'processing';
            const config = styles[status];
            return `<tr class="booking-row" data-booking-id="${reservation.id}" data-status="${status}">
                <td class="px-4 py-4"><strong class="text-primary">${escapeHtml(reservation.guest_name)}</strong><p class="mt-1 text-xs text-on-surface-variant">${escapeHtml(reservation.guest_email)}</p></td>
                <td class="px-4 py-4">${escapeHtml(roomName(reservation))}<p class="mt-1 text-xs text-on-surface-variant">${escapeHtml(reservation.guests || 1)} guest${Number(reservation.guests || 1) === 1 ? '' : 's'}</p></td>
                <td class="px-4 py-4">${escapeHtml(stayDates(reservation))}</td>
                <td class="px-4 py-4"><div class="status-picker inline-grid grid-cols-3 overflow-hidden rounded-lg border border-surface-container-highest bg-surface-container-low p-1 text-xs font-semibold">
                    ${Object.entries(styles).map(([value, option]) => `<button class="status-choice rounded px-3 py-2 transition ${value === status ? option.active : 'text-on-surface-variant hover:bg-white'}" data-status-choice="${value}" type="button" aria-pressed="${value === status}">${value === 'cancelled' ? 'Cancel' : value === 'booked' ? 'Booked' : 'Processing'}</button>`).join('')}
                </div></td>
                <td class="px-4 py-4"><span class="booking-status-label rounded-full px-3 py-1 text-xs font-semibold ${config.badge}">${config.label}</span><p class="booking-updated mt-1 text-xs text-on-surface-variant">${escapeHtml(updatedAt(reservation))}</p></td>
            </tr>`;
        }).join('') : '<tr><td class="px-4 py-8 text-center text-sm text-on-surface-variant" colspan="5">No live reservations yet.</td></tr>';

        tableBody.querySelectorAll('.status-choice').forEach((button) => {
            button.addEventListener('click', async () => {
                const row = button.closest('.booking-row');
                if (!row) return;
                const status = button.dataset.statusChoice;
                button.disabled = true;
                try {
                    const path = isStaticVercel
                        ? `/api/reservations?code=${encodeURIComponent(adminCode)}`
                        : `/admin/reservations/${encodeURIComponent(row.dataset.bookingId)}/status`;
                    const headers = { Accept: 'application/json', 'Content-Type': 'application/json' };
                    if (isStaticVercel) headers['x-admin-code'] = adminCode;
                    if (!isStaticVercel && csrfToken) headers['X-CSRF-TOKEN'] = csrfToken;
                    const response = await fetch(path, {
                        method: isStaticVercel ? 'PATCH' : 'PATCH',
                        headers,
                        body: JSON.stringify(isStaticVercel ? { id: Number(row.dataset.bookingId), status } : { status }),
                    });
                    if (!response.ok) throw new Error('Status update failed.');
                    await loadReservations();
                } catch {
                    button.disabled = false;
                    window.alert('The reservation status could not be updated. Please try again.');
                }
            });
        });
    };

    const loadReservations = async () => {
        try {
            const path = isStaticVercel ? `/api/reservations?code=${encodeURIComponent(adminCode)}` : '/admin/reservations/feed';
            const headers = { Accept: 'application/json' };
            if (isStaticVercel) headers['x-admin-code'] = adminCode;
            const response = await fetch(path, { headers });
            if (!response.ok) throw new Error('Reservation feed failed.');
            const data = await response.json();
            render(data.reservations || []);
        } catch {
            tableBody.innerHTML = '<tr><td class="px-4 py-8 text-center text-sm text-error" colspan="5">Reservations are temporarily unavailable. Refresh to try again.</td></tr>';
        }
    };

    loadReservations();
    if (isStaticVercel) window.setInterval(loadReservations, 10000);
});
