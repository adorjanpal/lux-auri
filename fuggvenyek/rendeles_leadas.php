<?php
  include_once("./dbfuggvenyek.php"); 

  $termekek = $_POST['termek'];
  $felhasznalonev = $_POST['felhasznalonev'];
  

  
  
  if ( isset($termekek) && isset($felhasznalonev)) {
      rendelest_beszur($felhasznalonev, $termekek);
      
      header("Location: ../index.php");
      

  
  } else {
      error_log("Nincs beállítva valamely érték");
  }
