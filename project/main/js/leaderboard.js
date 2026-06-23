function generateLeaderboard() {
    users.sort((a, b) => b.points - a.points);
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
  const user = users[id];
  if (user && user.user) {
    window.location.href = "pages/profile.php?name=" + encodeURIComponent(user.user);
  } else {
    window.location.href = "pages/user.php?id=" + id;
  }
}
