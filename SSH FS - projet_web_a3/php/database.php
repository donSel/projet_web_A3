<?php
//Author: Prenom NOM
//Login : etuXXX
//Groupe: ISEN X GROUPE Y
//Annee:
include("constants.php");
setlocale(LC_TIME, "fr_FR.utf8");
$time = time();
session_start();
/**
 * Connexion à la BDD
 * @return PDO
 */
function dbConnect(){
    try
    {
      $db = new PDO('mysql:host='.DB_SERVER.';port='.DB_PORT.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $exception)
    {
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    return $db;
  }


// Fonction ajoutant un accident à la base de donnée
function ajouterAccident($db, $age, $date_heure, $ville, $latitude, $longitude, $descr_athmo_id, $descr_lum_id, $descr_etat_surf_id, $descr_dispo_secu_id) {

  // Préparation de la requête SQL d'insertion avec des paramètres liés
  $request = "INSERT INTO accident (age, date_heure, ville, latitude, longitude, descr_athmo, descr_lum, descr_etat_surf, descr_dispo_secu) VALUES (:age, :date_heure, :ville, :latitude, :longitude, :descr_athmo, :descr_lum, :descr_etat_surf, :descr_dispo_secu)";
  $stmt = $db->prepare($request);

  // Liaison des paramètres à la requête préparée
  $stmt->bindParam(':age', $age);
  $stmt->bindParam(':date_heure', $date_heure);
  $stmt->bindParam(':ville', $ville);
  $stmt->bindParam(':latitude', $latitude);
  $stmt->bindParam(':longitude', $longitude);
  $stmt->bindParam(':descr_athmo', $descr_athmo_id);
  $stmt->bindParam(':descr_lum', $descr_lum_id);
  $stmt->bindParam(':descr_etat_surf', $descr_etat_surf_id);
  $stmt->bindParam(':descr_dispo_secu', $descr_dispo_secu_id);

  // Exécuter la requête préparée
  if ($stmt->execute()) {
      echo "Accident ajouté avec succès !";
  } else {
      echo "Erreur lors de l'ajout de l'accident.";
  }
  
  // Récupération de l'ID de l'accident ajouté ?
}


// fonction récupérant la liste des valeurs de "descr_athmo"
function getValDescrAthmo($db){
  
  // requête de récupération des valeurs de description d'athmosphère
  $request = "SELECT val FROM descr_athmo";
  // récupération des valeurs
  $resultat = $db->query($request);
  $valeurs = array();
  while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
      $valeurs[] = $row['val'];
  }
  
  return $valeurs;
  
  //$request = 'SELECT * FROM player WHERE mail=:mail';
  //$statement = $db->prepare($request);
  //$statement->bindParam(':mail', $mail);
  //$statement->execute();
  //return $statement->fetchAll(PDO::FETCH_ASSOC); 
}


// fonction récupérant la liste des valeurs de "descr_lum"
function getValDescrLum($db){
  
  // requête de récupération des valeurs de descr_lum
  $request = "SELECT val FROM descr_lum";
  // récupération des valeurs
  $resultat = $db->query($request);
  $valeurs = array();
  while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
      $valeurs[] = $row['val'];
  }
  
  return $valeurs; 
}


// fonction récupérant la liste des valeurs de "descr_etat_surf"
function getValDescrEtatSurf($db){
  
  // requête de récupération des valeurs de descr_etat_surf
  $request = "SELECT val FROM descr_etat_surf";
  // récupération des valeurs
  $resultat = $db->query($request);
  $valeurs = array();
  while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
      $valeurs[] = $row['val'];
  }
  
  return $valeurs; 
}


// fonction récupérant la liste des valeurs de "descr_dispo_secu"
function getValDescrDispoSecu($db){
  
  // requête de récupération des valeurs de descr_dispo_secu
  $request = "SELECT val FROM descr_dispo_secu";
  // récupération des valeurs
  $resultat = $db->query($request);
  $valeurs = array();
  while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
      $valeurs[] = $row['val'];
  }
  
  return $valeurs; 
}


// Recherche de tous les accidents en retournant un tableau contenant les attributs suivant :
// [age, date_heure, ville, latitude, longitude, descr_athmo, descr_lum, descr_etat_surf, descr_dispo_secu] 
function getInfosAllAccident($db){
    // Requête SQL pour récupérer tous les accidents
    $requete = "SELECT age, date_heure, ville, latitude, longitude, descr_athmo.val AS descr_athmo, descr_lum.val AS descr_lum, descr_etat_surf.val AS descr_etat_surf, descr_dispo_secu.val AS descr_dispo_secu
                FROM accident
                INNER JOIN descr_athmo ON accident.descr_athmo_id = descr_athmo.id
                INNER JOIN descr_lum ON accident.descr_lum_id = descr_lum.id
                INNER JOIN descr_etat_surf ON accident.descr_etat_surf_id = descr_etat_surf.id
                INNER JOIN descr_dispo_secu ON accident.descr_dispo_secu_id = descr_dispo_secu.id";

    $resultat = $connexion->query($requete);

    if ($resultat) {
        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return array(); // Retourner un tableau vide en cas d'erreur ou de résultats vides
    }
    
    // --------- OLD
    //// getting the today date
    //$statement = $db->query('SELECT m.match_id, t.town, s.sport_name, 
    //m.date-current_date AS period, m.registered_count>=m.number_max_player AS complete 
    //FROM match m, sport s, town t 
    //WHERE m.sport_id = s.sport_id AND m.town_id = t.town_id AND m.date > NOW() ORDER BY m.date');
    //return $statement->fetchAll(PDO::FETCH_ASSOC);
}


