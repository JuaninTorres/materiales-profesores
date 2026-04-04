/* ============================================================
   guide.js — Motor de interactividad para guías de ejercicios
   Profesor Nicolás González · profenicolas.cl
   Servido desde: https://profenicolas.cl/assets_guias/guide.js

   Requiere que el documento defina (en <script> inline previo):
     const EXERCISES = [ { id, type, question, options, correct, explanation }, ... ]
   ============================================================ */

// ─────────────────────────────────────────────
// ESTADO
// ─────────────────────────────────────────────
let userAnswers = new Array(EXERCISES.length).fill(null);
let submitted = false;

// ─────────────────────────────────────────────
// CONSTRUCCIÓN DE EJERCICIOS
// ─────────────────────────────────────────────
function buildExercises() {
  const container = document.getElementById('exercises-container');
  container.innerHTML = '';
  EXERCISES.forEach((ex, i) => {
    const card = document.createElement('div');
    card.className = 'exercise-card';
    card.id = `exercise-${i}`;
    card.innerHTML = `
      <div class="exercise-header">
        <div class="exercise-num">${i + 1}</div>
        <div class="exercise-type">${ex.type}</div>
      </div>
      <div class="exercise-question">${ex.question}</div>
      <div class="exercise-options" id="options-${i}">
        ${'ABCD'.split('').map((letter, j) => `
          <button class="option-btn" id="opt-${i}-${j}" onclick="selectOption(${i}, ${j})">
            <span class="option-letter">${letter}</span>
            <span class="option-text">${ex.options[j]}</span>
          </button>
        `).join('')}
      </div>
    `;
    container.appendChild(card);
  });

  if (window.MathJax) {
    MathJax.typesetPromise([container]).catch(console.error);
  }
}

// ─────────────────────────────────────────────
// SELECCIÓN DE ALTERNATIVA
// ─────────────────────────────────────────────
function selectOption(exerciseIndex, optionIndex) {
  if (submitted) return;
  userAnswers[exerciseIndex] = optionIndex;

  document.querySelectorAll(`#options-${exerciseIndex} .option-btn`).forEach((btn, j) => {
    btn.classList.toggle('selected', j === optionIndex);
  });

  updateProgress();
}

// ─────────────────────────────────────────────
// PROGRESO
// ─────────────────────────────────────────────
function updateProgress() {
  const answered = userAnswers.filter(a => a !== null).length;
  const total = EXERCISES.length;
  const pct = Math.round((answered / total) * 100);

  document.getElementById('progress-text').textContent = `${answered} / ${total} respondidas`;
  document.getElementById('progress-pct').textContent = `${pct}%`;
  document.getElementById('progress-fill').style.width = `${pct}%`;

  const submitBtn = document.getElementById('submit-btn');
  submitBtn.disabled = answered < total;

  const note = document.getElementById('pending-note');
  note.textContent = answered < total
    ? `Faltan ${total - answered} respuesta${total - answered !== 1 ? 's' : ''} para habilitar el envío`
    : '¡Listo! Puedes enviar tus respuestas.';
}

// ─────────────────────────────────────────────
// ENVÍO Y CORRECCIÓN
// ─────────────────────────────────────────────
function submitAnswers() {
  if (userAnswers.some(a => a === null) || submitted) return;
  submitted = true;

  let correct = 0;
  EXERCISES.forEach((ex, i) => {
    const isCorrect = userAnswers[i] === ex.correct;
    if (isCorrect) correct++;

    document.querySelectorAll(`#options-${i} .option-btn`).forEach((btn, j) => {
      btn.disabled = true;
      if (j === ex.correct) btn.classList.add('correct');
      else if (j === userAnswers[i]) btn.classList.add('incorrect');
    });
  });

  const pct = Math.round((correct / EXERCISES.length) * 100);
  document.getElementById('result-pct').textContent = `${pct}%`;
  document.getElementById('result-correct').textContent = correct;
  document.getElementById('result-incorrect').textContent = EXERCISES.length - correct;

  let msg;
  if (pct < 60) {
    msg = '💪 ¡No te rindas! Cada error es una oportunidad de aprender. Revisa el material de clase y vuelve a intentarlo — la constancia hace la diferencia.';
  } else if (pct < 80) {
    msg = '👍 ¡Buen trabajo! Estás en el camino correcto. Repasa los ejercicios que fallaste para consolidar tu comprensión del tema.';
  } else {
    msg = '🎉 ¡Excelente resultado! Demuestras un sólido dominio del tema. El hábito de estudiar y practicar es lo que te llevará lejos — ¡sigue así!';
  }
  document.getElementById('motivation-msg').textContent = msg;

  buildAnswerDetails();

  const resultsEl = document.getElementById('results-section');
  resultsEl.style.display = 'block';
  setTimeout(() => resultsEl.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);

  document.getElementById('submit-btn').disabled = true;
}

// ─────────────────────────────────────────────
// DETALLE DE RESPUESTAS
// ─────────────────────────────────────────────
function buildAnswerDetails() {
  const container = document.getElementById('answers-detail');
  container.innerHTML = '';

  EXERCISES.forEach((ex, i) => {
    const isCorrect = userAnswers[i] === ex.correct;
    const item = document.createElement('div');
    item.className = `answer-item ${isCorrect ? 'answer-correct' : 'answer-incorrect'}`;

    const givenText = ex.options[userAnswers[i]];
    const correctText = ex.options[ex.correct];

    item.innerHTML = `
      <div class="answer-item-header">
        <div class="answer-num">${i + 1}</div>
        <div class="answer-question-text">${ex.question}</div>
        <div class="answer-status-icon">${isCorrect ? '✅' : '❌'}</div>
      </div>
      <div class="answer-body">
        ${!isCorrect ? `<p class="given mb-1"><strong>Tu respuesta:</strong> ${givenText}</p>` : ''}
        <p class="correct-ans mb-1"><strong>Respuesta correcta:</strong> ${correctText}</p>
        <div class="explanation-box">${ex.explanation}</div>
      </div>
    `;
    container.appendChild(item);
  });

  if (window.MathJax) {
    MathJax.typesetPromise([container]).catch(console.error);
  }
}

// ─────────────────────────────────────────────
// REINICIAR
// ─────────────────────────────────────────────
function resetQuiz() {
  submitted = false;
  userAnswers = new Array(EXERCISES.length).fill(null);
  document.getElementById('results-section').style.display = 'none';
  buildExercises();
  updateProgress();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ─────────────────────────────────────────────
// STICKY PROGRESS BAR (IntersectionObserver)
// ─────────────────────────────────────────────
const _headerEl = document.getElementById('guide-header');
const _stickyEl = document.getElementById('progress-sticky');
new IntersectionObserver(
  ([entry]) => _stickyEl.classList.toggle('visible', !entry.isIntersecting),
  { threshold: 0 }
).observe(_headerEl);

// ─────────────────────────────────────────────
// INICIALIZAR
// ─────────────────────────────────────────────
buildExercises();
updateProgress();
