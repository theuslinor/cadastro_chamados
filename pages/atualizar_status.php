<?php 
include('../includes/db.php');

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id= intval($_GET['id']);
    $novoStatus = $GET['status'];

    $statusPermitidos = ["Aberto", "Em andamento", "Resolvido"];
    if (!in_array($novoStatus, $statusPermitidos)) {
        die("Status inválido.");
    }

    $sql = "UPDATE chamados SET status = '$novoStatus' WHERE id = $id";
    if($conn -> query($sql) === TRUE) {
        header("Location: listar.php");
        exit;
    } else {
        echo "Erro ao atualizar status: " . $conn -> error;
    }
} else {
    echo "Parâmetros ausentes.";
}