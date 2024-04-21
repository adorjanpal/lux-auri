<?php 
include_once("./dbfuggvenyek.php");
$felhasznalonev = $_POST['felhasznalonev'];
$szoveg = $_POST['szoveg'];
$szulo = isset($_POST['szulo_id']) ? $_POST['szulo_id'] : null;

if (isset($felhasznalonev) && isset($szoveg)) {
    
    uzenetet_beszur($felhasznalonev, $szoveg, $szulo);

    header("Location: ../uzenofal.php");
    
}