<?php
include('../includes/db.php');
include('../includes/header.php');
?>

<!-- Já deve ter o Bootstrap no header.php, mas caso não, pode incluir aqui -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

<div class="container my-5" style="max-width: 900px;">
    <h2 class="text-center mb-4">Lista de Chamados (Admin)</h2>

    <!-- Form filtro -->
    <form method="GET" class="mb-4 d-flex justify-content-center align-items-center gap-2 flex-wrap">
        <label for="filtro_status" class="form-label mb-0">Filtrar por status:</label>
        <select name="status" id="filtro_status" class="form-select" style="width: 200px;">
            <option value="">Todos</option>
            <option value="Aberto" <?php if(isset($_GET['status']) && $_GET['status'] == 'Aberto') echo 'selected'; ?>>Aberto</option>
            <option value="Em andamento" <?php if(isset($_GET['status']) && $_GET['status'] == 'Em andamento') echo 'selected'; ?>>Em andamento</option>
            <option value="Concluído" <?php if(isset($_GET['status']) && $_GET['status'] == 'Concluído') echo 'selected'; ?>>Concluído</option>
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['acao'])) {
        $id = intval($_POST['id']);
        $acao = $_POST['acao'];

        if ($acao === 'atualizar' && isset($_POST['novo_status'])) {
            $novo_status = $_POST['novo_status'];
            $statusPermitidos = ['Aberto', 'Em andamento', 'Concluído'];
            if (in_array($novo_status, $statusPermitidos)) {
                $conn->query("UPDATE chamados SET status = '$novo_status' WHERE id = $id");
            }
        } elseif ($acao === 'excluir') {
            $conn->query("DELETE FROM chamados WHERE id = $id");
        }
    }
    ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Tipo de Problema</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $filtro_status = isset($_GET['status']) ? $_GET['status'] : '';

            $sql = "SELECT * FROM chamados";
            if (!empty($filtro_status)) {
                $sql .= " WHERE status = '$filtro_status'";
            }

            $sql .= " ORDER BY 
                CASE prioridade
                    WHEN 'Alta' THEN 1
                    WHEN 'Média' THEN 2
                    WHEN 'Baixa' THEN 3
                    ELSE 4
                END,
                data_criacao ASC";

            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr class='text-center'>";
                echo "<td>{$row['id']}</td>";
                echo "<td class='text-start'>{$row['titulo']}</td>";
                echo "<td class='text-start'>{$row['tipo_problema']}</td>";
                echo "<td>{$row['prioridade']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "<td>" . date('d/m/Y H:i', strtotime($row['data_criacao'])) . "</td>";

                echo "<td><button class='btn btn-sm btn-info' data-bs-target='#modal{$row['id']}'>Ver mais</button></td>";

                echo "<td class='d-flex justify-content-center gap-2'>";
                echo "
                    <form method='POST' class='d-inline'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='hidden' name='acao' value='atualizar'>
                        <select name='novo_status' class='form-select form-select-sm' style='width: 130px; display: inline-block;'>
                            <option value='Aberto' ".($row['status'] == 'Aberto' ? 'selected' : '').">Aberto</option>
                            <option value='Em andamento' ".($row['status'] == 'Em andamento' ? 'selected' : '').">Em andamento</option>
                            <option value='Concluído' ".($row['status'] == 'Concluído' ? 'selected' : '').">Concluído</option>
                        </select>
                        <button type='submit' class='btn btn-sm btn-success ms-1'>Atualizar</button>
                    </form>

                    <form method='POST' class='d-inline' onsubmit=\"return confirm('Tem certeza que deseja excluir o chamado #{$row['id']}?');\">
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='hidden' name='acao' value='excluir'>
                        <button type='submit' class='btn btn-sm btn-danger'>Excluir</button>
                    </form>
                ";
                echo "</td>";

                echo "</tr>";

                echo "
                <div class='modal fade' id='modal{$row['id']}' tabindex='-1' aria-labelledby='modalLabel{$row['id']}' aria-hidden='true'>
                  <div class='modal-dialog modal-dialog-centered'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title' id='modalLabel{$row['id']}'>Descrição do Chamado #{$row['id']}</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Fechar'></button>
                      </div>
                      <div class='modal-body text-start'>
                        " . nl2br(htmlspecialchars($row['descricao'])) . "
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
                      </div>
                    </div>
                  </div>
                </div>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
