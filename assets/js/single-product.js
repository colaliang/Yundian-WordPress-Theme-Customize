/**
 * ERDU Single Product Page Scripts
 * Gallery lightbox, video switcher, smooth scroll nav
 *
 * @package ERDU_Lighting
 */

(function () {
    'use strict';

    // ==========================================
    // Product Gallery & Lightbox
    // ==========================================
    function initProductGallery() {
        const galleryContainer = document.getElementById('erdu-gallery-container');
        const mainImage = document.getElementById('erdu-main-image');
        const mainImageWrapper = document.getElementById('erdu-main-image-wrapper');
        const thumbs = Array.from(document.querySelectorAll('.erdu-gallery-thumb'));

        const videoContainer = document.getElementById('erdu-video-container');
        const videoThumb = document.getElementById('erdu-video-thumb');
        const btnPhotos = document.getElementById('btn-show-photos');
        const btnVideo = document.getElementById('btn-show-video');

        const lightbox = document.getElementById('erdu-lightbox');
        const lightboxImg = document.getElementById('erdu-lightbox-img');
        const lightboxClose = document.getElementById('erdu-lightbox-close');
        const lightboxPrev = document.getElementById('erdu-lightbox-prev');
        const lightboxNext = document.getElementById('erdu-lightbox-next');
        const lightboxCurrent = document.getElementById('erdu-lightbox-current');
        const lightboxThumbs = Array.from(document.querySelectorAll('.erdu-lightbox-thumb'));

        if (!galleryContainer || !mainImage) return;

        // Helper: Stop video playback
        const stopVideoPlayback = function () {
            if (!videoContainer) return;

            var iframeEl = videoContainer.querySelector('iframe');
            if (iframeEl) {
                var currentSrc = iframeEl.getAttribute('src');
                if (currentSrc) {
                    iframeEl.setAttribute('src', currentSrc);
                }
            }

            var videoEl = videoContainer.querySelector('video');
            if (videoEl) {
                videoEl.pause();
                videoEl.currentTime = 0;
            }
        };

        // Helper: Show Photos
        var showPhotos = function () {
            if (videoContainer) videoContainer.classList.add('hidden');
            if (mainImageWrapper) mainImageWrapper.classList.remove('hidden');

            if (btnPhotos && btnVideo) {
                btnPhotos.className = "flex items-center justify-center px-2 py-1 rounded-md text-sm transition-colors bg-white text-black font-bold shadow-sm";
                btnVideo.className = "flex items-center justify-center px-2 py-1 rounded-md text-sm transition-colors text-black font-normal hover:bg-white/50 hover:text-black hover:font-bold";
            }

            if (videoThumb) {
                videoThumb.classList.remove('border-[#f97316]', 'opacity-100');
                videoThumb.classList.add('border-transparent', 'opacity-70');
            }

            stopVideoPlayback();
        };

        // Helper: Show Video
        var showVideo = function () {
            if (videoContainer) videoContainer.classList.remove('hidden');
            if (mainImageWrapper) mainImageWrapper.classList.add('hidden');

            if (btnPhotos && btnVideo) {
                btnVideo.className = "flex items-center justify-center px-2 py-1 rounded-md text-sm transition-colors bg-white text-black font-bold shadow-sm";
                btnPhotos.className = "flex items-center justify-center px-2 py-1 rounded-md text-sm transition-colors text-black font-normal hover:bg-white/50 hover:text-black hover:font-bold";
            }

            // Reset photo thumbnails highlight
            thumbs.forEach(function (t) {
                t.classList.remove('border-[#f97316]', 'opacity-100');
                t.classList.add('border-transparent', 'opacity-70');
            });

            // Highlight video thumb
            if (videoThumb) {
                videoThumb.classList.remove('border-transparent', 'opacity-70');
                videoThumb.classList.add('border-[#f97316]', 'opacity-100');
            }
        };

        // Event Listeners for Media Switchers
        if (btnPhotos && btnVideo) {
            btnPhotos.addEventListener('click', showPhotos);
            btnVideo.addEventListener('click', showVideo);
        }
        if (videoThumb) {
            videoThumb.addEventListener('click', showVideo);
        }

        // Update main image logic
        var updateMainImage = function (thumb) {
            showPhotos();

            var fullUrl = thumb.getAttribute('data-full');
            var index = thumb.getAttribute('data-index');
            mainImage.src = fullUrl;
            mainImage.setAttribute('data-current-index', index);

            // Update thumbnail states (Page)
            thumbs.forEach(function (t) {
                t.classList.remove('border-[#f97316]', 'opacity-100');
                t.classList.add('border-transparent', 'opacity-70');
            });
            thumb.classList.remove('border-transparent', 'opacity-70');
            thumb.classList.add('border-[#f97316]', 'opacity-100');
        };

        // Thumbnail Hover Logic (and click for mobile fallback)
        thumbs.forEach(function (thumb) {
            thumb.addEventListener('mouseenter', function () { updateMainImage(this); });
            thumb.addEventListener('click', function () { updateMainImage(this); });
        });

        // Lightbox
        if (lightbox && lightboxImg) {
            // Move lightbox to body to avoid being constrained by parent stacking contexts
            document.body.appendChild(lightbox);

            var updateLightboxNav = function () {
                var currentIndex = parseInt(mainImage.getAttribute('data-current-index') || '0', 10);

                // Update counter
                if (lightboxCurrent) lightboxCurrent.textContent = currentIndex + 1;

                // Update prev/next buttons
                if (thumbs.length > 1) {
                    lightboxPrev.classList.toggle('hidden', currentIndex <= 0);
                    lightboxNext.classList.toggle('hidden', currentIndex >= thumbs.length - 1);
                }

                // Update Lightbox Thumbnails state
                lightboxThumbs.forEach(function (lt, i) {
                    if (i === currentIndex) {
                        lt.classList.remove('border-transparent', 'opacity-60');
                        lt.classList.add('border-[#f97316]', 'opacity-100');
                        lt.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    } else {
                        lt.classList.remove('border-[#f97316]', 'opacity-100');
                        lt.classList.add('border-transparent', 'opacity-60');
                    }
                });
            };

            var changeLightboxImage = function (newIndex) {
                if (newIndex >= 0 && newIndex < thumbs.length) {
                    lightboxImg.classList.add('opacity-0');
                    setTimeout(function () {
                        updateMainImage(thumbs[newIndex]);
                        lightboxImg.src = mainImage.src;
                        updateLightboxNav();
                        lightboxImg.classList.remove('opacity-0');
                    }, 150);
                }
            };

            mainImage.parentElement.addEventListener('click', function () {
                lightboxImg.src = mainImage.src;
                updateLightboxNav();
                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');
                setTimeout(function () {
                    lightbox.classList.remove('opacity-0');
                    lightbox.classList.add('opacity-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            });

            // Lightbox Close
            var closeLightbox = function () {
                lightbox.classList.remove('opacity-100');
                lightbox.classList.add('opacity-0');
                setTimeout(function () {
                    lightbox.classList.add('hidden');
                    lightbox.classList.remove('flex');
                    document.body.style.overflow = '';
                }, 300);
            };

            lightboxClose.addEventListener('click', closeLightbox);

            lightbox.addEventListener('click', function (e) {
                if (e.target === lightbox || e.target.closest('#erdu-lightbox-img-wrapper') === e.target) {
                    closeLightbox();
                }
            });

            // Lightbox Thumbnail Clicks
            lightboxThumbs.forEach(function (lt) {
                lt.addEventListener('click', function () {
                    var index = parseInt(this.getAttribute('data-index'), 10);
                    changeLightboxImage(index);
                });
            });

            // Lightbox Navigation Buttons
            lightboxPrev.addEventListener('click', function (e) {
                e.stopPropagation();
                var currentIndex = parseInt(mainImage.getAttribute('data-current-index') || '0', 10);
                changeLightboxImage(currentIndex - 1);
            });

            lightboxNext.addEventListener('click', function (e) {
                e.stopPropagation();
                var currentIndex = parseInt(mainImage.getAttribute('data-current-index') || '0', 10);
                changeLightboxImage(currentIndex + 1);
            });

            // Keyboard Navigation
            document.addEventListener('keydown', function (e) {
                if (lightbox.classList.contains('hidden')) return;

                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    var currentIndex = parseInt(mainImage.getAttribute('data-current-index') || '0', 10);
                    changeLightboxImage(currentIndex - 1);
                } else if (e.key === 'ArrowRight') {
                    var currentIndex = parseInt(mainImage.getAttribute('data-current-index') || '0', 10);
                    changeLightboxImage(currentIndex + 1);
                }
            });
        }
    }

    // ==========================================
    // Product Tabs Smooth Scroll & Active State
    // ==========================================
    function initProductTabs() {
        var navLinks = document.querySelectorAll('.erdu-nav-link');
        var sections = document.querySelectorAll('.erdu-content-block');

        if (!navLinks.length || !sections.length) return;

        // Smooth scrolling for navigation links
        navLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                var targetId = this.getAttribute('href');
                var targetElement = document.querySelector(targetId);

                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Intersection Observer to highlight active nav link on scroll
        var observerOptions = {
            root: null,
            rootMargin: '-100px 0px -60% 0px',
            threshold: 0
        };

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    navLinks.forEach(function (link) {
                        link.classList.remove('text-orange-600');
                        link.classList.add('text-gray-500');
                    });

                    var activeId = '#' + entry.target.id;
                    var activeLink = document.querySelector('.erdu-nav-link[href="' + activeId + '"]');
                    if (activeLink) {
                        activeLink.classList.remove('text-gray-500');
                        activeLink.classList.add('text-orange-600');
                    }
                }
            });
        }, observerOptions);

        sections.forEach(function (section) {
            observer.observe(section);
        });
    }

    // ==========================================
    // Initialize
    // ==========================================
    function init() {
        initProductGallery();
        initProductTabs();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
