<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "sistema_chamados";

$conn = new mysqli($host, $username, $password, $database);

if ($conn -> connect_error) {
    die("Falha na conexão: " . $conn -> connect_error);
}
?>