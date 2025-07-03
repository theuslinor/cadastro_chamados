<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "sistema_chamados";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS chamados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    tipo_problema VARCHAR(100) NOT NULL,
    prioridade ENUM('Alta', 'Média', 'Baixa') NOT NULL,
    status ENUM('Aberto', 'Em andamento', 'Concluído') DEFAULT 'Aberto',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($sql)) {
    die("Erro ao criar tabela: " . $conn->error);
}
?>
