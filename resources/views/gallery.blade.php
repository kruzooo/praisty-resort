<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gallery | Praisty Resort</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..900&amp;family=Hanken+Grotesk:ital,wght@0,100..900;1,400..900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>tailwind.config={theme:{extend:{colors:{background:'#fbf9f4',surface:'#fbf9f4','surface-container-low':'#f5f3ee','surface-container-high':'#eae8e3','surface-container-highest':'#e4e2dd',primary:'#001e40','primary-container':'#003366','on-primary':'#ffffff','primary-fixed':'#d5e3ff','inverse-primary':'#a7c8ff','on-surface':'#1b1c19','on-surface-variant':'#43474f',outline:'#737780','outline-variant':'#c3c6d1','tertiary-fixed':'#ffdea5'},spacing:{'section-gap':'120px','margin-mobile':'20px','container-max':'1280px','margin-desktop':'64px'},fontFamily:{display:['EB Garamond','serif'],headline:['EB Garamond','serif'],body:['Hanken Grotesk','sans-serif']}}}};</script>
    <style>
        .masonry-grid { column-count: 1; column-gap: 24px; }
        @media (min-width: 768px) { .masonry-grid { column-count: 2; } }
        @media (min-width: 1024px) { .masonry-grid { column-count: 3; } }
        .masonry-item { break-inside: avoid; margin-bottom: 24px; }
        .gallery-filter { border-bottom: 1px solid transparent; padding-bottom: 5px; }
        .gallery-filter.active { border-color: currentColor; color: #001e40; }
        .gallery-image { transition: transform .6s cubic-bezier(.25,1,.5,1); }
        .gallery-card:hover .gallery-image { transform: scale(1.06); }
        .gallery-card:hover .gallery-overlay { opacity: 1; }
        .gallery-overlay { background: linear-gradient(to top,rgba(0,30,64,.86),transparent 60%); opacity: 0; transition: opacity .3s ease; }
        .gallery-item[hidden] { display: none; }
    </style>
</head>
<body class="overflow-x-hidden bg-background font-body text-on-surface antialiased">
<nav class="fixed top-0 z-50 w-full bg-surface/90 shadow-sm backdrop-blur-md" id="main-nav">
    <div class="mx-auto flex max-w-container-max items-center justify-between px-margin-mobile py-4 md:px-margin-desktop">
        <a class="font-headline text-[28px] tracking-widest text-primary uppercase" href="{{ route('home') }}">Praisty Resort</a>
        <div class="hidden items-center space-x-8 text-sm font-semibold tracking-wide md:flex">
            <a class="text-on-surface-variant hover:text-primary" href="{{ route('home') }}">Home</a><a class="text-on-surface-variant hover:text-primary" href="{{ route('rooms') }}">Rooms &amp; Villas</a><a class="text-on-surface-variant hover:text-primary" href="{{ route('experiences') }}">Experiences</a><a class="border-b border-primary pb-1 text-primary" href="{{ route('gallery') }}">Gallery</a><a class="text-on-surface-variant hover:text-primary" href="{{ route('contact') }}">Contact</a>
        </div>
        <a class="hidden rounded bg-primary-container px-6 py-3 text-sm font-semibold uppercase tracking-wide text-on-primary transition-transform hover:scale-105 md:inline-flex" href="{{ route('rooms') }}#room-search">Book Now</a>
        <button aria-controls="mobile-menu" aria-expanded="false" aria-label="Open navigation menu" class="p-2 text-primary md:hidden" id="mobile-menu-button" type="button"><span class="material-symbols-outlined">menu</span></button>
    </div>
    <div class="hidden border-t border-outline-variant bg-surface px-margin-mobile py-5 md:hidden" id="mobile-menu"><div class="flex flex-col gap-4 text-sm font-semibold text-primary"><a href="{{ route('home') }}">Home</a><a href="{{ route('rooms') }}">Rooms &amp; Villas</a><a href="{{ route('experiences') }}">Experiences</a><a href="{{ route('gallery') }}">Gallery</a><a href="{{ route('contact') }}">Contact</a></div></div>
</nav>

<header class="mx-auto max-w-container-max px-margin-mobile pb-14 pt-36 text-center md:px-margin-desktop md:pb-16 md:pt-44">
    <h1 class="mb-5 font-display text-5xl leading-none text-primary md:text-7xl">Visual Journey</h1>
    <p class="mx-auto max-w-2xl text-lg leading-7 text-on-surface-variant">Explore the raw beauty and refined luxury of Praisty Resort through moments of calm, celebration, and island discovery.</p>
</header>

<main class="mx-auto max-w-container-max px-margin-mobile pb-section-gap md:px-margin-desktop">
    <div class="mb-10 flex flex-wrap justify-center gap-x-7 gap-y-4 border-b border-surface-container-highest pb-4 text-sm font-semibold uppercase tracking-wider text-on-surface-variant md:mb-12 md:gap-x-10" role="tablist" aria-label="Gallery categories">
        <button class="gallery-filter active hover:text-primary" data-filter="all" type="button">All</button><button class="gallery-filter hover:text-primary" data-filter="rooms" type="button">Rooms</button><button class="gallery-filter hover:text-primary" data-filter="beach" type="button">Beach</button><button class="gallery-filter hover:text-primary" data-filter="dining" type="button">Dining</button><button class="gallery-filter hover:text-primary" data-filter="spa" type="button">Spa</button><button class="gallery-filter hover:text-primary" data-filter="activities" type="button">Activities</button>
    </div>
    @php
        $photos = [
            ['beach', 'Infinity Escape', 'images/gallery/gallery-27.png', 'Infinity pool framed by palms and the islands of El Nido', 'aspect-[4/3]'],
            ['activities', 'Island Passage', 'images/gallery/gallery-28.png', 'Private yacht cruising through clear Palawan waters', 'aspect-[3/4]'],
            ['rooms', 'Ocean Suite', 'images/gallery/gallery-29.png', 'Light-filled suite with an uninterrupted ocean view', 'aspect-square'],
            ['dining', 'Golden Hour Table', 'images/gallery/gallery-30.png', 'Fresh seafood and champagne overlooking the sea', 'aspect-[3/4]'],
            ['rooms', 'Overwater Sanctuary', 'images/resort/royal-overwater-bungalow.png', 'Overwater villa above a clear turquoise lagoon', 'aspect-[4/3]'],
            ['spa', 'A Quiet Ritual', 'images/resort/sanctuary-spa.png', 'Oceanfront spa ritual in a tranquil setting', 'aspect-[2/3]'],
            ['beach', 'Pristine Shores', 'images/resort/praisty-poolside-retreat.png', 'Praisty coastline with calm blue water', 'aspect-square'],
            ['dining', 'Tide Table', 'images/resort/tide-table-dining.png', 'Private dining experience beside the water', 'aspect-[16/9]'],
            ['rooms', 'Canopy Villa', 'images/resort/canopy-jungle-villa.png', 'Private jungle villa immersed in tropical greenery', 'aspect-[4/5]'],
            ['activities', 'Morning Wellness', 'images/resort/overwater-wellness-ritual.png', 'Wellness ritual above the blue lagoon', 'aspect-[3/2]'],
            ['spa', 'Restore & Renew', 'images/resort/praisty-wellness-spa.png', 'Spa moment with serene ocean surroundings', 'aspect-[4/5]'],
            ['dining', 'Sunset Celebration', 'images/resort/praisty-sunset-dining.png', 'Candlelit dinner at sunset by the shore', 'aspect-square'],
        ];
    @endphp
    <div class="masonry-grid" id="gallery-grid">
        @foreach ($photos as $index => [$category, $title, $image, $alt, $aspect])
            <button class="gallery-item masonry-item group block w-full text-left" data-category="{{ $category }}" type="button" aria-label="View {{ $title }}">
                <span class="gallery-card relative block overflow-hidden rounded-lg bg-surface-container-low shadow-[0_10px_30px_rgba(0,51,102,.05)]"><span class="{{ $aspect }} block overflow-hidden"><img class="gallery-image h-full w-full object-cover" src="{{ asset($image) }}" alt="{{ $alt }}" loading="{{ $index < 6 ? 'eager' : 'lazy' }}"></span><span class="gallery-overlay absolute inset-0 flex flex-col justify-end p-6 text-on-primary"><span class="mb-1 text-xs font-semibold uppercase tracking-wider text-tertiary-fixed">{{ $category }}</span><span class="font-headline text-2xl">{{ $title }}</span></span></span>
            </button>
        @endforeach
    </div>
    <div class="mt-12 text-center" id="load-more-wrap"><button class="border border-outline px-8 py-3 text-sm font-semibold text-primary transition-colors hover:bg-surface-container-high" id="load-more" type="button">Load More</button></div>
</main>

<div aria-hidden="true" aria-label="Gallery image preview" class="fixed inset-0 z-[60] hidden items-center justify-center bg-primary/90 p-5 backdrop-blur-sm" id="lightbox" role="dialog"><button aria-label="Close image preview" class="absolute right-5 top-5 text-4xl text-on-primary hover:opacity-70" id="lightbox-close" type="button">&times;</button><button aria-label="Previous image" class="absolute left-3 top-1/2 -translate-y-1/2 p-3 text-on-primary md:left-8" id="lightbox-previous" type="button"><span class="material-symbols-outlined text-4xl">chevron_left</span></button><figure class="max-h-full max-w-5xl"><img class="max-h-[78vh] w-auto max-w-full rounded-lg object-contain" id="lightbox-image" src="" alt=""><figcaption class="mt-4 text-center font-headline text-2xl text-on-primary" id="lightbox-caption"></figcaption></figure><button aria-label="Next image" class="absolute right-3 top-1/2 -translate-y-1/2 p-3 text-on-primary md:right-8" id="lightbox-next" type="button"><span class="material-symbols-outlined text-4xl">chevron_right</span></button></div>

<footer class="bg-primary py-12 text-on-primary"><div class="mx-auto flex max-w-container-max flex-col justify-between gap-5 px-margin-mobile md:flex-row md:items-end md:px-margin-desktop"><div><div class="mb-3 font-headline text-2xl tracking-widest">PRAISTY</div><p class="max-w-xs text-sm text-primary-fixed">A modern sanctuary where raw nature meets refined luxury.</p></div><p class="text-sm text-primary-fixed">&copy; {{ date('Y') }} Praisty Resort &amp; Spa. All rights reserved.</p></div></footer>
<script src="{{ asset('js/app.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const items = [...document.querySelectorAll('.gallery-item')], filters = [...document.querySelectorAll('.gallery-filter')], loadWrap = document.getElementById('load-more-wrap');
    let active = 'all', expanded = false;
    const refresh = () => { const matched = items.filter(i => active === 'all' || i.dataset.category === active); items.forEach(i => i.hidden = !matched.includes(i) || (!expanded && matched.indexOf(i) > 8)); loadWrap.hidden = matched.length <= 9 || expanded; };
    filters.forEach(button => button.addEventListener('click', () => { active = button.dataset.filter; expanded = active !== 'all'; filters.forEach(filter => filter.classList.toggle('active', filter === button)); refresh(); }));
    document.getElementById('load-more').addEventListener('click', () => { expanded = true; refresh(); }); refresh();
    const lightbox = document.getElementById('lightbox'), lightboxImage = document.getElementById('lightbox-image'), caption = document.getElementById('lightbox-caption'); let current = 0;
    const visible = () => items.filter(i => !i.hidden);
    const show = position => { const choices = visible(); current = (position + choices.length) % choices.length; const image = choices[current].querySelector('img'); lightboxImage.src = image.src; lightboxImage.alt = image.alt; caption.textContent = choices[current].querySelector('.font-headline').textContent; };
    const close = () => { lightbox.classList.add('hidden'); lightbox.classList.remove('flex'); lightbox.setAttribute('aria-hidden', 'true'); document.body.classList.remove('overflow-hidden'); };
    items.forEach(item => item.addEventListener('click', () => { current = visible().indexOf(item); show(current); lightbox.classList.remove('hidden'); lightbox.classList.add('flex'); lightbox.setAttribute('aria-hidden', 'false'); document.body.classList.add('overflow-hidden'); }));
    document.getElementById('lightbox-close').addEventListener('click', close); document.getElementById('lightbox-previous').addEventListener('click', () => show(current - 1)); document.getElementById('lightbox-next').addEventListener('click', () => show(current + 1)); lightbox.addEventListener('click', e => { if (e.target === lightbox) close(); }); document.addEventListener('keydown', e => { if (lightbox.classList.contains('hidden')) return; if (e.key === 'Escape') close(); if (e.key === 'ArrowLeft') show(current - 1); if (e.key === 'ArrowRight') show(current + 1); });
});
</script>
</body>
</html>
