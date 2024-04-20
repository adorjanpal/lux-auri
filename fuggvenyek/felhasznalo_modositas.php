<?php
  include_once("./dbfuggvenyek.php");
  $felhasznalonev = $_POST['felhasznalonev'];
  $email = $_POST['email'];
  $lakcim = $_POST['lakcim'];
  $szuletesi_datum = $_POST['szuletesi_datum'];
  $nem = $_POST['nem'];
  $telefonszam = $_POST['telefonszam'];
  $file = $_FILES['profilkep'];

  
  
  if ( isset($felhasznalonev)) {
      $aktualisFelhasznalo = felhasznalot_leker($felhasznalonev);
      $modositando = [];
      if ($aktualisFelhasznalo["email"] !== $email) {
        $modositando['email'] = $email;
      }
      if ($aktualisFelhasznalo["lakcim"] !== $lakcim) {
        $modositando[ 'lakcim']  = $lakcim;
      }
      if ($aktualisFelhasznalo["szuletesi_datum"]!== $szuletesi_datum) {
        
        $modositando['szuletesi_datum'] = $szuletesi_datum;
      }
      if ($aktualisFelhasznalo["telefonszam"] !== $telefonszam) {
        $modositando['telefonszam']=$telefonszam;
      }
      if ($aktualisFelhasznalo["ferfi"] !== $nem) {
        echo $aktualisFelhasznalo['ferfi'].'medadott: '.$nem;
        $modositando['ferfi'] = $nem;
      }
      if ($aktualisFelhasznalo["profilkep"] !== $file['name']) {
        $modositando['profilkep']=$file;
      }
      


      
              
      felhasznalot_modosit($modositando, $felhasznalonev);
      
    //   header("Location: ../profil.php");
      

  
  } else {
      error_log("Nincs beállítva valamely érték");
  }