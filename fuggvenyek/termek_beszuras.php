<?php
  include_once("./dbfuggvenyek.php"); 
  $nev = $_POST['nev'];
  $ar = $_POST['ar'];
  $mennyiseg = $_POST['mennyiseg'];
  $meret = $_POST['meret'];
  $tipus = $_POST['tipus'];
  $leiras = $_POST['leiras'];
  $file = $_FILES['kep'];

  
  
  if ( isset($nev) && isset($ar) && isset($mennyiseg) && isset($meret) && isset($leiras) && isset($tipus) && isset($file)) {
      
      
              
      termeket_beszur($nev, $meret, $mennyiseg, $leiras, $ar, $tipus, $file);
      
      header("Location: ../index.php");
      

  
  } else {
      error_log("Nincs beállítva valamely érték");
  }
