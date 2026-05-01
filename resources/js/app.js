import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

      // Navbar scroll effect
      const navbar = document.getElementById('navbar');
      if (navbar) {
        window.addEventListener('scroll', () => {
          if (window.scrollY > 60) {
            navbar.classList.add('bg-black/60', 'backdrop-blur-md');
          } else {
            if (!menuOpen) { // Keep background if mobile menu is open
              navbar.classList.remove('bg-black/60', 'backdrop-blur-md');
            }
          }
        });
      }

      // Mobile menu toggle
      const hamburger = document.getElementById('hamburger');
      const mobileMenu = document.getElementById('mobile-menu');
      const hamOpen = document.getElementById('ham-open');
      const hamClose = document.getElementById('ham-close');
      let menuOpen = false;

      if (hamburger) {
        hamburger.addEventListener('click', () => {
          menuOpen = !menuOpen;
          if (menuOpen) {
            mobileMenu.classList.remove('hidden');
            hamOpen.classList.add('hidden');
            hamClose.classList.remove('hidden');
            hamburger.setAttribute('aria-expanded', 'true');
            // Add background when menu opens
            navbar.classList.add('bg-black/60', 'backdrop-blur-md');
          } else {
            mobileMenu.classList.add('hidden');
            hamOpen.classList.remove('hidden');
            hamClose.classList.add('hidden');
            hamburger.setAttribute('aria-expanded', 'false');
            // Remove background if scrolled to top
            if (window.scrollY <= 60) {
              navbar.classList.remove('bg-black/60', 'backdrop-blur-md');
            }
          }
        });

        // Close menu on mobile nav link click
        document.querySelectorAll('.mobile-nav-link').forEach(link => {
          link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            hamOpen.classList.remove('hidden');
            hamClose.classList.add('hidden');
            menuOpen = false;
            hamburger.setAttribute('aria-expanded', 'false');
            if (window.scrollY <= 60) {
              navbar.classList.remove('bg-black/60', 'backdrop-blur-md');
            }
          });
        });
      }

      // Intersection Observer for reveal animations
      const revealEls = document.querySelectorAll('.reveal');
      if (revealEls.length > 0) {
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('visible');
              observer.unobserve(entry.target);
            }
          });
        }, {
          threshold: 0.12,
          rootMargin: '0px 0px -40px 0px',
        });
        revealEls.forEach(el => observer.observe(el));
      }

      // Pricing card 3D tilt effect (subtle)
      document.querySelectorAll('.pricing-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
          const rect = card.getBoundingClientRect();
          const x = e.clientX - rect.left;
          const y = e.clientY - rect.top;
          const centerX = rect.width / 2;
          const centerY = rect.height / 2;
          const rotateX = ((y - centerY) / centerY) * -4;
          const rotateY = ((x - centerX) / centerX) * 4;
          card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-12px)`;
        });

        card.addEventListener('mouseleave', () => {
          if (card.classList.contains('featured')) {
            card.style.transform = 'scale(1.05)';
          } else {
            card.style.transform = '';
          }
        });
      });

      // Active nav section highlighting
      const sections = document.querySelectorAll('section[id]');
      const navLinks = document.querySelectorAll('nav a[href^="#"]');
      if (sections.length > 0 && navLinks.length > 0) {
        window.addEventListener('scroll', () => {
          let current = '';
          sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            if (window.pageYOffset >= sectionTop) {
              current = section.getAttribute('id');
            }
          });

          navLinks.forEach(link => {
            link.classList.remove('text-cyan-accent');
            link.classList.add('text-white/70');
            if (link.getAttribute('href') === `#${current}`) {
              link.classList.add('text-cyan-accent');
              link.classList.remove('text-white/70');
            }
          });
        });
      }
