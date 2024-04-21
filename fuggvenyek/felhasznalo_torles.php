<?php
session_start();
include('./dbfuggvenyek.php');
$felhasznalonev = $_POST['felhasznalonev'];

if (isset($felhasznalonev)) {
    session_unset();
    session_destroy();
    felhasznalot_torol($felhasznalonev);
    header('Location: ../hitelesites.php');
}