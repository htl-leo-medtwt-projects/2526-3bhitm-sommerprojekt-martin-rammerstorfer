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

function sortChallenges(order) {
  const container = document.querySelector('.challenges-container');
  if (!container) return;
  const cards = Array.from(container.querySelectorAll('.challenge-card'));
  cards.sort((a, b) => {
    const aScoreText = a.querySelector('.points span')?.textContent || '0';
    const bScoreText = b.querySelector('.points span')?.textContent || '0';
    const aScore = parseInt(aScoreText, 10) || 0;
    const bScore = parseInt(bScoreText, 10) || 0;
    return order === 'asc' ? aScore - bScore : bScore - aScore;
  })
  cards.forEach(c => container.appendChild(c));
}

document.addEventListener('DOMContentLoaded', () => {
  const sortBtn = document.getElementById('sort-btn');
  if (!sortBtn) return;
  sortBtn.addEventListener('click', () => {
    const current = sortBtn.getAttribute('data-order') || 'desc';
    const next = current === 'desc' ? 'asc' : 'desc';
    sortBtn.setAttribute('data-order', next);
    sortBtn.textContent = `${next === 'desc' ? '▼ Descending' : '▲ Ascending'}`;
    sortChallenges(next);
  });
  sortChallenges(sortBtn.getAttribute('data-order') || 'desc');
});
