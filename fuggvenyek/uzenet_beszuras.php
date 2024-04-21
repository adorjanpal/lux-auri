<?php 
print_r($_POST);
$felhasznalonev = $_POST['felhasznalonev'];
$szoveg = $_POST['szoveg'];
$szulo = $_POST['uzenet_id'];

if (isset($felhasznalonev) && isset($szoveg)) {
    
    uzenetet_beszur($felhasznalonev, $szoveg, $szulo);

    
}