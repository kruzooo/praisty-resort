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
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            const action = form.getAttribute('action') || window.location.pathname;

            if (action.includes('/rooms/') || action.includes('/reservation')) {
                window.location.href = '/guest-login';
                return;
            }

            if (action.includes('/create-account')) {
                window.location.href = '/guest-login?created=1';
                return;
            }

            if (action.includes('/guest-login')) {
                window.location.href = '/';
                return;
            }

            if (action.includes('/admin/login')) {
                showStatus(form, 'Admin login is available on the local or shared-hosting Laravel backend.');
                return;
            }

            if (action.includes('/forgot-password')) {
                showStatus(form, 'Password reset requests are available on the full Laravel backend.');
                return;
            }

            showStatus(form, 'Thank you. Your message has been received for review.');
        });
    });
});
