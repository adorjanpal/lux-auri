<?php   
  session_start();
  include_once('./fuggvenyek/dbfuggvenyek.php');
  
  $aktualisFelhasznalo = felhasznalot_leker($_SESSION['felhasznalonev']);
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
    <header>
      <nav class="navbar">
        <a href="index.html"> <h1>LUXAURI</h1></a>
        <span class="nav-icon-container"
          ><a href="kosar.html"
            ><img src="assets/bag.svg" alt="Bevasarlo Kosar"
          /></a>
          <a href="kedvencek.html"
            ><img src="assets/heart.svg" alt="Kedvencek"
          /></a>
          <a href="profil.html"><img src="assets/person.svg" alt="Profil" /></a>
        </span>
      </nav>
    </header>
    <main class="profil-main">
      <div class="profil-container">
        <div class="adatok-menu-span">
          <button id="profil-switch" class="link-btn active">
            Profil adatok
          </button>
          <span class="active">|</span>
          <button id="korabbi-switch" class="link-btn">
            Korábbi rendelések
          </button>
        </div>
        <!-- Profil fejléc -->
        <div class="profile-header">
          
          <img class="profil-img" src="felhasznalo_kepek/<?php echo $aktualisFelhasznalo['profilkep'] ?  $aktualisFelhasznalo['profilkep'] : 'default.jpg' ?>" alt="Profilkép" />
          <div>
            <span><?php echo $aktualisFelhasznalo['nev'] ?></span>
            <span><?php echo $aktualisFelhasznalo['felhasznalonev'] ?></span>
          </div>
          <img src="assets/box-arrow-right.svg" alt="Kijelentkezés Gomb" />
        </div>
        <!-- Korábbi rendelések -->
        <div
          id="korabbi-rendelesek"
          class="korabbi-rendelesek-container hidden"
        >
          <div class="korabbi-rendeles-row">
            <div class="elso-oszlop">
              <a href="termek.html" class="img-container">
                <img src="assets/rings.jpg" alt="gyuru" />
              </a>
              <div class="gyuru-details">
                <a href="#" class="kosar-item-title">Arany gyűrű</a>
                <div>
                  <p class="kosar-item-detail">Méret: 40</p>
                  <p class="kosar-item-detail">Mennyiség: 1</p>
                </div>
              </div>
            </div>
            <div>
              <p>50 000 FT</p>
            </div>
            <div class="tetel-modositasa-container">
              <div class="tetel-modositasa-container">
                <button class="btn">Megrendelés mégegyszer</button>
              </div>
            </div>
          </div>
          <div class="korabbi-rendeles-row">
            <div class="elso-oszlop">
              <div class="img-container">
                <img src="assets/rings.jpg" alt="gyuru" />
              </div>
              <div class="gyuru-details">
                <a href="#" class="kosar-item-title">Arany gyűrű</a>
                <div>
                  <p class="kosar-item-detail">Méret: 40</p>
                  <p class="kosar-item-detail">Mennyiség: 1</p>
                </div>
              </div>
            </div>
            <div>
              <p>50 000 FT</p>
            </div>
            <div class="tetel-modositasa-container">
              <div class="tetel-modositasa-container">
                <button class="btn">Megrendelés mégegyszer</button>
              </div>
            </div>
          </div>
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
                <select name="nem" id="nem" value="<?php echo $aktualisFelhasznalo['ferfi'] ?>">
                  <option selected>- Nincs megadva -</option>
                  <option value="1">Férfi</option>
                  <option value="0">Nő</option>
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
            <button class="btn">Adatok módosítása</button>
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
