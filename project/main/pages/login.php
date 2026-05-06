<?php
require '../php/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - StegoCTF</title>
  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/login.css">
</head>
<body>

  <nav id="navigation">
    <div id="nav-left">
      <span id="logo">StegoCTF</span>
      <a href="../index.php">Home</a>
      <a href="challenges.php">Challenges</a>
      <a href="leaderboard.php">Leaderboard</a>
    </div>
    <div id="nav-right">
      <?php if (!empty($_SESSION['login']) && $_SESSION['login'] === 1): ?>
        <a href="user.php">Profile</a>
      <?php else: ?>
        <a href="register.php">Register</a>
      <?php endif; ?>
    </div>
  </nav>

  <section class="login-container">
    <h1>Login</h1>

    <form class="login-form" method="POST" action="../php/loginMySql.php">
      <label for="username">Username:</label>
      <input id="username" name="username" type="text" placeholder="">

      <label for="password">Password:</label>
      <input id="password" name="password" type="password" placeholder="">

      <button type="submit" name="submit" value="Login" class="btn">Login</button>
    </form>

    <div class="form-error" id="errorMessage" aria-live="polite"></div>

    <p class="register-text">
      Don't have an account yet? <a href="register.php">Register</a>
    </p>
  </section>

  <script>
    const loginErrors = {
      'wrong-password': 'Incorrect username or password.',
      'user-not-found': 'User not found.',
      'password-mismatch': 'Passwords do not match.'
    };
    const loginErrorKey = new URLSearchParams(window.location.search).get('error');
    if (loginErrorKey && loginErrors[loginErrorKey]) {
      document.getElementById('errorMessage').textContent = loginErrors[loginErrorKey];
    }
  </script>
</body>
</html>
