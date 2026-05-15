<script>
    // Hero Slider
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.indicator');
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(ind => ind.classList.remove('active'));

        if (index >= totalSlides) currentSlide = 0;
        if (index < 0) currentSlide = totalSlides - 1;

        slides[currentSlide].classList.add('active');
        indicators[currentSlide].classList.add('active');
    }

    function nextSlide() {
        currentSlide++;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide--;
        showSlide(currentSlide);
    }

    // Auto slide
    let autoSlide = setInterval(nextSlide, 5000);

    // Manual controls
    document.querySelector('.slider-next')?.addEventListener('click', () => {
        nextSlide();
        clearInterval(autoSlide);
        autoSlide = setInterval(nextSlide, 5000);
    });

    document.querySelector('.slider-prev')?.addEventListener('click', () => {
        prevSlide();
        clearInterval(autoSlide);
        autoSlide = setInterval(nextSlide, 5000);
    });

    // Indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
            clearInterval(autoSlide);
            autoSlide = setInterval(nextSlide, 5000);
        });
    });
</script>


<script>
    // Animated Counter
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200;

    const animateCounter = (counter) => {
        const target = +counter.getAttribute('data-target');
        const increment = target / speed;
        let count = 0;

        const updateCount = () => {
            if (count < target) {
                count += increment;
                counter.innerText = Math.ceil(count);
                setTimeout(updateCount, 1);
            } else {
                counter.innerText = target;
            }
        };

        updateCount();
    };

    // Trigger animation when in viewport
    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target.querySelector('.stat-number');
                if (counter.hasAttribute('data-target') && !counter.classList.contains('counted')) {
                    animateCounter(counter);
                    counter.classList.add('counted');
                }
            }
        });
    }, observerOptions);

    document.querySelectorAll('.stat-box').forEach(box => observer.observe(box));
</script>



<script>
    // Gallery Lightbox
    const galleryImages = {!! json_encode(
        $galleries->map(function ($gallery) {
                return [
                    'src' => $gallery->image ? asset('storage/' . $gallery->image) : asset('assets/img/placeholder.jpg'),
                    'title' => $gallery->title,
                    'description' => $gallery->description ?? '',
                ];
            })->values(),
    ) !!};

    let currentImageIndex = 0;

    function openLightbox(index) {
        currentImageIndex = index;
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        const caption = document.getElementById('lightbox-caption');

        lightbox.classList.add('show');
        img.src = galleryImages[index].src;
        caption.innerHTML = `<strong>${galleryImages[index].title}</strong><br>${galleryImages[index].description}`;
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function changeLightboxImage(direction) {
        currentImageIndex += direction;
        if (currentImageIndex >= galleryImages.length) {
            currentImageIndex = 0;
        }
        if (currentImageIndex < 0) {
            currentImageIndex = galleryImages.length - 1;
        }

        const img = document.getElementById('lightbox-img');
        const caption = document.getElementById('lightbox-caption');

        img.src = galleryImages[currentImageIndex].src;
        caption.innerHTML =
            `<strong>${galleryImages[currentImageIndex].title}</strong><br>${galleryImages[currentImageIndex].description}`;
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('lightbox').classList.contains('show')) {
            if (e.key === 'ArrowLeft') changeLightboxImage(-1);
            if (e.key === 'ArrowRight') changeLightboxImage(1);
            if (e.key === 'Escape') closeLightbox();
        }
    });
</script>


<script>
    // Testimonial Slider
    const testimonialTrack = document.querySelector('.testimonial-track');
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    const testimonialPrev = document.querySelector('.testimonial-prev');
    const testimonialNext = document.querySelector('.testimonial-next');

    let testimonialIndex = 0;
    const testimonialCardsToShow = window.innerWidth > 1024 ? 3 : (window.innerWidth > 768 ? 2 : 1);
    const maxTestimonialIndex = testimonialCards.length - testimonialCardsToShow;

    function updateTestimonialSlider() {
        const cardWidth = testimonialCards[0].offsetWidth;
        const gap = 30;
        testimonialTrack.style.transform = `translateX(-${testimonialIndex * (cardWidth + gap)}px)`;
    }

    testimonialNext?.addEventListener('click', () => {
        if (testimonialIndex < maxTestimonialIndex) {
            testimonialIndex++;
            updateTestimonialSlider();
        }
    });

    testimonialPrev?.addEventListener('click', () => {
        if (testimonialIndex > 0) {
            testimonialIndex--;
            updateTestimonialSlider();
        }
    });

    // Auto slide testimonials
    setInterval(() => {
        if (testimonialIndex >= maxTestimonialIndex) {
            testimonialIndex = 0;
        } else {
            testimonialIndex++;
        }
        updateTestimonialSlider();
    }, 5000);
</script>
