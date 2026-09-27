<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <title>{{ $room['name'] }} | Praisty Resort</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..900&amp;family=Hanken+Grotesk:ital,wght@0,100..900;1,400..900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>tailwind.config={theme:{extend:{colors:{background:'#fbf9f4',surface:'#fbf9f4','surface-container-low':'#f5f3ee','surface-container-high':'#eae8e3','surface-container-highest':'#e4e2dd',primary:'#001e40','primary-container':'#003366','on-primary':'#ffffff','primary-fixed':'#d5e3ff','inverse-primary':'#a7c8ff',secondary:'#3b6934','secondary-container':'#b9eeab','on-secondary-container':'#3f6d38','on-surface':'#1b1c19','on-surface-variant':'#43474f',outline:'#737780','outline-variant':'#c3c6d1'},spacing:{'section-gap':'120px','margin-mobile':'20px','container-max':'1280px','margin-desktop':'64px'},fontFamily:{display:['EB Garamond','serif'],headline:['EB Garamond','serif'],body:['Hanken Grotesk','sans-serif']}}}};</script>
</head>
<body class="overflow-x-hidden bg-background font-body text-on-surface antialiased">
<nav class="fixed top-0 z-50 w-full bg-surface/90 shadow-sm backdrop-blur-md" id="main-nav">
    <div class="mx-auto flex max-w-container-max items-center justify-between px-margin-mobile py-4 md:px-margin-desktop">
        <a class="font-headline text-[28px] tracking-widest text-primary uppercase" href="{{ route('home') }}">Praisty Resort</a>
        <div class="hidden items-center space-x-8 text-sm font-semibold tracking-wide md:flex"><a class="text-on-surface-variant hover:text-primary" href="{{ route('home') }}">Home</a><a class="border-b border-primary pb-1 text-primary" href="{{ route('rooms') }}">Rooms &amp; Villas</a><a class="text-on-surface-variant hover:text-primary" href="{{ route('experiences') }}">Experiences</a><a class="text-on-surface-variant hover:text-primary" href="{{ route('gallery') }}">Gallery</a><a class="text-on-surface-variant hover:text-primary" href="{{ route('contact') }}">Contact</a></div>
        <a class="hidden rounded bg-primary-container px-6 py-3 text-sm font-semibold uppercase tracking-wide text-on-primary transition-transform hover:scale-105 md:inline-flex" href="{{ route('rooms') }}#room-search">Book Now</a>
        <button aria-controls="mobile-menu" aria-expanded="false" aria-label="Open navigation menu" class="p-2 text-primary md:hidden" id="mobile-menu-button" type="button"><span class="material-symbols-outlined">menu</span></button>
    </div>
    <div class="hidden border-t border-outline-variant bg-surface px-margin-mobile py-5 md:hidden" id="mobile-menu"><div class="flex flex-col gap-4 text-sm font-semibold text-primary"><a href="{{ route('home') }}">Home</a><a href="{{ route('rooms') }}">Rooms &amp; Villas</a><a href="{{ route('experiences') }}">Experiences</a><a href="{{ route('gallery') }}">Gallery</a><a href="{{ route('contact') }}">Contact</a></div></div>
</nav>

@php
    $description = match ($room['category']) {
        'suite' => 'A light-filled retreat designed for slow mornings and unhurried evenings. Natural textures, thoughtful comforts, and a private outlook create a serene place to settle in.',
        'pavilion' => 'Set above the luminous lagoon, this private hideaway brings you close to the water while preserving the quiet and comfort of a true island sanctuary.',
        default => 'A refined island residence where indoor comfort opens naturally onto tropical scenery. Every detail is made for restorative days, private moments, and effortless coastal living.',
    };
    $galleryImages = [
        [$room['image'], $room['alt']],
        ['images/resort/canopy-sun-lounge.png', 'A relaxed sun lounge surrounded by tropical scenery'],
        ['images/resort/praisty-coastal-lounge.png', 'Praisty Resort coastal lounge by the water'],
    ];
    $amenities = [
        ['wifi', 'High-Speed WiFi'],
        [$room['featureIcon'], $room['feature']],
        ['room_service', '24/7 Butler Service'],
        ['spa', 'Spa Access'],
        ['wine_bar', 'Premium Mini Bar'],
        ['restaurant_menu', 'In-Villa Dining'],
    ];
@endphp

