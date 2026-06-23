<?php
require '../php/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - StegoCTF</title>
  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/signup.css">
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
        <a href="login.php">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <section class="login-container">
    <h1>Create an account</h1>

    <form class="login-form" method="POST" action="../php/createUserMySql.php">
      <label for="username">Username:</label>
      <input id="username" name="username" type="text" placeholder="">

      <label for="password">Password:</label>
      <input id="password" name="password" type="password" placeholder="">

      <label for="password2">Confirm password:</label>
      <input id="password2" name="password2" type="password" placeholder="">

      <div class="form-error" id="errorMessage" aria-live="polite"></div>

      <button type="submit" name="submit" value="Create account" class="btn">Create account</button>
    </form>

    <p class="register-text">
      Already have an account? <a href="login.php">Log in</a>
    </p>
  </section>

  <script>
    const registerErrors = {
      'password-mismatch': 'Passwords do not match.',
      'create-failed': 'Could not create account. The username may already exist.'
    };
    const registerErrorKey = new URLSearchParams(window.location.search).get('error');
    if (registerErrorKey && registerErrors[registerErrorKey]) {
      document.getElementById('errorMessage').textContent = registerErrors[registerErrorKey];
    }
  </script>
</body>
</html>
