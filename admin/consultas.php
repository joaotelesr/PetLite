<?php
// admin/consultas.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'verificar.php';
require_once '../config/conexao.php';
require_once '../funcoes/banco-consultas.php';
require_once '../funcoes/banco-tutores.php';
require_once '../funcoes/banco-pets.php';
require_once '../funcoes/banco-veterinarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    agendarConsulta(
        $conexao,
        $_POST['id_tutor'] ?? '',
        $_POST['id_pet'] ?? '',
        $_POST['id_veterinario'] ?? '',
        $_POST['data'] ?? '',
        $_POST['horario'] ?? '',
        $_POST['descricao'] ?? '',
        $_POST['observacoes'] ?? '',
        $_POST['status'] ?? 'Agendada'
    );
    header('Location: consultas.php');
    exit;
}

$consultas = function_exists('listarConsultas') ? listarConsultas($conexao) : [];
$tutores = function_exists('listarTutores') ? listarTutores($conexao) : [];
$pets = function_exists('listarPets') ? listarPets($conexao) : [];
$veterinarios = function_exists('listarVeterinarios') ? listarVeterinarios($conexao) : [];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Consultas - PetLife Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="header-wrapper">
            <h2>🐾 PetLife Admin</h2>
            <nav>
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="tutores.php">Tutores</a></li>
                    <li><a href="pets.php">Pets</a></li>
                    <li><a href="veterinarios.php">Veterinários</a></li>
                    <li><a href="consultas.php">Consultas</a></li>
                    <li><a href="usuarios.php">Utilizadores</a></li>
                    <li><a href="logout.php">Sair</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1>Gestão de Consultas</h1>
        <p>Preencha os dados abaixo para agendar uma nova consulta na clínica.</p>

        <form action="consultas.php" method="POST">
            <div>
                <label for="id_tutor">Tutor:</label>
                <select name="id_tutor" id="id_tutor" required>
                    <option value="">Selecione o tutor</option>
                    <?php foreach ($tutores as $tutor): ?>
                        <option value="<?= $tutor['id_tutor'] ?? $tutor['id'] ?>"><?= $tutor['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="id_pet">Pet:</label>
                <select name="id_pet" id="id_pet" required>
                    <option value="">Selecione o pet</option>
                    <?php foreach ($pets as $pet): ?>
                        <option value="<?= $pet['id_pet'] ?? $pet['id'] ?>"><?= $pet['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="id_veterinario">Veterinário:</label>
                <select name="id_veterinario" id="id_veterinario" required>
                    <option value="">Selecione o veterinário</option>
                    <?php foreach ($veterinarios as $vet): ?>
                        <option value="<?= $vet['id_veterinario'] ?? $vet['id'] ?>"><?= $vet['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="data">Data:</label>
                <input type="date" name="data" id="data" required>
            </div>

            <div>
                <label for="horario">Horário:</label>
                <input type="time" name="horario" id="horario" required>
            </div>

            <div>
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="Agendada">Agendada</option>
                    <option value="Realizada">Realizada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>

            <div style="grid-column: 1 / -1;">
                <label for="descricao">Descrição / Motivo:</label>
                <input type="text" name="descricao" id="descricao" placeholder="Ex: Vacinação anual, consulta de rotina...">
            </div>

            <div style="grid-column: 1 / -1;">
                <label for="observacoes">Observações:</label>
                <textarea name="observacoes" id="observacoes" rows="3" placeholder="Observações adicionais..."></textarea>
            </div>

            <button type="submit">Agendar Consulta</button>
        </form>

        <hr>

        <h2>Consultas Registradas</h2>
        <table border="1">
            
            <thead>
                
                <tr>
                    <th>ID</th>
                    <th>Data / Hora</th>
                    <th>Tutor</th>
                    <th>Pet</th>
                    <th>Veterinário</th>
                    <th>Status</th>
                    <th colspan="2">Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($consultas)): ?>
                    <?php foreach ($consultas as $c): ?>
                        <tr>
                            <td><?= $c['id_consulta'] ?? $c['id'] ?? '' ?></td>
                            <td><?= ($c['data'] ?? '') . ' às ' . ($c['horario'] ?? '') ?></td>
                            <td><?= $c['nome_tutor'] ?? $c['nome_tutor'] ?? 'N/D' ?></td>
                            <td><?= $c['nome_pet'] ?? $c['nome_pet'] ?? 'N/D' ?></td>
                            <td><?= $c['nome_vet'] ?? $c['nome_vet'] ?? 'N/D' ?></td>
                            <td><?= $c['status'] ?? 'Agendada' ?></td>
                            <td><button class="btn-editar"
                                data-id="2"
                                data-data="<?= htmlspecialchars($c['data']) ?>"
                                data-nome_tutor="<?= htmlspecialchars($c['nome_tutor']) ?>"
                                data-nome_pet="<?= htmlspecialchars($c['nome_pet']) ?>"
                                data-nome_vet="<?= htmlspecialchars($c['nome_vet']) ?>"
                                data-status="<?= htmlspecialchars($c['status']) ?>"
                                data-descricao="<?= htmlspecialchars($c['descricao']) ?>"
                                data-observacoes="<?= htmlspecialchars($c['observacoes']) ?>"
                                >Editar</button></td>
                            <td><a href="excluir-consultas.php?id_consulta=<?= $c['id_consulta'] ?>">Excluir</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Nenhuma consulta agendada até o momento.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Modal de edição -->
    <div id="modalEditar" class="modal">

        <div class="modal-conteudo">

            <span id="fecharModal" class="fechar">&times;</span>

            <h2>Editar Tutor</h2>

            <form id="formEditar">

                <input type="hidden" id="edit-id">

                <label>Data</label>
                <input type="data" id="edit-data" required>

                <label>TUTOR</label>
                <input type="text" id="edit-nome_tutor" required>

                <label>PET</label>
                <input type="text" id="edit-nome_pet">
                
                <label>VETERINARIO</label>
                <input type="text" id="edit-nome_vet">
                
                <label>STAUTS</label>
                <input type="text" id="edit-status">
                
                <label>DESCRIÇÃO</label>
                <input type="text" id="edit-descricao">
                
                <label>OBSERVAÇÕES</label>
                <input type="text" id="edit-observacoes">

                <div class="botoes-modal">

                    <button type="button" id="cancelar">
                        Cancelar
                    </button>

                    <button type="submit" id="salvar">
                        Salvar alterações
                    </button>
                    

                </div>

            </form>

        </div>

    </div>
<script>
 

        const modal = document.getElementById('modalEditar');

        const botoesEditar = document.querySelectorAll('.btn-editar');

        const fecharModal = document.getElementById('fecharModal');

        const cancelar = document.getElementById('cancelar');

        const form = document.getElementById('formEditar');


        // Abrir modal e preencher os dados
        botoesEditar.forEach(botao => {

            botao.addEventListener('click', function() {

                document.getElementById('edit-id').value = this.dataset.data;

                document.getElementById('edit-nome').value = this.dataset.nome_tutor;

                document.getElementById('edit-nome_pt').value = this.dataset.nome_pet;

                document.getElementById('edit-nome_vet').value = this.dataset.nome_vet;

                document.getElementById('edit-status').value = this.dataset.status;

                document.getElementById('edit-descricao').value = this.dataset.descricao;

                document.getElementById('edit-observacoes').value = this.dataset.observacoes;

                modal.style.display = 'flex';

            });

        });


        // Fechar modal
        function fechar() {
            modal.style.display = 'none';
        }

        fecharModal.addEventListener('click', fechar);

        cancelar.addEventListener('click', fechar);


        // Fechar clicando fora
        modal.addEventListener('click', function(event) {

            if (event.target === modal) {
                fechar();
            }

        });




 </script>





</body>
</html>