function generateLeaderboard() {
    let outp = '';
    for (let i=0; i<users.length; i++) {
        let user = users[i];
        outp += `
        <tr onclick="openUser(${i});">
          <td>${i+1}</td>
          <td>${user.user}</td>
          <td>${user.team}</td>
          <td class="points">${user.points}</td>
        </tr>`;
    }
    document.getElementById("leaderboard-body").innerHTML = outp;
}
generateLeaderboard();

function openUser(id) {
  window.location.href = "user.html?id=" + id;
}
