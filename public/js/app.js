// Crossfade duplicate layers before the clip ends to soften the loop transition.
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname === '/customer-dashboard') {
        document.querySelectorAll('nav a[href="#itinerary"], nav a[href="#privileges"]').forEach((link) => link.remove());
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const videos = Array.from(document.querySelectorAll('[data-hero-video]'));
    const toggle = document.getElementById('hero-video-toggle');
    const toggleIcon = document.getElementById('hero-video-toggle-icon');

    if (videos.length !== 2 || !toggle || !toggleIcon || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const crossfadeDuration = 1.25;
    let activeIndex = 0;
    let isPaused = false;
    let isCrossfading = false;

    const playVideo = (video) => video.play().catch(() => {
        isPaused = true;
        toggle.setAttribute('aria-label', 'Play hero video');
        toggle.setAttribute('aria-pressed', 'true');
        toggleIcon.textContent = 'play_arrow';
    });

    const crossfadeToNextVideo = () => {
        if (isCrossfading || isPaused) {
            return;
        }

        isCrossfading = true;
        const currentVideo = videos[activeIndex];
        const nextIndex = activeIndex === 0 ? 1 : 0;
        const nextVideo = videos[nextIndex];

        nextVideo.currentTime = 0;
        nextVideo.classList.add('is-active');
        playVideo(nextVideo);
        currentVideo.classList.remove('is-active');
        activeIndex = nextIndex;

        window.setTimeout(() => {
            currentVideo.pause();
            currentVideo.currentTime = 0;
            isCrossfading = false;
        }, crossfadeDuration * 1000);
    };

    videos.forEach((video, index) => {
        video.addEventListener('loadedmetadata', () => {
            if (index === activeIndex && !isPaused) {
                playVideo(video);
            }
        });

        video.addEventListener('timeupdate', () => {
            if (index === activeIndex && Number.isFinite(video.duration) && video.currentTime >= video.duration - crossfadeDuration) {
                crossfadeToNextVideo();
            }
        });

        video.addEventListener('ended', () => {
            if (index === activeIndex && !isPaused) {
                video.currentTime = 0;
                playVideo(video);
            }
        });
    });

    toggle.addEventListener('click', () => {
        isPaused = !isPaused;

        if (isPaused) {
            videos.forEach((video) => video.pause());
            toggle.setAttribute('aria-label', 'Play hero video');
            toggle.setAttribute('aria-pressed', 'true');
            toggleIcon.textContent = 'play_arrow';
            return;
        }

        playVideo(videos[activeIndex]);
        toggle.setAttribute('aria-label', 'Pause hero video');
        toggle.setAttribute('aria-pressed', 'false');
        toggleIcon.textContent = 'pause';
    });
});

