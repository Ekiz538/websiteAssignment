/* 0. NAV DROPDOWN */
document.querySelectorAll('.nav-dropdown').forEach(dropdown => {
    dropdown.querySelector('.nav-username').addEventListener('click', e => {
        e.stopPropagation();
        dropdown.classList.toggle('open');
    });
});
document.addEventListener('click', () => {
    document.querySelectorAll('.nav-dropdown.open').forEach(d => d.classList.remove('open'));
});

/* 0a. MOBILE MENU TOGGLE - Close menu when link is clicked */
(function() {
    const menuToggle = document.getElementById('menu-toggle');
    if (menuToggle) {
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.checked = false;
            });
        });
    }
})();

/* 0b. HIDE HEADER ON SCROLL DOWN, SHOW ON SCROLL UP */
(function() {
    const header = document.querySelector('header');
    let lastY = window.scrollY;
    window.addEventListener('scroll', () => {
        const currentY = window.scrollY;
        if (currentY > lastY && currentY > 60) {
            header.style.transform = 'translateY(-100%)';
        } else {
            header.style.transform = 'translateY(0)';
        }
        lastY = currentY;
    }, { passive: true });
})();

/* 1. DARK MODE + HOME BUTTON */
const darkBtn = document.createElement('button');
darkBtn.id = 'dark-toggle';
darkBtn.title = 'Toggle dark mode';
// Insert dark toggle into footer instead of nav
const footer = document.querySelector('footer');
if (footer) footer.appendChild(darkBtn);
else document.body.appendChild(darkBtn);

const isDark = localStorage.getItem('darkMode') === 'true';
if (isDark) document.body.classList.add('dark');
darkBtn.textContent = isDark ? '☀️' : '🌙';
darkBtn.addEventListener('click', () => {
    const on = document.body.classList.toggle('dark');
    localStorage.setItem('darkMode', on);
    darkBtn.textContent = on ? '☀️' : '🌙';
});

const isHome = window.location.pathname.endsWith('index.php') || window.location.pathname.endsWith('/');

if (!isHome) {
    const homeBtn = document.createElement('a');
    homeBtn.id = 'home-btn';
    homeBtn.href = 'index.php';
    homeBtn.textContent = '🏠 Home';
    document.body.appendChild(homeBtn);
}

/* 2. STAT COUNTERS */
function animateCounters() {
    document.querySelectorAll('.stat h3').forEach(el => {
        const original = el.dataset.original || el.textContent.trim();
        el.dataset.original = original;
        const target = parseInt(original);
        if (isNaN(target)) return;
        const suffix = original.slice(String(target).length);
        let current = 0;
        const step = Math.ceil(target / 60);
        clearInterval(el._cTimer);
        el._cTimer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = current + suffix;
            if (current >= target) clearInterval(el._cTimer);
        }, 20);
    });
}

const statsSection = document.querySelector('.stats');
if (statsSection) {
    new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) animateCounters();
    }, { threshold: 0.5 }).observe(statsSection);
}

/* 3. GALLERY LIGHTBOX */
const galleryItems = document.querySelectorAll('.gallery-item img');
if (galleryItems.length) {
    const overlay = document.createElement('div');
    overlay.style.cssText = 'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:9999;align-items:center;justify-content:center;cursor:zoom-out;';
    const img = document.createElement('img');
    img.style.cssText = 'max-width:90vw;max-height:90vh;border-radius:8px;box-shadow:0 0 40px rgba(0,212,255,0.3);';
    overlay.appendChild(img);
    document.body.appendChild(overlay);
    galleryItems.forEach(item => {
        item.style.cursor = 'zoom-in';
        item.addEventListener('click', () => { img.src = item.src; img.alt = item.alt; overlay.style.display = 'flex'; });
    });
    overlay.addEventListener('click', () => { overlay.style.display = 'none'; });
}

/* 4. SCROLL-TO-TOP */
const scrollBtn = document.createElement('button');
scrollBtn.textContent = '↑';
scrollBtn.style.cssText = 'position:fixed;bottom:2rem;right:2rem;background:#00d4ff;color:#1a1a2e;border:none;border-radius:50%;width:44px;height:44px;font-size:1.3rem;font-weight:bold;cursor:pointer;display:none;z-index:999;box-shadow:0 4px 12px rgba(0,212,255,0.4);transition:opacity 0.3s;';
document.body.appendChild(scrollBtn);
window.addEventListener('scroll', () => { scrollBtn.style.display = window.scrollY > 300 ? 'block' : 'none'; });
scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

