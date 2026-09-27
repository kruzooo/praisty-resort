// Crossfade duplicate layers before the clip ends to soften the loop transition.
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
                    payload.room_slug = action.split('/rooms/')[1]?.split('/')[0] || window.location.pathname.split('/rooms/')[1] || '';
                    const data = await apiPost('/api/reservations', payload);
                    window.localStorage.setItem('praisty_latest_reservation', JSON.stringify({
                        ...payload,
                        ...data.reservation,
                        guest_name: profile.name,
                        guest_email: profile.email,
                    }));
                    window.location.replace('/customer-dashboard');
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
