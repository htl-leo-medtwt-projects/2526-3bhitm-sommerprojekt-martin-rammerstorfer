const params = new URLSearchParams(window.location.search);
const id = parseInt(params.get("id"));

if (challenges[id]) {
  let challenge = challenges[id];

  document.getElementById("challenge-details").innerHTML = `<div class="challenge-header">
        <h1>${challenge.title}</h1>
        <span class="difficulty ${challenge.difficulty}">${challenge.difficulty}</span>
      </div>

      <p>${challenge.description}</p><br>

      <p>The flag is in the format ${challenge.format}</p><br>

      <p class="meta">Points: <span>${challenge.points}</span></p>
      <p class="meta">Category: <span>${challenge.category}</span></p>

      <button class="btn" onclick="downloadFile()">Download File</button>`;

  document.getElementById("challenge-flag").innerHTML = `<h2>Submit Flag</h2>
      <div class="flag-row">
        <input type="text" id="flagInput" placeholder="${challenge.format}">
        <button onclick="submitFlag()">Submit</button>
      </div>
      <p id="result"></p>`
}
