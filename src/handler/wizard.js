const next = document.querySelectorAll('.next');
const previous = document.querySelectorAll('.prev');
const cardOnLoad = document.querySelector('#card-1');
const cards = document.querySelectorAll('.card');
hightlightStep(cardOnLoad);
console.log(cards);

function showNext() {
    const currentCard = this.parentElement.parentElement;
    const nextCard = currentCard.nextElementSibling;
    currentCard.style.display = 'none';
    nextCard.style.display = 'block';
    removeHighlightStep(currentCard);
    // markComplete(currentCard);
    hightlightStep(nextCard);
}

function showPrevious() {
    const currentCard = this.parentElement.parentElement;
    const previousCard = currentCard.previousElementSibling;
    currentCard.style.display = 'none';
    previousCard.style.display = 'block';
    removeHighlightStep(currentCard);
    hightlightStep(previousCard);
}

function hightlightStep(card) {
    const stepId = getStepId(card);
    const step = document.querySelector(stepId);
    step.classList.add('active-step');
    console.dir(step);
}

function removeHighlightStep(card) {
    const stepId = getStepId(card);
    const step = document.querySelector(stepId);
    step.classList.remove('active-step');
    console.dir(step);
}

function getStepId(card) {
    const cardId = card.id.slice(-1);
    const stepId = `#step-${cardId}`; // use template literals
    return stepId;
}

function markComplete(card) {
    const step = document.querySelector(getStepId(card));
    step.classList.add('complete');
}

function removeComplete(card) {
    const step = document.querySelector(getStepId(card));
    step.classList.remove('complete');
}

next.forEach(n => n.addEventListener('click', showNext));
previous.forEach(p => p.addEventListener('click', showPrevious));
