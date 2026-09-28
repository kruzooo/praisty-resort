<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="noindex, nofollow" name="robots">
    <title>Guest Feedback | Praisty Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600&amp;family=Hanken+Grotesk:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <script>tailwind.config={theme:{extend:{colors:{primary:'#001e40','primary-container':'#003366',secondary:'#3b6934',surface:'#fbf9f4','surface-container':'#f0eee9','surface-container-low':'#f5f3ee','surface-container-high':'#eae8e3','surface-container-highest':'#e4e2dd','on-surface':'#1b1c19','on-surface-variant':'#43474f',error:'#ba1a1a'},fontFamily:{headline:['EB Garamond','serif'],body:['Hanken Grotesk','sans-serif']},spacing:{sidebar:'18rem'}}}}</script>
</head>
<body class="min-h-screen bg-surface font-body text-on-surface antialiased">
<div class="lg:pl-sidebar">
    <aside class="fixed inset-y-0 left-0 z-40 hidden w-sidebar flex-col justify-between bg-surface-container-low px-4 py-6 shadow-[1px_0_12px_rgba(0,30,64,0.03)] lg:flex">
        <div>
            <div class="mb-8 px-4">
                <div class="flex items-center gap-2"><span class="font-headline text-3xl tracking-wide text-primary">PRAISTY</span><span class="rounded bg-primary-container px-2 py-0.5 text-[11px] font-semibold uppercase tracking-wider text-white">Portal</span></div>
                <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-on-surface-variant">Luxury Operations ERP</p>
            </div>
            <nav class="space-y-1.5 text-sm font-semibold">
                @foreach ($nav as $item)
                    <a class="flex items-center gap-3 rounded-lg px-4 py-3 {{ $item['label'] === 'Guest Feedback' ? 'bg-primary-container text-white' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' }}" href="{{ $item['route'] }}"><span class="material-symbols-outlined">{{ $item['icon'] }}</span>{{ $item['label'] }}</a>
                @endforeach
            </nav>
        </div>
        <a class="rounded-lg bg-surface-container-high p-4 text-xs text-on-surface-variant hover:bg-surface-container-highest" href="{{ route('admin.dashboard') }}"><span class="font-semibold uppercase tracking-wider text-secondary">Back to dashboard</span><p class="mt-2 leading-5">Return to command central</p></a>
    </aside>
    <header class="sticky top-0 z-30 border-b border-surface-container-highest bg-surface/95 backdrop-blur">
        <div class="flex h-20 items-center justify-between gap-4 px-5 sm:px-8">
            <a class="inline-flex items-center gap-2 text-sm font-semibold text-primary" href="{{ route('admin.dashboard') }}"><span class="material-symbols-outlined">arrow_back</span>Dashboard</a>
            <div class="hidden text-right sm:block"><p class="text-xs font-semibold text-primary">{{ $admin->name }}</p><p class="text-xs text-on-surface-variant">Authorized administrator</p></div>
        </div>
    </header>
    <main class="space-y-8 px-5 py-8 sm:px-8">
        <section class="flex flex-col justify-between gap-5 xl:flex-row xl:items-end">
            <div>
                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-secondary"><span class="h-2 w-2 rounded-full bg-secondary"></span>Customer Voice</p>
                <h1 class="mt-3 font-headline text-4xl text-primary sm:text-5xl">Guest Feedback Inbox</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-on-surface-variant">Customer dashboard feedback and contact page inquiries appear here for admin review.</p>
            </div>
            <div class="rounded bg-white px-5 py-4 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Total Feedback</p><p class="font-headline text-3xl text-primary" data-feedback-count>{{ $feedbackEntries->count() }}</p></div>
        </section>
        @if (session('admin_status'))<div class="rounded border border-secondary/30 bg-green-50 px-4 py-3 text-sm font-semibold text-secondary" role="status">{{ session('admin_status') }}</div>@endif
        <section class="grid gap-4" data-feedback-list>
            @forelse ($feedbackEntries as $entry)
                <article class="rounded-lg bg-white p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="font-headline text-2xl text-primary">{{ $entry['name'] }}</h2>
                                @if ($entry['rating'])
                                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-secondary">{{ $entry['rating'] }}/5 rating</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800">Contact Inquiry</span>
                                @endif
                                <span class="rounded-full bg-surface-container-low px-3 py-1 text-xs font-semibold text-on-surface-variant">{{ $entry['type'] }}</span>
                            </div>
                            <p class="mt-1 text-xs text-on-surface-variant">{{ $entry['email'] }} · Reference: {{ $entry['reference'] }}</p>
                        </div>
                        <div class="flex items-center gap-3"><p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">{{ \Carbon\Carbon::parse($entry['created_at'])->format('M d, Y · h:i A') }}</p>@if ($entry['id'])<form action="{{ route('admin.feedback.delete', $entry['id']) }}" method="POST" onsubmit="return confirm('Delete this guest feedback?')">@csrf @method('DELETE')<button class="inline-flex items-center gap-1 rounded border border-red-200 px-2.5 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50" type="submit"><span class="material-symbols-outlined text-sm">delete</span>Delete</button></form>@endif</div>
                    </div>
                    <p class="mt-5 rounded-lg bg-surface-container-low p-4 text-sm leading-6 text-on-surface-variant">{{ $entry['message'] }}</p>
                </article>
            @empty
                <article class="rounded-lg bg-white p-10 text-center shadow-sm">
                    <span class="material-symbols-outlined text-5xl text-primary">reviews</span>
                    <h2 class="mt-3 font-headline text-3xl text-primary">No feedback yet</h2>
                    <p class="mt-2 text-sm text-on-surface-variant">Once customers submit feedback, it will appear here.</p>
                </article>
            @endforelse
        </section>
    </main>
</div>
<script src="{{ asset('js/admin-feedback.js') }}?v=202609281500"></script>
<script src="{{ asset('js/app.js') }}?v=202609280945"></script></body>
</html>

