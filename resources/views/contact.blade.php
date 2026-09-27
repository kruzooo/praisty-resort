<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <title>Contact &amp; Location | Praisty Resort</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&amp;family=Hanken+Grotesk:ital,wght@0,100..900;1,400..900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#fbf9f4', surface: '#fbf9f4', 'surface-container-low': '#f5f3ee',
                        'surface-container-lowest': '#ffffff', 'surface-container-high': '#eae8e3',
                        'surface-container-highest': '#e4e2dd', primary: '#001e40', 'primary-container': '#003366',
                        'on-primary': '#ffffff', 'on-primary-container': '#799dd6', 'primary-fixed': '#d5e3ff',
                        'on-primary-fixed': '#001b3c', 'on-primary-fixed-variant': '#1f477b',
                        secondary: '#3b6934', 'secondary-container': '#b9eeab', 'on-secondary-container': '#3f6d38',
                        'on-surface': '#1b1c19', 'on-surface-variant': '#43474f', outline: '#737780',
                        'outline-variant': '#c3c6d1', 'inverse-primary': '#a7c8ff'
                    },
                    spacing: { 'section-gap': '120px', 'margin-mobile': '20px', gutter: '24px', 'container-max': '1280px', 'margin-desktop': '64px' },
                    fontFamily: { 'display-lg': ['EB Garamond', 'serif'], 'headline-lg': ['EB Garamond', 'serif'], 'headline-md': ['EB Garamond', 'serif'], 'body-md': ['Hanken Grotesk', 'sans-serif'], 'body-lg': ['Hanken Grotesk', 'sans-serif'], 'label-md': ['Hanken Grotesk', 'sans-serif'] },
                    fontSize: { 'display-lg': ['64px', { lineHeight: '72px', fontWeight: '400' }], 'headline-lg': ['40px', { lineHeight: '48px', fontWeight: '500' }], 'headline-md': ['28px', { lineHeight: '36px', fontWeight: '500' }], 'body-md': ['16px', { lineHeight: '24px' }], 'body-lg': ['18px', { lineHeight: '28px' }], 'label-md': ['14px', { lineHeight: '20px', letterSpacing: '0.05em', fontWeight: '600' }] }
                }
            }
        };
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; }
        .faq-answer { max-height: 0; opacity: 0; overflow: hidden; transition: max-height .3s ease, opacity .3s ease; }
        .faq-item.active .faq-answer { max-height: 500px; opacity: 1; }
        .faq-icon { transition: transform .3s ease; }
        .faq-item.active .faq-icon { transform: rotate(180deg); }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md antialiased overflow-x-hidden">
<nav class="fixed top-0 z-50 w-full bg-surface/90 backdrop-blur-md shadow-sm" id="main-nav">
    <div class="mx-auto flex max-w-container-max items-center justify-between px-margin-mobile py-4 md:px-margin-desktop">
        <a class="font-headline-md text-headline-md tracking-widest text-primary uppercase" href="{{ route('home') }}">Praisty Resort</a>
        <div class="hidden items-center space-x-8 md:flex">
            <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary" href="{{ route('home') }}">Home</a>
            <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary" href="{{ route('rooms') }}">Rooms &amp; Villas</a>
            <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary" href="{{ route('experiences') }}">Experiences</a>
            <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary" href="{{ route('gallery') }}">Gallery</a>
            <a class="border-b border-primary pb-1 font-label-md text-label-md text-primary" href="{{ route('contact') }}">Contact</a>
        </div>
        <a class="hidden rounded bg-primary-container px-6 py-3 font-label-md text-label-md text-on-primary uppercase transition-transform hover:scale-105 md:inline-flex" href="{{ route('rooms') }}#room-search">Book Now</a>
        <button aria-controls="mobile-menu" aria-expanded="false" aria-label="Open navigation menu" class="p-2 text-primary md:hidden" id="mobile-menu-button" type="button"><span class="material-symbols-outlined">menu</span></button>
    </div>
    <div class="hidden border-t border-outline-variant bg-surface px-margin-mobile py-5 md:hidden" id="mobile-menu">
        <div class="flex flex-col gap-4 font-label-md text-label-md text-primary">
            <a href="{{ route('home') }}">Home</a><a href="{{ route('rooms') }}">Rooms &amp; Villas</a><a href="{{ route('experiences') }}">Experiences</a><a href="{{ route('gallery') }}">Gallery</a><a href="{{ route('contact') }}">Contact</a>
        </div>
    </div>