// fonction de filtrage pour la visualisation
// IDee faire une recherche autour de la zone d'une ville ou d'une latitude ou longitude
function searchEvent($db, $age, $date_heure, $ville, $latitude, $longitude, $descr_athmo_id, $descr_lum_id, $descr_etat_surf_id, $descr_dispo_secu_id){
  // setting generic value
  $genericVal = '*';

  // getting the table with all events
  $eventArr = getInfosAllEventForSearch($db);
  //echo "eventArr before <br>";
  //print_r($eventArr);

  // modifying the array with all events filtered (if the search field is empty, it puts a generic value for this column)
  foreach ($eventArr as $i => $val){

    if (empty($age)){
        $eventArr[$i]['age'] = $genericVal;
    }
    if (empty($date_heure)){
        $eventArr[$i]['date_heure'] = $genericVal;
    }
    if (empty($ville)){
        $eventArr[$i]['ville'] = $genericVal;
    }
    if (empty($latitude)){
      $eventArr[$i]['latitude'] = $genericVal;
    }
    if (empty($longitude)){
        $eventArr[$i]['longitude'] = $genericVal;
    }
    if (empty($descr_athmo_id)){
      $eventArr[$i]['descr_athmo_id'] = $genericVal;
    }
    if (empty($descr_lum_id)){
      $eventArr[$i]['descr_lum_id'] = $genericVal;
    }
    if (empty($descr_etat_surf_id)){
      $eventArr[$i]['descr_etat_surf_id'] = $genericVal;
    }
    if (empty($descr_dispo_secu_id)){
      $eventArr[$i]['descr_dispo_secu_id'] = $genericVal;
    }
  }

  // setting the non searched fields value to the value '*'
  if (empty($age)){
    $age = $genericVal;
  }
  if (empty($date_heure)){
    $date_heure = $genericVal;
  }
  if (empty($ville)){
    $ville = $genericVal;
  }
  if (empty($latitude)){
    $latitude = $genericVal;
  }
  if (empty($longitude)){
    $longitude = $genericVal;
  }
  if (empty($descr_athmo_id)){
    $descr_athmo_id = $genericVal;
  }
  if (empty($descr_lum_id)){
    $descr_lum_id = $genericVal;
  }
  if (empty($descr_etat_surf_id)){
    $descr_etat_surf_id = $genericVal;
  }
  if (empty($descr_dispo_secu_id)){
    $descr_dispo_secu_id = $genericVal;
  }

  // filling the searchedAcc with the IDs of the matches searched
  $searchedAcc = [];
  foreach ($eventArr as $val){
      if ($val['age']==$age && $val['date_heure']==$date_heure && $val['ville']==$ville && $val['latitude']==$latitude && $val['longitude']==$longitude && 
      $val['descr_athmo_id']==$descr_athmo_id && $val['descr_lum_id']==$descr_lum_id && $val['descr_etat_surf_id']==$descr_etat_surf_id && $val['descr_dispo_secu_id']==$descr_dispo_secu_id){ // gerer periodes
          array_push($searchedAcc, $val['id_acc']);
      }
  }
  //print_r($searchedEventIdArr);
  return $searchedAcc;
}


// ----------------------------- TESTS -----------------------------

// Connexion à la base de donnée
$db = dbConnect();

// Exemple d'utilisation de la fonction ajouterAccident
ajouterAccident($db, 25, 20090131200000, "Paris", 48.8566, 2.3522, 1, 2, 3, 4);

// exemple d'utilisation de la fonction getDescrAthmoValues
$valeursDescrAthmo = getDescrAthmoValues($db);

// exemple d'utilisation de la fonction getValDescrLum
$valeursDescrLum = getValDescrLum($db);

// exemple d'utilisation de la fonction getValDescrEtatSurf
$valeursDescrEtatSurf = getValDescrEtatSurf($db);

// exemple d'utilisation de la fonction getValDescrDispoSecu
$valeursDescrDispoSecu = getValDescrDispoSecu($db);

// exemple d'utilisation de la fonction searchEvent
$searchedArr = searchEvent($db, $age, $date_heure, $ville, $latitude, $longitude, $descr_athmo_id, $descr_lum_id, $descr_etat_surf_id, $descr_dispo_secu_id)

// Fermeture de la connexion
$connexion = null;

?>
