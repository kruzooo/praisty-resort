<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page['title'] }} | Praisty Resort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>tailwind.config={theme:{extend:{colors:{primary:'#001e40',surface:'#fbf9f4','surface-container-low':'#f5f3ee','surface-container-highest':'#e4e2dd','on-surface':'#1b1c19','on-surface-variant':'#43474f',secondary:'#3b6934'},fontFamily:{headline:['EB Garamond','serif'],body:['Hanken Grotesk','sans-serif']}}}}</script>
</head>
<body class="min-h-screen bg-surface font-body text-on-surface antialiased">
    <header class="border-b border-surface-container-highest bg-surface">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-5 lg:px-10">
            <a class="font-headline text-2xl tracking-[0.16em] text-primary" href="{{ route('home') }}">PRAISTY RESORT</a>
            <nav class="hidden items-center gap-6 text-sm font-semibold text-on-surface-variant md:flex">
                <a class="hover:text-primary" href="{{ route('home') }}">Home</a>
                <a class="hover:text-primary" href="{{ route('rooms') }}">Rooms &amp; Villas</a>
                <a class="hover:text-primary" href="{{ route('experiences') }}">Experiences</a>
                <a class="hover:text-primary" href="{{ route('contact') }}">Contact</a>
            </nav>
            <a class="inline-flex items-center gap-2 rounded bg-primary px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary/90" href="{{ route('rooms') }}">Book now</a>
        </div>
    </header>
    <main class="mx-auto max-w-4xl px-5 py-16 lg:px-10 lg:py-24">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-secondary">{{ $page['eyebrow'] }}</p>
        <h1 class="mt-4 font-headline text-6xl leading-none text-primary">{{ $page['title'] }}</h1>
        <p class="mt-6 max-w-2xl text-lg leading-8 text-on-surface-variant">{{ $page['summary'] }}</p>
        <div class="mt-14 grid gap-8 border-t border-surface-container-highest pt-10">
            @foreach ($page['sections'] as $section)
                <section class="max-w-3xl">
                    <h2 class="font-headline text-3xl text-primary">{{ $section['title'] }}</h2>
                    <p class="mt-3 leading-7 text-on-surface-variant">{{ $section['body'] }}</p>
                </section>
            @endforeach
        </div>
        <a class="mt-14 inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-wider text-primary underline underline-offset-4 hover:text-secondary" href="{{ route('contact') }}">Contact the concierge <span aria-hidden="true">→</span></a>
    </main>
    <footer class="bg-primary py-8 text-center text-sm text-white">
        <p>© {{ date('Y') }} Praisty Resort &amp; Spa. All rights reserved.</p>
    </footer>
</body>
</html>

