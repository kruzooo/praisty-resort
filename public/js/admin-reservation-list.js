document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-admin-reservations]');
    const tableBody = section?.querySelector('tbody');

    if (!section || !tableBody || !window.location.hostname.endsWith('.vercel.app')) {
        return;
    }

    const code = '053008';
    const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (character) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;',
    }[character]));
    const roomName = (reservation) => reservation.room_name || String(reservation.room_slug || 'Selected accommodation')
        .replace(/[-_]+/g, ' ')
        .replace(/\b\w/g, (letter) => letter.toUpperCase());
    const formatDate = (value) => {
        if (!value) return 'Dates pending';
        const text = String(value);
        const date = new Date(text.length > 10 ? text : `${text}T00:00:00`);
        return Number.isNaN(date.getTime())
            ? 'Dates pending'
            : new Intl.DateTimeFormat('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }).format(date);
    };
    const statusStyle = {
        processing: 'bg-amber-50 text-amber-800',
        booked: 'bg-green-50 text-secondary',
        cancelled: 'bg-red-50 text-error',
    };

    const render = (reservations) => {
        tableBody.innerHTML = reservations.length ? reservations.map((reservation) => {
            const status = statusStyle[reservation.status] ? reservation.status : 'processing';
            return `<tr class="live-reservation-row" data-reservation-id="${escapeHtml(reservation.id)}">
                <td class="px-4 py-4"><strong class="text-primary">${escapeHtml(reservation.guest_name)}</strong><p class="mt-1 text-xs text-on-surface-variant">${escapeHtml(reservation.guest_email)}</p></td>
                <td class="px-4 py-4 text-on-surface-variant">${escapeHtml(roomName(reservation))}</td>
                <td class="px-4 py-4 text-on-surface-variant">${escapeHtml(formatDate(reservation.check_in))} - ${escapeHtml(formatDate(reservation.check_out))}<p class="mt-1 text-xs">${escapeHtml(reservation.guests || 1)} guest${Number(reservation.guests || 1) === 1 ? '' : 's'}</p></td>
                <td class="px-4 py-4"><span class="rounded-full px-3 py-1 text-xs font-semibold ${statusStyle[status]}">${status === 'booked' ? 'Successfully Booked' : status === 'cancelled' ? 'Cancelled' : 'Processing'}</span><p class="mt-2 text-xs text-on-surface-variant">Live database</p></td>
            </tr>`;
        }).join('') : '<tr><td class="px-4 py-8 text-center text-sm text-on-surface-variant" colspan="4">No live reservations yet.</td></tr>';
    };

    const load = async () => {
        try {
            const response = await fetch(`/api/reservations?code=${encodeURIComponent(code)}&t=${Date.now()}`, { headers: { Accept: 'application/json', 'x-admin-code': code }, cache: 'no-store' });
            if (!response.ok) throw new Error('Reservation feed unavailable');
            const data = await response.json();
            render(data.reservations || []);
        } catch {
            tableBody.innerHTML = '<tr><td class="px-4 py-8 text-center text-sm text-error" colspan="4">Live reservations are temporarily unavailable. Refresh to try again.</td></tr>';
        }
    };

    load();
    window.setInterval(load, 2000);
    window.addEventListener('focus', load);
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') load();
    });
});
