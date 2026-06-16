document.addEventListener('DOMContentLoaded', () => {
  // 1. Initialize Lenis Smooth Scroll
  const lenis = new Lenis({
    duration: 1.4,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    direction: 'vertical',
    gestureDirection: 'vertical',
    smooth: true,
    mouseMultiplier: 1,
    smoothTouch: false,
    touchMultiplier: 2,
    infinite: false,
  });

  lenis.on('scroll', ScrollTrigger.update);
  gsap.ticker.add((time)=>{
    lenis.raf(time * 1000);
  });
  gsap.ticker.lagSmoothing(0);

  // 1.5 Custom Magnetic Cursor
  const cursor = document.createElement('div');
  cursor.classList.add('custom-cursor');
  document.body.appendChild(cursor);

  const xSet = gsap.quickSetter(cursor, "x", "px");
  const ySet = gsap.quickSetter(cursor, "y", "px");

  window.addEventListener('mousemove', (e) => {
    xSet(e.clientX);
    ySet(e.clientY);
  });

  const interactables = document.querySelectorAll('a, button, .btn, input, textarea, select');
  interactables.forEach(el => {
    el.addEventListener('mouseenter', () => {
      cursor.classList.add('hover');
    });
    el.addEventListener('mouseleave', () => {
      cursor.classList.remove('hover');
    });
  });

  // 2. GSAP Animations

  // Hero Section Load Animation
  const heroTl = gsap.timeline();
  heroTl.to('.hero .reveal-text', {
    y: 0,
    rotateZ: 0,
    duration: 1.4,
    ease: 'power4.out',
    stagger: 0.1,
    delay: 0.2
  })
  .to('.hero .fade-up', {
    opacity: 1,
    y: 0,
    duration: 1,
    ease: 'power3.out'
  }, "-=1");

  // Global Mask Reveals
  gsap.utils.toArray('.reveal-mask').forEach(mask => {
    const text = mask.querySelector('.reveal-text');
    if(!text) return;
    
    if(mask.closest('.hero')) return;

    gsap.to(text, {
      scrollTrigger: {
        trigger: mask,
        start: "top 85%",
      },
      y: 0,
      duration: 1.4,
      ease: "power4.out"
    });
  });

  // Global Fade Ups
  gsap.utils.toArray('.fade-up').forEach(elem => {
    if(elem.closest('.hero')) return;

    gsap.to(elem, {
      scrollTrigger: {
        trigger: elem,
        start: "top 85%",
      },
      opacity: 1,
      y: 0,
      duration: 1,
      ease: "power3.out"
    });
  });

  // Parallax Service Cards (Asymmetrical scrolling offset)
  gsap.utils.toArray('.parallax-card').forEach((card, i) => {
    gsap.to(card, {
      scrollTrigger: {
        trigger: card,
        start: "top 95%",
        end: "top 20%",
        scrub: 1
      },
      y: 0,
      opacity: 1,
      ease: "none"
    });
  });

  gsap.utils.toArray('.parallax-card-delayed').forEach((card, i) => {
    // Start delayed cards lower down
    gsap.set(card, { y: 200 }); 
    gsap.to(card, {
      scrollTrigger: {
        trigger: card,
        start: "top 95%",
        end: "top 20%",
        scrub: 1.5 // Slower scrub to create parallax effect against normal cards
      },
      y: 0,
      opacity: 1,
      ease: "none"
    });
  });

  // Image Parallax
  gsap.utils.toArray('.parallax-bg').forEach(bg => {
    gsap.to(bg, {
      scrollTrigger: {
        trigger: bg.closest('.parallax-container'),
        start: "top bottom",
        end: "bottom top",
        scrub: true
      },
      y: "30%",
      ease: "none"
    });
  });
});
