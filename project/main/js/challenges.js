function filter(level, elem) {
  document.querySelectorAll('.filter').forEach(btn => btn.classList.remove('active'));
  elem.classList.add('active');

  document.querySelectorAll('.challenge-card').forEach(card => {
    if (level === 'all' || card.dataset.difficulty === level) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}
