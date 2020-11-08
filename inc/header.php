<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
} ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ma Ludothèque</title>
  <link rel="stylesheet" href="asset/style.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous" defer></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
    <a class="navbar-brand" href="#">La ludothèque</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">

      <?php if (isset($_SESSION['auth'])) : ?>
        <ul class="navbar-nav">
          <li class="nav-item active"><a class="nav-link" href="logout.php">Se déconnecter</a></li>

          <li class="nav-item active">
            <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="jeux.php">Jeux</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="blu-ray.php">DVD/ Blu-ray</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="disques.php">Disques</a>
          </li>
        </ul>

      <?php else : ?>
        <ul class="navbar-nav justify-content-end">
        <li class="nav-item active">
            <a class="nav-link" href="login.php">Se connecter <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="register.php">S'inscrire <span class="sr-only">(current)</span></a>
          </li>
        </ul>

      <?php endif; ?>

    </div>
  </nav>
  <div class="container">

    <?php if (isset($_SESSION['flash'])) : ?>
      <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
        <div class="alert alert-<?= $type; ?>">
          <?= $message; ?>
        </div>
      <?php endforeach; ?>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>