import '../scss/app.scss';
import 'bootstrap-icons/font/bootstrap-icons.css';
import AOS from 'aos';
import 'aos/dist/aos.css';
import * as bootstrap from 'bootstrap';

// Habilitar tooltips/popovers globalmente (opcional)
document.addEventListener('DOMContentLoaded', () => {
  AOS.init({ once: true, duration: 600, easing: 'ease-out-quad', offset: 60 });

  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el);
  });
  document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => {
    new bootstrap.Popover(el);
  });
});

window.bootstrap = bootstrap; // útil en caso de debug o inicializaciones ad-hoc
