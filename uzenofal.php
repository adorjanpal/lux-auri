<?php 
session_start();
include_once('./fuggvenyek/dbfuggvenyek.php');

$aktualisFelhasznalo = felhasznalot_leker($_SESSION['felhasznalonev']);

$aktualisFelhasznalo = $aktualisFelhasznalo['felhasznalonev'];

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
    
    <form mehod="POST" action="./fuggvenyek/uzenet_beszuras.php" class="col text-center">
      <h1>Üzenőfal</h1>
      
      <input type="hidden" name="felhasznalonev" id="felhasznalonev" value="<?php echo $aktualisFelhasznalo ?>">
      <input type="hidden" name="uzenet_id" id="uzenet_id" value='1' >
      <textarea
        name="szoveg"
        id="szoveg"
        cols="30"
        rows="10"
        placeholder="Visszajelzés..."
      ></textarea>
      <button type="submit" class="btn">Küldés</button>
    </form>
  </body>
</html>
