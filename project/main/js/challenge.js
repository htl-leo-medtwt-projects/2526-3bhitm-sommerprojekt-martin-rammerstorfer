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


// Mithilfe von KI generiert
function downloadFile() {
  const challenge = challenges[id];
  if (!challenge || !challenge.file) {
    alert("No file available for download.");
    return;
  }

  const fileName = challenge.file.split("/").pop() || "download";
  const downloadPath = location.protocol === 'file:'
    ? `../${challenge.file}`
    : `../php/download.php?path=${encodeURIComponent(challenge.file)}`;

  const anchor = document.createElement("a");
  anchor.href = downloadPath;
  anchor.download = fileName;
  anchor.target = "_blank";
  anchor.style.display = "none";
  document.body.appendChild(anchor);
  anchor.click();
  document.body.removeChild(anchor);
}

function submitFlag() {
  if (!challenges) {
    return;
  }
  let challenge = challenges[id];
  let input = document.getElementById("flagInput");
  let result = document.getElementById("result");
  let submittedFlag = input.value.trim();

  if (!submittedFlag) {
    result.innerText = "Enter a flag.";
    result.style.color = "#9ca3af";
  } else if (submittedFlag === challenge.flag) {
    result.innerText = "Flag is correct!";
    result.style.color = "#4ade80";
  } else {
    result.innerText = "Flag is incorrect.";
    result.style.color = "#f87171";
  }
}
