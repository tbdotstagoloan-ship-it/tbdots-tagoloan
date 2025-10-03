
  const dateSpan = document.getElementById('current-date');
  const today = new Date();
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  dateSpan.textContent = today.toLocaleDateString(undefined, options);
