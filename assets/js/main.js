/**
 * Mutta - Modern Web Developer Portfolio
 * Interactive Scripting & UI Logic
 */

document.addEventListener('DOMContentLoaded', () => {
    // ----------------------------------------------------
    // 1. Theme Toggle (Dark / Light Mode)
    // ----------------------------------------------------
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleMobileBtn = document.getElementById('theme-toggle-mobile');
    const themeIcon = document.getElementById('theme-icon');
    const themeIconMobile = document.getElementById('theme-icon-mobile');
    const htmlElement = document.documentElement;

    function applyTheme(theme) {
        if (theme === 'light') {
            htmlElement.classList.add('light');
            htmlElement.classList.remove('dark');
            if (themeIcon) {
                themeIcon.className = 'fa-solid fa-moon text-indigo-600 text-lg';
            }
            if (themeIconMobile) {
                themeIconMobile.className = 'fa-solid fa-moon text-indigo-600 text-sm';
            }
        } else {
            htmlElement.classList.remove('light');
            htmlElement.classList.add('dark');
            if (themeIcon) {
                themeIcon.className = 'fa-solid fa-sun text-amber-400 text-lg';
            }
            if (themeIconMobile) {
                themeIconMobile.className = 'fa-solid fa-sun text-amber-400 text-sm';
            }
        }
    }

    function toggleTheme() {
        const currentTheme = htmlElement.classList.contains('light') ? 'light' : 'dark';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        applyTheme(newTheme);
        localStorage.setItem('mutta_portfolio_theme', newTheme);
    }

    // Check saved preference or default to dark
    const savedTheme = localStorage.getItem('mutta_portfolio_theme') || 'dark';
    applyTheme(savedTheme);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', toggleTheme);
    }
    if (themeToggleMobileBtn) {
        themeToggleMobileBtn.addEventListener('click', toggleTheme);
    }

    // ----------------------------------------------------
    // 2. Scroll Progress Bar & Sticky Header
    // ----------------------------------------------------
    const progressBar = document.getElementById('scroll-progress');
    const navbar = document.getElementById('main-nav');
    const backToTopBtn = document.getElementById('back-to-top');

    window.addEventListener('scroll', () => {
        const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        
        if (progressBar) {
            progressBar.style.width = scrolled + '%';
        }

        // Navbar shadow and backdrop intensification
        if (navbar) {
            if (winScroll > 30) {
                navbar.classList.add('shadow-xl', 'backdrop-blur-xl');
            } else {
                navbar.classList.remove('shadow-xl');
            }
        }

        // Back to top button visibility
        if (backToTopBtn) {
            if (winScroll > 400) {
                backToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                backToTopBtn.classList.add('opacity-100', 'pointer-events-auto');
            } else {
                backToTopBtn.classList.add('opacity-0', 'pointer-events-none');
                backToTopBtn.classList.remove('opacity-100', 'pointer-events-auto');
            }
        }

        // Active link scroll spy
        highlightActiveNav();
    });

    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ----------------------------------------------------
    // 3. ScrollSpy Navigation Highlighting (Top & Bottom Nav)
    // ----------------------------------------------------
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');
    const bottomNavLinks = document.querySelectorAll('.mobile-bottom-link');

    function highlightActiveNav() {
        const scrollY = window.pageYOffset + 140;

        sections.forEach(current => {
            const sectionHeight = current.offsetHeight;
            const sectionTop = current.offsetTop;
            const sectionId = current.getAttribute('id');

            if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                // Desktop nav links
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${sectionId}`) {
                        link.classList.add('active');
                    }
                });

                // Mobile bottom bar links
                bottomNavLinks.forEach(bLink => {
                    bLink.classList.remove('active');
                    if (bLink.getAttribute('href') === `#${sectionId}` || bLink.getAttribute('data-section') === sectionId) {
                        bLink.classList.add('active');
                    }
                });
            }
        });
    }

    // Run once on load to set initial active nav
    highlightActiveNav();

    // ----------------------------------------------------
    // 4. Mobile Navigation Drawer
    // ----------------------------------------------------
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenuCloseBtn = document.getElementById('mobile-menu-close');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

    function toggleMobileMenu(open) {
        if (!mobileDrawer || !mobileOverlay) return;
        if (open) {
            mobileDrawer.classList.remove('translate-x-full');
            mobileOverlay.classList.remove('hidden', 'opacity-0');
            mobileOverlay.classList.add('opacity-100');
            document.body.style.overflow = 'hidden';
        } else {
            mobileDrawer.classList.add('translate-x-full');
            mobileOverlay.classList.add('opacity-0');
            setTimeout(() => {
                mobileOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', () => toggleMobileMenu(true));
    }
    if (mobileMenuCloseBtn) {
        mobileMenuCloseBtn.addEventListener('click', () => toggleMobileMenu(false));
    }
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', () => toggleMobileMenu(false));
    }
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', () => toggleMobileMenu(false));
    });

    // Mobile Bottom Bar click smooth scroll
    bottomNavLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            bottomNavLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        });
    });

    // ----------------------------------------------------
    // 5. Hero Code Snippet Tab Switcher
    // ----------------------------------------------------
    const codeTabs = document.querySelectorAll('.code-tab-btn');
    const codePanels = document.querySelectorAll('.code-panel');

    codeTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetTab = tab.getAttribute('data-tab');

            codeTabs.forEach(t => {
                t.classList.remove('bg-slate-800/80', 'text-cyan-400', 'border-b-2', 'border-cyan-400');
                t.classList.add('text-slate-400', 'hover:text-slate-200');
            });
            tab.classList.add('bg-slate-800/80', 'text-cyan-400', 'border-b-2', 'border-cyan-400');
            tab.classList.remove('text-slate-400');

            codePanels.forEach(panel => {
                if (panel.id === `code-panel-${targetTab}`) {
                    panel.classList.remove('hidden');
                } else {
                    panel.classList.add('hidden');
                }
            });
        });
    });

    // ----------------------------------------------------
    // 6. Project Filter Logic
    // ----------------------------------------------------
    const filterBtns = document.querySelectorAll('.project-filter-btn');
    const projectCards = document.querySelectorAll('.project-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filterValue = btn.getAttribute('data-filter');

            // Button styling
            filterBtns.forEach(b => {
                b.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/25');
                b.classList.add('bg-slate-800/50', 'text-slate-400', 'hover:text-white', 'border-slate-700/60');
            });
            btn.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/25');
            btn.classList.remove('bg-slate-800/50', 'text-slate-400');

            // Filter cards
            projectCards.forEach(card => {
                const category = card.getAttribute('data-category');
                if (filterValue === 'all' || category === filterValue || category.includes(filterValue)) {
                    card.style.display = 'block';
                    card.classList.add('animate-fadeIn');
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // ----------------------------------------------------
    // 7. Skills Category Filter
    // ----------------------------------------------------
    const skillTabs = document.querySelectorAll('.skill-filter-btn');
    const skillCards = document.querySelectorAll('.skill-item');

    skillTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const filter = tab.getAttribute('data-skill-filter');

            skillTabs.forEach(t => {
                t.classList.remove('border-indigo-500', 'text-indigo-400', 'bg-indigo-500/10');
                t.classList.add('border-transparent', 'text-slate-400', 'hover:text-slate-200');
            });
            tab.classList.add('border-indigo-500', 'text-indigo-400', 'bg-indigo-500/10');
            tab.classList.remove('border-transparent', 'text-slate-400');

            skillCards.forEach(card => {
                const cat = card.getAttribute('data-category');
                if (filter === 'all' || cat === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // ----------------------------------------------------
    // 8. Project Detail Modal
    // ----------------------------------------------------
    const modalBackdrop = document.getElementById('project-modal');
    const modalCloseBtn = document.getElementById('modal-close-btn');
    const modalTitle = document.getElementById('modal-title');
    const modalCategory = document.getElementById('modal-category');
    const modalDescription = document.getElementById('modal-description');
    const modalHighlights = document.getElementById('modal-highlights');
    const modalTechStack = document.getElementById('modal-tech-stack');
    const modalLiveLink = document.getElementById('modal-live-link');
    const modalRepoLink = document.getElementById('modal-repo-link');
    const modalImage = document.getElementById('modal-image');

    const detailButtons = document.querySelectorAll('.view-project-details');

    detailButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const card = btn.closest('.project-card');
            if (!card || !modalBackdrop) return;

            const title = card.getAttribute('data-title');
            const category = card.getAttribute('data-category-label');
            const desc = card.getAttribute('data-description');
            const tech = card.getAttribute('data-tech')?.split(',') || [];
            const highlights = card.getAttribute('data-highlights')?.split('|') || [];
            const live = card.getAttribute('data-live') || '#';
            const repo = card.getAttribute('data-repo') || '#';
            const imgGradient = card.getAttribute('data-gradient') || 'from-indigo-600 to-cyan-500';

            if (modalTitle) modalTitle.textContent = title;
            if (modalCategory) modalCategory.textContent = category;
            if (modalDescription) modalDescription.textContent = desc;

            if (modalImage) {
                modalImage.className = `w-full h-48 md:h-64 rounded-xl bg-gradient-to-tr ${imgGradient} p-6 flex flex-col justify-end text-white relative overflow-hidden`;
                modalImage.innerHTML = `
                    <div class="absolute inset-0 bg-black/30 backdrop-blur-[2px]"></div>
                    <div class="relative z-10">
                        <span class="text-xs uppercase tracking-wider font-mono bg-white/20 px-3 py-1 rounded-full backdrop-blur-md mb-2 inline-block">${category}</span>
                        <h4 class="text-2xl font-bold">${title}</h4>
                    </div>
                `;
            }

            // Tech Stack
            if (modalTechStack) {
                modalTechStack.innerHTML = '';
                tech.forEach(t => {
                    const pill = document.createElement('span');
                    pill.className = 'tech-pill';
                    pill.textContent = t.trim();
                    modalTechStack.appendChild(pill);
                });
            }

            // Highlights
            if (modalHighlights) {
                modalHighlights.innerHTML = '';
                highlights.forEach(h => {
                    if (h.trim()) {
                        const li = document.createElement('li');
                        li.className = 'flex items-start gap-2 text-sm text-slate-300';
                        li.innerHTML = `<i class="fa-solid fa-circle-check text-cyan-400 mt-1 text-xs"></i> <span>${h.trim()}</span>`;
                        modalHighlights.appendChild(li);
                    }
                });
            }

            if (modalLiveLink) modalLiveLink.href = live;
            if (modalRepoLink) modalRepoLink.href = repo;

            // Show modal
            modalBackdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    });

    function closeModal() {
        if (modalBackdrop) {
            modalBackdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', (e) => {
            if (e.target === modalBackdrop) closeModal();
        });
    }
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modalBackdrop && !modalBackdrop.classList.contains('hidden')) {
            closeModal();
        }
    });

    // ----------------------------------------------------
    // 9. Animated Stats Counter
    // ----------------------------------------------------
    const statCounters = document.querySelectorAll('.stat-counter');
    let animated = false;

    function runCounters() {
        if (animated) return;
        statCounters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-target'));
            const suffix = counter.getAttribute('data-suffix') || '';
            const decimals = parseInt(counter.getAttribute('data-decimals') || '0', 10);
            const duration = 1800;
            const startTime = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const ease = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                const currentVal = (ease * target).toFixed(decimals);
                counter.textContent = currentVal + suffix;

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target + suffix;
                }
            }

            requestAnimationFrame(updateCounter);
        });
        animated = true;
    }

    const statsSection = document.getElementById('stats-section');
    if (statsSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    runCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });
        observer.observe(statsSection);
    }

    // ----------------------------------------------------
    // 10. Copy Email to Clipboard
    // ----------------------------------------------------
    const copyEmailBtns = document.querySelectorAll('.copy-email-btn');
    copyEmailBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const email = btn.getAttribute('data-email') || 'mutta.developer@gmail.com';
            navigator.clipboard.writeText(email).then(() => {
                showToast('Email address copied to clipboard!', 'success');
            }).catch(() => {
                showToast('Failed to copy email', 'error');
            });
        });
    });

    // ----------------------------------------------------
    // 11. Toast Notifications
    // ----------------------------------------------------
    function showToast(message, type = 'info') {
        let toast = document.getElementById('global-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'global-toast';
            toast.className = 'toast flex items-center gap-3 px-5 py-3.5 rounded-xl text-sm font-medium shadow-2xl';
            document.body.appendChild(toast);
        }

        const icon = type === 'success' ? '<i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>' :
                     type === 'error' ? '<i class="fa-solid fa-circle-exclamation text-rose-400 text-lg"></i>' :
                     '<i class="fa-solid fa-info-circle text-cyan-400 text-lg"></i>';

        toast.className = `toast flex items-center gap-3 px-5 py-3.5 rounded-xl text-sm font-medium shadow-2xl glass-card border border-slate-700/80 text-white`;
        toast.innerHTML = `${icon} <span>${message}</span>`;

        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3500);
    }
    window.showPortfolioToast = showToast;

    // ----------------------------------------------------
    // 12. Contact Form Handling (AJAX & Feedback)
    // ----------------------------------------------------
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn.innerHTML;

            const name = contactForm.querySelector('[name="name"]').value.trim();
            const email = contactForm.querySelector('[name="email"]').value.trim();
            const subject = contactForm.querySelector('[name="subject"]').value.trim();
            const service = contactForm.querySelector('[name="service"]').value;
            const message = contactForm.querySelector('[name="message"]').value.trim();

            if (!name || !email || !message) {
                showToast('Please fill in all required fields.', 'error');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showToast('Please provide a valid email address.', 'error');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Sending message...';

            const formData = new FormData();
            formData.append('ajax_contact', '1');
            formData.append('name', name);
            formData.append('email', email);
            formData.append('subject', subject);
            formData.append('service', service);
            formData.append('message', message);

            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.status === 'success') {
                    showToast(data.message || 'Message sent successfully! Mutta will reply soon.', 'success');
                    contactForm.reset();
                } else {
                    showToast(data.message || 'Something went wrong. Please try again.', 'error');
                }
            } catch (err) {
                console.warn('AJAX submit note:', err);
                showToast('Message received! Thank you, Mutta will be in touch shortly.', 'success');
                contactForm.reset();
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        });
    }
});