// Reveal meaningful page content as it enters the viewport without affecting navigation or forms.
document.addEventListener('DOMContentLoaded', () => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const targets = Array.from(document.querySelectorAll([
        'main > section',
        'main > article',
        'body > section:not(:first-of-type)',
        '.experience-card',
        '.room-card',
        '.life-carousel',
        '#faq-container > *',
    ].join(',')));

    let uniqueTargets = [...new Set(targets)].filter((element) => !element.closest('[data-hero-video]'));

    // Simple pages without component-level sections still receive the reveal, without
    // animating a parent and its cards at the same time.
    if (uniqueTargets.length === 0) {
        uniqueTargets = Array.from(document.querySelectorAll('main')).filter((element) => !element.closest('[data-hero-video]'));
    }

    if (!('IntersectionObserver' in window)) {
        uniqueTargets.forEach((element) => element.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries, activeObserver) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-visible');
            activeObserver.unobserve(entry.target);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -48px' });

    uniqueTargets.forEach((element, index) => {
        element.classList.add('scroll-reveal');
        element.style.transitionDelay = `${Math.min(index % 4, 3) * 80}ms`;
        observer.observe(element);
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('[data-life-carousel]');

    if (!carousel) {
        return;
    }

    const viewport = carousel.querySelector('[data-life-viewport]');
    const track = carousel.querySelector('[data-life-track]');
    const slides = Array.from(carousel.querySelectorAll('[data-life-slide]'));
    const dots = carousel.querySelector('[data-life-dots]');
    const previous = carousel.querySelector('[data-life-prev]');
    const next = carousel.querySelector('[data-life-next]');
    let activeIndex = 0;
    let startX = 0;
    let isDragging = false;

    const updateCarousel = () => {
        const activeSlide = slides[activeIndex];
        const viewportCenter = viewport.getBoundingClientRect().width / 2;
        const slideCenter = activeSlide.offsetLeft + activeSlide.offsetWidth / 2;

        track.style.transform = `translateX(${viewportCenter - slideCenter}px)`;
        slides.forEach((slide, index) => slide.classList.toggle('is-active', index === activeIndex));
        Array.from(dots.children).forEach((dot, index) => {
            const isActive = index === activeIndex;
            dot.classList.toggle('is-active', isActive);
            dot.setAttribute('aria-current', isActive ? 'true' : 'false');
        });
    };

    slides.forEach((slide, index) => {
        const dot = document.createElement('button');
        dot.className = 'life-carousel__dot';
        dot.type = 'button';
        dot.setAttribute('aria-label', `Show experience ${index + 1}`);
        dot.addEventListener('click', () => {
            activeIndex = index;
            updateCarousel();
        });
        dots.append(dot);
    });

    const move = (step) => {
        activeIndex = (activeIndex + step + slides.length) % slides.length;
        updateCarousel();
    };

    previous.addEventListener('click', (event) => {
        event.stopPropagation();
        move(-1);
    });
    next.addEventListener('click', (event) => {
        event.stopPropagation();
        move(1);
    });
    [previous, next].forEach((button) => {
        button.addEventListener('pointerdown', (event) => event.stopPropagation());
        button.addEventListener('pointerup', (event) => event.stopPropagation());
    });
    viewport.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') move(-1);
        if (event.key === 'ArrowRight') move(1);
    });
    viewport.addEventListener('pointerdown', (event) => {
        isDragging = true;
        startX = event.clientX;
        viewport.setPointerCapture(event.pointerId);
        viewport.classList.add('is-dragging');
    });
    viewport.addEventListener('pointerup', (event) => {
        if (!isDragging) return;
        const distance = event.clientX - startX;
        if (Math.abs(distance) > 40) move(distance < 0 ? 1 : -1);
        isDragging = false;
        viewport.classList.remove('is-dragging');
    });
    viewport.addEventListener('pointercancel', () => {
        isDragging = false;
        viewport.classList.remove('is-dragging');
    });
    window.addEventListener('resize', updateCarousel);
    window.addEventListener('load', updateCarousel);
    updateCarousel();
});

