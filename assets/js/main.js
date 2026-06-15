/* ─── NAVBAR ─────────────────────────────────────────────── */
const navbar = document.querySelector('.navbar');
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 40);
});

if (hamburger) {
  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('open');
    navLinks.classList.toggle('open');
  });
}

// Close mobile menu on link click
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', () => {
    hamburger?.classList.remove('open');
    navLinks?.classList.remove('open');
  });
});

// Active nav link
const currentPage = window.location.pathname.split('/').pop() || 'index.php';
document.querySelectorAll('.nav-links a').forEach(link => {
  const href = link.getAttribute('href');
  if (href === currentPage || (currentPage === '' && href === 'index.php')) {
    link.classList.add('active');
  }
});

/* ─── SCROLL REVEAL ──────────────────────────────────────── */
const revealEls = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });

revealEls.forEach(el => observer.observe(el));

/* ─── GALLERY TABS ───────────────────────────────────────── */
const tabs = document.querySelectorAll('.gallery-tab');
const items = document.querySelectorAll('.gallery-item');

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    const filter = tab.dataset.filter;
    items.forEach(item => {
      const show = filter === 'all' || item.dataset.category === filter;
      item.style.display = show ? 'block' : 'none';
    });
  });
});

/* ─── LIGHTBOX ───────────────────────────────────────────── */
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightbox-img');

document.querySelectorAll('.gallery-item').forEach(item => {
  item.addEventListener('click', () => {
    const src = item.querySelector('img').src;
    lightboxImg.src = src;
    lightbox?.classList.add('open');
    document.body.style.overflow = 'hidden';
  });
});

document.getElementById('lightbox-close')?.addEventListener('click', closeLightbox);
lightbox?.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

function closeLightbox() {
  lightbox?.classList.remove('open');
  document.body.style.overflow = '';
}

/* ─── CONTACT FORM ───────────────────────────────────────── */
const contactForm = document.getElementById('contact-form');
if (contactForm) {
  contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = contactForm.querySelector('[type=submit]');
    const msg = document.getElementById('form-msg');
    btn.disabled = true;
    btn.textContent = 'Sending...';

    try {
      const res = await fetch('includes/send-mail.php', {
        method: 'POST',
        body: new FormData(contactForm)
      });
      const data = await res.json();
      msg.className = 'form-msg ' + (data.success ? 'success' : 'error');
      msg.textContent = data.message;
      if (data.success) contactForm.reset();
    } catch {
      msg.className = 'form-msg error';
      msg.textContent = 'Something went wrong. Please try again.';
    } finally {
      btn.disabled = false;
      btn.textContent = 'Send Message';
    }
  });
}

/* ─── BOOKING FORM ───────────────────────────────────────── */
const bookingForm = document.getElementById('booking-form');
if (bookingForm) {
  bookingForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = bookingForm.querySelector('[type=submit]');
    const msg = document.getElementById('booking-msg');
    btn.disabled = true;
    btn.textContent = 'Submitting...';

    try {
      const res = await fetch('includes/booking.php', {
        method: 'POST',
        body: new FormData(bookingForm)
      });
      const data = await res.json();
      msg.className = 'form-msg ' + (data.success ? 'success' : 'error');
      msg.textContent = data.message;
      if (data.success) bookingForm.reset();
    } catch {
      msg.className = 'form-msg error';
      msg.textContent = 'Something went wrong. Please try again.';
    } finally {
      btn.disabled = false;
      btn.textContent = 'Book Appointment';
    }
  });
}
