// Motor de navegación de presentaciones — profenicolas.cl
// Maneja: slides, barra de progreso, teclado, soluciones plegables y MathJax

let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const total  = slides.length;

function updateCounter() {
  document.getElementById('slide-counter').textContent = `${currentSlide + 1} / ${total}`;
  document.getElementById('prev-btn').disabled = currentSlide === 0;
  document.getElementById('next-btn').disabled = currentSlide === total - 1;
  updateProgressBar();
}

function changeSlide(direction) {
  slides[currentSlide].classList.remove('active');
  currentSlide = Math.max(0, Math.min(currentSlide + direction, total - 1));
  slides[currentSlide].classList.add('active');
  updateCounter();
  if (window.MathJax && MathJax.typesetPromise) {
    MathJax.typesetPromise([slides[currentSlide]]).catch(() => {});
  }
}

document.addEventListener('keydown', e => {
  if (e.key === 'ArrowRight' || e.key === ' ') { e.preventDefault(); changeSlide(1); }
  if (e.key === 'ArrowLeft')                   { e.preventDefault(); changeSlide(-1); }
});

function updateProgressBar() {
  const activeSection = parseInt(slides[currentSlide].dataset.section || '0');
  const sections   = document.querySelectorAll('.progress-section');
  const connectors = document.querySelectorAll('.progress-connector');

  sections.forEach((sec, i) => {
    sec.classList.remove('active', 'completed');
    if (i < activeSection) sec.classList.add('completed');
    if (i === activeSection) sec.classList.add('active');
  });

  connectors.forEach((conn, i) => {
    conn.classList.toggle('completed', i < activeSection);
  });
}

function toggleSolution(btn, solutionId) {
  const solution = document.getElementById(solutionId);
  if (solution.classList.contains('show')) {
    solution.classList.remove('show');
    btn.classList.remove('active');
    btn.textContent = '👁️ Ver Solución';
  } else {
    solution.classList.add('show');
    btn.classList.add('active');
    btn.textContent = '🙈 Ocultar Solución';
    if (window.MathJax) MathJax.typesetPromise([solution]);
  }
}

updateCounter();