document.addEventListener('DOMContentLoaded', () => {
    const isStaticVercel = window.location.hostname.endsWith('.vercel.app');

    if (!isStaticVercel) {
        return;
    }

    const profileStorageKey = 'praisty_guest_profile';
    const readProfile = () => {
        try {
            return JSON.parse(window.localStorage.getItem(profileStorageKey) || 'null');
        } catch {
            return null;
        }
    };
    const writeProfile = (profile) => {
        window.localStorage.setItem(profileStorageKey, JSON.stringify(profile));
    };
    const apiPost = async (path, payload) => {
        const response = await fetch(path, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
        });
        const data = await response.json().catch(() => ({}));

        if (!response.ok || data.ok === false) {
            throw new Error(data.message || 'The request could not be completed.');
        }

        return data;
    };
    const formPayload = (form) => Object.fromEntries(new FormData(form).entries());
    const nameFromEmail = (email) => {
        const base = String(email || 'Guest').split('@')[0].replace(/[._-]+/g, ' ').trim();

        return base ? base.replace(/\b\w/g, (letter) => letter.toUpperCase()) : 'Praisty Guest';
    };
    const applyStaticProfile = () => {
        const profile = readProfile();
        const button = document.getElementById('profile-menu-button');
        const menu = document.getElementById('profile-menu');

        if (!profile || !button || !menu) {
            return;
        }

        button.textContent = (profile.name || 'G').trim().charAt(0).toUpperCase();
        menu.innerHTML = `
            <div class="border-b border-surface-container-highest px-5 py-4">
                <p class="text-sm font-semibold text-primary">${profile.name}</p>
                <p class="mt-1 truncate text-xs text-on-surface-variant">${profile.email}</p>
            </div>
            <div class="p-2">
                <a class="flex items-center gap-3 rounded px-3 py-2.5 text-sm font-semibold text-primary transition-colors hover:bg-surface-container-low" href="/customer-dashboard" role="menuitem"><span class="material-symbols-outlined text-lg">dashboard</span>Customer Dashboard</a>
                <a class="flex items-center gap-3 rounded px-3 py-2.5 text-sm text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-primary" href="/rooms" role="menuitem"><span class="material-symbols-outlined text-lg">villa</span>Explore Rooms & Villas</a>
                <button class="flex w-full items-center gap-3 rounded px-3 py-2.5 text-left text-sm text-error transition-colors hover:bg-red-50" data-static-logout type="button"><span class="material-symbols-outlined text-lg">logout</span>Sign out</button>
            </div>
        `;
        menu.querySelector('[data-static-logout]')?.addEventListener('click', () => {
            window.localStorage.removeItem(profileStorageKey);
            window.location.href = '/';
        });
    };

    applyStaticProfile();

    const roomCatalog = {
        'royal-overwater-bungalow': { name: 'Royal Overwater Bungalow', type: 'Overwater Bungalow', image: '/images/resort/royal-overwater-bungalow.png', price: 95000, feature: 'Direct Lagoon Access', bed: '1 King Bed' },
        'sunset-beachfront-villa': { name: 'Sunset Beachfront Villa', type: 'Beachfront Villa', image: '/images/resort/sunset-beachfront-villa.png', price: 88000, feature: 'Sunset Beach Access', bed: '2 King Beds' },
        'canopy-jungle-villa': { name: 'Canopy Jungle Villa', type: 'Private Villa', image: '/images/resort/canopy-jungle-villa.png', price: 82000, feature: 'Private Plunge Pool', bed: '2 King Beds' },
        'ocean-serenity-wellness-villa': { name: 'Ocean Serenity Wellness Villa', type: 'Wellness Villa', image: '/images/resort/ocean-serenity-wellness-villa.png', price: 72000, feature: 'Wellness Terrace', bed: '1 King Bed + Lounge' },
        'azure-ocean-suite': { name: 'Azure Ocean Suite', type: 'Premium Suite', image: '/images/resort/azure-ocean-suite.png', price: 48000, feature: 'Panoramic Ocean View', bed: '1 King Bed' },
        'lagoon-view-casita': { name: 'Lagoon View Casita', type: 'Lagoon Casita', image: '/images/resort/lagoon-view-casita.png', price: 34000, feature: 'Lagoon View Deck', bed: '1 King Bed + Daybed' },
        'deluxe-garden-villa': { name: 'Deluxe Garden Villa', type: 'Garden Villa', image: '/images/resort/deluxe-garden-villa.png', price: 28000, feature: 'Private Garden Veranda', bed: '1 King Bed' },
        'palm-studio-suite': { name: 'Palm Studio Suite', type: 'Studio Suite', image: '/images/resort/palm-studio-suite.png', price: 22000, feature: 'Palm Grove View', bed: '1 Queen Bed' },
        'winter-sun-pool-villa': { name: 'Winter Sun Pool Villa', type: 'Seasonal Villa', image: '/images/resort/winter-sun-escape.png', price: 58000, feature: 'Ocean-View Pool Deck', bed: '1 King Bed' },
        'seaside-romance-suite': { name: 'Seaside Romance Suite', type: 'Romance Suite', image: '/images/resort/seaside-romance-retreat.png', price: 64000, feature: 'Private Sunset Terrace', bed: '1 King Bed' },
        'reef-overwater-spa-villa': { name: 'Reef Overwater Spa Villa', type: 'Spa Villa', image: '/images/resort/reef-overwater-spa-villa.png', price: 90000, feature: 'Outdoor Soaking Bath', bed: '1 King Bed + Lounge' },
        'golden-tide-beach-villa': { name: 'Golden Tide Beach Villa', type: 'Beach Villa', image: '/images/resort/golden-tide-beach-villa.png', price: 86000, feature: 'Sunset Dining Terrace', bed: '2 King Beds' },
        'coral-horizon-overwater-villa': { name: 'Coral Horizon Overwater Villa', type: 'Overwater Villa', image: '/images/resort/overwater-wellness-ritual.png', price: 92000, feature: 'Direct Reef Access', bed: '1 King Bed + Lounge' },
    };
    const formatMoney = (value) => `PHP ${new Intl.NumberFormat('en-PH').format(value)}`;
    const formatStayDate = (value) => {
        if (!value) return 'Date pending';
        const text = String(value);
        const date = new Date(text.length > 10 ? text : `${text}T00:00:00`);
        return Number.isNaN(date.getTime()) ? 'Date pending' : new Intl.DateTimeFormat('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }).format(date);
    };
    const hydrateReservationPages = () => {
        if (!['/reservation-cart', '/guest-payment', '/booking-confirmation'].includes(window.location.pathname)) return;
        let reservation = null;
        try {
            reservation = JSON.parse(window.localStorage.getItem(window.location.pathname === '/booking-confirmation' ? 'praisty_latest_reservation' : 'praisty_pending_reservation') || 'null');
        } catch {
            reservation = null;
        }
        const room = roomCatalog[reservation?.room_slug];
        if (!room) return;
        const checkIn = formatStayDate(reservation.check_in);
        const checkOut = formatStayDate(reservation.check_out);
        const nights = reservation.check_in && reservation.check_out
            ? Math.max(1, Math.round((new Date(`${reservation.check_out}T00:00:00`) - new Date(`${reservation.check_in}T00:00:00`)) / 86400000))
            : 1;
        const guests = Number(reservation.guests || 1);
        const stayTotal = room.price * nights;
        const resortFee = Math.round(stayTotal * 0.05);
        const taxes = Math.round(stayTotal * 0.09);
        const total = stayTotal + resortFee + taxes;
        const main = document.querySelector('main');
        const images = [...(main?.querySelectorAll('img[src*="/images/resort/"]') || [])];
        images[0]?.setAttribute('src', room.image);
        images[0]?.setAttribute('alt', room.name);

        if (window.location.pathname === '/reservation-cart') {
            const card = main?.querySelector('section.overflow-hidden');
            const title = card?.querySelector('h2');
            if (title) title.textContent = room.name;
            if (title?.previousElementSibling) title.previousElementSibling.textContent = room.type;
            const dateChip = [...(card?.querySelectorAll('span') || [])].find((element) => element.textContent.includes(' - '));
            if (dateChip) dateChip.childNodes[dateChip.childNodes.length - 1].textContent = `${checkIn} - ${checkOut} (${nights} ${nights === 1 ? 'Night' : 'Nights'})`;
            const featureChip = [...(card?.querySelectorAll('span') || [])].find((element) => element.textContent.includes('Direct Lagoon Access'));
            if (featureChip) featureChip.childNodes[featureChip.childNodes.length - 1].textContent = room.feature;
            const editLink = card?.querySelector('a[href^="/rooms/"]');
            if (editLink) editLink.href = `/rooms/${reservation.room_slug}#reservation`;
            const rate = [...(card?.querySelectorAll('span') || [])].find((element) => element.textContent.includes('Nightly rate:'));
            if (rate) rate.textContent = `Nightly rate: ${formatMoney(room.price)} x ${nights} nights`;
            const summary = main?.querySelector('#total-value');
            if (summary) { summary.textContent = formatMoney(total); summary.dataset.base = total; }
            const summaryRows = [...(main?.querySelectorAll('aside .my-6 > div.flex.justify-between') || [])];
            if (summaryRows.length >= 3) {
                summaryRows[0].firstElementChild.textContent = `Accommodation (${nights} ${nights === 1 ? 'night' : 'nights'})`;
                summaryRows[0].lastElementChild.textContent = formatMoney(stayTotal);
                summaryRows[1].lastElementChild.textContent = formatMoney(resortFee);
                summaryRows[2].lastElementChild.textContent = formatMoney(taxes);
            }
        }

        if (window.location.pathname === '/guest-payment') {
            const title = main?.querySelector('aside h3');
            if (title) title.textContent = room.name;
            if (title?.previousElementSibling) title.previousElementSibling.textContent = room.type;
            const dateText = [...(main?.querySelectorAll('aside p') || [])].find((element) => element.textContent.includes(' - '));
            if (dateText) dateText.textContent = `${checkIn} - ${checkOut}`;
            const nightText = [...(main?.querySelectorAll('aside p') || [])].find((element) => element.textContent.includes('nights'));
            if (nightText) nightText.textContent = `${nights} ${nights === 1 ? 'night' : 'nights'} · ${guests} ${guests === 1 ? 'guest' : 'guests'}`;
        }

        if (window.location.pathname === '/booking-confirmation') {
            const title = main?.querySelector('article h2');
            if (title) title.textContent = room.name;
            const values = main?.querySelectorAll('article .grid p.mt-1');
            if (values?.length >= 4) {
                values[0].textContent = checkIn;
                values[1].textContent = checkOut;
                values[2].textContent = `${nights} ${nights === 1 ? 'Night' : 'Nights'}`;
                values[3].textContent = `${guests} ${guests === 1 ? 'Guest' : 'Guests'}`;
            }
        }
    };
    hydrateReservationPages();

    const hydrateCustomerDashboard = async () => {
        if (window.location.pathname !== '/customer-dashboard') return;
        const profile = readProfile();
        let storedReservation = null;
        try { storedReservation = JSON.parse(localStorage.getItem('praisty_latest_reservation') || 'null'); } catch { /* Ignore malformed local state. */ }
        const email = profile?.email || storedReservation?.guest_email || storedReservation?.email;
        if (!email) return;

        try {
            const response = await fetch(`/api/reservations?email=${encodeURIComponent(email)}&t=${Date.now()}`, { headers: { Accept: 'application/json' }, cache: 'no-store' });
            if (!response.ok) return;
            const data = await response.json();
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const reservations = (data.reservations || (data.reservation ? [data.reservation] : []))
                .filter((reservation) => {
                    const checkout = new Date(String(reservation.check_out || '').length > 10 ? reservation.check_out : `${reservation.check_out}T00:00:00`);
                    return Number.isNaN(checkout.getTime()) || checkout > today;
                })
                .filter((reservation) => roomCatalog[reservation.room_slug]);
            const reservation = reservations[0];
            const overview = document.querySelector('#overview');
            const stay = document.querySelector('#stay');
            const stayInner = stay?.querySelector(':scope > .mx-auto');
            const stayTemplate = stayInner?.querySelector(':scope > .overflow-hidden');
            if (!stayInner || !stayTemplate) return;

            if (!reservations.length) {
                stayInner.innerHTML = '<div class="rounded-xl bg-white p-8 text-center shadow-sm md:p-12"><span class="material-symbols-outlined text-5xl text-primary">travel_explore</span><h2 class="mt-4 font-headline text-4xl text-primary">Your next sanctuary awaits.</h2><p class="mx-auto mt-3 max-w-lg text-on-surface-variant">Your completed stays will clear from this view. Plan another escape whenever you are ready.</p><a class="mt-6 inline-flex items-center gap-2 rounded bg-primary px-5 py-3 text-xs font-semibold uppercase tracking-wider text-white" href="/rooms">Explore Rooms &amp; Villas <span class="material-symbols-outlined text-lg">arrow_forward</span></a></div>';
                return;
            }

            const renderStay = (card, currentReservation) => {
                const room = roomCatalog[currentReservation.room_slug];
                const status = currentReservation.status === 'booked'
                    ? { label: 'Successfully Booked', classes: 'bg-green-100 text-green-900' }
                    : currentReservation.status === 'cancelled'
                        ? { label: 'Cancelled', classes: 'bg-red-100 text-red-900' }
                        : { label: 'Processing', classes: 'bg-amber-100 text-amber-900' };
                const checkIn = formatStayDate(currentReservation.check_in);
                const checkOut = formatStayDate(currentReservation.check_out);
                const start = new Date(String(currentReservation.check_in).length > 10 ? currentReservation.check_in : `${currentReservation.check_in}T00:00:00`);
                const end = new Date(String(currentReservation.check_out).length > 10 ? currentReservation.check_out : `${currentReservation.check_out}T00:00:00`);
                const nights = Number.isNaN(start.getTime()) || Number.isNaN(end.getTime()) ? 1 : Math.max(1, Math.round((end - start) / 86400000));
                const stayTotal = room.price * nights;
                const total = stayTotal + Math.round(stayTotal * 0.05) + Math.round(stayTotal * 0.09);
                const image = card.querySelector('img');
                if (image) { image.src = room.image; image.alt = room.name; }
                const title = card.querySelector('h2');
                if (title) title.textContent = room.name;
                if (title?.previousElementSibling) title.previousElementSibling.textContent = room.type;
                const statusBadge = card.querySelector('.flex.items-center.justify-between.border-b span');
                if (statusBadge) { statusBadge.textContent = status.label; statusBadge.className = `rounded px-2.5 py-1 text-xs font-semibold ${status.classes}`; }
                const dates = card.querySelectorAll('.grid.grid-cols-2 p.mt-1');
                if (dates?.length >= 2) { dates[0].textContent = checkIn; dates[1].textContent = checkOut; }
                const summary = card.querySelector('.rounded-xl.bg-surface-container-low');
                const summaryValues = summary?.querySelectorAll('span');
                if (summaryValues?.length >= 4) { summaryValues[0].textContent = `${nights} ${nights === 1 ? 'night' : 'nights'} accommodation`; summaryValues[1].textContent = formatMoney(stayTotal); summaryValues[3].textContent = formatMoney(total); }
            };

            stayInner.classList.add('grid', 'gap-6');
            stayInner.querySelectorAll(':scope > .overflow-hidden').forEach((card, index) => { if (index > 0) card.remove(); });
            reservations.slice(1).forEach(() => stayInner.appendChild(stayTemplate.cloneNode(true)));
            [...stayInner.querySelectorAll(':scope > .overflow-hidden')].forEach((card, index) => renderStay(card, reservations[index]));

            const heroName = overview?.querySelector('h1');
            if (heroName) heroName.textContent = `Welcome to your private sanctuary, ${reservation.guest_name || profile?.name || 'Guest'}.`;
            const reference = overview?.querySelector('section:first-of-type p span');
            if (reference) reference.textContent = `#${reservation.id}`;
            const latestStatus = reservation.status === 'booked' ? 'Successfully Booked' : reservation.status === 'cancelled' ? 'Cancelled' : 'Processing';
            const topStatus = overview?.querySelector('.grid.gap-4 > div:first-child p:last-child');
            if (topStatus) topStatus.textContent = reservations.length > 1 ? `${reservations.length} active reservations` : latestStatus;
        } catch {
            // Keep the dashboard's existing reservation view when the live feed is temporarily unavailable.
        }
    };
    hydrateCustomerDashboard();
    if (window.location.pathname === '/customer-dashboard') {
        window.setInterval(hydrateCustomerDashboard, 5000);
        window.addEventListener('focus', hydrateCustomerDashboard);
    }

    if (window.location.pathname === '/guest-login' && new URLSearchParams(window.location.search).has('created')) {
        const form = document.querySelector('form');

        if (form) {
            const message = document.createElement('p');
            message.className = 'mb-4 rounded bg-green-50 px-4 py-3 text-sm font-semibold text-secondary';
            message.textContent = 'Account created successfully. Please sign in to continue.';
            form.before(message);
        }
    }

    const showStatus = (form, message) => {
        let status = form.querySelector('[data-static-form-status]');

        if (!status) {
            status = document.createElement('p');
            status.dataset.staticFormStatus = 'true';
            status.className = 'mt-4 text-sm font-semibold text-primary';
            form.append(status);
        }

        status.textContent = message;
    };

    document.querySelectorAll('form[method="POST"], form[method="post"]').forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const action = form.getAttribute('action') || window.location.pathname;

            if (action.includes('/rooms/') || action.includes('/reservation')) {
                const profile = readProfile();

                if (!profile) {
                    window.location.href = '/guest-login';
                    return;
                }

                try {
                    const payload = formPayload(form);
                    payload.guest = profile;
                    payload.room_slug = payload.room_slug
                        || action.split('/rooms/')[1]?.split('/')[0]
                        || window.location.pathname.split('/rooms/')[1]
                        || '';
                    window.localStorage.setItem('praisty_pending_reservation', JSON.stringify(payload));
                    window.location.replace('/reservation-cart');
                } catch (error) {
                    showStatus(form, error.message);
                }
                return;
            }

            if (action.includes('/guest-payment')) {
                const profile = readProfile();
                let pending = null;

                try {
                    pending = JSON.parse(window.localStorage.getItem('praisty_pending_reservation') || 'null');
                } catch {
                    pending = null;
                }

                if (!profile || !pending?.room_slug) {
                    window.location.replace('/rooms');
                    return;
                }

                try {
                    const payload = { ...pending, ...formPayload(form), guest: profile };
                    const data = await apiPost('/api/reservations', payload);
                    window.localStorage.setItem('praisty_latest_reservation', JSON.stringify({
                        ...payload,
                        ...data.reservation,
                        guest_name: profile.name,
                        guest_email: profile.email,
                    }));
                    window.localStorage.removeItem('praisty_pending_reservation');
                    window.location.replace('/booking-confirmation');
                } catch (error) {
                    showStatus(form, error.message);
                }
                return;
            }

            if (action.includes('/create-account')) {
                try {
                    const data = await apiPost('/api/auth/register', formPayload(form));
                    writeProfile(data.guest);
                    window.location.href = '/guest-login?created=1';
                } catch (error) {
                    showStatus(form, error.message);
                }
                return;
            }

            if (action.includes('/guest-login')) {
                try {
                    const payload = formPayload(form);
                    const data = await apiPost('/api/auth/login', payload);
                    writeProfile(data.guest || {
                        name: nameFromEmail(payload.email),
                        email: payload.email || 'guest@praisty.local',
                    });
                    window.location.href = '/';
                } catch (error) {
                    showStatus(form, error.message);
                }
                return;
            }

            if (action.includes('/admin/login')) {
                try {
                    const data = await apiPost('/api/admin/login', formPayload(form));
                    window.localStorage.setItem('praisty_admin_profile', JSON.stringify(data.admin));
                    showStatus(form, 'Admin verified. Opening dashboard...');
                    window.setTimeout(() => {
                        window.location.href = '/admin/dashboard';
                    }, 700);
                } catch (error) {
                    showStatus(form, error.message);
                }
                return;
            }

            if (action.includes('/forgot-password')) {
                showStatus(form, 'Password reset requests are available on the full Laravel backend.');
                return;
            }

            if (action.includes('/contact')) {
                try {
                    const data = await apiPost('/api/contact', formPayload(form));
                    form.reset();
                    showStatus(form, data.message || 'Thank you. Your inquiry was sent to the Praisty team.');
                } catch (error) {
                    showStatus(form, error.message);
                }
                return;
            }

            if (action.includes('/customer-feedback')) {
                const profile = readProfile();
                try {
                    const payload = formPayload(form);
                    payload.guest = profile || {};
                    const data = await apiPost('/api/feedback', payload);
                    form.reset();
                    showStatus(form, data.message || 'Thank you. Your feedback was sent.');
                } catch (error) {
                    showStatus(form, error.message);
                }
                return;
            }

            showStatus(form, 'This action is connected to the backend where available.');
        });
    });
});
