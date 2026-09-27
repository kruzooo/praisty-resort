<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="noindex, nofollow" name="robots">
    <title>{{ $page['title'] }} | Praisty Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600&amp;family=Hanken+Grotesk:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <script>tailwind.config={theme:{extend:{colors:{primary:'#001e40','primary-container':'#003366',secondary:'#3b6934','secondary-fixed':'#bcf0ae',surface:'#fbf9f4','surface-container':'#f0eee9','surface-container-low':'#f5f3ee','surface-container-high':'#eae8e3','surface-container-highest':'#e4e2dd','on-surface':'#1b1c19','on-surface-variant':'#43474f',outline:'#737780',error:'#ba1a1a'},fontFamily:{headline:['EB Garamond','serif'],body:['Hanken Grotesk','sans-serif']},spacing:{sidebar:'18rem'}}}}</script>
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
                    <a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-on-surface" href="{{ $item['route'] }}"><span class="material-symbols-outlined">{{ $item['icon'] }}</span>{{ $item['label'] }}</a>
                @endforeach
            </nav>
        </div>
        <a class="rounded-lg bg-surface-container-high p-4 text-xs text-on-surface-variant hover:bg-surface-container-highest" href="{{ route('admin.dashboard') }}"><span class="font-semibold uppercase tracking-wider text-secondary">Back to dashboard</span><p class="mt-2 leading-5">Return to command central</p></a>
    </aside>
    <header class="sticky top-0 z-30 border-b border-surface-container-highest bg-surface/95 backdrop-blur">
        <div class="flex h-20 items-center justify-between gap-4 px-5 sm:px-8">
            <a class="inline-flex items-center gap-2 text-sm font-semibold text-primary" href="{{ route('admin.dashboard') }}"><span class="material-symbols-outlined">arrow_back</span>Dashboard</a>
            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block"><p class="text-xs font-semibold text-primary">{{ $admin->name }}</p><p class="text-xs text-on-surface-variant">Authorized administrator</p></div>
                <form action="{{ route('admin.logout') }}" method="POST">@csrf<button class="rounded border border-primary px-3 py-2 text-xs font-semibold text-primary hover:bg-surface-container" type="submit">Sign out</button></form>
            </div>
        </div>
    </header>
    <main class="space-y-8 px-5 py-8 sm:px-8">
        <section class="flex flex-col justify-between gap-5 xl:flex-row xl:items-end">
            <div>
                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-secondary"><span class="h-2 w-2 rounded-full bg-secondary"></span>{{ $page['eyebrow'] }}</p>
                <h1 class="mt-3 font-headline text-4xl text-primary sm:text-5xl">{{ $page['title'] }}</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-on-surface-variant">{{ $page['summary'] }}</p>
            </div>
            @if (! empty($page['actions']))
                <div class="flex flex-wrap gap-2">
                    @foreach ($page['actions'] as $action)
                        <a class="inline-flex items-center gap-2 rounded bg-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-container" href="{{ $action['route'] }}"><span class="material-symbols-outlined text-lg">{{ $action['icon'] }}</span>{{ $action['label'] }}</a>
                    @endforeach
                </div>
            @endif
        </section>
        <section class="grid gap-4 md:grid-cols-3">
            @foreach ($page['stats'] as $stat)
                <article class="rounded-lg bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">{{ $stat['label'] }}</p>
                    <p class="mt-3 font-headline text-3xl text-primary">{{ $stat['value'] }}</p>
                    <span class="mt-4 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $stat['tone'] }}">Live admin metric</span>
                </article>
            @endforeach
        </section>
        <section class="rounded-lg bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[760px] w-full text-left text-sm">
                    <thead class="bg-surface-container-low text-xs uppercase tracking-wider text-on-surface-variant">
                        <tr><th class="rounded-l px-4 py-3">Item</th><th class="px-4 py-3">Details</th><th class="px-4 py-3">Status</th><th class="rounded-r px-4 py-3">Admin Note</th></tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-highest">
                        @foreach ($page['rows'] as $row)
                            @php($tone = $row['status'] === 'Cancelled' ? 'bg-red-50 text-error' : ($row['status'] === 'Successfully Booked' || $row['status'] === 'Ready' ? 'bg-green-50 text-secondary' : 'bg-amber-50 text-amber-800'))
                            <tr>
                                <td class="px-4 py-4"><strong class="text-primary">{{ $row['title'] }}</strong></td>
                                <td class="px-4 py-4 text-on-surface-variant">{{ $row['meta'] }}</td>
                                <td class="px-4 py-4"><span class="rounded-full px-3 py-1 text-xs font-semibold {{ $tone }}">{{ $row['status'] }}</span></td>
                                <td class="px-4 py-4 text-on-surface-variant">{{ $row['note'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
</body>
</html>