</nav>

<header class="mx-auto max-w-container-max px-margin-mobile pb-16 pt-[140px] md:px-margin-desktop md:pb-24 md:pt-[180px]">
    <div class="max-w-3xl"><h1 class="mb-6 font-display-lg text-display-lg text-primary max-md:text-5xl">Contact &amp; Location</h1><p class="font-body-lg text-body-lg text-on-surface-variant">Whether you have a question about booking a villa, arranging airport transfers, or special requests for your stay, our dedicated concierge team is ready to assist you.</p></div>
</header>

<main>
<section class="mx-auto grid max-w-container-max grid-cols-1 gap-12 px-margin-mobile pb-section-gap md:px-margin-desktop lg:grid-cols-12 lg:gap-gutter">
    <div class="rounded-xl border border-surface-container-highest bg-surface-container-lowest p-6 shadow-[0_20px_40px_-15px_rgba(0,30,64,.05)] md:p-12 lg:col-span-7">
        <h2 class="mb-8 font-headline-lg text-headline-lg text-primary">Send a Message</h2>
        @if (session('contact_status'))<div class="mb-6 rounded-lg border border-secondary/30 bg-secondary-container/40 px-4 py-3 text-on-secondary-container" role="status">{{ session('contact_status') }}</div>@endif
        @if ($errors->any())<div class="mb-6 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-red-800"><p class="font-semibold">Please check your details.</p><ul class="mt-1 list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('contact.send') }}" class="space-y-6" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-2"><label class="block text-xs font-label-md uppercase tracking-wider text-on-surface-variant" for="name">Full Name</label><input class="w-full border-0 border-b border-outline-variant bg-transparent px-0 py-3 text-on-surface placeholder:text-outline focus:border-primary focus:ring-0" id="name" name="name" required type="text" value="{{ old('name') }}"></div>
                <div class="space-y-2"><label class="block text-xs font-label-md uppercase tracking-wider text-on-surface-variant" for="email">Email Address</label><input class="w-full border-0 border-b border-outline-variant bg-transparent px-0 py-3 text-on-surface placeholder:text-outline focus:border-primary focus:ring-0" id="email" name="email" required type="email" value="{{ old('email') }}"></div>
            </div>
            <div class="space-y-2"><label class="block text-xs font-label-md uppercase tracking-wider text-on-surface-variant" for="subject">Subject</label><select class="w-full border-0 border-b border-outline-variant bg-transparent px-0 py-3 text-on-surface focus:border-primary focus:ring-0" id="subject" name="subject" required><option disabled @selected(!old('subject')) value="">Select an inquiry type</option><option @selected(old('subject') === 'booking') value="booking">Booking Inquiry</option><option @selected(old('subject') === 'transportation') value="transportation">Transportation &amp; Transfers</option><option @selected(old('subject') === 'events') value="events">Special Events &amp; Weddings</option><option @selected(old('subject') === 'other') value="other">Other Questions</option></select></div>
            <div class="space-y-2"><label class="block text-xs font-label-md uppercase tracking-wider text-on-surface-variant" for="message">Message</label><textarea class="w-full resize-none border-0 border-b border-outline-variant bg-transparent px-0 py-3 text-on-surface placeholder:text-outline focus:border-primary focus:ring-0" id="message" name="message" placeholder="How can we help you prepare for your stay?" required rows="4">{{ old('message') }}</textarea></div>
            <button class="inline-flex w-full items-center justify-center rounded bg-primary px-8 py-4 font-label-md text-label-md text-on-primary transition-colors hover:bg-secondary md:w-auto" type="submit">Send Inquiry <span class="material-symbols-outlined ml-2 text-xl">arrow_forward</span></button>
        </form>
    </div>
    <div class="space-y-8 lg:col-span-5">
        <div class="relative overflow-hidden rounded-xl bg-primary p-8 text-on-primary md:p-10"><div class="absolute -right-20 -top-20 h-48 w-48 rounded-full bg-primary-container opacity-70 blur-3xl"></div><div class="relative"><h3 class="mb-8 font-headline-md text-headline-md">Direct Contact</h3><div class="space-y-6"><div class="flex items-start gap-4"><span class="material-symbols-outlined mt-1 text-inverse-primary">location_on</span><div><h4 class="mb-1 text-xs font-label-md uppercase tracking-wider text-inverse-primary">Resort Address</h4><p>1 Praisty Way, Barangay San Isidro<br>El Nido, Palawan 5313, Philippines</p></div></div><div class="flex items-start gap-4"><span class="material-symbols-outlined mt-1 text-inverse-primary">call</span><div><h4 class="mb-1 text-xs font-label-md uppercase tracking-wider text-inverse-primary">Phone</h4><p>+63 995 527 1898<br>Available 24/7</p></div></div><div class="flex items-start gap-4"><span class="material-symbols-outlined mt-1 text-inverse-primary">mail</span><div><h4 class="mb-1 text-xs font-label-md uppercase tracking-wider text-inverse-primary">Email</h4><p>praistyp@gmail.com</p></div></div></div></div></div>
    </div>
