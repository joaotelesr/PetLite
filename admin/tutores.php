<?php
// admin/tutores.php
require_once '../funcoes/banco-tutores.php';

// Processa o formulário de cadastro caso seja enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    inserirTutor(
        $conexao, 
        $_POST['nome'], 
        $_POST['cpf'], 
        $_POST['telefone'], 
        $_POST['email'], 
        $_POST['endereco']
    );
    header('Location: tutores.php');
    exit;
}

$tutores = listarTutores($conexao);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Tutores - Petlite</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
      <!-- Cabeçalho e Menu de Navegação Unificado -->
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
    <h1>Gestão de Tutores</h1>

    <!-- Formulário de Cadastro -->
    <form action="tutores.php" method="POST">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="text" name="cpf" placeholder="CPF" required>
        <input type="text" name="telefone" placeholder="Telefone">
        <input type="email" name="email" placeholder="E-mail">
        <input type="text" name="endereco" placeholder="Endereço">
        <button type="submit">Cadastrar Tutor</button>
    </form>

    <hr>

    <!-- Tabela de Listagem -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th colspan="2">Operações</th>
            
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tutores as $tutor): ?>
                <tr>
                    <td><?= $tutor['id_tutor'] ?></td>
                    <td><?= htmlspecialchars($tutor['nome']) ?></td>
                    <td><?= htmlspecialchars($tutor['cpf']) ?></td>
                    <td><?= htmlspecialchars($tutor['telefone']) ?></td>
                    <td><?= htmlspecialchars($tutor['email']) ?></td>
                    <td><button class="btn-editar"
                                data-id="2"
                                data-nome="<?=htmlspecialchars($tutor['nome'])?>"
                                data-cpf="<?= htmlspecialchars($tutor['cpf']) ?>"
                                data-telefone="<?= htmlspecialchars($tutor['telefone']) ?>"
                                data-email="<?= htmlspecialchars($tutor['email']) ?>"
                                data-endereco="<?= htmlspecialchars($tutor['endereco']) ?>">
                    
                    >Editar</button></td>
                    <td><a class="btn-excluir" href="excluir-tutores.php?id_tutor=<?= $tutor['id_tutor'] ?>">Excluir</a></td>

                    <!-- <td><a href="excluir-tutores.php?id_tutor=<?= $tutor['id_tutor'] ?>">Excluir</a></td>
                    <td><a href="#">Editar</a></td> -->
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

                <label>Nome completo</label>
                <input type="text" id="edit-nome" required>

                <label>CPF</label>
                <input type="text" id="edit-cpf" required>

                <label>Telefone</label>
                <input type="text" id="edit-telefone">

                <label>E-mail</label>
                <input type="email" id="edit-email">

                <label>Endereço</label>
                <input type="text" id="edit-endereco">

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

                document.getElementById('edit-cpf').value = this.dataset.cpf;

                document.getElementById('edit-telefone').value = this.dataset.telefone;

                document.getElementById('edit-email').value = this.dataset.email;

                document.getElementById('edit-endereco').value = this.dataset.endereco;

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


