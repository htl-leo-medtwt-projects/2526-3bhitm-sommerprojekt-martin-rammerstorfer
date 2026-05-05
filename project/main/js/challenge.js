let challenges = [
    {
        title: "Emptiness",
        description: "nothing to see here.",
        format: "The flag is in the format KDCTF{...}",
        points: 100,
        difficulty: "easy",
        category: "file",
        file: "challenge_files/emptiness/emptiness.txt",
        flag: "KDCTF{wh4t_4_n1c3_qr_c0d3}"
    },
    {
        title: "Jingle Bells",
        description: "A classic! The lyrics are about bells and also some guy riding in a carriage",
        format: "The flag is in the format FLAG{...}",
        points: 300,
        difficulty: "medium",
        category: "file",
        file: "challenge_files/jingle_bells/jingle_bells",
        flag: "FLAG{j1ngl3_b3lls_b4tm4n_sm3lls}"
    },
    {
        title: "Elliot",
        description: "02:48 -!- alderson [~alderson@unaffiliated/alderson] has joined #fsociety 02:48 -!- Topic for #fsociety: Preparing for Stage 2 | Evil Corp must burn! 02:48 -!- Topic set by mrrobot [] [Fri Nov 4 14:47:04 2016] 02:52 < alderson> What is Stage 2??? 02:53 <+mrrobot> dont you remember? 02:53 <+mrrobot> you created the plans for it 02:53 < alderson> Are you hunter2 crazy? 02:54 <+mrrobot> no need for profanity. anyways you said if you ever forgot about Stage 2 that i should give you this file 02:55 <+mrrobot> i have no idea how this picture of yourself is going to help you remember, but here it is anyways:",
        format: "The flag is in the format KDCTF{...}",
        points: 300,
        difficulty: "medium",
        category: "image",
        file: "challenge_files/elliot/Elliot.png",
        flag: "KDCTF{ev1l_c0rp_1s_n0t_y0ur_fr13nd}"
    },
    {
        title: "Blackout",
        description: "Copied files, blackout, file broken, help pls. T_T",
        format: "The flag is in the format KDCTF{...}",
        points: 300,
        difficulty: "medium",
        category: "file",
        file: "challenge_files/blackout/secret",
        flag: "KDCTF{s4mpl3_fl4g}"
    },
    {
        title: "Ievian Polkka",
        description: "Hra-tsa-tsa, ia ripi-dapi dilla barits tad dillan deh lando. Aba rippadta parip parii ba ribi, ribi, ribiriz den teahlando, La barillaz dillan deiallou ara va reve reve revydyv dyvjavuo Bariz dah l'llavz dei lando dabaoke dagae gadae due due dei ia do Hra-tsa-tsa, ia ripi-dapi dilla barits tad dillan deh lando. Aba rippadta parip parii ba ribi, ribi, ribiriz den teahlando, La barillaz dillan deiallou ara va reve reve revydyv dyvjavuo Bariz dah l'llavz dei lando dabaoke dagae gadae due due dei ia do.",
        format: "The flag is in the format KDCTF{...}",
        points: 500,
        difficulty: "hard",
        category: "video",
        file: "challenge_files/ievian_polkka/Ievian_Polkka.mp4",
        flag: "KDCTF{m1ku_l0v3s_h3r_l33k}"
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