/* 5. HERO ANIMATION */
const heroContent = document.querySelector('.hero-content');
if (heroContent) {
    heroContent.querySelectorAll('h1, p, .cta-button').forEach((el, i) => {
        el.style.cssText += `opacity:0;transform:translateY(30px);transition:opacity 0.7s ease ${i * 0.25}s,transform 0.7s ease ${i * 0.25}s;`;
    });
    requestAnimationFrame(() => requestAnimationFrame(() => {
        heroContent.querySelectorAll('h1, p, .cta-button').forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        });
    }));
}

/* 6. HOME — strong card & stat fade */
if (isHome) {
    document.querySelectorAll('.service-card, .stat').forEach(el => {
        el.style.cssText += 'opacity:0;transform:translateY(24px);transition:opacity 0.5s ease,transform 0.5s ease;';
    });
    new IntersectionObserver(entries => {
        entries.forEach(entry => {
            entry.target.style.opacity = entry.isIntersecting ? '1' : '0';
            entry.target.style.transform = entry.isIntersecting ? 'translateY(0)' : 'translateY(24px)';
        });
    }, { threshold: 0.15 }).observe(document.querySelector('.services-preview') || document.body);

    document.querySelectorAll('.service-card, .stat').forEach(el => {
        new IntersectionObserver(entries => {
            entries.forEach(entry => {
                entry.target.style.opacity = entry.isIntersecting ? '1' : '0';
                entry.target.style.transform = entry.isIntersecting ? 'translateY(0)' : 'translateY(24px)';
            });
        }, { threshold: 0.15 }).observe(el);
    });

    /* HOME — typewriter on h2s */
    function typewriter(el) {
        const text = el.dataset.text;
        el.textContent = '';
        el.style.opacity = '1';
        clearInterval(el._twTimer);
        let i = 0;
        el._twTimer = setInterval(() => {
            el.textContent += text[i++];
            if (i >= text.length) clearInterval(el._twTimer);
        }, 40);
    }

    document.querySelectorAll('.services-preview h2, .home-about h2').forEach(el => {
        el.dataset.text = el.textContent.trim();
        new IntersectionObserver(entries => {
            if (entries[0].isIntersecting) {
                typewriter(entries[0].target);
            } else {
                clearInterval(entries[0].target._twTimer);
                entries[0].target.textContent = '';
                entries[0].target.style.opacity = '0';
            }
        }, { threshold: 0.3 }).observe(el);
    });

    /* HOME — word-by-word paragraphs */
    document.querySelectorAll('.about-content p').forEach(el => {
        const words = el.textContent.trim().split(' ');
        el.textContent = '';
        const spans = words.map(w => {
            const span = document.createElement('span');
            span.className = 'word';
            span.style.opacity = '0';
            span.textContent = w;
            return span;
        });
        spans.forEach((span, i) => {
            if (i > 0) el.appendChild(document.createTextNode(' '));
            el.appendChild(span);
        });
        new IntersectionObserver(entries => {
            spans.forEach((span, i) => {
                if (entries[0].isIntersecting) {
                    span.style.transition = `opacity 0.4s ease ${i * 0.05}s`;
                    span.style.opacity = '1';
                } else {
                    span.style.transition = 'none';
                    span.style.opacity = '0';
                }
            });
        }, { threshold: 0.2 }).observe(el);
    });
}

/* 7. ALL PAGES — cards, gallery, testimonials, table rows */
document.querySelectorAll('.highlight-box, .testimonial-card, .gallery-item, .services-table tbody tr').forEach((el, i) => {
    new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            setTimeout(() => entries[0].target.classList.add('visible'), i * 80);
        } else {
            entries[0].target.classList.remove('visible');
        }
    }, { threshold: 0.1 }).observe(el);
});

/* 8. OTHER PAGES — subtle fade on headings & paragraphs */
if (!isHome) {
    document.querySelectorAll(
        '.about-page h2, .services-page h2, .gallery-page h2, .testimonials-page h2, .contact-page h2,' +
        '.services-intro p, .gallery-intro p, .testimonials-intro p, .contact-intro p, .about-page-content p'
    ).forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(14px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        new IntersectionObserver(entries => {
            if (entries[0].isIntersecting) {
                entries[0].target.style.opacity = '1';
                entries[0].target.style.transform = 'translateY(0)';
            } else {
                entries[0].target.style.opacity = '0';
                entries[0].target.style.transform = 'translateY(14px)';
            }
        }, { threshold: 0.15 }).observe(el);
    });
}

