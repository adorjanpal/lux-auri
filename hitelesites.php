<?php 
  session_start();
  if (isset($_SESSION["felhasznalonev"])) {
    header("Location: ./index.php");
  }
?>
<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="index.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Regisztráció</title>
  </head>
  <body>
    <main>
      <div class="container">
        <div class="image-container">
          <img src="assets/LUXAURI.jpg" alt="LuxAuri" />
        </div>

        <!-- Regisztrációs űrlap (ez jelenik meg alapból) -->
        <form
          id="regisztracio-form"
          class="register-form"
          action="./fuggvenyek/regisztracio.php"
          method="post"
        >
          <h2>REGISZTRÁCIÓ</h2>
          <div class="form-item">
            <label class="form-label" for="email">email</label>
            <input
              class="form-input"
              type="text"
              id="email"
              name="email"
              required
              placeholder="email..."
            />
          </div>
          <div class="form-item">
            <label class="form-label" for="felhasznalonev"
              >felhasználónév</label
            >
            <input
              class="form-input"
              type="text"
              id="felhasznalonev"
              name="felhasznalonev"
              required
              placeholder="felhasználónév..."
            />
          </div>

          <div class="nev-container">
            <div class="form-item">
              <label class="form-label vezeteknev-label" for="vezeteknev"
                >vezetéknév</label
              >
              <input
                class="form-input"
                type="text"
                id="vezeteknev"
                name="vezeteknev"
                required
                placeholder="vezetéknév..."
              />
            </div>
            <div class="form-item">
              <label class="form-label keresztnev-label" for="keresztnev"
                >keresztnév</label
              >
              <input
                class="form-input"
                type="text"
                id="keresztnev"
                name="keresztnev"
                required
                placeholder="keresztnév..."
              />
            </div>
          </div>

          <div class="form-item">
            <label class="form-label" for="jelszo">jelszó</label>
            <input
              class="form-input"
              type="password"
              id="jelszo"
              name="jelszo"
              required
              placeholder="jelszó..."
            />
          </div>
          <div class="form-item">
            <label class="form-label" for="jelszoMegegyszer"
              >jelszó mégegyszer</label
            >
            <input
              class="form-input"
              type="password"
              id="jelszoMegegyszer"
              name="jelszoMegegyszer"
              required
              placeholder="jelszó mégegyszer..."
            />
          </div>

          <div class="nav-container">
            <button class="btn text-center">Regisztráció</button>

            <div class="bejelentkezes-nav-container">
              <p>Van már fiókod?</p>
              <p id="bejelentkezes-kapcsolo" class="bejelentkezes-link">
                Bejelentkezés
              </p>
            </div>
          </div>
        </form>

        <!-- Bejelentkezési Űrlap -->
        <form
          class="register-form hidden"
          action="./fuggvenyek/bejelentkezes.php"
          method="post"
          id="bejelentkezes-form"
        >
          <h2>BEJELENTKEZÉS</h2>
          <div class="form-item">
            <label class="form-label" for="felhasznalonev"
              >felhasználónév</label
            >
            <input
              class="form-input"
              type="text"
              id="felhasznalonev2"
              name="felhasznalonev2"
              required
              placeholder="felhasználónév..."
            />
          </div>

          <div class="form-item">
            <label class="form-label" for="jelszo">jelszó</label>
            <input
              class="form-input"
              type="password"
              id="jelszo2"
              name="jelszo2"
              required
              placeholder="jelszó..."
            />
          </div>

          <div class="nav-container">
            <button class="btn text-center">Bejelentkezés</button>

            <div class="bejelentkezes-nav-container">
              <p id="van">Nincs fiókod?</p>
              <p id="regisztracio-kapcsolo" class="bejelentkezes-link">
                Regisztráció
              </p>
            </div>
          </div>
        </form>
      </div>
    </main>
    <script>
      //Váltás a bejelentkezési űrlapra
      $("#bejelentkezes-kapcsolo").click(function (e) {
        $("#regisztracio-form").addClass("hidden");
        $("#bejelentkezes-form").removeClass("hidden");
      });

      //Váltás a regisztrációs űrlapra
      $("#regisztracio-kapcsolo").click(function (e) {
        $("#regisztracio-form").removeClass("hidden");
        $("#bejelentkezes-form").addClass("hidden");
      });
    </script>
  </body>
</html>
