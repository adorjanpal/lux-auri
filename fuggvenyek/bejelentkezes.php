<?php
include ('./dbfuggvenyek.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = adatbazis_csatlakozas();
    $felhasznalonev = $_POST["felhasznalonev2"];
    $jelszo = $_POST["jelszo2"];

    $sql = "SELECT * FROM felhasznalok WHERE felhasznalonev = '$felhasznalonev'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $hash = $row["jelszo"];
        if (password_verify($jelszo, $hash)) {
            session_start();
            $_SESSION['felhasznalonev'] = $felhasznalonev;
            
            header("Location: ../index.html");
            exit();
        } else {
            echo "Hibás jelszó!";
        }
    } else {
        echo "Nincs ilyen felhasználó regisztrálva ezzel az felhasznalonevvel!";
    }
}

$conn->close();
