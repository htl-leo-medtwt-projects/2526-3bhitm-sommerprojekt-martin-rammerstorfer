<?php
include '../php/mysql.php';

session_start();

$sql = "SELECT * FROM challenges";
$result = $conn->query($sql);
$challenges = mysqli_fetch_all($result, MYSQLI_ASSOC);

function printChallenges() {
  global $challenges;
  echo "<div class='challenges-container'>";
  for ($i = 0; $i < count($challenges); $i++) {
    $challenge = $challenges[$i];  
    $title = $challenge['title'];
    $difficulty = $challenge['difficulty'];
    $description = $challenge['description'];
    $points = $challenge['points'];
    echo "<div class="challenge-card">
            <div class="challenge-header">
            <h2>{$title}</h2>
            <span class="difficulty {$difficulty}">{$difficulty}</span>
            </div>
            <p>{$description}</p>
            <p class="points">Points: <span>{$points}</span></p>
        </div>";
  }
  echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Challenges - StegoCTF</title>
  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/challenges.css">
  <script src="../js/challenges.js" defer></script>
</head>
<body>

  <nav id="navigation">
    <div id="nav-left">
      <span id="logo">StegoCTF</span>
      <a href="../index.html">Home</a>
      <a href="challenges.html">Challenges</a>
      <a href="leaderboard.html">Leaderboard</a>
    </div>
    <div id="nav-right">
      <a href="login.html">Login</a>
    </div>
  </nav>

  <section class="challenges">
    <h1>Challenges</h1>

    <div class="filters">
      <h3>Filters</h3>
      <div class="filter-buttons">
        <button class="filter active" onclick="filter('all', this)">All</button>
        <button class="filter" onclick="filter('easy', this)">Easy</button>
        <button class="filter" onclick="filter('medium', this)">Medium</button>
        <button class="filter" onclick="filter('hard', this)">Hard</button>
      </div>
    </div>

    <div id="challenge-container"></div>

  </section>

</body>
</html>
