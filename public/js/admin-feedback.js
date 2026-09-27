document.addEventListener('DOMContentLoaded', () => {
    const list = document.querySelector('[data-feedback-list]');
    const count = document.querySelector('[data-feedback-count]');

    if (!list || !window.location.hostname.endsWith('.vercel.app')) {
        return;
    }

    const code = '053008';
    const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (character) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;',
    }[character]));
    const emptyState = '<article class="rounded-lg bg-white p-10 text-center shadow-sm"><span class="material-symbols-outlined text-5xl text-primary">reviews</span><h2 class="mt-3 font-headline text-3xl text-primary">No guest reports yet</h2><p class="mt-2 text-sm text-on-surface-variant">Feedback and concierge inquiries will appear here.</p></article>';
    const render = (feedback, reports) => {
        const entries = [
            ...feedback.map((entry) => ({ ...entry, type: 'Guest Feedback', isFeedback: true })),
            ...reports.map((entry) => ({ ...entry, type: 'Contact Report', isFeedback: false })),
        ].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        if (count) count.textContent = entries.length;
        list.innerHTML = entries.length ? entries.map((entry) => `<article class="rounded-lg bg-white p-6 shadow-sm" data-feedback-id="${entry.isFeedback ? escapeHtml(entry.id) : ''}">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start"><div><div class="flex flex-wrap items-center gap-3"><h2 class="font-headline text-2xl text-primary">${escapeHtml(entry.name)}</h2><span class="rounded-full ${entry.isFeedback ? 'bg-green-50 text-secondary' : 'bg-amber-50 text-amber-800'} px-3 py-1 text-xs font-semibold">${entry.isFeedback ? `${escapeHtml(entry.rating)}/5 rating` : 'Contact report'}</span><span class="rounded-full bg-surface-container-low px-3 py-1 text-xs font-semibold text-on-surface-variant">${entry.type}</span></div><p class="mt-1 text-xs text-on-surface-variant">${escapeHtml(entry.email)} · Live database</p></div><div class="flex items-center gap-3"><p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">${new Date(entry.created_at).toLocaleString()}</p>${entry.isFeedback ? `<button class="inline-flex items-center gap-1 rounded border border-red-200 px-2.5 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50" data-delete-feedback="${escapeHtml(entry.id)}" type="button"><span class="material-symbols-outlined text-sm">delete</span>Delete</button>` : ''}</div></div>
            <p class="mt-5 rounded-lg bg-surface-container-low p-4 text-sm leading-6 text-on-surface-variant">${escapeHtml(entry.message)}</p></article>`).join('') : emptyState;
        list.querySelectorAll('[data-delete-feedback]').forEach((button) => button.addEventListener('click', async () => {
            if (!window.confirm('Delete this guest feedback?')) return;
            button.disabled = true;
            const response = await fetch(`/api/feedback?id=${encodeURIComponent(button.dataset.deleteFeedback)}&code=${code}`, { method: 'DELETE', headers: { Accept: 'application/json', 'x-admin-code': code } });
            if (response.ok) load(); else { button.disabled = false; window.alert('The feedback could not be deleted.'); }
        }));
    };
    const load = async () => {
        try {
            const headers = { Accept: 'application/json', 'x-admin-code': code };
            const [feedbackResponse, reportsResponse] = await Promise.all([
                fetch(`/api/feedback?code=${code}`, { headers, cache: 'no-store' }),
                fetch(`/api/contact?code=${code}`, { headers, cache: 'no-store' }),
            ]);
            if (!feedbackResponse.ok || !reportsResponse.ok) throw new Error('Admin reports unavailable');
            const [feedbackData, reportsData] = await Promise.all([feedbackResponse.json(), reportsResponse.json()]);
            render(feedbackData.feedback || [], reportsData.messages || []);
        } catch {
            list.innerHTML = '<article class="rounded-lg bg-white p-10 text-center shadow-sm"><span class="material-symbols-outlined text-5xl text-error">error</span><h2 class="mt-3 font-headline text-3xl text-primary">Reports are unavailable</h2><p class="mt-2 text-sm text-on-surface-variant">Refresh the page to reconnect to the live database.</p></article>';
            if (count) count.textContent = '0';
        }
    };
    load();
    window.setInterval(load, 10000);
});
