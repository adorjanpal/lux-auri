<?php
    include_once('./dbfuggvenyek.php');
    if(!($conn = adatbazis_csatlakozas())){
        return false;
    };
    $mennyiseg = $_POST['mennyiseg'];
    $id = $_POST['id'];
    $felhasznalonev = $_POST['felhasznalonev'];

    $query = "UPDATE HOZZAAD SET mennyiseg = '$mennyiseg' WHERE felhasznalonev = '$felhasznalonev' AND termek_id = '$id' and KOSARHOZ = 1";
    mysqli_query($conn, $query);

    header('Location: ../kosar.php');
