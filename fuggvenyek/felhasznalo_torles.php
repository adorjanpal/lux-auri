<?php 


$felhasznalonev = $_POST['felhasznalonev'];

if (isset($felhasznalonev)) {
    
    felhasznalot_torol($felhasznalonev);
    
    header('Location: ../profil.php');
}