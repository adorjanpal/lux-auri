<?php
   function adatbazis_csatlakozas() {
    
    $conn = new mysqli("localhost", "root", "","luxauri_db");
    
    if (mysqli_connect_errno()) {
        
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
      }
    
    return $conn;
    
}

    function kepet_beszur_termekhez($termek_id){
        if (!($conn = adatbazis_csatlakozas()) || !($_FILES['kep']['name'])) {
            return false;
        }
        
        $eleresi_ut = "../termek_kepek/";
        $nev = strtolower($_FILES['kep']["name"]);
        move_uploaded_file($_FILES['kep']['tmp_name'], $eleresi_ut.$nev);

        $stmt = mysqli_prepare( $conn,"INSERT INTO KEPEK(cim, termek_id, eleresi_ut) VALUES (?, ?, ?)");

        mysqli_stmt_bind_param($stmt, "sis", $nev, $termek_id, $eleresi_ut);

        $sikeres = mysqli_stmt_execute($stmt);

        return $sikeres;


    }

    function kepet_beszur_felhasznalohoz($felhasznalonev){
        if (!($conn = adatbazis_csatlakozas()) || !($_FILES['profilkep']['name'])) {
            return false;
        }
        
        $eleresi_ut = "../felhasznalo_kepek/";
        $nev = strtolower($_FILES['profilkep']["name"]);
        move_uploaded_file($_FILES['profilkep']['tmp_name'], $eleresi_ut.$nev);

        $stmt = mysqli_query( $conn,"UPDATE FELHASZNALOK SET profilkep = '$nev' WHERE felhasznalonev = '$felhasznalonev'");
        return $stmt;


    }
 
    function termeket_beszur($nev, $meret,$mennyiseg,$leiras,$ar,$tipus,$kep){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }

        $stmt = mysqli_prepare( $conn,"INSERT INTO TERMEKEK(nev, meret, mennyiseg, leiras, ar, tipus) VALUES (?, ?, ?, ?, ?,?)");

        mysqli_stmt_bind_param($stmt, "ssdsss", $nev, $meret, $mennyiseg, $leiras, $ar, $tipus );

        
        
        $sikeres = mysqli_stmt_execute($stmt);

        if ($sikeres) {
            $sql = "SELECT id FROM TERMEKEK ORDER BY id DESC LIMIT 1";
            $eredmeny = mysqli_query($conn, $sql);
            $termek_id = mysqli_fetch_assoc($eredmeny);
            kepet_beszur_termekhez($termek_id["id"]);
        }
        
        
        mysqli_close($conn);
        return $sikeres;
    }

    function termekeket_leker($tipus){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
        $sql ="
        WITH
            ertekeles AS (SELECT SUM(csillag)/COUNT(*) as csillag,termek_id FROM ERTEKELESEK INNER JOIN TERMEKEK ON ERTEKELESEK.termek_id = TERMEKEK.id), 
            kep AS (SELECT cim,tipus,termek_id,ar,nev FROM KEPEK INNER JOIN TERMEKEK ON KEPEK.termek_id = TERMEKEK.id) 
            SELECT * FROM kep LEFT JOIN ertekeles ON kep.termek_id = ertekeles.termek_id WHERE tipus= '$tipus';
            ";
        $eredmeny = mysqli_query($conn,$sql);
        
        mysqli_close($conn);
        return $eredmeny;
    }

    function felhasznalot_leker($felhasznalonev){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
        $sql = "SELECT * FROM FELHASZNALOK WHERE felhasznalonev = '$felhasznalonev'";
        $query = mysqli_query($conn, $sql);

        $eredmeny = mysqli_fetch_assoc($query);

        mysqli_close($conn);

        return $eredmeny;
        
    }

    function termeket_leker_id($termek_id){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }

        $sql = "SELECT * FROM TERMEKEK WHERE id = '$termek_id'";

        $eredmeny = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $eredmeny;
    }

    function kosarat_leker($felhasznalonev){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
        $sql = "WITH 
            kepek AS (SELECT termek_id,cim,ar,nev,meret FROM KEPEK INNER JOIN TERMEKEK ON KEPEK.termek_id = TERMEKEK.id),
            kosar AS (SELECT termek_id,felhasznalonev,kosarhoz,hozzaad.mennyiseg FROM HOZZAAD INNER JOIN TERMEKEK ON HOZZAAD.termek_id = TERMEKEK.id)
        SELECT * FROM kepek INNER JOIN kosar ON kepek.termek_id = kosar.termek_id WHERE FELHASZNALONEV = '$felhasznalonev' AND kosarhoz = 1
        ";

        $kosarEredmeny = mysqli_query($conn,$sql);

        return $kosarEredmeny;
    }

    function felhasznalot_modosit($modositando, $felhasznalonev){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }

        foreach ($modositando as $key => $value) {
            if ($key == 'profilkep') {
                kepet_beszur_felhasznalohoz($felhasznalonev);
            } else {
                mysqli_query($conn, "UPDATE FELHASZNALOK SET $key = '$value' WHERE felhasznalonev = '$felhasznalonev'");
            }
        }
        

        mysqli_close($conn);
    }

    function felhasznalot_torol($felhasznalonev){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }

        $sql = "DELETE FROM FELHASZNALOK WHERE felhasznalonev = '$felhasznalonev'";

        $eredmeny = mysqli_query($conn,$sql);

        return $eredmeny;
    }

    function uzenetet_beszur($felhasznalonev, $tartalom, $szulo){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }

        $idopont = date('YYYY-MM-DD hh:mi:ss');

        $stmt = mysqli_prepare( $conn,"INSERT INTO UZENETEK(iro, tartalom, szulo,idopont) VALUES (?, ?, ?,?)");

        mysqli_stmt_bind_param($stmt, "s,s,i,s", $iro, $tartalom, $szulo, $idopont);

        $sikeres = mysqli_stmt_execute($stmt);

        return $sikeres;
    }


    
