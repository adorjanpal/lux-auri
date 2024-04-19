<?php
   function adatbazis_csatlakozas() {
    
    $conn = new mysqli("localhost", "root", "","luxauri_db");
    
    if (mysqli_connect_errno()) {
        
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
      }
    
    return $conn;
    
}
 
    function termeket_beszur($nev, $meret,$mennyiseg,$leiras,$ar,$tipus,$kep){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
        echo $kep;
        
        $stmt = mysqli_prepare( $conn,"INSERT INTO TERMEKEK(nev, meret, mennyiseg, leiras, ar, tipus, kep) VALUES (?, ?, ?, ?, ?,?,?)");

        mysqli_stmt_bind_param($stmt, "ssdsssb", $nev, $meret, $mennyiseg, $leiras, $ar, $tipus,$kep );
        
        $sikeres = mysqli_stmt_execute($stmt);
        
        mysqli_close($conn);
        return $sikeres;
    }

    function termekeket_leker($tipus){
        if (!($conn = adatbazis_csatlakozas())) {
            return false;
        }
    

        $sql ="SELECT * FROM TERMEKEK WHERE tipus = ? ";

        $eredmeny = $conn -> execute_query($sql,[$tipus]) -> fetch_assoc();

        
        mysqli_close($conn);
        return $eredmeny;
    }
?>