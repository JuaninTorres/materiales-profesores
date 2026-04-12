// ═══════════════════════════════════════════════════════════
// quiz.js — Motor de quiz autocontenido
// Profesor Nicolás González · profenicolas.cl
//
// Lee el atributo data-quiz del #quiz-container al cargar la página.
// Sin dependencias externas. Sin localStorage ni sessionStorage.
// Al recargar la página el quiz vuelve al inicio.
//
// Formato del atributo data-quiz (JSON):
// [
//   {
//     "pregunta": "¿Cuánto es 2 + 2?",
//     "alternativas": ["3", "4", "5", "6"],
//     "correcta": 1,
//     "explicacion": "2 + 2 = 4 (opcional)"
//   }
// ]
// ═══════════════════════════════════════════════════════════

(function () {
  'use strict';

  function initQuiz() {
    const container = document.getElementById('quiz-container');
    if (!container) return;

    const raw = container.getAttribute('data-quiz');
    if (!raw) return;

    let QUIZ;
    try {
      QUIZ = JSON.parse(raw);
    } catch (e) {
      container.innerHTML = '<p class="text-danger">Error al cargar el quiz: JSON inválido.</p>';
      return;
    }

    if (!Array.isArray(QUIZ) || QUIZ.length === 0) return;

    // ── Estado ──
    let currentQ = 0;
    let answered = [];
    let selected = null;

    // ── Renderizar estructura base ──
    container.innerHTML = `
      <div id="quiz-progress" class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <small class="text-muted">
            Pregunta <span id="q-current">1</span> de <span id="q-total">${QUIZ.length}</span>
          </small>
          <small class="text-muted" id="q-score-live"></small>
        </div>
        <div class="progress" style="height:4px">
          <div id="quiz-progress-bar" class="progress-bar"
               style="width:0%;background:var(--color-secondary)"></div>
        </div>
      </div>

      <div id="question-area"></div>

      <div id="quiz-actions" class="mt-3 d-flex gap-2">
        <button id="btn-check"
                class="btn btn-sm"
                style="background:var(--color-primary);color:white"
                onclick="quizCheck()">
          Verificar
        </button>
        <button id="btn-next-q"
                class="btn btn-sm btn-outline-secondary d-none"
                onclick="quizNext()">
          Siguiente →
        </button>
      </div>

      <div id="quiz-result" class="d-none mt-3">
        <div class="formula-highlight" style="font-size:1.4rem;padding:1rem">
          <span id="result-percent"></span>
        </div>
        <div id="result-review" class="mt-3"></div>
        <button class="btn btn-sm mt-2"
                style="background:var(--color-secondary);color:white"
                onclick="quizReset()">
          Intentar de nuevo
        </button>
      </div>
    `;

    // ── Renderizar pregunta actual ──
    function renderQuestion() {
      const data = QUIZ[currentQ];
      const area = document.getElementById('question-area');
      selected = null;

      document.getElementById('q-current').textContent = currentQ + 1;
      const pct = (currentQ / QUIZ.length) * 100;
      document.getElementById('quiz-progress-bar').style.width = pct + '%';

      // Soporta tanto el formato nuevo (pregunta/alternativas/correcta)
      // como el formato legado (q/opts/ans)
      const pregunta     = data.pregunta     || data.q    || '';
      const alternativas = data.alternativas || data.opts || [];
      const letters = ['A', 'B', 'C', 'D', 'E'];

      area.innerHTML = `
        <p class="fw-semibold mb-3" style="font-size:1rem;">${pregunta}</p>
        <div id="options-list">
          ${alternativas.map((opt, i) => `
            <div class="option-item" data-idx="${i}" onclick="quizSelect(${i})">
              <span class="badge me-1" style="background:var(--color-primary)">${letters[i]}</span>
              ${opt}
            </div>
          `).join('')}
        </div>
      `;

      const btnCheck = document.getElementById('btn-check');
      btnCheck.classList.remove('d-none');
      btnCheck.disabled = true;
      document.getElementById('btn-next-q').classList.add('d-none');

      if (window.MathJax && MathJax.typesetPromise) {
        MathJax.typesetPromise([area]).catch(() => {});
      }
    }

    // ── Seleccionar alternativa ──
    window.quizSelect = function (idx) {
      selected = idx;
      document.querySelectorAll('.option-item').forEach((el, i) => {
        el.classList.toggle('selected', i === idx);
      });
      document.getElementById('btn-check').disabled = false;
    };

    // ── Verificar respuesta ──
    window.quizCheck = function () {
      if (selected === null) return;

      const data = QUIZ[currentQ];
      const correcta = data.correcta !== undefined ? data.correcta : data.ans;
      const correct  = selected === correcta;
      answered.push({ q: currentQ, selected, correct });

      // Marcar opciones visualmente
      document.querySelectorAll('.option-item').forEach((el, i) => {
        el.style.cursor = 'default';
        el.onclick = null;
        el.classList.remove('selected');
        if (i === correcta)               el.classList.add('correct');
        else if (i === selected && !correct) el.classList.add('incorrect');
      });

      // Feedback con explicación
      const explicacion = data.explicacion || data.explanation || '';
      const feedbackBox = document.createElement('div');
      feedbackBox.className = (correct ? 'solution-box' : 'note-box') + ' mt-2';
      feedbackBox.style.display = 'block';
      feedbackBox.innerHTML = (correct ? '✅ ¡Correcto! ' : '❌ Incorrecto. ') + explicacion;
      document.getElementById('question-area').appendChild(feedbackBox);

      if (window.MathJax && MathJax.typesetPromise) {
        MathJax.typesetPromise([feedbackBox]).catch(() => {});
      }

      // Actualizar marcador en vivo
      document.getElementById('btn-check').classList.add('d-none');
      const correctCount = answered.filter(a => a.correct).length;
      document.getElementById('q-score-live').textContent =
        `${correctCount}/${answered.length} correctas`;

      if (currentQ < QUIZ.length - 1) {
        document.getElementById('btn-next-q').classList.remove('d-none');
      } else {
        setTimeout(quizShowResult, 900);
      }
    };

    // ── Avanzar a la siguiente pregunta ──
    window.quizNext = function () {
      currentQ++;
      renderQuestion();
    };

    // ── Mostrar resultado final ──
    window.quizShowResult = function () {
      document.getElementById('quiz-progress').classList.add('d-none');
      document.getElementById('question-area').classList.add('d-none');
      document.getElementById('quiz-actions').classList.add('d-none');

      const correctCount = answered.filter(a => a.correct).length;
      const pct   = Math.round((correctCount / QUIZ.length) * 100);
      const emoji = pct >= 80 ? '🌟' : pct >= 60 ? '👍' : '💪';
      const msg   = pct >= 80 ? '¡Excelente!' : pct >= 60 ? '¡Buen trabajo!' : '¡Sigue practicando!';

      document.getElementById('result-percent').innerHTML =
        `${emoji} ${msg} — ${pct}% (${correctCount}/${QUIZ.length})`;

      // Revisión de errores
      const errors = answered.filter(a => !a.correct);
      if (errors.length > 0) {
        const letters    = ['A', 'B', 'C', 'D', 'E'];
        const reviewEl   = document.getElementById('result-review');
        reviewEl.innerHTML =
          `<p class="fw-semibold text-danger mb-2">Preguntas incorrectas:</p>` +
          errors.map(e => {
            const d           = QUIZ[e.q];
            const opts        = d.alternativas || d.opts || [];
            const correcta    = d.correcta !== undefined ? d.correcta : d.ans;
            const explicacion = d.explicacion || d.explanation || '';
            const pregunta    = d.pregunta || d.q || '';
            return `
              <div class="note-box mb-2" style="display:block">
                <strong>Pregunta ${e.q + 1}:</strong> ${pregunta}<br>
                Tu respuesta: <strong>${letters[e.selected]}) ${opts[e.selected]}</strong><br>
                Correcta: <strong>${letters[correcta]}) ${opts[correcta]}</strong>
                ${explicacion ? `<br><small>${explicacion}</small>` : ''}
              </div>`;
          }).join('');

        if (window.MathJax && MathJax.typesetPromise) {
          MathJax.typesetPromise([reviewEl]).catch(() => {});
        }
      }

      document.getElementById('quiz-result').classList.remove('d-none');
    };

    // ── Reiniciar quiz ──
    window.quizReset = function () {
      currentQ = 0;
      answered = [];
      selected = null;
      document.getElementById('quiz-progress').classList.remove('d-none');
      document.getElementById('question-area').classList.remove('d-none');
      document.getElementById('quiz-actions').classList.remove('d-none');
      document.getElementById('quiz-result').classList.add('d-none');
      document.getElementById('q-score-live').textContent = '';
      renderQuestion();
    };

    // ── Modo impresión: renderizar todas las preguntas en estático ──
    const printModo = new URLSearchParams(window.location.search).get('modo');
    if (printModo) {
      renderAllForPrint(printModo);
      return;
    }

    function renderAllForPrint(modo) {
      container.innerHTML = '';
      const letters = ['A', 'B', 'C', 'D', 'E'];
      QUIZ.forEach((data, qIdx) => {
        const pregunta     = data.pregunta     || data.q    || '';
        const alternativas = data.alternativas || data.opts || [];
        const correcta     = data.correcta !== undefined ? data.correcta : data.ans;
        const explicacion  = data.explicacion  || data.explanation || '';

        const qEl = document.createElement('div');
        qEl.style.marginBottom = '1rem';
        qEl.innerHTML = `
          <p style="font-weight:600;font-size:0.95rem;margin-bottom:0.5rem">
            Ejercicio ${qIdx + 1}: ${pregunta}
          </p>
          <div>
            ${alternativas.map((opt, i) => `
              <div class="option-item ${modo === 'docente' && i === correcta ? 'correct' : ''}"
                   style="cursor:default">
                <span class="badge me-1" style="background:var(--color-primary)">${letters[i]}</span>
                ${opt}
              </div>
            `).join('')}
          </div>
          ${modo === 'docente' && explicacion ? `
            <div class="solution-box show" style="display:block;margin-top:0.5rem">
              ${explicacion}
            </div>
          ` : ''}
        `;
        container.appendChild(qEl);
      });

      if (window.MathJax && MathJax.typesetPromise) {
        MathJax.typesetPromise([container]).catch(() => {});
      }
    }

    // ── Iniciar ──
    renderQuestion();
  }

  if (document.readyState !== 'loading') initQuiz();
  else document.addEventListener('DOMContentLoaded', initQuiz);
})();