</section>

<section class="bg-surface-container-low py-16 md:py-24"><div class="mx-auto max-w-container-max px-margin-mobile md:px-margin-desktop"><div class="mx-auto mb-16 max-w-3xl text-center"><h2 class="mb-4 font-headline-lg text-headline-lg text-primary">Arrival &amp; Transportation</h2><p class="text-on-surface-variant">We offer seamless transfer services from the international airport so your relaxation begins the moment you land.</p></div><div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:gap-12"><article class="flex items-start gap-6 rounded-xl border border-surface-container-highest bg-surface-container-lowest p-8 shadow-sm"><div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-primary-fixed text-on-primary-fixed"><span class="material-symbols-outlined text-3xl">flight</span></div><div><h3 class="mb-2 font-headline-md text-2xl text-primary">Luxury Seaplane Transfer</h3><p class="mb-4 text-on-surface-variant">A scenic 45-minute flight from the international airport directly to our arrival jetty, available during daylight hours.</p><span class="rounded-full bg-surface-container-high px-3 py-1 text-xs font-label-md uppercase text-on-surface-variant">Recommended</span></div></article><article class="flex items-start gap-6 rounded-xl border border-surface-container-highest bg-surface-container-lowest p-8 shadow-sm"><div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-secondary-container text-on-secondary-container"><span class="material-symbols-outlined text-3xl">directions_boat</span></div><div><h3 class="mb-2 font-headline-md text-2xl text-primary">Private Yacht Charter</h3><p class="mb-4 text-on-surface-variant">A leisurely two-hour cruise through the atoll with champagne and light refreshments, available around the clock.</p><a class="inline-flex items-center font-label-md text-label-md text-primary hover:text-secondary" href="{{ route('rooms') }}">Explore Villas <span class="material-symbols-outlined ml-1 text-sm">arrow_outward</span></a></div></article></div></div></section>

