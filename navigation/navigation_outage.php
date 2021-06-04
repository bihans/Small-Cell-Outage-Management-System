<?php

$nav='<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="font-family: Poppins, sans-serif;">
  <a class="navbar-brand" href="#"><img src="../images/fevi.png" width="50" height="50" alt=""> SMALL SITE OUTAGE</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="../site-list">Sites<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../index.php">Current</a>
      </li>
      <li class="nav-item  active">
        <a class="nav-link" href="index.php">Outage</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../filter/index.php">Reports</a>
      </li>
      <li class="nav-item dropdown">
        <a style="text-transform:uppercase" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          '.htmlspecialchars($_SESSION["username"]).'
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="../reset-password.php">Reset Password</a>
          <a class="dropdown-item" href="../logout.php">Sign Out</a>
        </div>
      </li>
    </ul>
  </div>
</nav>';

 ?>
