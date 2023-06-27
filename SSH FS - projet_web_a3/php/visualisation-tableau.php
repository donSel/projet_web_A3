
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/visualisation_tableau.css">
<?php require_once('navbar.php'); ?>
</head>
<body>
<div class="container">
  <form>
    <!-- TOP of the form -->
    <div class="row">
      <div class="col">
        <h4>Age du conducteur</h4>
        <input type="text" id="ageConducteur" name="ageConducteur">
      </div>
      <div class="col">
        <h4>Ville</h4>
        <input type="text" id="ville" name="ville">
      </div>
      <div class="col">
        <h4>Latitude et longitude</h4>
        <input type="text" id="latitude" name="latitude" placeholder="Latitude">
      </div>
      <div class="col">
        <h4>Date</h4>
        <div class="input-group">
          <input type="text" id="day" name="day" placeholder="DD">
          <input type="text" id="month" name="month" placeholder="MM">
          <input type="text" id="year" name="year" placeholder="YYYY">
        </div>
      </div>
      <div class="col">
      <h4>Condition atmosphérique</h4>
      <div class="input-group">
    <select id="conditionAtmospherique" name="conditionAtmospherique">
      <option value="pluie">Pluie</option>
      <option value="sec">Sec</option>
      <option value="ensoleille">Ensoleillé</option>
    </select>
</div>
</div>
<div class="col">
      <h4>Condition atmosphérique</h4>
      <div class="input-group">
    <select id="luminosite" name="luminosite">
      <option value="Soleil">Soleil</option>
      <option value="Sombre">Sombre</option>
      <option value="Sombre">Sombre</option>
    </select>
</div>
</div>
<div class="col">
      <h4>État de la route</h4>
      <div class="input-group">
    <select id="etatRoute" name="etatRoute">
      <option value="casse">Cassé</option>
      <option value="Intact">Intact</option>
    </select>
</div>
</div>
<div class="col">
      <h4>Sécurité</h4>
      <div class="input-group">
    <select id="securite" name="securite">
      <option value="Mise">Mise</option>
      <option value="Mise">Mise</option>
    </select>
</div>
</div>
    </div>
  </form>
</div>
</form>
</body>
</html>
