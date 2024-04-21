<?php
session_start();

if (!isset($_SESSION['felhasznalonev'])) {
    header("Location: index.html");
    exit();
}

include("fuggvenyek/dbfuggvenyek.php");
$reszosszeg = 0;
$aktualisFelhasznalo = felhasznalot_leker($_SESSION['felhasznalonev']);

$kosarTetelek = kosarat_leker($_SESSION['felhasznalonev'], 1);
$termekek = [];

?>

<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css" />
    <title>Kosár</title>
  </head>
  <body>
    <?php include('./layout/header.php') ?>
    <main class="kosar-main">
      <div class="kosar-container">
        <div class="kosar-header">
          <h2>Kosaram</h2>
          <img
            src="assets/cash-stack.svg"
            style="margin-left: 2rem"
            alt="Pénz"
          />
          <div></div>
        </div>
        <?php foreach ($kosarTetelek as $tétel) : ?>

        <div class="kosar-row">
          <div class="elso-oszlop">
            <div class="img-container">
              <img
                src="./termek_kepek/<?php echo $tétel['cim']; ?>"
                alt="<?php echo $tétel['nev']; ?>"
              />
            </div>
            <div class="gyuru-details">
              <a href="#" class="kosar-item-title"
                ><?php echo $tétel['nev']; ?></a
              >
              <div class="col">
                <p class="kosar-item-detail">
                  Méret:
                  <?php echo $tétel['meret']; ?>
                </p>
               
              </div>
            </div>
          </div>
          <div>
            <p>
              <?php $reszosszeg += $tétel['ar'] * $tétel['mennyiseg']; echo $tétel['ar']; ?>
              FT
            </p>
          </div>
          <div class="tetel-modositasa-container">
            <form method="POST" action="./fuggvenyek/kosarbol_torles.php" class="tetel-modositasa-container">
              <input type="hidden" name="id" id="id" value="<?php echo $tétel['termek_id'] ?>">
              <input type="hidden" id="felhasznalonev" name="felhasznalonev" value="<?php echo $aktualisFelhasznalo["felhasznalonev"] ?>">
              <input type="hidden" id="kosarhoz" name="kosarhoz" value="1">
              <button type="submit" class="btn eltavolitas-btn">Eltávolítás</button>
            </form>
            <form method="POST" action="./fuggvenyek/kosar_modositas.php" class="tetel-modositasa-container">
              <input type="hidden" name="id" id="id" value="<?php echo $tétel['termek_id'] ?>">
              <input type="hidden" id="felhasznalonev" name="felhasznalonev" value="<?php echo $aktualisFelhasznalo["felhasznalonev"] ?>">
              
              <button type="submit" class="btn ">Módosítás</button>
              <div class="row items-center text-grey">
                <label for="mennyiseg">Mennyiség:</label>
                <input class="db-input" min='1' name="mennyiseg" id="mennyiseg" value= "<?php echo $tétel['mennyiseg'] ?>" class="kosar-item-detail" type="number">
                </div>
            </form>
          </div>
        </div>
        <?php 
        $termekek += [$tétel['termek_id'] => $tétel['mennyiseg']];
        
        
      ?>
        <?php endforeach; ?>
      </div>
      <form action="./fuggvenyek/rendeles_leadas.php" method="POST" class="osszegzes-container">
        <h2>Összesítés</h2>
        <input type="hidden" name="felhasznalonev" value=<?php echo $aktualisFelhasznalo["felhasznalonev"] ?> >
        <?php
          
          foreach($termekek as $key => $value)
          { 
            echo '<input id="" name="termek['.$key.']" type="hidden" value="'. $value.'" />';
          }
        ?>

        
        <div class="osszesites-div col gap-1">
         
          <div >
            <span class="bold">Részösszeg: </span> <?php echo $reszosszeg.' Ft'?>
          </div>
          <div >
            <span class="bold">Szállítás: </span> 2000 Ft
          </div>
        </div>
        <div>
          <span class="bold">
          Végösszeg:
          </span> <?php echo $reszosszeg + 2000 .' Ft'?>
        </div>
        <button class="btn">Megrendelés</button>
      </form>
    </main>
  </body>
</html>
