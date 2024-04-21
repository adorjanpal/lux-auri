<?php

    include_once('./dbfuggvenyek.php');
   
    if (!($conn = adatbazis_csatlakozas())) {
        return false;
    }
    
    $termek_id = $_POST['id'];
    $felhasznalonev = $_POST['felhasznalonev']; 
    $kosarhoz = $_POST['kosarhoz']; 

    if (isset($termek_id) && isset($felhasznalonev)) {
        $query = "DELETE FROM hozzaad WHERE felhasznalonev = '$felhasznalonev' AND termek_id = '$termek_id' AND kosarhoz = '$kosarhoz'";
        $result = mysqli_query($conn, $query);
        
        mysqli_close($conn);
        header($kosarhoz ? "Location: ../kosar.php" : "Location: ../kedvencek.php");
    } else {
        return false;
    }

?>