<section class="mx-auto max-w-container-max px-margin-mobile py-section-gap md:px-margin-desktop"><div class="mx-auto max-w-3xl"><h2 class="mb-10 text-center font-headline-lg text-headline-lg text-primary">Frequently Asked Questions</h2><div class="space-y-4" id="faq-container">
@foreach ([['What is the check-in and check-out time?', 'Check-in is guaranteed from 3:00 PM local time, and check-out is by 12:00 PM. Complimentary early check-in or late check-out may be arranged subject to availability.'], ['Do you accommodate dietary restrictions?', 'Yes. Our culinary team can prepare vegan, gluten-free, halal, and allergy-conscious menus. Please let our concierge know before your arrival.'], ['Is the resort suitable for children?', 'Praisty Resort has family-friendly zones, a Kids Club for ages 4 to 12, and babysitting services available upon request.'], ['What is the cancellation policy?', 'For standard rates, cancellations made up to 14 days before arrival are fully refundable. Peak holiday stays may follow a 30-day policy.'] ] as [$question, $answer])
<div class="faq-item overflow-hidden rounded-lg border border-surface-container-highest bg-surface-container-lowest"><button aria-expanded="false" class="flex w-full items-center justify-between px-6 py-5 text-left hover:bg-surface-container-low" type="button"><span class="font-headline-md text-xl text-primary">{{ $question }}</span><span class="material-symbols-outlined faq-icon text-on-surface-variant">expand_more</span></button><div class="faq-answer bg-surface-container-lowest px-6"><div class="pb-6 text-on-surface-variant">{{ $answer }}</div></div></div>
@endforeach
</div></div></section>
</main>

<footer class="bg-primary pb-8 pt-section-gap text-on-primary"><div class="mx-auto grid max-w-container-max grid-cols-1 gap-gutter px-margin-mobile md:grid-cols-4 md:px-margin-desktop"><div class="md:col-span-1"><div class="mb-4 font-headline-md text-headline-md tracking-widest">PRAISTY</div><p class="max-w-xs text-sm text-primary-fixed">A modern sanctuary where raw nature meets refined luxury.</p></div><div class="grid grid-cols-2 gap-8 md:col-span-3 md:grid-cols-3"><div><h4 class="mb-4 text-xs font-label-md uppercase tracking-wider text-primary-fixed">Resort</h4><a class="text-sm text-primary-fixed hover:text-on-primary" href="{{ route('rooms') }}">Rooms &amp; Villas</a></div><div><h4 class="mb-4 text-xs font-label-md uppercase tracking-wider text-primary-fixed">Discover</h4><a class="text-sm text-primary-fixed hover:text-on-primary" href="{{ route('experiences') }}">Experiences</a></div><div><h4 class="mb-4 text-xs font-label-md uppercase tracking-wider text-primary-fixed">Contact</h4><a class="text-sm text-primary-fixed hover:text-on-primary" href="{{ route('contact') }}">Get in touch</a></div></div></div><div class="mx-auto mt-16 flex max-w-container-max justify-between border-t border-on-primary/10 px-margin-mobile pt-8 text-sm text-primary-fixed md:px-margin-desktop"><p>&copy; {{ date('Y') }} Praisty Resort &amp; Spa. All rights reserved.</p></div></footer>
<script src="{{ asset('js/app.js') }}?v=202609271500"></script>
<script>
    document.querySelectorAll('.faq-item button').forEach((button) => button.addEventListener('click', () => { const item = button.closest('.faq-item'); const active = item.classList.contains('active'); document.querySelectorAll('.faq-item').forEach((entry) => { entry.classList.remove('active'); entry.querySelector('button').setAttribute('aria-expanded', 'false'); }); if (!active) { item.classList.add('active'); button.setAttribute('aria-expanded', 'true'); } }));
    const menuButton = document.getElementById('mobile-menu-button'); const mobileMenu = document.getElementById('mobile-menu'); menuButton?.addEventListener('click', () => { const open = mobileMenu.classList.toggle('hidden'); menuButton.setAttribute('aria-expanded', String(!open)); });
</script>
</body>
</html>

