function generateCards() {
    let outp = '';
    for (let i=0; i<challenges.length; i++) {
        let challenge = challenges[i];
        outp += `
        <div class="challenge-card" onclick="openChallenge(${i})">
            <div class="challenge-header">
            <h2>${challenge.title}</h2>
            <span class="difficulty ${challenge.difficulty}">${challenge.difficulty}</span>
            </div>
            <p>${challenge.description}</p>
            <p class="points">Points: <span>${challenge.points}</span></p>
        </div>`;
    }
    document.getElementById("challenge-container").innerHTML = outp;
}
generateCards();

function filter(level, elem) {
  document.querySelectorAll('.filter').forEach(btn => btn.classList.remove('active'));
  elem.classList.add('active');

  for (let i=0; i<challenges.length; i++) {
    let card = document.querySelectorAll('.challenge-card')[i];
    if (level === 'all' || challenges[i].difficulty === level) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  }
}

function openChallenge(id) {
  window.location.href = "challenge.html?id=" + id;
}
