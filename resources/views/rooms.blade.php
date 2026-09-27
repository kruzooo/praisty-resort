<!DOCTYPE html><html lang="en" style=""><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="{{ csrf_token() }}" name="csrf-token">
<title>Praisty Resort - Rooms &amp; Villas</title>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect">
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600&amp;family=Hanken+Grotesk:wght@400;500;600&amp;display=swap" rel="stylesheet">
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<link href="{{ asset('css/app.css') }}?v=202609280945" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
    </style>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-fixed": "#002201",
                        "on-primary-fixed": "#001b3c",
                        "on-tertiary-fixed": "#261900",
                        "on-background": "#1b1c19",
                        "on-tertiary-fixed-variant": "#5d4201",
                        "error-container": "#ffdad6",
                        "inverse-on-surface": "#f2f1ec",
                        "surface": "#fbf9f4",
                        "secondary": "#3b6934",
                        "on-primary-container": "#799dd6",
                        "primary": "#001e40",
                        "surface-container-highest": "#e4e2dd",
                        "background": "#fbf9f4",
                        "on-primary": "#ffffff",
                        "inverse-primary": "#a7c8ff",
                        "secondary-fixed": "#bcf0ae",
                        "on-tertiary-container": "#bb9650",
                        "tertiary-fixed": "#ffdea5",
                        "outline": "#737780",
                        "on-surface": "#1b1c19",
                        "on-secondary-fixed-variant": "#23501e",
                        "on-secondary-container": "#3f6d38",
                        "tertiary-fixed-dim": "#e9c176",
                        "surface-container-lowest": "#ffffff",
                        "tertiary": "#2a1c00",
                        "on-primary-fixed-variant": "#1f477b",
                        "inverse-surface": "#30312e",
                        "tertiary-container": "#453000",
                        "on-error-container": "#93000a",
                        "primary-fixed-dim": "#a7c8ff",
                        "on-surface-variant": "#43474f",
                        "surface-variant": "#e4e2dd",
                        "on-secondary": "#ffffff",
                        "surface-dim": "#dbdad5",
                        "surface-container": "#f0eee9",
                        "on-error": "#ffffff",
                        "outline-variant": "#c3c6d1",
                        "error": "#ba1a1a",
                        "primary-container": "#003366",
                        "secondary-container": "#b9eeab",
                        "surface-bright": "#fbf9f4",
                        "secondary-fixed-dim": "#a1d494",
                        "surface-tint": "#3a5f94",
                        "on-tertiary": "#ffffff",
                        "surface-container-low": "#f5f3ee",
                        "primary-fixed": "#d5e3ff",
                        "surface-container-high": "#eae8e3"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-mobile": "20px",
                        "unit": "8px",
                        "section-gap": "120px",
                        "gutter": "24px",
                        "container-max": "1280px",
                        "margin-desktop": "64px"
                    },
                    "fontFamily": {
                        "headline-lg": ["EB Garamond"],
                        "body-md": ["Hanken Grotesk"],
                        "label-md": ["Hanken Grotesk"],
                        "headline-lg-mobile": ["EB Garamond"],
                        "body-lg": ["Hanken Grotesk"],
                        "headline-md": ["EB Garamond"],
                        "display-lg": ["EB Garamond"]
                    },
                    "fontSize": {
                        "headline-lg": ["40px", { "lineHeight": "48px", "fontWeight": "500" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.05em", "fontWeight": "600" }],
                        "headline-lg-mobile": ["32px", { "lineHeight": "40px", "fontWeight": "500" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "headline-md": ["28px", { "lineHeight": "36px", "fontWeight": "500" }],
                        "display-lg": ["64px", { "lineHeight": "72px", "letterSpacing": "-0.02em", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background text-on-background font-body-md antialiased selection:bg-primary-container selection:text-on-primary-container">
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 bg-surface/80 backdrop-blur-md shadow-sm">
<div class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-4 max-w-container-max mx-auto">
<a aria-label="Home" class="font-headline-md text-headline-md text-primary tracking-widest uppercase" href="{{ route('home') }}">PRAISTY RESORT</a>
<div class="hidden md:flex items-center space-x-8">
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
<!-- Active State -->
<a class="font-label-md text-label-md text-primary border-b border-primary pb-1" href="{{ route('rooms') }}">Rooms &amp; Villas</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="{{ route('experiences') }}">Experiences</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="{{ route('gallery') }}">Gallery</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="{{ route('contact') }}">Contact</a>
</div>
<a class="hidden md:inline-flex bg-primary-container text-on-primary font-label-md text-label-md uppercase px-6 py-2.5 rounded-full hover:scale-105 transition-transform duration-300" href="{{ route('rooms') }}#room-search">Book Now</a>
<!-- Mobile Menu Toggle -->
<button aria-controls="mobile-menu" aria-expanded="false" aria-label="Open Menu" class="md:hidden text-primary p-2" id="mobile-menu-button" type="button">
<span class="material-symbols-outlined" data-icon="menu">menu</span>
</button>
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
<main class="pt-[140px] pb-section-gap">
<!-- Header & Filters -->
<section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mb-24">
<div class="text-center mb-12">
<h1 class="font-display-lg text-display-lg text-primary mb-4">Discover Your Sanctuary</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Immerse yourself in elevated comfort where raw natural beauty meets refined hospitality.</p>
</div>
@if ($errors->any())
<div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
    <p class="font-semibold">Please review your search details.</p>
    <ul class="mt-1 list-disc pl-5">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ route('rooms') }}#results" class="bg-surface-container-lowest border border-outline-variant/40 rounded-xl p-4 md:p-5 shadow-[0_14px_40px_-20px_rgba(0,30,64,0.32)] relative z-10" id="room-search" method="GET">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_auto] gap-3 items-stretch">
<fieldset class="min-w-0 rounded-lg border border-outline-variant/50 bg-surface p-3 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/10 transition-all">
<legend class="px-1 font-label-md text-[11px] text-on-surface-variant uppercase tracking-widest">Your stay</legend>
<div class="grid grid-cols-2 gap-3">
<label class="min-w-0"><span class="sr-only">Check-in date</span><span class="block text-[11px] font-medium text-outline mb-1">CHECK-IN</span><input class="w-full border-0 bg-transparent p-0 text-sm text-primary focus:ring-0" min="{{ now()->toDateString() }}" name="check_in" type="date" value="{{ $filters['check_in'] }}"></label>
<label class="min-w-0"><span class="sr-only">Check-out date</span><span class="block text-[11px] font-medium text-outline mb-1">CHECK-OUT</span><input class="w-full border-0 bg-transparent p-0 text-sm text-primary focus:ring-0" min="{{ $filters['check_in'] ?: now()->toDateString() }}" name="check_out" type="date" value="{{ $filters['check_out'] }}"></label>
</div>
</fieldset>
<label class="rounded-lg border border-outline-variant/50 bg-surface p-3 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/10 transition-all">
<span class="flex items-center gap-2 text-[11px] font-label-md text-on-surface-variant uppercase tracking-widest mb-2"><span class="material-symbols-outlined text-[17px]">group</span>Guests</span>
<select class="w-full border-0 bg-transparent p-0 text-sm text-primary focus:ring-0 cursor-pointer" name="guests">
<option value="1" @selected($filters['guests'] === 1)>1 Guest</option>
<option value="2" @selected($filters['guests'] === 2)>2 Guests</option>
<option value="3" @selected($filters['guests'] === 3)>3 Guests</option>
<option value="4" @selected($filters['guests'] === 4)>4 Guests</option>
</select>
</label>
<label class="rounded-lg border border-outline-variant/50 bg-surface p-3 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/10 transition-all">
<span class="flex items-center gap-2 text-[11px] font-label-md text-on-surface-variant uppercase tracking-widest mb-2"><span class="material-symbols-outlined text-[17px]">bed</span>Accommodation</span>
<select class="w-full border-0 bg-transparent p-0 text-sm text-primary focus:ring-0 cursor-pointer" name="room_type">
<option value="all" @selected($filters['room_type'] === 'all')>All accommodations</option>
<option value="suite" @selected($filters['room_type'] === 'suite')>Suites</option>
<option value="villa" @selected($filters['room_type'] === 'villa')>Villas</option>
<option value="pavilion" @selected($filters['room_type'] === 'pavilion')>Pavilions</option>
</select>
</label>
<div class="flex min-h-[76px] items-end"><button class="w-full h-[52px] rounded-lg bg-primary-container px-7 text-on-primary font-label-md text-label-md uppercase tracking-wide shadow-[0_10px_20px_-10px_rgba(0,30,64,.7)] transition-all hover:bg-primary hover:-translate-y-0.5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary" type="submit"><span class="material-symbols-outlined align-[-5px] mr-1 text-[19px]">search</span>Search</button></div>
</div>
@if ($filters['check_in'] && $filters['check_out'])
<p class="mt-3 px-1 text-sm text-on-surface-variant"><span class="font-medium text-primary">Selected stay:</span> {{ \Carbon\Carbon::parse($filters['check_in'])->format('M j, Y') }} to {{ \Carbon\Carbon::parse($filters['check_out'])->format('M j, Y') }}</p>
@endif
</form>
</section>
<!-- Accommodations Grid Area -->
<section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop" id="results">
<!-- Sorting -->
<div class="flex justify-between items-center mb-8 border-b border-outline-variant/30 pb-4">
<p class="font-body-md text-body-md text-on-surface-variant">Showing <span class="font-medium text-primary">{{ $roomCount }}</span> matching accommodation{{ $roomCount === 1 ? '' : 's' }}</p>
<div class="flex items-center gap-3">
<span class="font-label-md text-label-md text-on-surface-variant uppercase">Sort By:</span>
<select class="bg-surface-container-low border border-outline-variant/40 font-body-md text-body-md text-primary focus:ring-2 focus:ring-primary/10 cursor-pointer py-2 pr-9 pl-3 rounded-lg transition-colors" form="room-search" name="sort" onchange="this.form.requestSubmit()">
<option value="popularity" @selected($filters['sort'] === 'popularity')>Popularity</option>
<option value="price_low" @selected($filters['sort'] === 'price_low')>Price: low to high</option>
<option value="price_high" @selected($filters['sort'] === 'price_high')>Price: high to low</option>
<option value="size" @selected($filters['sort'] === 'size')>Largest first</option>
</select>
</div>
</div>
{{-- Room data is provided by HomeController so filters and sorting run server-side.
    $rooms = [
        [
            'name' => 'Royal Overwater Bungalow',
            'type' => 'Overwater Bungalow',
            'image' => 'images/resort/royal-overwater-bungalow.png',
            'alt' => 'Royal Overwater Bungalow over clear turquoise lagoon waters',
            'size' => '1,100 sq ft',
            'guests' => 'Max 3 Guests',
            'bed' => '1 King Bed',
            'featureIcon' => 'waves',
            'feature' => 'Direct Lagoon Access',
            'price' => '₱95,000',
        ],
        [
            'name' => 'Sunset Beachfront Villa',
            'type' => 'Beachfront Villa',
            'image' => 'images/resort/sunset-beachfront-villa.png',
            'alt' => 'Sunset Beachfront Villa with private terrace and infinity pool',
            'size' => '1,320 sq ft',
            'guests' => 'Max 4 Guests',
            'bed' => '2 King Beds',
            'featureIcon' => 'star',
            'feature' => 'Sunset Beach Access',
            'price' => '₱88,000',
        ],
        [
            'name' => 'Canopy Jungle Villa',
            'type' => 'Private Villa',
            'image' => 'images/resort/canopy-jungle-villa.png',
            'alt' => 'Canopy Jungle Villa with private pool',
            'size' => '1,200 sq ft',
            'guests' => 'Max 4 Guests',
            'bed' => '2 King Beds',
            'featureIcon' => 'pool',
            'feature' => 'Private Plunge Pool',
            'price' => '₱82,000',
        ],
        [
            'name' => 'Ocean Serenity Wellness Villa',
            'type' => 'Wellness Villa',
            'image' => 'images/resort/ocean-serenity-wellness-villa.png',
            'alt' => 'Ocean Serenity Wellness Villa with cliffside infinity pool and sea view',
            'size' => '980 sq ft',
            'guests' => 'Max 3 Guests',
            'bed' => '1 King Bed + Lounge',
            'featureIcon' => 'spa',
            'feature' => 'Wellness Terrace',
            'price' => '₱72,000',
        ],
        [
            'name' => 'Azure Ocean Suite',
            'type' => 'Premium Suite',
            'image' => 'images/resort/azure-ocean-suite.png',
            'alt' => 'Azure Ocean Suite interior with panoramic balcony',
            'size' => '650 sq ft',
            'guests' => 'Max 3 Guests',
            'bed' => '1 King Bed',
            'featureIcon' => 'sunny',
            'feature' => 'Panoramic Ocean View',
            'price' => '₱48,000',
        ],
        [
            'name' => 'Lagoon View Casita',
            'type' => 'Lagoon Casita',
            'image' => 'images/resort/lagoon-view-casita.png',
            'alt' => 'Lagoon View Casita living area facing a bright turquoise shoreline',
            'size' => '610 sq ft',
            'guests' => 'Max 3 Guests',
            'bed' => '1 King Bed + Daybed',
            'featureIcon' => 'waves',
            'feature' => 'Lagoon View Deck',
            'price' => '₱34,000',
        ],
        [
            'name' => 'Deluxe Garden Villa',
            'type' => 'Garden Villa',
            'image' => 'images/resort/deluxe-garden-villa.png',
            'alt' => 'Deluxe Garden Villa bedroom with private veranda and lush gardens',
            'size' => '540 sq ft',
            'guests' => 'Max 2 Guests',
            'bed' => '1 King Bed',
            'featureIcon' => 'eco',
            'feature' => 'Private Garden Veranda',
            'price' => '₱28,000',
        ],
        [
            'name' => 'Palm Studio Suite',
            'type' => 'Studio Suite',
            'image' => 'images/resort/palm-studio-suite.png',
            'alt' => 'Palm Studio Suite airy interior overlooking a tropical coconut grove',
            'size' => '420 sq ft',
            'guests' => 'Max 2 Guests',
            'bed' => '1 Queen Bed',
            'featureIcon' => 'eco',
            'feature' => 'Palm Grove View',
            'price' => '₱22,000',
        ],
        [
            'name' => 'Winter Sun Pool Villa',
            'type' => 'Seasonal Villa',
            'image' => 'images/resort/winter-sun-escape.png',
            'alt' => 'Sunlit infinity pool villa overlooking the ocean',
            'size' => '920 sq ft',
            'guests' => 'Max 2 Guests',
            'bed' => '1 King Bed',
            'featureIcon' => 'sunny',
            'feature' => 'Ocean-View Pool Deck',
            'price' => '₱58,000',
        ],
        [
            'name' => 'Seaside Romance Suite',
            'type' => 'Romance Suite',
            'image' => 'images/resort/seaside-romance-retreat.png',
            'alt' => 'Oceanfront villa suite at sunset with private pool',
            'size' => '780 sq ft',
            'guests' => 'Max 2 Guests',
            'bed' => '1 King Bed',
            'featureIcon' => 'favorite',
            'feature' => 'Private Sunset Terrace',
            'price' => '₱64,000',
        ],
        [
            'name' => 'Reef Overwater Spa Villa',
            'type' => 'Spa Villa',
            'image' => 'images/resort/reef-overwater-spa-villa.png',
            'alt' => 'Overwater spa villa with private deck above clear reef waters',
            'size' => '1,180 sq ft',
            'guests' => 'Max 3 Guests',
            'bed' => '1 King Bed + Lounge',
            'featureIcon' => 'hot_tub',
            'feature' => 'Outdoor Soaking Bath',
            'price' => '₱90,000',
        ],
        [
            'name' => 'Golden Tide Beach Villa',
            'type' => 'Beach Villa',
            'image' => 'images/resort/golden-tide-beach-villa.png',
            'alt' => 'Beach villa terrace with sunset dining by the ocean',
            'size' => '1,050 sq ft',
            'guests' => 'Max 4 Guests',
            'bed' => '2 King Beds',
            'featureIcon' => 'wb_twilight',
            'feature' => 'Sunset Dining Terrace',
            'price' => '₱86,000',
        ],
        [
            'name' => 'Coral Horizon Overwater Villa',
            'type' => 'Overwater Villa',
            'image' => 'images/resort/coral-horizon-overwater-villa.png',
            'alt' => 'Private overwater villa with reef access and ocean horizon view',
            'size' => '1,180 sq ft',
            'guests' => 'Max 3 Guests',
            'bed' => '1 King Bed + Lounge',
            'featureIcon' => 'snorkeling',
            'feature' => 'Direct Reef Access',
            'price' => '₱92,000',
        ],
    ];

    $perPage = 4;
    $totalPages = (int) ceil(count($rooms) / $perPage);
    $currentPage = max(1, min((int) request('page', 1), $totalPages));
    $visibleRooms = array_slice($rooms, ($currentPage - 1) * $perPage, $perPage);
--}}

<!-- Bento/Spacious Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-12">
@foreach ($visibleRooms as $room)
<article class="group flex flex-col bg-surface-container-lowest rounded-2xl overflow-hidden shadow-[0_15px_40px_-15px_rgba(0,30,64,0.06)] hover:shadow-[0_25px_50px_-12px_rgba(0,30,64,0.12)] transition-all duration-500 border border-surface-container-high">
<div class="relative h-[350px] lg:h-[450px] overflow-hidden">
<img alt="{{ $room['alt'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-in-out" loading="lazy" src="{{ asset($room['image']) }}">
<div class="absolute top-4 left-4 bg-surface/90 backdrop-blur px-4 py-1.5 rounded-full border border-outline-variant/20">
<span class="font-label-md text-[12px] text-primary uppercase tracking-wider">{{ $room['type'] }}</span>
</div>
</div>
<div class="p-8 md:p-10 flex flex-col flex-grow">
<div class="flex justify-between items-start mb-4">
<h2 class="font-headline-md text-headline-md text-primary group-hover:text-surface-tint transition-colors">{{ $room['name'] }}</h2>
</div>
<div class="flex flex-wrap gap-x-6 gap-y-3 mb-8">
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-[20px] font-light" data-icon="straighten">straighten</span>
<span class="font-body-md text-body-md">{{ $room['size'] }}</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-[20px] font-light" data-icon="person">person</span>
<span class="font-body-md text-body-md">Max {{ $room['capacity'] }} Guests</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-[20px] font-light" data-icon="king_bed">king_bed</span>
<span class="font-body-md text-body-md">{{ $room['bed'] }}</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant w-full mt-1">
<span class="material-symbols-outlined text-[20px] font-light text-secondary" data-icon="{{ $room['featureIcon'] }}">{{ $room['featureIcon'] }}</span>
<span class="font-label-md text-[12px] uppercase tracking-wide text-secondary">{{ $room['feature'] }}</span>
</div>
</div>
<div class="mt-auto pt-6 border-t border-outline-variant/30 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6">
<div>
<p class="font-label-md text-[12px] text-on-surface-variant uppercase tracking-widest mb-1">Starting From</p>
<p class="font-headline-md text-[32px] leading-none text-primary">{{ $room['price'] }} <span class="font-body-md text-[16px] text-outline font-normal">/night</span></p>
</div>
<div class="flex items-center gap-6 w-full sm:w-auto">
<a class="font-label-md text-label-md text-primary hover:text-surface-tint transition-colors relative after:content-[''] after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[1px] after:bg-primary hover:after:bg-surface-tint" href="{{ route('rooms.details', ['room' => \Illuminate\Support\Str::slug($room['name'])]) }}">
                                    View Details
                                </a>
<a class="bg-primary-container text-on-primary font-label-md text-label-md uppercase px-8 py-3.5 rounded-full hover:scale-105 transition-transform duration-300 w-full sm:w-auto text-center" href="{{ route('rooms.details', ['room' => \Illuminate\Support\Str::slug($room['name'])]) }}">
                                    Book Now
                                </a>
</div>
</div>
</div>
</article>
@endforeach
</div>
@if ($visibleRooms->isEmpty())
<div class="rounded-xl border border-outline-variant/40 bg-surface-container-low p-10 text-center">
<span class="material-symbols-outlined text-primary text-4xl">bedroom_parent</span>
<h2 class="mt-4 font-headline-md text-headline-md text-primary">No matching accommodations</h2>
<p class="mt-2 text-on-surface-variant">Try a lower guest count or choose another accommodation type.</p>
</div>
@endif
<nav aria-label="Rooms pagination" class="mt-14 flex flex-wrap items-center justify-center gap-3">
@if ($currentPage > 1)
<a class="inline-flex h-11 items-center justify-center rounded-full border border-outline-variant px-5 font-label-md text-label-md uppercase text-primary transition-colors hover:bg-surface-container" href="{{ route('rooms', array_merge(request()->query(), ['page' => $currentPage - 1])) }}">Previous</a>
@else
<span class="inline-flex h-11 items-center justify-center rounded-full border border-outline-variant/50 px-5 font-label-md text-label-md uppercase text-on-surface-variant opacity-50">Previous</span>
@endif

@for ($page = 1; $page <= $totalPages; $page++)
<a aria-current="{{ $currentPage === $page ? 'page' : 'false' }}" class="inline-flex h-11 w-11 items-center justify-center rounded-full border font-label-md text-label-md transition-colors {{ $currentPage === $page ? 'border-primary bg-primary text-on-primary' : 'border-outline-variant text-primary hover:bg-surface-container' }}" href="{{ route('rooms', array_merge(request()->query(), ['page' => $page])) }}">{{ $page }}</a>
@endfor

@if ($currentPage < $totalPages)
<a class="inline-flex h-11 items-center justify-center rounded-full border border-outline-variant px-5 font-label-md text-label-md uppercase text-primary transition-colors hover:bg-surface-container" href="{{ route('rooms', array_merge(request()->query(), ['page' => $currentPage + 1])) }}">Next</a>
@else
<span class="inline-flex h-11 items-center justify-center rounded-full border border-outline-variant/50 px-5 font-label-md text-label-md uppercase text-on-surface-variant opacity-50">Next</span>
@endif
</nav>
</section>
</main>
<!-- Footer -->
<footer class="w-full pt-section-gap pb-8 bg-primary text-on-primary">
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto mb-16">
<div class="col-span-1 md:col-span-2">
<h3 class="font-headline-md text-headline-md text-on-primary mb-6">PRAISTY RESORT</h3>
<p class="font-body-md text-body-md text-primary-fixed max-w-sm">Where the horizon meets modern luxury. Experience the pinnacle of tropical tranquility.</p>
</div>
<div class="col-span-1">
<h4 class="font-label-md text-label-md uppercase tracking-widest text-on-primary mb-6 opacity-70">Legal &amp; Privacy</h4>
<ul class="space-y-4">
<li class=""><a class="font-body-md text-body-md text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('privacy') }}">Privacy Policy</a></li>
<li class=""><a class="font-body-md text-body-md text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('terms') }}">Terms of Service</a></li>
</ul>
</div>
<div class="col-span-1">
<h4 class="font-label-md text-label-md uppercase tracking-widest text-on-primary mb-6 opacity-70">Company</h4>
<ul class="space-y-4">
<li class=""><a class="font-body-md text-body-md text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('careers') }}">Careers</a></li>
<li class=""><a class="font-body-md text-body-md text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('press-room') }}">Press Room</a></li>
<li class=""><a class="font-body-md text-body-md text-primary-fixed hover:text-on-primary transition-colors" href="{{ route('sustainability') }}">Sustainability</a></li>
</ul>
</div>
</div>
<div class="border-t border-primary-fixed/30 pt-8 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-4">
<p class="font-body-md text-body-md text-primary-fixed">© {{ date('Y') }} Praisty Resort &amp; Spa. All rights reserved.</p>
</div>
</footer>

<script src="{{ asset('js/app.js') }}?v=202609280945"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton?.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden', isOpen);
            menuButton.setAttribute('aria-expanded', String(!isOpen));
        });

        mobileMenu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            menuButton?.setAttribute('aria-expanded', 'false');
        }));

        const checkIn = document.querySelector('[name="check_in"]');
        const checkOut = document.querySelector('[name="check_out"]');

        checkIn?.addEventListener('change', () => {
            checkOut.min = checkIn.value;
            if (checkOut.value && checkOut.value <= checkIn.value) {
                checkOut.value = '';
            }
        });
    });
</script>




</body></html>

