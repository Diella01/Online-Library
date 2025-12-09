(function() {
const form = document.getElementById('contactForm');
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const subjectInput = document.getElementById('subject');
const messageInput = document.getElementById('message');
const feedback = document.getElementById('formFeedback');
const resetBtn = document.getElementById('resetBtn');

  if (!form) return; 
  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function showError(msg) {
    if (feedback) {
      feedback.style.color = 'crimson';
      feedback.textContent = msg;
    }
  }

  function showSuccess(msg) {
    if (feedback) {
      feedback.style.color = 'green';
      feedback.textContent = msg;
    }
  }

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (feedback) feedback.textContent = '';

    const name = nameInput.value.trim();
    const email = emailInput.value.trim();
    const subject = subjectInput.value.trim();
    const message = messageInput.value.trim();
    if (name.length < 2) {
      showError('Please enter a valid name (min 2 characters).');
      nameInput.focus();
      return;
    }

    if (!validateEmail(email)) {
      showError('Please enter a valid email.');
      emailInput.focus();
      return;
    }

    if (subject.length < 2) {
      showError('Subject must be at least 2 characters.');
      subjectInput.focus();
      return;
    }

    if (message.length < 10) {
      showError('Message must be at least 10 characters.');
      messageInput.focus();
      return;
    }

    showSuccess('Message sent successfully! Thank you.');
    form.reset();
  });

  if (resetBtn) {
    resetBtn.addEventListener('click', function() {
      form.reset();
      if (feedback) feedback.textContent = '';
    });
  }

})();
