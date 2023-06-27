<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/navbar.css">
</head>
  <nav class="navbar">
    <div class="logo">
      <img src="../img/logo.png" alt="Logo">
    </div>
    <ul class="nav-links">
      <li><a href="accueil.php">Home</a></li>
      <li><a href="ajout.php">Ajout</a></li>
      <li class="dropdown">
        <a href="#" class="dropbtn">Visualisation <i class="fa fa-caret-down"></i></a>
        <div class="dropdown-content">
          <a href="visualisation-carte.php">Visualisation carte</a>
          <a href="visualisation-tableau.php">Visualisation Tableau</a>
        </div>
      </li>
      <li class="dropdown">
        <a href="#" class="dropbtn">Prediction <i class="fa fa-caret-down"></i></a>
        <div class="dropdown-content">
          <a href="prediction_carte.php">Prediction cluster</a>
          <a href="prediction_haut_niveau.php">Prediction haut niveau </a>
        </div>
      </li>
    </ul>
  </nav>

