<?php 
session_start();
include_once('./fuggvenyek/dbfuggvenyek.php');
$aktualisFelhasznalo = felhasznalot_leker($_SESSION['felhasznalonev']);
$uzenet_id = $_GET['id'];
$valaszok = uzeneteket_leker_id($uzenet_id);
if (!isset($_SESSION["felhasznalonev"])) {
  header("Location: ./hitelesites.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css" />
    <title>Document</title>
</head>

<body>
<?php include("./layout/header.php") ?>
   <main class="col">
   <h1>Válaszok</h1>
    <?php
    while ($egysor = mysqli_fetch_assoc($valaszok)) {
        echo '<form action="./fuggvenyek/uzenet_beszuras.php" method="POST" class="velemeny-container border-b-normal-gray pb-1 mb-3">
    <div class="row items-center">
   
      <div class="velemeny-img-container">
      <img class="profil-img mr-1 mb-1" src="./felhasznalo_kepek/'.((isset($egysor["profilkep"]) && $egysor["profilkep"] !== '') ? $egysor["profilkep"] : "default.jpg").'"/>
      </div>
     
      <div class="col">
          <span class="bold large">'.$egysor['nev'].'</span>
          <span class="normal gray">'.$egysor['felhasznalonev'].'</span>
      </div>
      <span class="ml-1">'.$egysor['idopont'].'</span> 
    </div>
    <p class="ml-1 mb-3">'.
     $egysor['tartalom']
    .'</p>
  <input type="hidden" name="felhasznalonev" id="felhasznalonev" value="'.$aktualisFelhasznalo['felhasznalonev'].'">
  <input type="hidden" name="szulo_id" id="szulo_id" value="'.$egysor['id'].'">';
  
   if($aktualisFelhasznalo['admin']){
    echo '
   <textarea 
   required
   class="w-full"
   name="szoveg"
   id="szoveg"
   rows="5"
   placeholder="Válasz..."></textarea>
   <button type="submit" class="btn mb-1">Válasz</button>';
   
   }
  echo '<a class="btn" href="./uzenetek.php?id='.$egysor['id'].'">Válaszok</a></form>';
    }
    ?>
   </main>
</body>
</html>