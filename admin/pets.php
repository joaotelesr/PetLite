<?php
// admin/pets.php
require_once '../funcoes/banco-pets.php';
require_once '../funcoes/banco-tutores.php';

// Processa o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foto_caminho = null;

    // Lógica simples para upload de fotografia
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $novo_nome = uniqid() . '.' . $extensao;
        $destino = '../img/' . $novo_nome;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            $foto_caminho = 'img/' . $novo_nome;
        }
    }

    inserirPet(
        $conexao,
        $_POST['id_tutor'],
        $_POST['nome'],
        $_POST['especie'],
        $_POST['raca'],
        $_POST['sexo'],
        $_POST['data_nascimento'],
        $_POST['peso'],
        $_POST['cor'],
        $_POST['observacoes'],
        $foto_caminho
    );

    header('Location: pets.php');
    exit;
}

$pets = listarPets($conexao);
$tutores = listarTutores($conexao);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pets - Petlite</title>
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
    <h1>Gestão de Pets</h1>

    <!-- Formulário com enctype para envio de arquivos -->
    <form action="pets.php" method="POST" enctype="multipart/form-data">
        <label>Tutor:</label>
        <select name="id_tutor" required>
            <option value="">Selecione um tutor</option>
            <?php foreach ($tutores as $tutor): ?>
                <option value="<?= $tutor['id_tutor'] ?>"><?= htmlspecialchars($tutor['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="nome" placeholder="Nome do Pet" required>
        <input type="text" name="especie" placeholder="Espécie (ex: Cão, Gato)">
        <input type="text" name="raca" placeholder="Raça">
        
        <select name="sexo">
            <option value="M">Macho</option>
            <option value="F">Fêmea</option>
        </select>

        <input type="date" name="data_nascimento">
        <input type="number" step="0.1" name="peso" placeholder="Peso (kg)">
        <input type="text" name="cor" placeholder="Cor">
        <textarea name="observacoes" placeholder="Observações"></textarea>
        
        <label>Fotografia:</label>
        <input type="file" name="foto" accept="image/*">

        <button type="submit">Cadastrar Pet</button>
    </form>

    <hr>

    <h2>Pets Cadastrados</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th>Tutor</th>
                <th>Espécie/Raça</th>
                <th>Sexo</th>
                <th>Peso</th>
                <th colspan="2">Operações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pets as $pet): ?>
                <tr>
                    <td>
                        <?php if (!empty($pet['foto_url'])): ?>
                            <img src="../<?= $pet['foto_url'] ?>" width="50" alt="Foto">
                        <?php else: ?>
                            Sem Foto
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($pet['nome']) ?></td>
                    <td><?= htmlspecialchars($pet['nome_tutor']) ?></td>
                    <td><?= htmlspecialchars($pet['especie'] . ' / ' . $pet['raca']) ?></td>
                    <td><?= htmlspecialchars($pet['sexo']) ?></td>
                    <td><?= htmlspecialchars($pet['peso']) ?> kg</td>
                    <td><button class="btn-editar"
                                data-id="2"
                                data-nome="<?=htmlspecialchars($pet['nome'])?>"
                                data-tutor="<?= htmlspecialchars($pet['nome_tutor']) ?>"
                                data-especie="<?= htmlspecialchars($pet['especie']) ?>"
                                data-sexo="<?= htmlspecialchars($pet['sexo']) ?>"
                                data-peso="<?= htmlspecialchars($pet['peso']) ?>"
                                data-observacoes="<?= htmlspecialchars($pet['observacoes']) ?>">
                                Editar
                                </button>
                    <td><a class="btn-excluir" href="excluir-tutores.php?id_tutor=<?= $tutor['id_tutor'] ?>">Excluir</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 </div>
 
 <!-- Modal de edição -->
    <div id="modalEditar" class="modal">

        <div class="modal-conteudo">

            <span id="fecharModal" class="fechar">&times;</span>

            <h2>Editar Pet</h2>

            <form id="formEditar">

                <input type="hidden" id="edit-id">

                <label>Nome</label>
                <input type="text" id="edit-nome" required>

                <label>Tutor</label>
                <input type="text" id="edit-tutor" required>

                <label>Especie</label>
                <input type="text" id="edit-especie">

                <label>Sexo</label>
                <input type="text" id="edit-sexo">

                <label>Peso</label>
                <input type="text" id="edit-peso">
                
                <label>Obervações</label>
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

                document.getElementById('edit-id').value = this.dataset.id;

                document.getElementById('edit-nome').value = this.dataset.nome;

                document.getElementById('edit-tutor').value = this.dataset.tutor;

                document.getElementById('edit-especie').value = this.dataset.especie;

                document.getElementById('edit-sexo').value = this.dataset.sexo;

                document.getElementById('edit-peso').value = this.dataset.peso;

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