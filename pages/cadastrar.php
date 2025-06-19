<?php include('../includes/db.php'); ?>
<?php include('../includes/header.php'); ?>

<div class="container my-5" style="max-width: 600px;">
    <h2 class="mb-4 text-center">Novo Chamado</h2>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Chamado cadastrado com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <form action="cadastrar.php" method="POST" novalidate>
        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" id="titulo" name="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tipo_problema" class="form-label">Tipo de Problema:</label>
            <select id="tipo_problema" name="tipo_problema" class="form-select" required>
                <option value="" disabled selected>Selecione</option>
                <optgroup label="Hardware">
                    <option value="Computador não liga">Computador não liga</option>
                    <option value="Problemas na fonte de alimentação">Problemas na fonte de alimentação</option>
                    <option value="Superaquecimento">Superaquecimento</option>
                    <option value="Teclado ou mouse não funcionam">Teclado ou mouse não funcionam</option>
                    <option value="Monitor sem imagem">Monitor sem imagem</option>
                    <option value="Falha no HD ou SSD">Falha no HD ou SSD</option>
                    <option value="Problema de rede física (cabo/conector)">Problema de rede física (cabo/conector)</option>
                </optgroup>
                <optgroup label="Software">
                    <option value="Sistema operacional travando">Sistema operacional travando</option>
                    <option value="Erro ao abrir programas">Erro ao abrir programas</option>
                    <option value="Instalação de software">Instalação de software</option>
                    <option value="Atualização de sistema ou drivers">Atualização de sistema ou drivers</option>
                    <option value="Antivírus detectando ameaças">Antivírus detectando ameaças</option>
                    <option value="Problemas com login ou senha">Problemas com login ou senha</option>
                    <option value="Rede sem internet">Rede sem internet</option>
                </optgroup>
            </select>
        </div>

        <div class="mb-4">
            <label for="descricao" class="form-label">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="5" class="form-control" required></textarea>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Cadastrar</button>
        </div>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $tipo_problema = $conn->real_escape_string($_POST['tipo_problema']);
    $descricao = $conn->real_escape_string($_POST['descricao']);

    $prioridades = [
        "Computador não liga" => "Alta",
        "Problemas na fonte de alimentação" => "Alta",
        "Superaquecimento" => "Média",
        "Teclado ou mouse não funcionam" => "Média",
        "Monitor sem imagem" => "Alta",
        "Falha no HD ou SSD" => "Alta",
        "Problema de rede física (cabo/conector)" => "Média",
        "Sistema operacional travando" => "Alta",
        "Erro ao abrir programas" => "Média",
        "Instalação de software" => "Baixa",
        "Atualização de sistema ou drivers" => "Baixa",
        "Antivírus detectando ameaças" => "Alta",
        "Problemas com login ou senha" => "Média",
        "Rede sem internet" => "Alta"
    ];

    $prioridade = isset($prioridades[$tipo_problema]) ? $prioridades[$tipo_problema] : "Média";

    $sql = "INSERT INTO chamados (titulo, tipo_problema, descricao, prioridade, status, data_criacao)
            VALUES ('$titulo', '$tipo_problema', '$descricao', '$prioridade', 'Aberto', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: cadastrar.php?sucesso=1");
        exit;
    } else {
        echo '<div class="container mt-3"><div class="alert alert-danger">Erro ao cadastrar chamado: ' . $conn->error . '</div></div>';
    }
}
?>

<?php include('../includes/footer.php'); ?>
