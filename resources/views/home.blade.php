<!DOCTYPE html><html class="light scroll-smooth" lang="en" style=""><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="{{ csrf_token() }}" name="csrf-token">
<title>Praisty Resort | The Art of Escape</title>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect">
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&amp;family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&amp;display=swap" rel="stylesheet">
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-variant": "#e4e2dd",
                        "inverse-on-surface": "#f2f1ec",
                        "inverse-primary": "#a7c8ff",
                        "tertiary-container": "#453000",
                        "on-surface": "#1b1c19",
                        "on-secondary-fixed": "#002201",
                        "on-error-container": "#93000a",
                        "primary-fixed": "#d5e3ff",
                        "on-tertiary-container": "#bb9650",
                        "on-tertiary": "#ffffff",
                        "inverse-surface": "#30312e",
                        "surface-container-highest": "#e4e2dd",
                        "surface-container-high": "#eae8e3",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "background": "#fbf9f4",
                        "secondary-fixed-dim": "#a1d494",
                        "tertiary": "#2a1c00",
                        "tertiary-fixed": "#ffdea5",
                        "surface-container": "#f0eee9",
                        "on-secondary-container": "#3f6d38",
                        "on-primary-container": "#799dd6",
                        "on-primary-fixed": "#001b3c",
                        "on-primary": "#ffffff",
                        "secondary-container": "#b9eeab",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed-variant": "#1f477b",
                        "on-secondary": "#ffffff",
                        "surface-dim": "#dbdad5",
                        "on-surface-variant": "#43474f",
                        "tertiary-fixed-dim": "#e9c176",
                        "on-background": "#1b1c19",
                        "error": "#ba1a1a",
                        "surface-tint": "#3a5f94",
                        "on-tertiary-fixed": "#261900",
                        "secondary-fixed": "#bcf0ae",
                        "on-tertiary-fixed-variant": "#5d4201",
                        "surface-container-low": "#f5f3ee",
                        "primary": "#001e40",
                        "surface-bright": "#fbf9f4",
                        "surface": "#fbf9f4",
                        "secondary": "#3b6934",
                        "outline": "#737780",
                        "primary-container": "#003366",
                        "outline-variant": "#c3c6d1",
                        "on-secondary-fixed-variant": "#23501e",
                        "primary-fixed-dim": "#a7c8ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "section-gap": "120px",
                        "margin-mobile": "20px",
                        "gutter": "24px",
                        "container-max": "1280px",
                        "unit": "8px",
                        "margin-desktop": "64px"
                    },
                    "fontFamily": {
                        "body-lg": ["Hanken Grotesk"],
                        "display-lg": ["EB Garamond"],
                        "headline-lg": ["EB Garamond"],
                        "label-md": ["Hanken Grotesk"],
                        "headline-md": ["EB Garamond"],
                        "headline-lg-mobile": ["EB Garamond"],
                        "body-md": ["Hanken Grotesk"]
                    },
                    "fontSize": {
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "display-lg": ["64px", { "lineHeight": "72px", "letterSpacing": "-0.02em", "fontWeight": "400" }],
                        "headline-lg": ["40px", { "lineHeight": "48px", "fontWeight": "500" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.05em", "fontWeight": "600" }],
                        "headline-md": ["28px", { "lineHeight": "36px", "fontWeight": "500" }],
                        "headline-lg-mobile": ["32px", { "lineHeight": "40px", "fontWeight": "500" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
<style>
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
        .hide-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-lg antialiased selection:bg-primary-container selection:text-on-primary-container">
<!-- TopNavBar (From JSON) -->
<nav class="fixed top-0 w-full z-50 bg-surface/80 backdrop-blur-md shadow-sm transition-all duration-300" id="main-nav">
<div class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-4 max-w-container-max mx-auto">
<!-- Brand -->
<a class="font-headline-md text-headline-md text-primary tracking-widest uppercase hover:opacity-80 transition-opacity" href="{{ route('home') }}">Praisty resort</a>
<!-- Navigation Links (Desktop) -->
<div class="hidden md:flex items-center space-x-8">
<a class="font-label-md text-label-md text-primary border-b border-primary pb-1" href="{{ route('home') }}">Home</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="{{ route('rooms') }}">Rooms &amp; Villas</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="{{ route('experiences') }}">Experiences</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="{{ route('gallery') }}">Gallery</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="{{ route('contact') }}">Contact</a>
</div>
<!-- Trailing Actions -->
<div class="flex items-center gap-2 md:gap-3">
<a class="hidden md:block bg-primary-container text-on-primary font-label-md text-label-md px-6 py-3 rounded hover:scale-105 transition-transform duration-300 uppercase tracking-wider" href="{{ route('rooms') }}">Book Now</a>
<div class="relative" id="profile-menu-wrapper">
@php($profileUser = auth()->user() ?? (session('guest_profile') ? (object) session('guest_profile') : null))
<button aria-controls="profile-menu" aria-expanded="false" aria-label="Open profile menu" class="flex h-10 w-10 items-center justify-center rounded-full border border-primary/15 bg-primary text-sm font-semibold text-on-primary shadow-sm transition-transform hover:scale-105 hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2" id="profile-menu-button" type="button">
@if ($profileUser)
{{ strtoupper(substr($profileUser->name, 0, 1)) }}
@else
<span class="material-symbols-outlined text-[21px]" style="font-variation-settings: 'FILL' 1;">person</span>
@endif
</button>
<div aria-labelledby="profile-menu-button" class="absolute right-0 top-12 hidden w-72 overflow-hidden rounded-lg border border-outline-variant bg-surface-container-lowest shadow-xl" id="profile-menu" role="menu">
@if ($profileUser)
<div class="border-b border-surface-container-highest px-5 py-4"><p class="text-sm font-semibold text-primary">{{ $profileUser->name }}</p><p class="mt-1 truncate text-xs text-on-surface-variant">{{ $profileUser->email }}</p></div>
<div class="p-2">
<a class="flex items-center gap-3 rounded px-3 py-2.5 text-sm font-semibold text-primary transition-colors hover:bg-surface-container-low" href="{{ route('customer.dashboard') }}" role="menuitem"><span class="material-symbols-outlined text-lg">dashboard</span>Customer Dashboard</a>
@if ($profileUser->is_admin)
<a class="flex items-center gap-3 rounded px-3 py-2.5 text-sm font-semibold text-primary transition-colors hover:bg-surface-container-low" href="{{ route('admin.dashboard') }}" role="menuitem"><span class="material-symbols-outlined text-lg">admin_panel_settings</span>Operations Dashboard</a>
@endif
<a class="flex items-center gap-3 rounded px-3 py-2.5 text-sm text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-primary" href="{{ route('rooms') }}" role="menuitem"><span class="material-symbols-outlined text-lg">calendar_month</span>Plan a stay</a>
<a class="flex items-center gap-3 rounded px-3 py-2.5 text-sm text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-primary" href="{{ route('contact') }}" role="menuitem"><span class="material-symbols-outlined text-lg">support_agent</span>Contact concierge</a>
<form action="{{ route('guest.logout') }}" method="POST">@csrf<button class="flex w-full items-center gap-3 rounded px-3 py-2.5 text-left text-sm text-error transition-colors hover:bg-red-50" role="menuitem" type="submit"><span class="material-symbols-outlined text-lg">logout</span>Sign out</button></form>
</div>
@else
<div class="border-b border-surface-container-highest px-5 py-4"><p class="text-sm font-semibold text-primary">Your Praisty profile</p><p class="mt-1 text-xs leading-5 text-on-surface-variant">Sign in to keep your stay details and preferences together.</p></div>
<div class="p-2"><a class="flex items-center gap-3 rounded px-3 py-2.5 text-sm font-semibold text-primary transition-colors hover:bg-surface-container-low" href="{{ route('guest.login') }}" role="menuitem"><span class="material-symbols-outlined text-lg">login</span>Guest Login</a><a class="flex items-center gap-3 rounded px-3 py-2.5 text-sm text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-primary" href="{{ route('guest.register') }}" role="menuitem"><span class="material-symbols-outlined text-lg">person_add</span>Create Account</a><a class="flex items-center gap-3 rounded px-3 py-2.5 text-sm text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-primary" href="{{ route('rooms') }}" role="menuitem"><span class="material-symbols-outlined text-lg">villa</span>Explore Rooms &amp; Villas</a></div>
@endif
</div>
</div>
<!-- Mobile Menu Toggle -->
<button aria-controls="mobile-menu" aria-expanded="false" aria-label="Open navigation menu" class="md:hidden text-primary p-2" id="mobile-menu-button" type="button"><span class="material-symbols-outlined" style="font-variation-settings: &quot;FILL&quot; 0;">menu</span></button>
</div>
</div>
<div class="hidden border-t border-outline-variant bg-surface px-margin-mobile py-5 md:hidden" id="mobile-menu">
<div class="flex flex-col gap-4 font-label-md text-label-md text-primary">
<a href="{{ route('home') }}">Home</a>
<a href="{{ route('rooms') }}">Rooms &amp; Villas</a>
<a href="{{ route('experiences') }}">Experiences</a>
<a href="{{ route('gallery') }}">Gallery</a>
<a href="{{ route('contact') }}">Contact</a>
</div>
</div>
</nav>
<!-- Hero Section (Split Screen) -->
<section class="min-h-screen flex flex-col md:flex-row pt-20 md:pt-0">
<!-- Left: Typography & Call to Action -->
<div class="w-full md:w-5/12 flex items-center justify-center p-margin-mobile md:p-margin-desktop bg-surface z-10 relative">
<div class="max-w-md w-full">
<p class="font-label-md text-label-md text-primary-container uppercase tracking-[0.2em] mb-4 opacity-80">Welcome to praisty resort</p>
<h1 class="font-display-lg text-display-lg text-primary mb-8 leading-tight">
<span class="block md:hidden font-headline-lg-mobile text-headline-lg-mobile">The Art of Escape</span>
<span class="hidden md:block">The Art<br>of Escape</span>
</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant mb-12 max-w-sm">
                    Discover a sanctuary where the rhythm of nature dictates the pace of luxury. An exclusive retreat designed to elevate the senses and restore the soul.
                </p>
<a class="group flex items-center space-x-4 bg-primary text-on-primary px-8 py-4 rounded hover:bg-primary-container transition-colors duration-300" href="{{ route('rooms') }}">
<span class="font-label-md text-label-md uppercase tracking-wider">Discover Our World</span>
<span class="material-symbols-outlined transform group-hover:translate-x-2 transition-transform duration-300" style="font-variation-settings: &quot;FILL&quot; 0;">arrow_forward</span>
</a>
</div>
<!-- Decorative minimal graphic -->
<div class="absolute bottom-10 left-10 w-24 h-24 border-l border-b border-primary/20 hidden md:block"></div>
</div>
<!-- Right: Full Height Video -->
<div class="w-full md:w-7/12 h-[614px] md:h-screen relative overflow-hidden" id="hero-video">
<video aria-hidden="true" class="hero-video is-active" data-hero-video muted playsinline preload="auto">
<source src="{{ asset('videos/resort/hero-sunset.mp4') }}" type="video/mp4">
</video>
<video aria-hidden="true" class="hero-video" data-hero-video muted playsinline preload="auto">
<source src="{{ asset('videos/resort/hero-sunset.mp4') }}" type="video/mp4">
</video>
<div class="absolute inset-0 bg-black/20 z-10"></div>
<div class="absolute bottom-8 right-8 z-20 flex space-x-4">
<button aria-label="Pause hero video" aria-pressed="false" class="w-12 h-12 rounded-full bg-surface/30 backdrop-blur-md flex items-center justify-center text-on-primary hover:bg-surface/50 transition-colors" id="hero-video-toggle" type="button">
<span class="material-symbols-outlined" id="hero-video-toggle-icon" style="font-variation-settings: &quot;FILL&quot; 1;">pause</span>
</button>
</div>
</div>
</section>
<!-- Seasonal Curations (Horizontal Scroll) -->
<section class="py-section-gap bg-surface-container-lowest overflow-hidden" id="rooms">
<div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto mb-16 flex justify-between items-end">
<div>
<h2 class="font-headline-lg text-headline-lg text-primary mb-2 hidden md:block">Seasonal Curations</h2>
<h2 class="font-headline-lg-mobile text-headline-lg-mobile text-primary mb-2 md:hidden">Seasonal Curations</h2>
<p class="font-body-md text-body-md text-on-surface-variant max-w-lg">Experiences thoughtfully crafted for the current moment. Embrace the distinct character of the season.</p>
</div>
<div class="hidden md:flex space-x-4">
<button class="w-12 h-12 rounded-full border border-outline-variant flex items-center justify-center text-primary hover:bg-surface-variant transition-colors" id="scroll-left">
<span class="material-symbols-outlined" style="font-variation-settings: &quot;FILL&quot; 0;">arrow_back</span>
</button>
<button class="w-12 h-12 rounded-full border border-outline-variant flex items-center justify-center text-primary hover:bg-surface-variant transition-colors" id="scroll-right">
<span class="material-symbols-outlined" style="font-variation-settings: &quot;FILL&quot; 0;">arrow_forward</span>
</button>
</div>
</div>
<div class="pl-margin-mobile md:pl-margin-desktop w-full">
<div class="flex space-x-6 md:space-x-8 overflow-x-auto hide-scroll pb-8 pr-margin-mobile md:pr-margin-desktop snap-x snap-mandatory" id="curations-scroll">
<!-- Card 1 -->
<div class="min-w-[85vw] md:min-w-[600px] flex-shrink-0 snap-center group cursor-pointer">
<div class="relative h-[400px] md:h-[500px] w-full overflow-hidden rounded mb-6">
<div class="absolute inset-0 bg-primary/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
<img alt="Private infinity pool overlooking a calm blue ocean" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700" src="{{ asset('images/resort/escape-the-cold.png') }}">
<div class="absolute top-6 left-6 z-20 bg-surface/80 backdrop-blur-md px-4 py-1.5 rounded-full">
<span class="font-label-md text-label-md text-primary uppercase">Winter Sun</span>
</div>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-2 group-hover:text-primary-container transition-colors">Escape the Cold</h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-4 max-w-md">Trade winter frost for tropical warmth. Exclusive access to our sun-drenched private coves and dedicated wellness programs.</p>
<a class="inline-flex items-center font-label-md text-label-md text-primary uppercase border-b border-primary/30 hover:border-primary pb-1 transition-colors" href="{{ route('rooms.details', ['room' => 'winter-sun-pool-villa']) }}">
                        Explore Offer <span class="material-symbols-outlined ml-2 text-sm" style="font-variation-settings: &quot;FILL&quot; 0;">arrow_outward</span>
</a>
</div>
<!-- Card 2 -->
<div class="min-w-[85vw] md:min-w-[600px] flex-shrink-0 snap-center group cursor-pointer">
<div class="relative h-[400px] md:h-[500px] w-full overflow-hidden rounded mb-6">
<div class="absolute inset-0 bg-primary/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
<img alt="Couple sharing a picnic by the ocean" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700" src="{{ asset('images/resort/moments-for-two.jfif') }}">
<div class="absolute top-6 left-6 z-20 bg-surface/80 backdrop-blur-md px-4 py-1.5 rounded-full">
<span class="font-label-md text-label-md text-primary uppercase">Romantic Retreats</span>
</div>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-2 group-hover:text-primary-container transition-colors">Moments for Two</h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-4 max-w-md">Slow down together with a private seaside picnic, warm ocean air, and uninterrupted time to share the simple moments that become your favorite memories.</p>
<a class="inline-flex items-center font-label-md text-label-md text-primary uppercase border-b border-primary/30 hover:border-primary pb-1 transition-colors" href="{{ route('rooms.details', ['room' => 'seaside-romance-suite']) }}">
                        Explore Offer <span class="material-symbols-outlined ml-2 text-sm" style="font-variation-settings: &quot;FILL&quot; 0;">arrow_outward</span>
</a>
</div>
<!-- Card 3 -->
<div class="min-w-[85vw] md:min-w-[600px] flex-shrink-0 snap-center group cursor-pointer">
<div class="relative h-[400px] md:h-[500px] w-full overflow-hidden rounded mb-6">
<div class="absolute inset-0 bg-primary/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
<img alt="Couple enjoying an overwater wellness ritual" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700" src="{{ asset('images/resort/overwater-wellness-ritual.png') }}">
<div class="absolute top-6 left-6 z-20 bg-surface/80 backdrop-blur-md px-4 py-1.5 rounded-full">
<span class="font-label-md text-label-md text-primary uppercase">Wellness Rituals</span>
</div>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-2 group-hover:text-primary-container transition-colors">Overwater Calm Ritual</h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-4 max-w-md">Begin the day above clear lagoon waters with guided sound therapy, soft ocean air, and a quiet wellness ritual designed to reset the body and mind.</p>
<a class="inline-flex items-center font-label-md text-label-md text-primary uppercase border-b border-primary/30 hover:border-primary pb-1 transition-colors" href="{{ route('rooms.details', ['room' => 'coral-horizon-overwater-villa']) }}">
                        Explore Offer <span class="material-symbols-outlined ml-2 text-sm" style="font-variation-settings: &quot;FILL&quot; 0;">arrow_outward</span>
</a>
</div>
<!-- Card 4 -->
<div class="min-w-[85vw] md:min-w-[600px] flex-shrink-0 snap-center group cursor-pointer">
<div class="relative h-[400px] md:h-[500px] w-full overflow-hidden rounded mb-6">
<div class="absolute inset-0 bg-primary/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
<img alt="Private beachfront dinner at sunset" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700" src="{{ asset('images/resort/tide-table-dining.png') }}">
<div class="absolute top-6 left-6 z-20 bg-surface/80 backdrop-blur-md px-4 py-1.5 rounded-full">
<span class="font-label-md text-label-md text-primary uppercase">Culinary Escape</span>
</div>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-2 group-hover:text-primary-container transition-colors">Tide Table Dining</h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-4 max-w-md">A candlelit seafood dinner on the sand, timed with the evening tide and golden sunset for an intimate coastal dining experience.</p>
<a class="inline-flex items-center font-label-md text-label-md text-primary uppercase border-b border-primary/30 hover:border-primary pb-1 transition-colors" href="{{ route('rooms.details', ['room' => 'golden-tide-beach-villa']) }}">
                        Explore Offer <span class="material-symbols-outlined ml-2 text-sm" style="font-variation-settings: &quot;FILL&quot; 0;">arrow_outward</span>
</a>
</div>
<!-- Card 5 -->
<div class="min-w-[85vw] md:min-w-[600px] flex-shrink-0 snap-center group cursor-pointer">
<div class="relative h-[400px] md:h-[500px] w-full overflow-hidden rounded mb-6">
<div class="absolute inset-0 bg-primary/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
<img alt="Couple lounging on a tropical canopy deck" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700" src="{{ asset('images/resort/canopy-sun-lounge.png') }}">
<div class="absolute top-6 left-6 z-20 bg-surface/80 backdrop-blur-md px-4 py-1.5 rounded-full">
<span class="font-label-md text-label-md text-primary uppercase">Canopy Living</span>
</div>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-2 group-hover:text-primary-container transition-colors">Canopy Sun Lounge</h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-4 max-w-md">Settle into a shaded jungle deck with ocean views, tropical refreshments, and unhurried afternoons beside your private plunge pool.</p>
<a class="inline-flex items-center font-label-md text-label-md text-primary uppercase border-b border-primary/30 hover:border-primary pb-1 transition-colors" href="{{ route('rooms.details', ['room' => 'canopy-jungle-villa']) }}">
                        Explore Offer <span class="material-symbols-outlined ml-2 text-sm" style="font-variation-settings: &quot;FILL&quot; 0;">arrow_outward</span>
</a>
</div>
</div>
</div>
</section>
<!-- Life at Praisty Resort -->
<section class="py-section-gap bg-surface-container px-margin-mobile md:px-margin-desktop" id="experiences">
<div class="max-w-container-max mx-auto">
<div class="text-center mb-16">
<p class="font-label-md text-label-md text-primary-container uppercase tracking-widest mb-4">The Experience</p>
<h2 class="font-headline-lg text-headline-lg text-primary hidden md:block">Life at Praisty Resort</h2>
<h2 class="font-headline-lg-mobile text-headline-lg-mobile text-primary md:hidden">Life at Praisty Resort</h2>
</div>
<div class="life-carousel" data-life-carousel aria-roledescription="carousel" aria-label="Life at Praisty Resort">
<div class="life-carousel__viewport" data-life-viewport tabindex="0">
<button class="life-carousel__side-button life-carousel__side-button--previous" data-life-prev type="button" aria-label="Show previous experience"><span class="material-symbols-outlined">west</span></button>
<div class="life-carousel__track" data-life-track>
<article class="life-carousel__slide" data-life-slide>
<img alt="Candlelit sunset dining by the sea" src="{{ asset('images/resort/praisty-sunset-dining.png') }}">
<div class="life-carousel__overlay"></div>
<div class="life-carousel__content"><span>Gastronomy</span><h3>Sunset Table</h3><p>Locally inspired plates, ocean air, and the last gold of day.</p></div>
</article>
<article class="life-carousel__slide" data-life-slide>
<img alt="Private poolside retreat at Praisty Resort" src="{{ asset('images/resort/praisty-poolside-retreat.png') }}">
<div class="life-carousel__overlay"></div>
<div class="life-carousel__content"><span>Private Leisure</span><h3>Poolside Pause</h3><p>Unhurried afternoons made for sun, water, and stillness.</p></div>
</article>
<article class="life-carousel__slide" data-life-slide>
<img alt="Wellness ritual at the resort spa" src="{{ asset('images/resort/praisty-wellness-spa.png') }}">
<div class="life-carousel__overlay"></div>
<div class="life-carousel__content"><span>Wellness</span><h3>Ocean Rituals</h3><p>A restorative escape guided by the rhythm of the coast.</p></div>
</article>
<article class="life-carousel__slide" data-life-slide>
<img alt="Relaxed coastal lounge at Praisty Resort" src="{{ asset('images/resort/praisty-coastal-lounge.png') }}">
<div class="life-carousel__overlay"></div>
<div class="life-carousel__content"><span>Island Living</span><h3>Coastal Ease</h3><p>Soft light, open horizons, and space to simply be.</p></div>
</article>
</div>
<button class="life-carousel__side-button life-carousel__side-button--next" data-life-next type="button" aria-label="Show next experience"><span class="material-symbols-outlined">east</span></button>
</div>
<div class="life-carousel__controls" aria-label="Carousel controls">
<div class="life-carousel__dots" data-life-dots aria-label="Choose an experience"></div>
</div>
</div>
</div>
</section>
<!-- Footer (From JSON) -->
<footer class="bg-primary pt-section-gap pb-8" id="contact">
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto mb-16">
<!-- Brand -->
<div class="col-span-1 md:col-span-1 mb-8 md:mb-0">
<a class="font-headline-md text-headline-md text-on-primary tracking-widest uppercase block mb-6" href="{{ route('home') }}">Praisty</a>
<p class="font-body-md text-body-md text-primary-fixed max-w-xs">
                    Elevating the art of luxury hospitality amidst nature's most spectacular settings.
                </p>
</div>
<!-- Links -->
<div class="col-span-1 md:col-span-3 flex flex-wrap justify-start md:justify-end gap-y-4 gap-x-8 items-center">
<a class="font-label-md text-label-md text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('privacy') }}">Privacy Policy</a>
<a class="font-label-md text-label-md text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('terms') }}">Terms of Service</a>
<a class="font-label-md text-label-md text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('careers') }}">Careers</a>
<a class="font-label-md text-label-md text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('press-room') }}">Press Room</a>
<a class="font-label-md text-label-md text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('sustainability') }}">Sustainability</a>
</div>
</div>
<div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto border-t border-on-primary/10 pt-8 flex flex-col md:flex-row justify-between items-center">
<p class="font-body-md text-body-md text-primary-fixed text-sm">
© {{ date('Y') }} Praisty Resort &amp; Spa. All rights reserved.
            </p>
<div class="flex space-x-4 mt-4 md:mt-0">
<!-- Social Placeholders -->
<a class="text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('gallery') }}" aria-label="Open resort gallery">
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: &quot;FILL&quot; 1;">public</span>
</a>
<a class="text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('contact') }}" aria-label="Contact the concierge">
<span class="material-symbols-outlined text-[20px]" style="font-variation-settings: &quot;FILL&quot; 1;">mail</span>
</a>
</div>
</div>
</footer>
<!-- Interactive Script for Horizontal Scroll & Nav Scroll Effect -->
<script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            menuButton?.addEventListener('click', () => {
                const isOpen = !mobileMenu.classList.contains('hidden');
                mobileMenu.classList.toggle('hidden', isOpen);
                menuButton.setAttribute('aria-expanded', String(!isOpen));
            });

            mobileMenu?.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    menuButton?.setAttribute('aria-expanded', 'false');
                });
            });

            const profileButton = document.getElementById('profile-menu-button');
            const profileMenu = document.getElementById('profile-menu');
            const profileWrapper = document.getElementById('profile-menu-wrapper');

            profileButton?.addEventListener('click', () => {
                const isOpen = !profileMenu.classList.contains('hidden');
                profileMenu.classList.toggle('hidden', isOpen);
                profileButton.setAttribute('aria-expanded', String(!isOpen));
            });

            document.addEventListener('click', (event) => {
                if (profileWrapper && !profileWrapper.contains(event.target)) {
                    profileMenu?.classList.add('hidden');
                    profileButton?.setAttribute('aria-expanded', 'false');
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    profileMenu?.classList.add('hidden');
                    profileButton?.setAttribute('aria-expanded', 'false');
                    profileButton?.focus();
                }
            });

            // Horizontal Scroll
            const scrollContainer = document.getElementById('curations-scroll');
            const leftBtn = document.getElementById('scroll-left');
            const rightBtn = document.getElementById('scroll-right');

            if(scrollContainer && leftBtn && rightBtn) {
                const scrollAmount = 600; // Match approximate card width

                leftBtn.addEventListener('click', () => {
                    scrollContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                });

                rightBtn.addEventListener('click', () => {
                    scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                });
            }

            // Nav Scroll Effect
            const nav = document.getElementById('main-nav');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    nav.classList.add('shadow-md');
                    nav.classList.replace('bg-surface/80', 'bg-surface/95');
                } else {
                    nav.classList.remove('shadow-md');
                    nav.classList.replace('bg-surface/95', 'bg-surface/80');
                }
            });
        });
    </script>

<script src="{{ asset('js/app.js') }}?v=202609271500"></script>


</body></html>
