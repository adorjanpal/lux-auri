<?php   
  session_start();
  include_once('./fuggvenyek/dbfuggvenyek.php');
  
  $aktualisFelhasznalo = felhasznalot_leker($_SESSION['felhasznalonev']);
  $korabbi_rendelesek = rendeleseket_leker($aktualisFelhasznalo['felhasznalonev']);

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
    <title>Profil</title>
  </head>

  <body>
  <?php include("./layout/header.php") ?>
    <main class="profil-main">
      <div class="profil-container relative">
        
        <!-- Profil fejléc -->
        <div class="profile-header">
        <div class="adatok-menu-span row gap-1 items-center normal">
          <span id="profil-switch" class="link-btn active pointer">
            Profil adatok
          </span>
          <span class="active">|</span>
          <span id="korabbi-switch" class="link-btn pointer">
            Korábbi rendelések
          </span>
        </div>
          <?php echo '<img class="profil-img mr-1 mb-1" src="./felhasznalo_kepek/'.((isset($aktualisFelhasznalo["profilkep"]) && $aktualisFelhasznalo["profilkep"] !== '') ? $aktualisFelhasznalo["profilkep"] : "default.jpg").'"/>' ?>
          <div class="col">
            <span class="large bold"><?php echo $aktualisFelhasznalo['nev'] ?></span>
            <span><?php echo $aktualisFelhasznalo['felhasznalonev'] ?></span>
          </div>
          <form action="./fuggvenyek/kijelentkezes.php" method="post">
            <button class="bg-transparent pointer"><img src="assets/box-arrow-right.svg" alt="Kijelentkezés Gomb" /></button>
          </form>
        </div>
        <!-- Korábbi rendelések -->
        <div
          id="korabbi-rendelesek"
          class="korabbi-rendelesek-container hidden"
        >
          <?php
            while($egysor = mysqli_fetch_assoc($korabbi_rendelesek)){
              $termek = mysqli_fetch_assoc(termeket_leker_id($egysor['termek_id']));
              echo '<div class="korabbi-rendeles-row">
              <div class="elso-oszlop">
              <div class="img-container">
                <img src="./termek_kepek/'.$termek['cim'].'" alt="Kép a termékről" />
              </div>
              <div class="gyuru-details">
               <a href="#" class="kosar-item-title">'.$termek['nev'].'</a>
              <div>
                <p class="kosar-item-detail"> Méret: '.$termek['meret'].'</p>
                <p class="kosar-item-detail"> Mennyiség: '.$termek['mennyiseg'].'</p>
              </div>
            </div>
          </div>
          <div>
            <p>Ár: '.$termek['ar'].'</p>
          </div>
          
        </div>';
              
            }?>
        </div>
       
        <!-- Felhasználó adatai -->
        <div id="profil-adatok-container" class="profil-adatok-container">
          <form
            id="profil-form"
            enctype="multipart/form-data"
            class="register-form profil-form"
            action="./fuggvenyek/felhasznalo_modositas.php"
            method="post"
          >
            <h2>Profil adatok</h2>
            <input type="hidden" name="felhasznalonev" id="felhasznalonev" value="<?php echo $aktualisFelhasznalo["felhasznalonev"] ?>">
            <div class="form-item">
              <label class="form-label" for="lakcim">Lakcím</label>
              <input
                class="form-input"
                type="text"
                id="lakcim"
                name="lakcim"
                value="<?php echo $aktualisFelhasznalo['lakcim'] ?>"
                placeholder="Lakcím..."
                
              />
            </div>
            <div class="form-item">
              <label class="form-label" for="telefonszam">Telefonszám</label>
              <input
                class="form-input"
                type="text"
                id="telefonszam"
                name="telefonszam"
                placeholder="Telefonszám..."
                
                value="<?php echo $aktualisFelhasznalo['telefonszam'] ?>"
              />
            </div>

            <div class="nev-container">
              <div class="profil-form-item">
                <label class="date-label" for="szuletesi_datum"
                  >Születési dátum</label
                >
                <input
                  class="form-input date-input"
                  type="date"
                  id="szuletesi_datum"
                  name="szuletesi_datum"
                  
                  value="<?php echo $aktualisFelhasznalo['szuletesi_datum'] ?>"
                />
              </div>
              <div class="profil-form-item">
                <label class="select-label" for="nem">Neme</label>
                <select name="nem" id="nem">
                  <option <?php ($aktualisFelhasznalo['ferfi']) === null && "selected" ?>>- Nincs megadva -</option>
                  <option <?php ($aktualisFelhasznalo['ferfi']) === '1' && "selected" ?> value=1>Férfi</option>
                  <option <?php ($aktualisFelhasznalo['ferfi'] === '0') && "selected" ?> value=0>Nő</option>
                </select>
              </div>
            </div>

            <div class="form-item">
              <label class="form-label" for="email">Email</label>
              <input
                class="form-input"
                type="email"
                id="email"
                name="email"
                
                value="<?php echo $aktualisFelhasznalo['email'] ?>"
              />
            </div>
            <div class="form-item">
              <label class="form-label" for="profilkep">Profilkép</label>
              <input
                class="form-input"
                type="file"
                id="profilkep"
                name="profilkep"
              />
            </div>
            <button class="btn w-full">Adatok módosítása</button>
            
          </form>
          <form method="POST" action="./fuggvenyek/felhasznalo_torles.php">
              <input type="hidden" name="felhasznalonev" value="<?php echo $aktualisFelhasznalo['felhasznalonev'] ?>">
              <button type="submit" class="btn eltavolitas-btn">Fiók törlése</button>
            </form>
        </div>
      </div>
    </main>
    <script>
      $("#profil-switch").click(function (e) {
        $("#korabbi-rendelesek").addClass("hidden");
        $("#profil-adatok-container").removeClass("hidden");
        $("#korabbi-switch").removeClass("active");
        $("#profil-switch").addClass("active");
        console.log("valtas profilra");
      });

      $("#korabbi-switch").click(function (e) {
        console.log("valtas korabbira");
        $("#korabbi-rendelesek").removeClass("hidden");
        $("#profil-adatok-container").addClass("hidden");
        $("#korabbi-switch").addClass("active");
        $("#profil-switch").removeClass("active");
      });
    </script>
  </body>
</html>
