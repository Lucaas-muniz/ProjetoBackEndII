<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "banco";

try {
    $conn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);

} catch (PDOException $err) {
    echo "Erro: Conexão com banco de dados não foi realizada. Erro gerado ". $err->getMessage();
}
