let challenges = [
    {
        title: "Challenge 1",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 100,
        difficulty: "easy",
        category: "Image"
    },
    {
        title: "Challenge 2",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 200,
        difficulty: "medium",
        category: "Image"
    },
    {
        title: "Challenge 3",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 500,
        difficulty: "hard",
        category: "Image"
    },
    {
        title: "Challenge 4",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 250,
        difficulty: "medium",
        category: "Image"
    },
    {
        title: "Challenge 5",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 300,
        difficulty: "medium",   
        category: "Image"
    },
    {
        title: "Challenge 6",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 100,
        difficulty: "easy",
        category: "Image"
    },
    {
        title: "Challenge 7",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 150,
        difficulty: "easy",
        category: "Image"
    }
];

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
