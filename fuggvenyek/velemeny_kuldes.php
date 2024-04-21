<?php 
include_once("./dbfuggvenyek.php");

$felhasznalonev = $_POST['felhasznalonev'];
$termek_id = $_POST['termek_id'];
$tartalom = $_POST['velemeny'];
$csillagok = $_POST['csillag'];

if (isset($felhasznalonev) && isset($termek_id) && isset($tartalom) && isset($csillagok)) {
    ertekelest_beszur($felhasznalonev,$termek_id,$tartalom,$csillagok);

    header("Location: ../termek.php?id=".$termek_id);
}