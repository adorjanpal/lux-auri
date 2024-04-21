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
            SELECT cim,kep.termek_id,tipus,nev,csillag,ar FROM kep LEFT JOIN ertekeles ON kep.termek_id = ertekeles.termek_id WHERE tipus= '$tipus';
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

        $sql = "SELECT * FROM TERMEKEK INNER JOIN KEPEK on termekek.id = kepek.termek_id WHERE termekek.id = '$termek_id'";

        $eredmeny = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $eredmeny;
    }

    function kosarat_leker($felhasznalonev, $kosarhoz){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
        $sql = "WITH 
            kepek AS (SELECT termek_id,cim,ar,nev,meret FROM KEPEK INNER JOIN TERMEKEK ON KEPEK.termek_id = TERMEKEK.id),
            kosar AS (SELECT termek_id,felhasznalonev,kosarhoz,hozzaad.mennyiseg FROM HOZZAAD INNER JOIN TERMEKEK ON HOZZAAD.termek_id = TERMEKEK.id)
        SELECT * FROM kepek INNER JOIN kosar ON kepek.termek_id = kosar.termek_id WHERE FELHASZNALONEV = '$felhasznalonev' AND kosarhoz = '$kosarhoz'
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
        mysqli_close($conn);
        return $eredmeny;
    }

    function uzenetet_beszur($felhasznalonev, $tartalom, $szulo){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }

        $idopont = date('Y-m-d H:i:s');
        
       if ($szulo !== null) {
        $stmt = mysqli_prepare( $conn,"INSERT INTO UZENETEK(iro, tartalom,idopont,szulo) VALUES (?, ?, ?,?)");

        mysqli_stmt_bind_param($stmt, "sssi", $felhasznalonev, $tartalom,$idopont,$szulo);
       } else {
        $stmt = mysqli_prepare( $conn,"INSERT INTO UZENETEK(iro, tartalom,idopont) VALUES (?, ?, ?)");

        mysqli_stmt_bind_param($stmt, "sss", $felhasznalonev, $tartalom,$idopont);
       }

        $sikeres = mysqli_stmt_execute($stmt);
        mysqli_close($conn);
        return $sikeres;
    }

    function uzeneteket_leker($admin, $felhasznalonev){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }

        if ($admin) {
            $sql = "SELECT * FROM UZENETEK INNER JOIN FELHASZNALOK ON FELHASZNALOK.FELHASZNALONEV = UZENETEK.IRO";
        } else {
            $sql = "SELECT * FROM UZENETEK INNER JOIN FELHASZNALOK on felhasznalok.felhasznalonev = uzenetek.iro WHERE iro = '$felhasznalonev'";
        }

        $eredmeny = mysqli_query($conn,$sql);
        mysqli_close($conn);
        return $eredmeny;
    }

    function uzeneteket_leker_id($uzenet_id){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
        $sql = "SELECT * FROM UZENETEK INNER JOIN FELHASZNALOK ON FELHASZNALOK.FELHASZNALONEV = UZENETEK.IRO WHERE id = '$uzenet_id' OR szulo = '$uzenet_id' ";
        
        $eredmeny = mysqli_query($conn,$sql);
        mysqli_close($conn);
        return $eredmeny;
    }

    function velemenyeket_leker_termek_id($id){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
        $sql = "SELECT csillag, SUM(csillag)/COUNT(*) as atlag, COUNT(*) as db FROM ERTEKELESEK INNER JOIN TERMEKEK ON ERTEKELESEK.termek_id = termekek.id WHERE termekek.id = '$id'";
        
        $eredmeny = mysqli_query($conn,$sql);
        mysqli_close($conn);
        return $eredmeny;
    }

    function velemenyt_leker_termek_id($id){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
        $sql = "SELECT * FROM ERTEKELESEK LEFT JOIN FELHASZNALOK ON ERTEKELESEK.felhasznalonev = felhasznalok.felhasznalonev WHERE ertekelesek.termek_id = '$id'";
        
        $eredmeny = mysqli_query($conn,$sql);
        mysqli_close($conn);
        return $eredmeny;
    }


    function termeket_hozzaad($felhasznalonev, $termek_id, $kosarhoz){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
        
        $stmt = mysqli_prepare( $conn,"INSERT INTO HOZZAAD(felhasznalonev, termek_id, kosarhoz) VALUES (?, ?, ?)");

        mysqli_stmt_bind_param($stmt, "sii", $felhasznalonev, $termek_id, $kosarhoz);

        $sikeres = mysqli_stmt_execute($stmt);

        return $sikeres;
    }

    function rendelest_beszur($felhasznalonev, $termekek){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }

        $stmt = mysqli_prepare( $conn,"INSERT INTO RENDELESEK(felhasznalonev) VALUES (?)");

        mysqli_stmt_bind_param($stmt, "s", $felhasznalonev);

        $sikeres = mysqli_stmt_execute($stmt);

        if ($sikeres) {
            $sql = "SELECT id FROM RENDELESEK ORDER BY id DESC LIMIT 1";
            $eredmeny = mysqli_query($conn, $sql);
            $rendeles_id = mysqli_fetch_assoc($eredmeny);
            
            $stmt2 = mysqli_prepare( $conn,"INSERT INTO TERMEKEK_RENDELESEK(rendeles_id,termek_id,termek_mennyiseg) VALUES (?,?,?)");

            foreach ($termekek as $id => $mennyiseg) {
                $id = strval($id);
                mysqli_stmt_bind_param($stmt2, "ddd", $rendeles_id['id'],$id ,$mennyiseg);
                $sikeres = mysqli_stmt_execute($stmt2);
            }

            
        }
        
        
        mysqli_close($conn);
        return $sikeres;
    }

    function rendeleseket_leker($felhasznalonev){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
        $sql = "
        WITH 
         TERMEK AS (SELECT * FROM TERMEKEK_RENDELESEK INNER JOIN TERMEKEK ON TERMEKEK_RENDELESEK.termek_id = TERMEKEK.id),
         RENDELOK AS (SELECT * FROM TERMEKEK_RENDELESEK INNER JOIN RENDELESEK ON RENDELESEK.id = TERMEKEK_RENDELESEK.rendeles_id)
        SELECT * FROM TERMEK,RENDELOK WHERE felhasznalonev = '$felhasznalonev';
         ";
        
        $eredmeny = mysqli_query($conn,$sql);
        mysqli_close($conn);
        return $eredmeny;
    }



    
