<?php
  session_start();
  include_once("./fuggvenyek/dbfuggvenyek.php");
  $termekek = termekeket_leker("karkötő");
  $aktualisFelhasznalo = felhasznalot_leker($_SESSION['felhasznalonev']);
  if (!isset($_SESSION["felhasznalonev"])) {
    header("Location: ./hitelesites.php");
  }
?>

<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Nyakláncok</title>
  </head>

  <body class="relative" >
 
    <?php include("./layout/header.php") ?>
    <main class="relative ">
    <div class="hidden modal-container" id="termekek-hozzaadasa-modal">
          <img src="assets/x-lg.svg" class="x-btn pointer" id="close" alt="Close modal">
          <?php include 'termekek_hozzaadasa.php'; ?>
    </div>
      <div class="gyuruk-heading">
        <div class="row gap-1">
          <h2>Karkötők</h2>
          <?php
            if ($aktualisFelhasznalo['admin']) {
              echo '<button class="btn hozzaadas" id="termek-hozzaadas">
              Termék hozzáadása
            </button>';
            }
           ?>
         </div>
        <p class="gyuruk-text">
          Fedezze fel lenyűgöző nyakláncainkat, melyek kifinomultságot és
          stílust kölcsönöznek viselőjüknek. Válasszon a vintage bájú, modern
          minimalista vagy extravagáns darabok közül. Kiváló minőségű anyagokból
          készültek, és minden alkalmazkodnak. Legyen az öltözékének
          elengedhetetlen része! Böngésszen most és találja meg tökéletes
          nyakláncát!
        </p>
        </div>
        <div class="grey-line"></div>
       
        
        <div class="gyuruk-container">
          
        <?php
           if ($termekek) {
            while($egysor = mysqli_fetch_assoc($termekek)){
             
              
              echo '<a href="./termek.php?id='.$egysor['termek_id'].'" class="col relative mt-1">'.
              '<form action="./fuggvenyek/hozzaad.php" method ="POST">
              <input type="hidden" name = "termek_id" value ="'.$egysor['termek_id'].'">
              <input type="hidden" name = "felhasznalonev" value ="'.$aktualisFelhasznalo['felhasznalonev'].'">
              <input type="hidden" name = "kosarhoz" value ="0">

              <button class="bg-transparent absolute top-1 right-1 pointer"><img src="assets/heart-white.svg" class = "icon-s "/></button></form>'.
              '<img class="termek-img" src="./termek_kepek/'.$egysor["cim"].'"/>'.
              '<div class="col gap-05 ">'.
              '<span class="csillagok">';
              if ($egysor["csillag"]) {
                for ($i=0; $i < intval($egysor["csillag"]); $i++) { 
                  echo '<img id="star-1" src="assets/star-fill.svg" alt="1. csillag" />';
                };
              } else {
                for ($i=0; $i < 5; $i++) { 
                  echo '<img id="star-1" src="assets/star.svg" alt="1. csillag" />';
                };
              }
               echo'</span>'.
                '<span class="large ">'.$egysor["nev"].'</span>'.
                '<span class="large" >'.$egysor["ar"].' Ft'.'</span>'.
                
              '</div>'.
            '</a>';

              
            }
           } else {
            echo '<span>Sajnos nem található termék az adott kategóriában :(</span>';
           }
        ?>
       
          
        </div>

       
      
     
    </main>
    <?php include('./layout/footer.php') ?>
    <script>
      $("#termek-hozzaadas").click(function (e) {
        e.preventDefault();
        
        $("#termekek-hozzaadasa-modal").removeClass("hidden");
        $("#termekek-hozzaadasa-modal").addClass("col");

      });
      $("#close").click(function (e) {
        e.preventDefault();
        
        $("#termekek-hozzaadasa-modal").removeClass("col");
        $("#termekek-hozzaadasa-modal").addClass("hidden");

      });
    </script>
  </body>
</html>