<main class="mx-auto max-w-container-max px-margin-mobile pb-section-gap pt-28 md:px-margin-desktop md:pt-32">
    <nav aria-label="Breadcrumb" class="mb-6 flex items-center gap-2 text-sm text-on-surface-variant"><a class="hover:text-primary" href="{{ route('rooms') }}">Rooms &amp; Villas</a><span class="material-symbols-outlined text-base">chevron_right</span><span class="text-primary">{{ $room['name'] }}</span></nav>

    <section class="mb-16 grid h-auto grid-cols-1 gap-4 md:h-[600px] md:grid-cols-4">
        <button class="room-gallery-button group relative overflow-hidden rounded-lg md:col-span-3" data-image="{{ asset($galleryImages[0][0]) }}" data-alt="{{ $galleryImages[0][1] }}" type="button"><img class="h-[360px] w-full object-cover transition-transform duration-700 group-hover:scale-105 md:h-full" src="{{ asset($galleryImages[0][0]) }}" alt="{{ $galleryImages[0][1] }}"><span class="absolute bottom-5 left-5 rounded bg-primary/80 px-4 py-2 text-sm font-semibold text-on-primary backdrop-blur">{{ $room['type'] }}</span></button>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-1">
            @foreach (array_slice($galleryImages, 1) as [$image, $alt])
                <button class="room-gallery-button group relative overflow-hidden rounded-lg" data-image="{{ asset($image) }}" data-alt="{{ $alt }}" type="button"><img class="h-44 w-full object-cover transition-transform duration-700 group-hover:scale-105 md:h-full" src="{{ asset($image) }}" alt="{{ $alt }}"></button>
            @endforeach
        </div>
    </section>

    <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
        <section class="lg:col-span-8">
            <div class="mb-5 flex flex-wrap items-start justify-between gap-5"><div><p class="mb-3 text-sm font-semibold uppercase tracking-widest text-secondary">{{ $room['type'] }}</p><h1 class="font-display text-5xl leading-none text-primary md:text-7xl">{{ $room['name'] }}</h1></div><div class="flex items-center rounded-full border border-outline-variant/40 bg-surface-container-low px-3 py-1.5 text-primary"><span class="material-symbols-outlined text-amber-600">star</span><span class="ml-1 text-sm font-semibold">5.0</span></div></div>
            <p class="max-w-3xl text-lg leading-8 text-on-surface-variant">{{ $description }}</p>

            <div class="my-10 flex flex-wrap gap-3 border-y border-surface-container-highest py-8 text-primary"><span class="flex items-center gap-2 bg-surface-container-high px-4 py-2 text-sm font-semibold"><span class="material-symbols-outlined text-xl">straighten</span>{{ $room['size'] }}</span><span class="flex items-center gap-2 bg-surface-container-high px-4 py-2 text-sm font-semibold"><span class="material-symbols-outlined text-xl">group</span>Up to {{ $room['capacity'] }} Guests</span><span class="flex items-center gap-2 bg-surface-container-high px-4 py-2 text-sm font-semibold"><span class="material-symbols-outlined text-xl">king_bed</span>{{ $room['bed'] }}</span></div>

            <h2 class="mb-6 font-headline text-3xl text-primary">Premium Amenities</h2>
            <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2 md:grid-cols-3">@foreach ($amenities as [$icon, $label])<div class="flex items-center gap-3 text-on-surface-variant"><span class="flex h-10 w-10 items-center justify-center rounded-full bg-surface-container-low text-primary"><span class="material-symbols-outlined">{{ $icon }}</span></span><span>{{ $label }}</span></div>@endforeach</div>
        </section>

        <aside class="lg:col-span-4" id="reservation">
            <div class="sticky top-28 rounded-xl border border-surface-container-highest bg-white p-6 shadow-[0_20px_40px_-15px_rgba(0,30,64,.1)] md:p-8">
                <div class="mb-6"><span class="font-headline text-3xl text-primary">{{ $room['price'] }}</span><span class="text-on-surface-variant"> / night</span></div>
                @if (session('reservation_status'))<div class="mb-5 rounded-lg border border-secondary/30 bg-secondary-container/40 px-4 py-3 text-sm text-on-secondary-container" role="status">{{ session('reservation_status') }}</div>@endif
                @if ($errors->any())<div class="mb-5 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-800"><p class="font-semibold">Please check your booking details.</p><ul class="mt-1 list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <form action="{{ route('rooms.reserve', ['room' => \Illuminate\Support\Str::slug($room['name'])]) }}" class="space-y-4" method="POST">@csrf
                    <div class="grid grid-cols-2 overflow-hidden rounded-lg border border-outline-variant"><label class="border-r border-outline-variant p-3 text-xs font-semibold uppercase tracking-wide text-on-surface-variant">Check-in<input class="mt-2 block w-full border-0 bg-transparent p-0 text-sm normal-case text-primary focus:ring-0" id="check_in" min="{{ now()->toDateString() }}" name="check_in" required type="date" value="{{ old('check_in') }}"></label><label class="p-3 text-xs font-semibold uppercase tracking-wide text-on-surface-variant">Check-out<input class="mt-2 block w-full border-0 bg-transparent p-0 text-sm normal-case text-primary focus:ring-0" id="check_out" min="{{ now()->addDay()->toDateString() }}" name="check_out" required type="date" value="{{ old('check_out') }}"></label><label class="col-span-2 border-t border-outline-variant p-3 text-xs font-semibold uppercase tracking-wide text-on-surface-variant">Guests<select class="mt-2 block w-full border-0 bg-transparent p-0 text-sm normal-case text-primary focus:ring-0" id="guests" name="guests">@for ($guest = 1; $guest <= $room['capacity']; $guest++)<option @selected((int) old('guests', 2) === $guest) value="{{ $guest }}">{{ $guest }} {{ $guest === 1 ? 'Guest' : 'Guests' }}</option>@endfor</select></label></div>
                    <button class="w-full rounded bg-primary-container py-4 text-sm font-semibold uppercase tracking-wide text-on-primary transition-all hover:scale-[1.02] hover:bg-secondary" type="submit">Reserve Now</button>
                </form>
                <p class="my-4 text-center text-sm text-on-surface-variant">You won't be charged yet.</p>
                <div class="space-y-3 border-t border-surface-container-highest pt-4 text-sm text-on-surface-variant"><div class="flex justify-between"><span id="nights-label">Select your dates</span><span id="room-rate" data-rate="{{ $room['priceValue'] }}">{{ $room['price'] }}</span></div><div class="flex justify-between"><span>Resort fee</span><span id="resort-fee">₱0</span></div><div class="flex justify-between"><span>Taxes</span><span id="taxes">₱0</span></div><div class="flex justify-between border-t border-surface-container-highest pt-3 font-semibold text-primary"><span>Total</span><span id="booking-total">{{ $room['price'] }}</span></div></div>
            </div>
        </aside>
    </div>

    <section class="mt-24 border-t border-surface-container-highest pt-16 text-center"><p class="mb-4 text-sm font-semibold uppercase tracking-widest text-secondary">Discover More</p><h2 class="mx-auto max-w-2xl font-display text-4xl text-primary md:text-5xl">Find the place that feels like your own island retreat.</h2><a class="mt-8 inline-flex items-center gap-2 rounded bg-primary px-7 py-4 text-sm font-semibold uppercase tracking-wide text-on-primary transition-colors hover:bg-secondary" href="{{ route('rooms') }}">Explore all accommodations <span class="material-symbols-outlined">arrow_forward</span></a></section>
