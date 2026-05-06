const params = new URLSearchParams(window.location.search);
const id = parseInt(params.get("id"));

if (users[id]) {
  let user = users[id];

  document.getElementById("user-details").innerHTML = `<h1 id="username">${user.user}</h1>
    <p>Rank: <span id="rank">${user.rank}</span></p>
    <p>Points: <span id="points">${user.points}</span></p>
    <p>Team: <span id="team">${user.team}</span></p>`;

  document.getElementById("user-stats").innerHTML = `
        <p id="p-correct">Correct guesses: <span id="correct">${user.correct}</span></p>
        <p id="p-incorrect">Incorrect guesses: <span id="incorrect">${user.incorrect}</span></p>
        <p>Total guesses: <span id="total">${user.correct + user.incorrect}</span></p>`
}
