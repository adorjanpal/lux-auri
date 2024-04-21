<?php 
session_start();
include_once('./fuggvenyek/dbfuggvenyek.php');

$aktualisFelhasznalo = felhasznalot_leker($_SESSION['felhasznalonev']);

$aktualisFelhasznalonev = $aktualisFelhasznalo['felhasznalonev'];

$uzenetek = uzeneteket_leker($aktualisFelhasznalo['admin'],$aktualisFelhasznalonev);

?>
<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css" />
    <title>Üzenőfal</title>
  </head>
  <body>
    <?php include('./layout/header.php') ?>
   <main>
   <div class="col items-center">
    <h1>Üzenőfal</h1>
      <?php 
        if (isset($uzenetek)) {
          while($egysor = mysqli_fetch_assoc($uzenetek)){
            
           if ($egysor['szulo'] == null) {
            echo '<form action="./fuggvenyek/uzenet_beszuras.php" method="POST" class="velemeny-container border-b-normal-gray pb-1 mb-3">
            <div class="row items-center">
           
              <div class="velemeny-img-container">
                <img class="profil-img mr-1" src="./felhasznalo_kepek/'.$egysor['profilkep'].'" alt="Profilkép" />
              </div>
             
              <div class="col">
                  <span class="bold large">'.$egysor['nev'].'</span>
                  <span class="normal gray">'.$egysor['felhasznalonev'].'</span>
              </div>
              <span class="ml-1">'.$egysor['idopont'].'</span> 
            </div>
            <p class="ml-1">'.
             $egysor['tartalom']
            .'</p>
          <input type="hidden" name="felhasznalonev" id="felhasznalonev" value="'.$aktualisFelhasznalonev.'">
          <input type="hidden" name="szulo_id" id="szulo_id" value="'.$egysor['id'].'">';
          
           echo '
           <textarea 
           required
           class="w-full"
           name="szoveg"
           id="szoveg"
           rows="5"
           placeholder="Válasz..."></textarea>
           <button type="submit" class="btn mb-1">Válasz</button>
           <a class="btn" href="./uzenetek.php?id='.$egysor['id'].'">Válaszok</a>
          </form>'; };
          
          }
        } else {
          echo "<span>Nincsenek üzenetek!</span>";
        }
      ?>      
    
    <form method="POST" action="./fuggvenyek/uzenet_beszuras.php" class="col text-center">
     
      
      <input type="hidden" name="felhasznalonev" id="felhasznalonev" value="<?php echo $aktualisFelhasznalonev ?>">
      
      <textarea
      required
        name="szoveg"
        id="szoveg"
        cols="30"
        rows="5"
        placeholder="Visszajelzés..."
      ></textarea>
      <button type="submit" class="btn">Küldés</button>
    </form>
    </div>
   </main>
  </body>
</html>
