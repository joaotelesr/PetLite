<?php
// admin/veterinarios.php
require_once '../config/conexao.php';
require_once '../funcoes/banco-veterinarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    inserirVeterinario(
        $conexao,
        $_POST['nome'],
        $_POST['crmv'],
        $_POST['especialidade'],
        $_POST['telefone'],
        $_POST['email'],
        $_POST['situacao']
    );
    header('Location: veterinarios.php');
    exit;
}

$veterinarios = listarVeterinarios($conexao);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Veterinários - Petlite</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header>
    <div class="header-wrapper">
        <h2>🐾 PetLife - Painel de Gestão</h2>
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
    <h1>Gestão de Veterinários</h1>

    <form action="veterinarios.php" method="POST">
        <input type="text" name="nome" placeholder="Nome Completo" required>
        <input type="text" name="crmv" placeholder="CRMV" required>
        <input type="text" name="especialidade" placeholder="Especialidade">
        <input type="text" name="telefone" placeholder="Telefone">
        <input type="email" name="email" placeholder="E-mail">
        <select name="situacao">
            <option value="Ativo">Ativo</option>
            <option value="Inativo">Inativo</option>
        </select>
        <button type="submit">Cadastrar Veterinário</button>
    </form>

    <hr>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CRMV</th>
                <th>Especialidade</th>
                <th>Situação</th>
                <th colspan="2">Operações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($veterinarios as $vet): ?>
                <tr>
                    <td><?= $vet['id_veterinario'] ?></td>
                    <td><?= htmlspecialchars($vet['nome']) ?></td>
                    <td><?= htmlspecialchars($vet['crmv']) ?></td>
                    <td><?= htmlspecialchars($vet['especialidade']) ?></td>
                    <td><?= htmlspecialchars($vet['situacao']) ?></td>
                    <td><button class="btn-editar"
                                data-id="2"
                                data-nome="<?=htmlspecialchars($vet['nome'])?>"
                                data-crvm="<?= htmlspecialchars($vet['crmv']) ?>"
                                data-especialidade="<?= htmlspecialchars($vet['especialidade']) ?>"
                                data-telefone="<?= htmlspecialchars($vet['telefone']) ?>"
                                data-email="<?= htmlspecialchars($vet['email']) ?>"
                                data-situacao="<?= htmlspecialchars($vet['situacao']) ?>"
                                >Editar</button></td>
                                 <td><a class="btn-excluir" href="excluir-tutores.php?id_tutor=<?= $vet['id_tutor'] ?>">Excluir</a></td>
                </tr>
            <?php endforeach; ?>
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

                <label>Nome</label>
                <input type="text" id="edit-nome" required>

                <label>CRVM</label>
                <input type="text" id="edit-crvm" required>

                <label>ESPECIALIDADE</label>
                <input type="text" id="edit-especialidade">
                
                <label>TELEFONE</label>
                <input type="email" id="edit-telefone">
                
                <label>E-MAIL</label>
                <input type="email" id="edit-email">

                <label>SITUAÇÃO</label>
                <input type="email" id="edit-situacao">

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

                document.getElementById('edit-id').value = this.dataset.id;

                document.getElementById('edit-nome').value = this.dataset.nome;

                document.getElementById('edit-crvm').value = this.dataset.crvm;

                document.getElementById('edit-especialidade').value = this.dataset.especialidade;

                document.getElementById('edit-telefone').value = this.dataset.telefone;

                document.getElementById('edit-email').value = this.dataset.email;

                document.getElementById('edit-situacao').value = this.dataset.situacao;

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