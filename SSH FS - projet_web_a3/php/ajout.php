
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/AjoutTest.css">
</head>
<body>
<?php require_once('navbar.php'); ?>

<div class="container">
  <form>
    <!-- TOP of the form -->
    <div class="row">
      <div class="col-half">
        <h4>Age du conducteur</h4>
        <input type="text" id="ageConducteur" name="ageConducteur">
      </div>
      <div class="col-half">
        <h4>Ville</h4>
        <input type="text" id="ville" name="ville">
      </div>
    </div>
    <div class="row">
      <div class="col-half">
        <h4>Latitude et longitude</h4>
        <div class="input-group">
          <input type="text" id="latitude" name="latitude" placeholder="Latitude">
        </div>
      </div>
      <div class="col-half">
        <h4>Date</h4>
        <div class="input-group">
          <div class="col-third">
            <input type="text" id="day" name="day" placeholder="DD">
          </div>
          <div class="col-third">
            <input type="text" id="month" name="month" placeholder="MM">
          </div>
          <div class="col-third">
            <input type="text" id="year" name="year" placeholder="YYYY">
          </div>
        </div>
      </div>
    </div>
        <!-- BOTTOM OF THE FORM -->

<!-- BOTTOM OF THE FORM -->

<div class="row">
  <div class="col-half">
    <h4>Condition atmosphérique</h4>
    <select id="conditionAtmospherique" name="conditionAtmospherique">
      <option value="pluie">Pluie</option>
      <option value="sec">Sec</option>
      <option value="ensoleille">Ensoleillé</option>
    </select>
  </div>
  <div class="col-half">
    <h4>Luminosité</h4>
    <select id="luminosite" name="luminosite">
      <option value="soleil">Soleil</option>
      <option value="sombre">Sombre</option>
    </select>
  </div>
</div>
<div class="row">
  <div class="col-half">
    <h4>État de la route</h4>
    <select id="etatRoute" name="etatRoute">
      <option value="casse">Cassé</option>
      <option value="intact">Intact</option>
    </select>
  </div>
  <div class="col-half">
    <h4>Sécurité</h4>
    <select id="securite" name="securite">
      <option value="mise">Mise</option>
      <option value="pasMise">Pas mise</option>
    </select>
  </div>
</div>
<div class="row center-button">
      <div class="col-half">
        <button type="submit">Envoyer</button>
      </div>
    </div>
</form>
</body>
</html>