/* 9. MOBILE INFINITE SCROLL */
if (isHome && window.innerWidth <= 768) {
    const mobilePages = [
        { url: 'about.php',        selector: '#about' },
        { url: 'services.php',     selector: '#services' },
        { url: 'gallery.php',      selector: '#gallery' },
        { url: 'testimonials.php', selector: '#testimonials' },
        { url: 'contact.php',      selector: '#contact' },
    ];

    const footer = document.querySelector('footer');
    const parser = new DOMParser();

    // placeholders reserve order synchronously
    const placeholders = mobilePages.map(() => {
        const div = document.createElement('div');
        footer.before(div);
        return div;
    });

    // fetch all pages in parallel
    Promise.all(
        mobilePages.map(({ url, selector }, index) =>
            fetch(url)
                .then(r => r.text())
                .then(html => ({ index, selector, html }))
                .catch(() => null)
        )
    ).then(results => {
        results.forEach(result => {
            if (!result) return;
            const { index, selector, html } = result;
            const doc = parser.parseFromString(html, 'text/html');
            const section = doc.querySelector(selector);
            if (!section) return;

            // make h2s visible
            section.querySelectorAll('h2').forEach(h => {
                h.style.opacity = '1';
                h.classList.add('visible');
            });

            // insert into reserved slot
            const hr = document.createElement('hr');
            hr.className = 'mobile-section-divider';
            placeholders[index].before(hr);
            placeholders[index].replaceWith(section);

            // animations via single shared observer
            section.querySelectorAll(
                '.highlight-box, .testimonial-card, .gallery-item, .services-table tbody tr'
            ).forEach((el, i) => {
                cardObserver.observe(el);
                el.dataset.delay = i * 80;
            });

            section.querySelectorAll(
                '.services-intro p, .gallery-intro p, .testimonials-intro p, .contact-intro p, .about-page-content p'
            ).forEach(el => {
                el.style.cssText += 'opacity:0;transform:translateY(14px);transition:opacity 0.5s ease,transform 0.5s ease;';
                fadeObserver.observe(el);
            });
        });
    });

    // shared observers reused across all injected sections
    const cardObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting)
                setTimeout(() => entry.target.classList.add('visible'), entry.target.dataset.delay || 0);
            else entry.target.classList.remove('visible');
        });
    }, { threshold: 0.1 });

    const fadeObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            entry.target.style.opacity = entry.isIntersecting ? '1' : '0';
            entry.target.style.transform = entry.isIntersecting ? 'translateY(0)' : 'translateY(14px)';
        });
    }, { threshold: 0.15 });

    // nav scroll interception
    document.querySelector('.nav-links').addEventListener('click', e => {
        const a = e.target.closest('a');
        if (!a) return;
        const map = {
            'about.php': '#about', 'services.php': '#services',
            'gallery.php': '#gallery', 'testimonials.php': '#testimonials',
            'contact.php': '#contact'
        };
        const href = a.getAttribute('href');
        if (map[href]) {
            e.preventDefault();
            const tryScroll = () => {
                const target = document.querySelector(map[href]);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                    document.getElementById('menu-toggle').checked = false;
                } else setTimeout(tryScroll, 100);
            };
            tryScroll();
        }
    });
}

/* 10. NOTIFICATION DOT FOR MESSAGES */
document.addEventListener('DOMContentLoaded', () => {
    const navUser = document.querySelector('.nav-username');
    if (navUser) {
        const fetchPath = window.location.pathname.includes('/admin/') ? '../api_check_replies.php' : 'api_check_replies.php';
        fetch(fetchPath)
            .then(r => r.json())
            .then(data => {
                if (data.unread && data.unread > 0) {
                    const dot = document.createElement('span');
                    dot.style.cssText = 'display:inline-block;width:10px;height:10px;background:#e74c3c;border-radius:50%;margin-left:6px;vertical-align:middle;box-shadow:0 0 8px #e74c3c;';
                    dot.title = data.unread + ' unread reply/replies';
                    navUser.appendChild(dot);
                }
            })
            .catch(err => console.error('Error checking replies:', err));
    }
});
