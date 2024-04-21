<?php
session_start();

if (!isset($_SESSION['felhasznalonev'])) {
    header("Location: ./hitelesites.php");
    exit();
}

include("fuggvenyek/dbfuggvenyek.php");

$aktualisFelhasznalo = felhasznalot_leker($_SESSION['felhasznalonev']);

$kedvencek = kosarat_leker($_SESSION['felhasznalonev'], 0);


?>
<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css" />
    <title>Kedvencek</title>
  </head>

  <body>
   <?php include("./layout/header.php") ?>
    <main class="kosar-main">
      <div class="kosar-container" style="width: 90%">
        <div class="kosar-header">
          <h2>Kedvenceid</h2>
          <img
            src="assets/cash-stack.svg"
            style="margin-right: 8rem"
            alt="Penz"
          />
          <div></div>
        </div>
        <?php
        while ($egysor = mysqli_fetch_assoc($kedvencek)) {
          echo '<div class="kosar-row">
          <div class="elso-oszlop">
            <div class="img-container">
              <img src="./termek_kepek/'.$egysor['cim'].'" alt="gyuru" />
            </div>
            <div class="gyuru-details">
              <a href="./termek.php?id='.$egysor['termek_id'].'" class="kosar-item-title">'.$egysor['nev'].'</a>
            </div>
          </div>
          <div>
            <p>'.$egysor['ar'].' Ft</p>
          </div>
          <form method="POST" action="./fuggvenyek/kosarbol_torles.php" class="tetel-modositasa-container">
              <input type="hidden" name="id" id="id" value="'.$egysor["termek_id"].'">
              <input type="hidden" id="felhasznalonev" name="felhasznalonev" value="'. $aktualisFelhasznalo["felhasznalonev"] .'">
              <input type="hidden" id="kosarhoz" name="kosarhoz" value="0">
              <button type="submit" class="btn eltavolitas-btn">Eltávolítás</button>
          </form>
        </div>';
        }
        
        ?>
        </div>
        </div>
      </div>
    </main>
  </body>
</html>