</main>

<div aria-hidden="true" class="fixed inset-0 z-[60] hidden items-center justify-center bg-primary/90 p-5 backdrop-blur-sm" id="lightbox" role="dialog"><button aria-label="Close image preview" class="absolute right-5 top-5 text-4xl text-on-primary" id="lightbox-close" type="button">&times;</button><img class="max-h-[85vh] max-w-full rounded-lg object-contain" id="lightbox-image" src="" alt=""></div>
<footer class="bg-primary py-12 text-on-primary"><div class="mx-auto flex max-w-container-max flex-col justify-between gap-5 px-margin-mobile md:flex-row md:items-end md:px-margin-desktop"><div><div class="mb-3 font-headline text-2xl tracking-widest">PRAISTY</div><p class="max-w-xs text-sm text-primary-fixed">A modern sanctuary where raw nature meets refined luxury.</p></div><p class="text-sm text-primary-fixed">&copy; {{ date('Y') }} Praisty Resort &amp; Spa. All rights reserved.</p></div></footer>
<script src="{{ asset('js/app.js') }}?v=202609271500"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const checkIn = document.getElementById('check_in'), checkOut = document.getElementById('check_out'), rate = Number(document.getElementById('room-rate').dataset.rate);
    const money = value => new Intl.NumberFormat('en-PH', {style:'currency', currency:'PHP', maximumFractionDigits:0}).format(value);
    const updateTotal = () => { if (!checkIn.value || !checkOut.value) return; const nights = Math.ceil((new Date(checkOut.value) - new Date(checkIn.value)) / 86400000); if (nights <= 0) return; const stay = nights * rate, fee = Math.round(stay * .05), taxes = Math.round(stay * .09); document.getElementById('nights-label').textContent = `${money(rate)} x ${nights} night${nights === 1 ? '' : 's'}`; document.getElementById('room-rate').textContent = money(stay); document.getElementById('resort-fee').textContent = money(fee); document.getElementById('taxes').textContent = money(taxes); document.getElementById('booking-total').textContent = money(stay + fee + taxes); };
    checkIn.addEventListener('change', () => { checkOut.min = checkIn.value; if (checkOut.value && checkOut.value <= checkIn.value) checkOut.value = ''; updateTotal(); }); checkOut.addEventListener('change', updateTotal); updateTotal();
    const box = document.getElementById('lightbox'), boxImage = document.getElementById('lightbox-image'), close = () => { box.classList.add('hidden'); box.classList.remove('flex'); document.body.classList.remove('overflow-hidden'); }; document.querySelectorAll('.room-gallery-button').forEach(button => button.addEventListener('click', () => { boxImage.src = button.dataset.image; boxImage.alt = button.dataset.alt; box.classList.remove('hidden'); box.classList.add('flex'); document.body.classList.add('overflow-hidden'); })); document.getElementById('lightbox-close').addEventListener('click', close); box.addEventListener('click', event => { if (event.target === box) close(); }); document.addEventListener('keydown', event => { if (event.key === 'Escape') close(); });
});
</script>
</body>
</html>
