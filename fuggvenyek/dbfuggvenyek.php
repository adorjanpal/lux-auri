<?php
   function adatbazis_csatlakozas() {
    
    $conn = new mysqli("localhost", "root", "","luxauri_db");
    
    if (mysqli_connect_errno()) {
        
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
      }
    
    return $conn;
    
}

    function kepet_beszur_termekhez($nev, $termek_id){
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
            kepet_beszur_termekhez($kep,$termek_id["id"]);
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
