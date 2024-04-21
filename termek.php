<?php
  session_start();
  include_once('./fuggvenyek/dbfuggvenyek.php');

  $id = $_GET['id'];

  $aktualisFelhasznalo = felhasznalot_leker($_SESSION['felhasznalonev']);
  $termek = termeket_leker_id($id);
  $velemenyek = velemenyeket_leker_termek_id($id);
  $velemenyek_felhasznalok = velemenyt_leker_termek_id($id);
  
  $termek = mysqli_fetch_assoc($termek);
  $velemenyekFetch = mysqli_fetch_assoc($velemenyek);
  
  // print_r($velemenyek);
  // print_r($termek);
 
?>
<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="index.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Gyűrű</title>
  </head>
  <body>
  <?php include("./layout/header.php") ?>
    <main class="termek-oldal-main w-full">

      <div class="termek-container">
        <!-- <div class="side-img-container">
          <img src="assets/ring2.jpg" alt="Fotó a termékről" />
          <img src="assets/ring5.jpg" alt="Fotó a termékről" />
          <img src="assets/ring4.jpg" alt="Fotó a termékről" />
        </div> -->
        <div class="main-img-container">
          <img src="./termek_kepek/<?php echo $termek['cim']?>" alt="Fotó a termékről" />
        </div>
        <form action="./fuggvenyek/hozzaad.php" method="POST" class="termek-adatok-container">
          <div>
            <div class="row gap-1 items-center mb-1">
              <h2 class="self-start"><?php echo $termek['nev'] ?></h2>
              <img
                class="kedvencek-img"
                src="assets/heart.svg"
                alt="Kedvencek Icon"
              />
            </div>
            <p class="gray mb-3 justify normal">
            <?php echo $termek['leiras'] ?>
            </p>
            <div class="ertekeles-container mb-1">
              <span class="csillagok">
                <?php 
                for ($i=0; $i < intval($velemenyekFetch['atlag']); $i++) { 
                  echo '<img id="star-1" src="assets/star-fill.svg" alt="1. csillag" />';
                }
                 ?>
              </span>
              <span class="gray">(<?php echo $velemenyekFetch['db'] ?>) Vélemény</span>
            </div>
            <span class="x-large"><?php echo $termek['ar'] ?> Ft</span>
          </div>
          <input type="hidden" name = 'felhasznalonev' value="<?php echo $aktualisFelhasznalo['felhasznalonev'] ?>">
          <input type="hidden" name = 'termek_id' value="<?php echo $id ?>">
          <input type="hidden" name = 'kosarhoz' value="1">
          <button class="btn abs-bottom-full w-inherit">Kosárba rakom</button>
        </form>
      </div>
      <div class="velemenyek-container ">
        <h3 class="x-large">Vélemények</h3>
        <?php
          while($velemeny = mysqli_fetch_assoc($velemenyek_felhasznalok)){
            echo '<div class="velemeny-container items-center border-b-normal-gray pb-1 mb-3 ">
            <div class="row items-center">
              <div class="velemeny-img-container">
              <img class="profil-img mr-1 mb-1" src="./felhasznalo_kepek/'.((isset($velemeny["profilkep"]) && $velemeny["profilkep"] !== '') ? $velemeny["profilkep"] : "default.jpg").'"/>
              </div>
              <div class="col">
                <div class="row items-center gap-1">
                  <span class="bold large">'.$velemeny['felhasznalonev'].'</span>
                  <span class="csillagok">';
                   for ($i=0; $i < intval($velemeny['csillag']); $i++) { 
                    echo ' <img src="assets/star-fill.svg" alt="1. csillag" />';
                   };
                   echo'</span>
                </div>
                <span class="normal gray">'.$velemeny['felhasznalonev'].'</span>
              </div>
            </div>
            <p class="ml-1">
              '.$velemeny['szoveg'].'
            </p>
          </div>';
          }
        ?>
      </div>
    </main>
  </body>
</html>
