<?php

    include_once('./dbfuggvenyek.php');
   
    if (!($conn = adatbazis_csatlakozas())) {
        return false;
    }
    
    $termek_id = $_POST['id'];
    $felhasznalonev = $_POST['felhasznalonev']; 

    if (isset($termek_id) && isset($felhasznalonev)) {
        $query = "DELETE FROM hozzaad WHERE felhasznalonev = '$felhasznalonev' AND termek_id = '$termek_id' AND kosarhoz = 1";
        $result = mysqli_query($conn, $query);
        
        mysqli_close($conn);
        header("Location: ../kosar.php");
    } else {
        return false;
    }

?>