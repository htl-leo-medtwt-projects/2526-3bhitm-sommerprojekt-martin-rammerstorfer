let challenges = [
    {
        title: "Challenge 1",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 100,
        difficulty: "easy",
        category: "Image",
        file: ""
    },
    {
        title: "Challenge 2",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 200,
        difficulty: "medium",
        category: "Image",
        file: ""
    },
    {
        title: "Challenge 3",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 500,
        difficulty: "hard",
        category: "Image",
        file: ""
    },
    {
        title: "Challenge 4",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 250,
        difficulty: "medium",
        category: "Image",
        file: ""
    },
    {
        title: "Challenge 5",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 300,
        difficulty: "medium",   
        category: "Image",
        file: ""
    },
    {
        title: "Challenge 6",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 100,
        difficulty: "easy",
        category: "Image",
        file: ""
    },
    {
        title: "Challenge 7",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        points: 150,
        difficulty: "easy",
        category: "Image",
        file: ""
    }
];

const params = new URLSearchParams(window.location.search);
const id = parseInt(params.get("id"));

if (challenges[id]) {
  let challenge = challenges[id];

  document.getElementById("challenge-details").innerHTML = `<div class="challenge-header">
        <h1>${challenge.title}</h1>
        <span class="difficulty ${challenge.difficulty}">${challenge.difficulty}</span>
      </div>

      <p>${challenge.description}</p>

      <p class="meta">Points: <span>${challenge.points}</span></p>
      <p class="meta">Category: <span>${challenge.category}</span></p>

      <button class="btn" onclick="donloadFile()">Download File</button>`;
}

function onStartedDownload(id) {
  console.log(`Started downloading: ${id}`);
}

function onFailed(error) {
  console.log(`Download failed: ${error}`);
}

let downloadUrl = "https://example.org/image.png";

let downloading = browser.downloads.download({
  url: downloadUrl,
  filename: "my-image-again.png",
  conflictAction: "uniquify",
});

downloading.then(onStartedDownload, onFailed);

function downloadFile() {
    
}

function submitFlag() {

}
