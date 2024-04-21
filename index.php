<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="index.css" />
    <title>Home</title>
  </head>
  <body>
    <?php include("./layout/header.php") ?> 
    <main>
      <div class="index-container">
        <!-- Karkötők -->
        <a id="karkotok-link" href="karkotok.php" class="home-img-container">
          <img src="assets/bracelet.webp" alt="Karkötők" />
          <div class="text-container">
            <h3 id="karkotok-title">Karkötők</h3>
            <p id="karkotok-text" class="index-text hidden">
              Elegáns, divatos karkötők széles választéka: gyöngy, bőr, arany.
              Kiemelkedő minőség, egyedi stílusok, kifinomult design.
            </p>
          </div>
        </a>
        <!-- Nyakláncok -->
        <a
          id="nyaklancok-link"
          href="nyaklancok.php"
          class="home-img-container"
        >
          <img src="assets/necklace.jpg" alt="Nyakláncok" />
          <div class="text-container">
            <h3>Nyakláncok</h3>
            <p id="nyaklancok-text" class="index-text hidden">
              Kifinomult nyakláncok: arany, gyöngy, drágakő. Egyedi stílusok,
              elegancia és minőség garantált.
            </p>
          </div>
        </a>
        <!-- Gyűrűk -->
        <a id="gyuruk-link" href="gyuruk.php" class="home-img-container">
          <img src="assets/rings.jpg" alt="Gyűrűk" />
          <div class="text-container">
            <h3>Gyűrűk</h3>
            <p id="gyuruk-text" class="index-text hidden">
              Elegáns gyűrűk: arany, ezüst, gyémánt. Klasszikus és modern
              design, tökéletes ajándék minden alkalomra.
            </p>
          </div>
        </a>
      </div>
    </main>
    <script>
      //Szöveg megjelenítése, ha ráviszi a felhasználó a kurzort (karkötők)
      $("#karkotok-link").mouseover(function (e) {
        let opacity = 0.1;
        let element = $("#karkotok-text");
        element.removeClass("hidden");
        element.css("opacity", opacity);

        let timer = setInterval(function () {
          if (opacity >= 1) {
            clearInterval(timer);
          }
          element.css("opacity", opacity);

          opacity += opacity * 0.1;
        }, 10);
      });
      //Szöveg eltűntetése, ha leviszi a képről a felhasználó a kurzort (karkötők)

      $("#karkotok-link").mouseleave(function (e) {
        var opacity = 1;
        let element = $("#karkotok-text");
        var timer = setInterval(function () {
          if (opacity <= 0.1) {
            element.addClass("hidden");
            clearInterval(timer);
          }
          element.css("opacity", opacity);
          opacity -= opacity * 0.1;
        }, 10);
      });
      //Szöveg megjelenítése, ha ráviszi a felhasználó a kurzort (nyakláncok)
      $("#nyaklancok-link").mouseover(function (e) {
        let opacity = 0.1;
        let element = $("#nyaklancok-text");
        element.removeClass("hidden");
        element.css("opacity", opacity);

        let timer = setInterval(function () {
          if (opacity >= 1) {
            clearInterval(timer);
          }
          element.css("opacity", opacity);

          opacity += opacity * 0.1;
        }, 10);
      });
      //Szöveg eltűntetése, ha leviszi a képről a felhasználó a kurzort (nyakláncok)
      $("#nyaklancok-link").mouseleave(function (e) {
        var opacity = 1;
        let element = $("#nyaklancok-text");
        var timer = setInterval(function () {
          if (opacity <= 0.1) {
            element.addClass("hidden");
            clearInterval(timer);
          }
          element.css("opacity", opacity);
          opacity -= opacity * 0.1;
        }, 10);
      });
      //Szöveg megjelenítése, ha ráviszi a felhasználó a kurzort (gyűrűk)
      $("#gyuruk-link").mouseover(function (e) {
        let opacity = 0.1;
        let element = $("#gyuruk-text");
        element.removeClass("hidden");
        element.css("opacity", opacity);

        let timer = setInterval(function () {
          if (opacity >= 1) {
            clearInterval(timer);
          }
          element.css("opacity", opacity);

          opacity += opacity * 0.1;
        }, 10);
      });
      //Szöveg eltűntetése, ha leviszi a képről a felhasználó a kurzort (gyűrűk)
      $("#gyuruk-link").mouseleave(function (e) {
        var opacity = 1;
        let element = $("#gyuruk-text");
        var timer = setInterval(function () {
          if (opacity <= 0.1) {
            element.addClass("hidden");
            clearInterval(timer);
          }
          element.css("opacity", opacity);
          opacity -= opacity * 0.1;
        }, 10);
      });
    </script>
  </body>
</html>
