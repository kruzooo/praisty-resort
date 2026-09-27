<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Forgot Password | Praisty Resort</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600&amp;family=Hanken+Grotesk:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <script>tailwind.config={theme:{extend:{colors:{primary:'#002b5c','primary-container':'#00417e',secondary:'#3d6e38',surface:'#fbf9f4','surface-container-low':'#f5f3ee','surface-container-highest':'#e4e2dd','on-surface':'#1b1c19','on-surface-variant':'#4e535b',outline:'#737780','tertiary-fixed-dim':'#e9c176'},fontFamily:{headline:['EB Garamond','serif'],body:['Hanken Grotesk','sans-serif']},spacing:{'margin-mobile':'20px','margin-desktop':'64px','container-max':'1280px'}}}}</script>
</head>
<body class="min-h-screen bg-surface font-body text-on-surface antialiased">
<nav class="sticky top-0 z-40 border-b border-surface-container-highest bg-surface/95 backdrop-blur">
    <div class="mx-auto flex max-w-container-max items-center justify-between px-margin-mobile py-4 md:px-margin-desktop">
        <a class="font-headline text-[28px] tracking-[0.16em] text-primary" href="{{ route('home') }}">PRAISTY RESORT</a>
        <a class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-secondary" href="{{ route('guest.login') }}"><span class="material-symbols-outlined text-lg">arrow_back</span>Back to login</a>
    </div>
</nav>
<main class="mx-auto grid max-w-container-max grid-cols-1 gap-10 px-margin-mobile py-12 md:px-margin-desktop lg:grid-cols-2 lg:items-center lg:py-20">
    <section>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-secondary">Secure Account Recovery</p>
        <h1 class="mt-3 max-w-lg font-headline text-6xl leading-[0.92] text-primary">Reset your guest password.</h1>
        <p class="mt-6 max-w-lg text-lg leading-8 text-on-surface-variant">Enter the email connected to your Praisty guest account and create a new password for local testing.</p>
        <div class="mt-8 rounded-lg bg-white p-5 text-sm leading-6 text-on-surface-variant shadow-sm">
            <span class="material-symbols-outlined align-bottom text-secondary">shield_lock</span>
            This local reset updates your database password directly. On production, this can later be replaced with an email reset link.
        </div>
    </section>
    <section class="rounded-lg bg-white p-7 shadow-xl sm:p-10">
        <h2 class="font-headline text-4xl text-primary">Forgot Password</h2>
        <p class="mt-2 text-sm text-on-surface-variant">Use your guest email address and choose a new password.</p>
        @if ($errors->any())
            <div class="mt-5 rounded border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('guest.password.update') }}" class="mt-7 space-y-5" method="POST">
            @csrf
            <label class="block text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Email address
                <input autocomplete="email" class="mt-2 w-full rounded border-0 bg-surface-container-low px-4 py-3 text-on-surface ring-1 ring-transparent focus:bg-white focus:ring-2 focus:ring-primary" name="email" required type="email" value="{{ old('email') }}">
            </label>
            <label class="block text-xs font-semibold uppercase tracking-wider text-on-surface-variant">New password
                <input autocomplete="new-password" class="mt-2 w-full rounded border-0 bg-surface-container-low px-4 py-3 text-on-surface ring-1 ring-transparent focus:bg-white focus:ring-2 focus:ring-primary" name="password" required type="password">
                <span class="mt-2 block normal-case text-on-surface-variant">At least 8 characters.</span>
            </label>
            <label class="block text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Confirm new password
                <input autocomplete="new-password" class="mt-2 w-full rounded border-0 bg-surface-container-low px-4 py-3 text-on-surface ring-1 ring-transparent focus:bg-white focus:ring-2 focus:ring-primary" name="password_confirmation" required type="password">
            </label>
            <button class="flex w-full items-center justify-center gap-2 rounded bg-primary-container px-6 py-3.5 text-sm font-semibold uppercase tracking-wider text-white transition-colors hover:bg-secondary" type="submit">Update Password<span class="material-symbols-outlined text-lg">lock_reset</span></button>
        </form>
        <p class="mt-6 text-center text-sm text-on-surface-variant">Remembered it? <a class="font-semibold text-primary underline underline-offset-4 hover:text-secondary" href="{{ route('guest.login') }}">Sign in</a></p>
    </section>
</main>
<script src="{{ asset('js/app.js') }}?v=202609271500"></script></body>
</html>

