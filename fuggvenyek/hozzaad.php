<?php
include_once('./dbfuggvenyek.php');
$felhasznalonev = $_POST['felhasznalonev'];
$termek_id = $_POST['termek_id'];
$kosarhoz = $_POST['kosarhoz'];

if (isset($felhasznalonev) && isset($termek_id) && isset($kosarhoz)) {
   
    termeket_hozzaad($felhasznalonev, $termek_id, $kosarhoz);

    header("Location: ../termek.php?id=".$termek_id);
}

?>