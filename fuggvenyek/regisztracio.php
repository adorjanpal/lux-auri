<?php
include("./dbfuggvenyek.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $felhasznalonev = filter_input(INPUT_POST, "felhasznalonev");
    $vezeteknev = filter_input(INPUT_POST, "vezeteknev" );
    $keresztnev = filter_input(INPUT_POST, "keresztnev" );
    $jelszo = filter_input(INPUT_POST, "jelszo" );
    $jelszo2 = filter_input(INPUT_POST, "jelszoMegegyszer" );
    
    if ($email && $felhasznalonev && $vezeteknev && $keresztnev && $jelszo && $jelszo2) {
        $conn = adatbazis_csatlakozas();
        if ($jelszo === $jelszo2) {
          $query = "SELECT * FROM felhasznalok WHERE felhasznalonev = '$felhasznalonev'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "Ez a felhasználónév már foglalt!";
            } else {
                $nev = $vezeteknev." ".$keresztnev;
                $hash = password_hash($jelszo, PASSWORD_DEFAULT);
                $sql = "INSERT INTO felhasznalok (email, felhasznalonev, nev, jelszo, admin) VALUES ('$email', '$felhasznalonev', '$nev', '$hash','0')";
                if (mysqli_query($conn, $sql)) {
                 header('Location: ../index.html');
                } else {
                    echo "Hiba történt a regisztráció során: " . mysqli_error($conn);
                }
            }
        } else {
            echo "A két jelszó nem egyezik meg!";
        }
    } else {
        echo "Kérem adjon meg minden adatot";
    }
}