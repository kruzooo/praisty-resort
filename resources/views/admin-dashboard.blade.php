<!DOCTYPE html>
@php($admin = auth()->user() ?? (object) session('admin_profile'))
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="noindex, nofollow" name="robots">
    <title>Operations Dashboard | Praisty Resort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600&amp;family=Hanken+Grotesk:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <script>tailwind.config={theme:{extend:{colors:{primary:'#001e40','primary-container':'#003366',secondary:'#3b6934','secondary-fixed':'#bcf0ae',surface:'#fbf9f4','surface-container':'#f0eee9','surface-container-low':'#f5f3ee','surface-container-high':'#eae8e3','surface-container-highest':'#e4e2dd','surface-container-lowest':'#ffffff','on-surface':'#1b1c19','on-surface-variant':'#43474f',outline:'#737780',error:'#ba1a1a','tertiary-fixed-dim':'#e9c176','surface-tint':'#3a5f94'},fontFamily:{headline:['EB Garamond','serif'],body:['Hanken Grotesk','sans-serif']},spacing:{sidebar:'18rem'}}}}</script>
</head>
<body class="min-h-screen bg-surface font-body text-on-surface antialiased">
    <div class="lg:pl-sidebar">
        <aside class="fixed inset-y-0 left-0 z-40 hidden w-sidebar flex-col justify-between bg-surface-container-low px-4 py-6 shadow-[1px_0_12px_rgba(0,30,64,0.03)] lg:flex">
            <div><div class="mb-8 px-4"><div class="flex items-center gap-2"><span class="font-headline text-3xl tracking-wide text-primary">PRAISTY</span><span class="rounded bg-primary-container px-2 py-0.5 text-[11px] font-semibold uppercase tracking-wider text-white">Portal</span></div><p class="mt-1 text-xs font-semibold uppercase tracking-widest text-on-surface-variant">Luxury Operations ERP</p></div><nav class="space-y-1.5 text-sm font-semibold"><a class="flex items-center gap-3 rounded-lg bg-primary-container px-4 py-3 text-white shadow-sm" href="{{ route('admin.dashboard') }}"><span class="material-symbols-outlined">grid_view</span>Executive Overview</a><a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-on-surface" href="{{ route('admin.operations', 'reservations') }}"><span class="material-symbols-outlined">calendar_month</span>Reservations &amp; Stays</a><a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-on-surface" href="{{ route('admin.operations', 'villas') }}"><span class="material-symbols-outlined">villa</span>Villa Inventory</a><a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-on-surface" href="{{ route('admin.operations', 'concierge') }}"><span class="material-symbols-outlined">room_service</span>Concierge Requests</a><a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-on-surface" href="{{ route('admin.operations', 'financials') }}"><span class="material-symbols-outlined">payments</span>Financials &amp; Yield</a><a class="flex items-center gap-3 rounded-lg px-4 py-3 text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-on-surface" href="{{ route('admin.feedback') }}"><span class="material-symbols-outlined">reviews</span>Guest Feedback</a></nav></div><div class="rounded-lg bg-surface-container-high p-4 text-xs text-on-surface-variant"><div class="flex items-center justify-between"><span class="font-semibold uppercase tracking-wider text-secondary">Private Cloud</span><span class="h-2 w-2 rounded-full bg-secondary"></span></div><p class="mt-2 leading-5">Secure Admin Gateway<br>Palawan Local Node: Active</p></div>
        </aside>
        <header class="sticky top-0 z-30 border-b border-surface-container-highest bg-surface/95 backdrop-blur"><div class="flex h-20 items-center justify-between gap-4 px-5 sm:px-8"><div class="flex items-center gap-3"><button aria-controls="mobile-sidebar" aria-expanded="false" class="rounded p-2 text-primary hover:bg-surface-container lg:hidden" id="mobile-menu" type="button"><span class="material-symbols-outlined">menu</span></button><div class="hidden items-center gap-2 rounded-full bg-surface-container px-3 py-1.5 text-xs sm:flex"><span class="material-symbols-outlined text-secondary">hotel</span><span class="uppercase tracking-wide">Occupancy:</span><strong class="text-secondary">94%</strong></div><div class="hidden items-center gap-2 rounded-full bg-surface-container px-3 py-1.5 text-xs md:flex"><span class="material-symbols-outlined text-tertiary-fixed-dim">sunny</span><span>Palawan: 28C, Calm Waters</span></div></div><div class="flex items-center gap-3"><a aria-label="Guest feedback" class="relative rounded-full p-2 text-on-surface-variant hover:bg-surface-container" href="{{ route('admin.feedback') }}"><span class="material-symbols-outlined">notifications</span><span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-error"></span></a><div class="hidden text-right sm:block"><p class="text-xs font-semibold text-primary">{{ $admin->name }}</p><p class="text-xs text-on-surface-variant">Authorized administrator</p></div><form action="{{ route('admin.logout') }}" method="POST">@csrf<button class="rounded border border-primary px-3 py-2 text-xs font-semibold text-primary hover:bg-surface-container" type="submit">Sign out</button></form></div></div><div class="hidden border-t border-surface-container-highest bg-surface-container-low px-5 py-4 lg:hidden" id="mobile-sidebar"><nav class="grid gap-2 text-sm font-semibold sm:grid-cols-2"><a class="rounded bg-primary-container px-3 py-2 text-white" href="{{ route('admin.dashboard') }}">Executive Overview</a><a class="rounded px-3 py-2 text-on-surface-variant hover:bg-surface-container-high" href="{{ route('admin.operations', 'reservations') }}">Reservations &amp; Stays</a><a class="rounded px-3 py-2 text-on-surface-variant hover:bg-surface-container-high" href="{{ route('admin.operations', 'villas') }}">Villa Inventory</a><a class="rounded px-3 py-2 text-on-surface-variant hover:bg-surface-container-high" href="{{ route('admin.operations', 'concierge') }}">Concierge Requests</a><a class="rounded px-3 py-2 text-on-surface-variant hover:bg-surface-container-high" href="{{ route('admin.feedback') }}">Guest Feedback</a></nav></div></header>
        <main class="space-y-8 px-5 py-8 sm:px-8" id="overview">
            <section class="flex flex-col justify-between gap-5 xl:flex-row xl:items-end"><div><p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-on-surface-variant"><span class="h-2 w-2 rounded-full bg-secondary"></span>Command Central · Palawan Marine Sanctuary</p><h1 class="mt-3 font-headline text-4xl text-primary sm:text-5xl">Good morning, {{ $admin->name }}</h1><p class="mt-1 text-sm text-on-surface-variant">Praisty Island Resort &amp; Spa · Private Archipelago Atoll</p></div><div class="flex flex-wrap gap-2"><a class="dashboard-action inline-flex items-center gap-2 rounded bg-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary-container" href="{{ route('admin.operations', 'new-reservation') }}"><span class="material-symbols-outlined text-lg">add</span>New VIP Reservation</a><a class="dashboard-action inline-flex items-center gap-2 rounded bg-surface-container-high px-4 py-2.5 text-sm font-semibold text-primary hover:bg-surface-container-highest" href="{{ route('admin.operations', 'dispatch-speedboat') }}"><span class="material-symbols-outlined text-lg">directions_boat</span>Dispatch Speedboat</a><a class="dashboard-action inline-flex items-center gap-2 rounded bg-surface-container-high px-4 py-2.5 text-sm font-semibold text-primary hover:bg-surface-container-highest" href="{{ route('admin.operations', 'assign-butler') }}"><span class="material-symbols-outlined text-lg">room_service</span>Assign Butler</a></div></section>
            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5"><article class="relative overflow-hidden rounded-lg bg-white p-5 shadow-sm"><span class="material-symbols-outlined float-right text-secondary">villa</span><p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Today's Occupancy</p><p class="mt-3 font-headline text-3xl text-primary">94.2%</p><p class="mt-1 text-xs text-on-surface-variant">34 of 36 villas booked</p><div class="mt-4 h-1.5 overflow-hidden rounded bg-surface-container-high"><div class="h-full w-[94%] rounded bg-secondary"></div></div></article><article class="rounded-lg bg-white p-5 shadow-sm"><span class="material-symbols-outlined float-right text-surface-tint">flight_land</span><p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">VIP Arrivals</p><p class="mt-3 font-headline text-3xl text-primary">8 Parties</p><p class="mt-1 text-xs text-secondary">Docks &amp; helipad ready</p></article><article class="rounded-lg bg-white p-5 shadow-sm"><span class="material-symbols-outlined float-right text-tertiary-fixed-dim">flight_takeoff</span><p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Departures</p><p class="mt-3 font-headline text-3xl text-primary">4 Parties</p><p class="mt-1 text-xs text-on-surface-variant">Luggage transfers on track</p></article><article class="rounded-lg bg-white p-5 shadow-sm"><span class="material-symbols-outlined float-right text-secondary">payments</span><p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Projected Revenue</p><p class="mt-3 font-headline text-3xl text-primary">PHP 1.84M</p><p class="mt-1 text-xs text-secondary">+12% against target</p></article><article class="rounded-lg bg-white p-5 shadow-sm"><span class="material-symbols-outlined float-right text-tertiary-fixed-dim">waves</span><p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Island Conditions</p><p class="mt-3 font-headline text-3xl text-primary">28C Calm</p><p class="mt-1 text-xs text-on-surface-variant">Safe water excursions</p></article></section>
            <section class="rounded-lg bg-white p-6 shadow-sm" id="booking-status">
                <div class="flex flex-col justify-between gap-4 border-b border-surface-container-highest pb-5 lg:flex-row lg:items-center">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-secondary">Guest Booking Control</p>
                        <h2 class="mt-1 font-headline text-3xl text-primary">Reservation Status Board</h2>
                        <p class="mt-1 text-sm text-on-surface-variant">Update each guest as processing, successfully booked, or cancelled.</p>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-center text-xs font-semibold sm:min-w-[360px]">
                        <div class="rounded bg-amber-50 px-3 py-2 text-amber-800"><span data-status-count="processing">2</span><br>Processing</div>
                        <div class="rounded bg-green-50 px-3 py-2 text-secondary"><span data-status-count="booked">1</span><br>Booked</div>
                        <div class="rounded bg-red-50 px-3 py-2 text-error"><span data-status-count="cancelled">1</span><br>Cancelled</div>
                    </div>
                </div>
                <div class="mt-5 overflow-x-auto">
                    <table class="min-w-[880px] w-full text-left text-sm">
                        <thead class="bg-surface-container-low text-xs uppercase tracking-wider text-on-surface-variant">
                            <tr>
                                <th class="rounded-l px-4 py-3">Guest</th>
                                <th class="px-4 py-3">Accommodation</th>
                                <th class="px-4 py-3">Stay Date</th>
                                <th class="px-4 py-3">Booking Status</th>
                                <th class="rounded-r px-4 py-3">Last Update</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-highest">
                            <tr class="booking-row" data-booking-id="alexander-cruz" data-status="processing">
                                <td class="px-4 py-4"><strong class="text-primary">Alexander Cruz</strong><p class="mt-1 text-xs text-on-surface-variant">alexander.cruz@example.com</p></td>
                                <td class="px-4 py-4">Overwater Wellness Pavilion<p class="mt-1 text-xs text-on-surface-variant">2 adults · Private dock arrival</p></td>
                                <td class="px-4 py-4">Sep 29 - Oct 2<p class="mt-1 text-xs text-on-surface-variant">3 nights</p></td>
                                <td class="px-4 py-4"><div class="status-picker inline-grid grid-cols-3 overflow-hidden rounded-lg border border-surface-container-highest bg-surface-container-low p-1 text-xs font-semibold"><button class="status-choice rounded px-3 py-2 transition" data-status-choice="processing" type="button">Processing</button><button class="status-choice rounded px-3 py-2 transition" data-status-choice="booked" type="button">Booked</button><button class="status-choice rounded px-3 py-2 transition" data-status-choice="cancelled" type="button">Cancel</button></div></td>
                                <td class="px-4 py-4"><span class="booking-status-label rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800">Processing</span><p class="booking-updated mt-1 text-xs text-on-surface-variant">Awaiting confirmation</p></td>
                            </tr>
                            <tr class="booking-row" data-booking-id="elena-vandermeer" data-status="booked">
                                <td class="px-4 py-4"><strong class="text-primary">Elena Vandermeer</strong><p class="mt-1 text-xs text-on-surface-variant">elena.v@example.com</p></td>
                                <td class="px-4 py-4">Treetop Canopy Villa<p class="mt-1 text-xs text-on-surface-variant">Private charter · Butler assigned</p></td>
                                <td class="px-4 py-4">Oct 4 - Oct 8<p class="mt-1 text-xs text-on-surface-variant">4 nights</p></td>
                                <td class="px-4 py-4"><div class="status-picker inline-grid grid-cols-3 overflow-hidden rounded-lg border border-surface-container-highest bg-surface-container-low p-1 text-xs font-semibold"><button class="status-choice rounded px-3 py-2 transition" data-status-choice="processing" type="button">Processing</button><button class="status-choice rounded px-3 py-2 transition" data-status-choice="booked" type="button">Booked</button><button class="status-choice rounded px-3 py-2 transition" data-status-choice="cancelled" type="button">Cancel</button></div></td>
                                <td class="px-4 py-4"><span class="booking-status-label rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-secondary">Successfully Booked</span><p class="booking-updated mt-1 text-xs text-on-surface-variant">Confirmed by reservations</p></td>
                            </tr>
                            <tr class="booking-row" data-booking-id="marco-santos" data-status="processing">
                                <td class="px-4 py-4"><strong class="text-primary">Marco Santos</strong><p class="mt-1 text-xs text-on-surface-variant">marco.santos@example.com</p></td>
                                <td class="px-4 py-4">Seaside Romance Suite<p class="mt-1 text-xs text-on-surface-variant">Anniversary package requested</p></td>
                                <td class="px-4 py-4">Oct 11 - Oct 13<p class="mt-1 text-xs text-on-surface-variant">2 nights</p></td>
                                <td class="px-4 py-4"><div class="status-picker inline-grid grid-cols-3 overflow-hidden rounded-lg border border-surface-container-highest bg-surface-container-low p-1 text-xs font-semibold"><button class="status-choice rounded px-3 py-2 transition" data-status-choice="processing" type="button">Processing</button><button class="status-choice rounded px-3 py-2 transition" data-status-choice="booked" type="button">Booked</button><button class="status-choice rounded px-3 py-2 transition" data-status-choice="cancelled" type="button">Cancel</button></div></td>
                                <td class="px-4 py-4"><span class="booking-status-label rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800">Processing</span><p class="booking-updated mt-1 text-xs text-on-surface-variant">Payment review pending</p></td>
                            </tr>
                            <tr class="booking-row" data-booking-id="sofia-lim" data-status="cancelled">
                                <td class="px-4 py-4"><strong class="text-primary">Sofia Lim</strong><p class="mt-1 text-xs text-on-surface-variant">sofia.lim@example.com</p></td>
                                <td class="px-4 py-4">Garden Pool Villa<p class="mt-1 text-xs text-on-surface-variant">Guest requested date change</p></td>
                                <td class="px-4 py-4">Oct 14 - Oct 16<p class="mt-1 text-xs text-on-surface-variant">2 nights</p></td>
                                <td class="px-4 py-4"><div class="status-picker inline-grid grid-cols-3 overflow-hidden rounded-lg border border-surface-container-highest bg-surface-container-low p-1 text-xs font-semibold"><button class="status-choice rounded px-3 py-2 transition" data-status-choice="processing" type="button">Processing</button><button class="status-choice rounded px-3 py-2 transition" data-status-choice="booked" type="button">Booked</button><button class="status-choice rounded px-3 py-2 transition" data-status-choice="cancelled" type="button">Cancel</button></div></td>
                                <td class="px-4 py-4"><span class="booking-status-label rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-error">Cancelled</span><p class="booking-updated mt-1 text-xs text-on-surface-variant">Cancelled by admin</p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>            <section class="grid gap-8 xl:grid-cols-12" id="stays"><article class="rounded-lg bg-white p-6 shadow-sm xl:col-span-8"><div class="flex flex-col justify-between gap-4 border-b border-surface-container-highest pb-5 sm:flex-row sm:items-center"><div><p class="text-xs font-semibold uppercase tracking-widest text-secondary">Expedition &amp; Reception</p><h2 class="mt-1 font-headline text-3xl text-primary">VIP Arrival Logistics &amp; Stays</h2></div><span class="w-fit rounded-full bg-surface-container px-3 py-1 text-xs font-semibold">3 Pending Transfers</span></div><div class="mt-4 overflow-x-auto"><table class="min-w-[720px] w-full text-left text-sm"><thead class="bg-surface-container-low text-xs uppercase tracking-wider text-on-surface-variant"><tr><th class="rounded-l px-4 py-3">Guest &amp; Villa</th><th class="px-4 py-3">Inbound Route</th><th class="px-4 py-3">Assigned Butler</th><th class="px-4 py-3">Status</th><th class="rounded-r px-4 py-3 text-right">Action</th></tr></thead><tbody class="divide-y divide-surface-container-highest"><tr><td class="px-4 py-4"><strong class="text-primary">Alexander Cruz</strong><p class="mt-1 text-xs text-on-surface-variant">Overwater Wellness Pavilion #104</p></td><td class="px-4 py-4">13:45 · Flight PR 2132<p class="mt-1 text-xs text-on-surface-variant">Dock Alpha speedboat</p></td><td class="px-4 py-4">Maya Soriano<p class="mt-1 text-xs text-on-surface-variant">Senior Butler</p></td><td class="px-4 py-4"><span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-secondary">En route</span></td><td class="px-4 py-4 text-right"><a aria-label="View arrival" class="inline-flex rounded p-1 text-on-surface-variant hover:bg-surface-container" href="{{ route('admin.operations', 'arrival-details') }}"><span class="material-symbols-outlined">more_horiz</span></a></td></tr><tr><td class="px-4 py-4"><strong class="text-primary">Elena Vandermeer</strong><p class="mt-1 text-xs text-on-surface-variant">Treetop Canopy Villa #202</p></td><td class="px-4 py-4">15:20 · Private charter<p class="mt-1 text-xs text-on-surface-variant">Helipad south arrival</p></td><td class="px-4 py-4">Noel Reyes<p class="mt-1 text-xs text-on-surface-variant">Villa Host</p></td><td class="px-4 py-4"><span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800">Awaiting departure</span></td><td class="px-4 py-4 text-right"><a aria-label="View arrival" class="inline-flex rounded p-1 text-on-surface-variant hover:bg-surface-container" href="{{ route('admin.operations', 'arrival-details') }}"><span class="material-symbols-outlined">more_horiz</span></a></td></tr></tbody></table></div></article><article class="rounded-lg bg-primary p-6 text-white shadow-sm xl:col-span-4" id="concierge"><p class="text-xs font-semibold uppercase tracking-widest text-secondary-fixed">Concierge Priority</p><h2 class="mt-2 font-headline text-3xl">Guest Requests</h2><div class="mt-6 space-y-4"><div class="border-b border-white/15 pb-4"><p class="font-semibold">Private sunset dinner</p><p class="mt-1 text-sm text-white/75">Seaside Romance Suite · 18:30</p></div><div class="border-b border-white/15 pb-4"><p class="font-semibold">Allergen-free tasting menu</p><p class="mt-1 text-sm text-white/75">Azure Ocean Suite · Chef notified</p></div><div><p class="font-semibold">Speedboat reschedule</p><p class="mt-1 text-sm text-white/75">Airport transfer · approval needed</p></div></div></article></section>
            <section class="grid gap-8 xl:grid-cols-12" id="villas"><article class="rounded-lg bg-white p-6 shadow-sm xl:col-span-7"><div class="flex items-center justify-between"><div><p class="text-xs font-semibold uppercase tracking-widest text-secondary">Villa Inventory</p><h2 class="mt-1 font-headline text-3xl text-primary">Housekeeping Readiness</h2></div><span class="material-symbols-outlined text-3xl text-primary">cleaning_services</span></div><div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4"><div class="rounded bg-green-50 p-4"><p class="text-2xl font-semibold text-secondary">28</p><p class="mt-1 text-xs text-on-surface-variant">Ready</p></div><div class="rounded bg-amber-50 p-4"><p class="text-2xl font-semibold text-amber-800">4</p><p class="mt-1 text-xs text-on-surface-variant">Turnover</p></div><div class="rounded bg-blue-50 p-4"><p class="text-2xl font-semibold text-primary">2</p><p class="mt-1 text-xs text-on-surface-variant">Inspection</p></div><div class="rounded bg-red-50 p-4"><p class="text-2xl font-semibold text-error">2</p><p class="mt-1 text-xs text-on-surface-variant">Maintenance</p></div></div><div class="mt-6 h-3 overflow-hidden rounded-full bg-surface-container-highest"><div class="h-full w-[78%] bg-secondary"></div></div><p class="mt-2 text-xs text-on-surface-variant">78% of villas prepared for current arrival window.</p></article><article class="rounded-lg bg-white p-6 shadow-sm xl:col-span-5" id="financials"><p class="text-xs font-semibold uppercase tracking-widest text-secondary">Financial Performance</p><h2 class="mt-1 font-headline text-3xl text-primary">Revenue Snapshot</h2><div class="mt-6 grid grid-cols-3 gap-3"><div class="rounded bg-surface-container-low p-3"><p class="text-xs text-on-surface-variant">ADR</p><p class="mt-2 font-headline text-2xl text-primary">PHP 68.5K</p><p class="mt-1 text-xs text-secondary">+6.2%</p></div><div class="rounded bg-surface-container-low p-3"><p class="text-xs text-on-surface-variant">RevPAR</p><p class="mt-2 font-headline text-2xl text-primary">PHP 64.5K</p><p class="mt-1 text-xs text-secondary">+18.4%</p></div><div class="rounded bg-surface-container-low p-3"><p class="text-xs text-on-surface-variant">Upsell</p><p class="mt-2 font-headline text-2xl text-primary">14.1%</p><p class="mt-1 text-xs text-secondary">On target</p></div></div><div class="mt-6 flex h-3 overflow-hidden rounded-full bg-surface-container-highest"><span class="w-[42%] bg-primary"></span><span class="w-[35%] bg-surface-tint"></span><span class="w-[23%] bg-tertiary-fixed-dim"></span></div><div class="mt-3 flex justify-between text-xs text-on-surface-variant"><span>Spa 42%</span><span>Marine 35%</span><span>Dining 23%</span></div></article></section>
        </main>
    </div>
    <script>
        const menu = document.getElementById('mobile-menu');
        const sidebar = document.getElementById('mobile-sidebar');
        menu?.addEventListener('click', () => {
            const open = !sidebar.classList.contains('hidden');
            sidebar.classList.toggle('hidden');
            menu.setAttribute('aria-expanded', String(!open));
        });

        document.querySelectorAll('.dashboard-action').forEach((button) => {
            button.addEventListener('click', () => {
                button.classList.add('opacity-70');
                setTimeout(() => button.classList.remove('opacity-70'), 180);
            });
        });

        const statusStyles = {
            processing: {
                label: 'Processing',
                note: 'Updated to processing',
                labelClass: 'bg-amber-50 text-amber-800',
                activeClass: 'bg-amber-100 text-amber-900 shadow-sm'
            },
            booked: {
                label: 'Successfully Booked',
                note: 'Confirmed successfully',
                labelClass: 'bg-green-50 text-secondary',
                activeClass: 'bg-green-100 text-secondary shadow-sm'
            },
            cancelled: {
                label: 'Cancelled',
                note: 'Booking has been cancelled',
                labelClass: 'bg-red-50 text-error',
                activeClass: 'bg-red-100 text-error shadow-sm'
            }
        };

        function applyBookingStatus(row, status, save = true) {
            const config = statusStyles[status] ?? statusStyles.processing;
            const label = row.querySelector('.booking-status-label');
            const updated = row.querySelector('.booking-updated');

            row.dataset.status = status;
            label.className = `booking-status-label rounded-full px-3 py-1 text-xs font-semibold ${config.labelClass}`;
            label.textContent = config.label;
            updated.textContent = config.note;

            row.querySelectorAll('.status-choice').forEach((button) => {
                const selected = button.dataset.statusChoice === status;
                button.className = `status-choice rounded px-3 py-2 transition ${selected ? config.activeClass : 'text-on-surface-variant hover:bg-white'}`;
                button.setAttribute('aria-pressed', String(selected));
            });

            if (save) {
                localStorage.setItem(`praisty-booking-status-${row.dataset.bookingId}`, status);
            }

            refreshStatusCounts();
        }

        function refreshStatusCounts() {
            const totals = { processing: 0, booked: 0, cancelled: 0 };
            document.querySelectorAll('.booking-row').forEach((row) => {
                totals[row.dataset.status] = (totals[row.dataset.status] ?? 0) + 1;
            });

            Object.entries(totals).forEach(([status, count]) => {
                const counter = document.querySelector(`[data-status-count="${status}"]`);
                if (counter) counter.textContent = count;
            });
        }

        document.querySelectorAll('.booking-row').forEach((row) => {
            const savedStatus = localStorage.getItem(`praisty-booking-status-${row.dataset.bookingId}`);
            applyBookingStatus(row, savedStatus || row.dataset.status, false);
            row.querySelectorAll('.status-choice').forEach((button) => {
                button.addEventListener('click', () => applyBookingStatus(row, button.dataset.statusChoice));
            });
        });
    </script>
<script src="{{ asset('js/admin-reservation-board.js') }}?v=202609281110"></script><script src="{{ asset('js/app.js') }}?v=202609280945"></script></body>
</html>



