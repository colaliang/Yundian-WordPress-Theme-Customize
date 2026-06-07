/**
 * ERDU Lighting Theme - Main JavaScript
 *
 * @package ERDU_Lighting
 * @version 1.0.0
 */

(function () {
    'use strict';

    // ==========================================
    // Search Features (History & Toggle)
    // ==========================================
    function initSearch() {
        const searchForms = document.querySelectorAll('form[action*="' + window.location.host + '"]');
        const historyContainers = document.querySelectorAll('.erdu-search-history-container');
        const historyLists = document.querySelectorAll('.erdu-search-history-list');
        const clearBtns = document.querySelectorAll('.erdu-search-clear-history');
        const STORAGE_KEY = 'erdu_search_history';

        // 1. Manage Search History
        function getHistory() {
            try {
                return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
            } catch (e) {
                return [];
            }
        }

        function saveHistory(term) {
            if (!term) return;
            let history = getHistory();
            // Remove if exists to push to front
            history = history.filter(item => item !== term);
            history.unshift(term);
            if (history.length > 10) history.pop(); // Keep max 10
            localStorage.setItem(STORAGE_KEY, JSON.stringify(history));
        }

        function renderHistory() {
            const history = getHistory();
            if (history.length > 0) {
                historyContainers.forEach(c => c.classList.remove('hidden'));
                historyLists.forEach(list => {
                    list.innerHTML = '';
                    history.forEach(term => {
                        const a = document.createElement('a');
                        a.href = '/?s=' + encodeURIComponent(term);
                        a.className = 'inline-flex items-center px-3 py-1 rounded-full bg-white border border-gray-200 text-sm text-gray-600 hover:border-orange-500 hover:text-orange-500 transition-colors';
                        a.innerHTML = `<svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>${term}`;
                        list.appendChild(a);
                    });
                });
            } else {
                historyContainers.forEach(c => c.classList.add('hidden'));
            }
        }

        // Save on submit
        searchForms.forEach(form => {
            form.addEventListener('submit', function () {
                const input = form.querySelector('input[name="s"]');
                if (input && input.value.trim()) {
                    saveHistory(input.value.trim());
                }
            });
        });

        // Clear history
        clearBtns.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                localStorage.removeItem(STORAGE_KEY);
                renderHistory();
            });
        });

        // Initial render
        renderHistory();

        // 2. Handle Search Toggle (Dropdown & Fullscreen)
        const toggles = document.querySelectorAll('.erdu-search-toggle');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const style = toggle.getAttribute('data-style');
                const container = toggle.closest('.erdu-search-trigger-container');

                if (style === 'dropdown') {
                    const panel = container.querySelector('.erdu-search-dropdown-panel');
                    if (panel) {
                        panel.classList.toggle('opacity-0');
                        panel.classList.toggle('invisible');
                        if (!panel.classList.contains('invisible')) {
                            setTimeout(() => panel.querySelector('input').focus(), 50);
                        }
                    }
                } else if (style === 'fullscreen') {
                    const overlay = document.querySelector('.erdu-search-fullscreen');
                    const content = document.querySelector('.erdu-search-fullscreen-content');
                    if (overlay) {
                        overlay.classList.remove('opacity-0', 'invisible');
                        setTimeout(() => {
                            content.classList.remove('scale-95');
                            overlay.querySelector('input').focus();
                        }, 50);
                    }
                }
            });
        });

        // Close Dropdown on click outside
        document.addEventListener('click', function (e) {
            const dropdowns = document.querySelectorAll('.erdu-search-dropdown-panel');
            dropdowns.forEach(panel => {
                if (!panel.classList.contains('invisible') && !panel.contains(e.target)) {
                    panel.classList.add('opacity-0', 'invisible');
                }
            });
        });

        // Close Fullscreen
        const closeFullscreen = document.querySelectorAll('.erdu-search-close');
        closeFullscreen.forEach(btn => {
            btn.addEventListener('click', function () {
                const overlay = document.querySelector('.erdu-search-fullscreen');
                const content = document.querySelector('.erdu-search-fullscreen-content');
                if (overlay) {
                    content.classList.add('scale-95');
                    setTimeout(() => {
                        overlay.classList.add('opacity-0', 'invisible');
                    }, 300);
                }
            });
        });
    }

    // ==========================================
    // Mobile Menu Toggle
    // ==========================================
    function initMobileMenu() {
        const toggleBtn = document.querySelector('.erdu-mobile-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (!toggleBtn || !mobileMenu) return;

        toggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isHidden = mobileMenu.classList.contains('hidden');
            
            if (isHidden) {
                // Open menu
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('block');
                toggleBtn.setAttribute('aria-expanded', 'true');
            } else {
                // Close menu
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('block');
                toggleBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (e) {
            if (!mobileMenu.contains(e.target) && !toggleBtn.contains(e.target) && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('block');
                toggleBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // Close menu on window resize to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024 && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('block');
                toggleBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // ==========================================
    // FAQ Accordion
    // ==========================================
    function initFaqAccordion() {
        const faqItems = document.querySelectorAll('.erdu-faq-item');
        if (!faqItems.length) return;

        faqItems.forEach(function (item) {
            const question = item.querySelector('.erdu-faq-question');
            const answer = item.querySelector('.erdu-faq-answer');
            const icon = item.querySelector('.erdu-faq-icon');
            if (!question || !answer) return;

            // Start collapsed (except first one if desired)
            answer.style.maxHeight = '0';
            answer.style.overflow = 'hidden';
            answer.style.transition = 'max-height 0.3s ease-out';

            question.addEventListener('click', function () {
                const isOpen = answer.style.maxHeight !== '0px' && answer.style.maxHeight !== '';

                // Close all others (accordion mode)
                faqItems.forEach(function (otherItem) {
                    const otherAnswer = otherItem.querySelector('.erdu-faq-answer');
                    const otherIcon = otherItem.querySelector('.erdu-faq-icon');
                    if (otherAnswer) otherAnswer.style.maxHeight = '0';
                    if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                    otherItem.classList.remove('active');
                });

                if (!isOpen) {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    item.classList.add('active');
                    if (icon) icon.style.transform = 'rotate(180deg)';
                }
            });
        });
    }

    // ==========================================
    // Tab System
    // ==========================================
    function initTabs() {
        const tabGroups = document.querySelectorAll('[data-tabs]');
        if (!tabGroups.length) return;

        tabGroups.forEach(function (group) {
            const tabs = group.querySelectorAll('[data-tab]');
            const panels = group.querySelectorAll('[data-panel]');
            if (!tabs.length) return;

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = tab.getAttribute('data-tab');

                    // Deactivate all tabs and panels
                    tabs.forEach(function (t) {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    panels.forEach(function (p) {
                        p.classList.add('hidden');
                    });

                    // Activate current
                    tab.classList.add('active');
                    tab.setAttribute('aria-selected', 'true');
                    const targetPanel = group.querySelector('[data-panel="' + target + '"]');
                    if (targetPanel) {
                        targetPanel.classList.remove('hidden');
                    }
                });
            });
        });
    }

    // ==========================================
    // Smooth Scroll for Anchor Links
    // ==========================================
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#' || !href) return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // ==========================================
    // Header Scroll Effect
    // ==========================================
    function initHeaderScroll() {
        const header = document.querySelector('.erdu-header');
        if (!header) return;

        let lastScroll = 0;
        window.addEventListener('scroll', function () {
            const currentScroll = window.pageYOffset;

            // Add shadow on scroll
            if (currentScroll > 10) {
                header.classList.add('shadow-md', 'is-scrolled');
            } else {
                header.classList.remove('shadow-md', 'is-scrolled');
            }

            // Hide/show header on scroll direction
            if (currentScroll > lastScroll && currentScroll > 200) {
                header.style.transform = 'translateY(-100%)';
            } else {
                header.style.transform = 'translateY(0)';
            }

            lastScroll = currentScroll;
        });

        header.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
    }

    // ==========================================
    // Number Counter Animation
    // ==========================================
    function initCounterAnimation() {
        const counters = document.querySelectorAll('[data-counter]');
        if (!counters.length) return;

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-counter'), 10);
                    const suffix = el.getAttribute('data-suffix') || '';
                    const duration = 2000;
                    const step = target / (duration / 16);
                    let current = 0;

                    const timer = setInterval(function () {
                        current += step;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        el.textContent = Math.floor(current).toLocaleString() + suffix;
                    }, 16);

                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(function (counter) {
            observer.observe(counter);
        });
    }

    // ==========================================
    // Sticky Sidebar Navigation (About page tabs)
    // ==========================================
    function initStickySidebar() {
        const sidebar = document.querySelector('.erdu-sticky-sidebar');
        if (!sidebar) return;

        const headerHeight = 80;
        sidebar.style.position = 'sticky';
        sidebar.style.top = headerHeight + 20 + 'px';
    }

    // ==========================================
    // Form Validation
    // ==========================================
    function initFormValidation() {
        const forms = document.querySelectorAll('.erdu-form-validate');
        if (!forms.length) return;

        forms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');

                requiredFields.forEach(function (field) {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');

                        // Add error message
                        let error = field.parentNode.querySelector('.erdu-field-error');
                        if (!error) {
                            error = document.createElement('span');
                            error.className = 'erdu-field-error text-red-500 text-xs mt-1';
                            field.parentNode.appendChild(error);
                        }
                        error.textContent = erdu_ajax.strings?.required || 'This field is required';
                    } else {
                        field.classList.remove('border-red-500');
                        const error = field.parentNode.querySelector('.erdu-field-error');
                        if (error) error.remove();
                    }
                });

                // Email validation
                const emailField = form.querySelector('input[type="email"]');
                if (emailField && emailField.value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(emailField.value)) {
                        isValid = false;
                        emailField.classList.add('border-red-500');
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    }

    // ==========================================
    // Scroll to Section with Offset (for anchor links)
    // ==========================================
    function initScrollSpy() {
        const sections = document.querySelectorAll('section[id]');
        if (!sections.length) return;

        const navLinks = document.querySelectorAll('.erdu-scroll-nav a[href^="#"]');
        if (!navLinks.length) return;

        window.addEventListener('scroll', function () {
            let current = '';
            sections.forEach(function (section) {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(function (link) {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });
    }

    // ==========================================
    // Initialize on DOM Ready
    // ==========================================
    function init() {
        initSearch();
        initMobileMenu();
        initFaqAccordion();
        initTabs();
        initSmoothScroll();
        initHeaderScroll();
        initCounterAnimation();
        initStickySidebar();
        initFormValidation();
        initScrollSpy();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
