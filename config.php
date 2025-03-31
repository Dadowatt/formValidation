<?php
try{
    $conn = new PDO("mysql:host=localhost;dbname=thilaye;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "connexion réussie";
}catch(PDOEXCEPTION $e){
    die("erreur de connexion " .$e->getMessage());
}
?>