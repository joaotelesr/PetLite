
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetLife - Tutores</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        h1 {
            margin-bottom: 25px;
        }

        /* Tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #2563eb;
            color: white;
        }

        /* Botões */
        button {
            padding: 9px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-editar {
            background: #2563eb;
            color: white;
        }

        .btn-excluir {
            background: #dc2626;
            color: white;
        }

        /* Fundo do modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            background: rgba(0, 0, 0, 0.6);

            justify-content: center;
            align-items: center;
        }

        /* Conteúdo do modal */
        .modal-conteudo {
            background: white;
            width: 450px;
            max-width: 90%;
            padding: 30px;
            border-radius: 10px;
            position: relative;

            animation: aparecer 0.3s ease;
        }

        .modal-conteudo h2 {
            margin-bottom: 20px;
        }

        /* Campos do formulário */
        .modal-conteudo label {
            display: block;
            margin-top: 10px;
        }

        .modal-conteudo input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Fechar modal */
        .fechar {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            cursor: pointer;
        }

        /* Botões do modal */
        .botoes-modal {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
        }

        #cancelar {
            background: #ddd;
        }

        #salvar {
            background: #2563eb;
            color: white;
        }

        /* Animação */
        @keyframes aparecer {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <h1>Gestão de Tutores</h1>

    <!-- Tabela de tutores -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Operações</th>
            </tr>
        </thead>

        <tbody id="tabelaTutores">

            <tr>
                <td>1</td>
                <td>João Silva</td>
                <td>123.456.789-00</td>
                <td>(11) 99999-1111</td>
                <td>joao@email.com</td>
                <td>
                    <button class="btn-editar"
                        data-id="1"
                        data-nome="João Silva"
                        data-cpf="123.456.789-00"
                        data-telefone="(11) 99999-1111"
                        data-email="joao@email.com"
                        data-endereco="Rua das Flores, 100">
                        Editar
                    </button>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>Maria Oliveira</td>
                <td>987.654.321-00</td>
                <td>(11) 98888-2222</td>
                <td>maria@email.com</td>
                <td>
                    <button class="btn-editar"
                        data-id="2"
                        data-nome="Maria Oliveira"
                        data-cpf="987.654.321-00"
                        data-telefone="(11) 98888-2222"
                        data-email="maria@email.com"
                        data-endereco="Avenida Central, 200">
                        Editar
                    </button>
                </td>
            </tr>

        </tbody>
    </table>


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


        // Salvar alterações
        form.addEventListener('submit', function(event) {

            event.preventDefault();

            const id = document.getElementById('edit-id').value;

            const nome = document.getElementById('edit-nome').value;

            const cpf = document.getElementById('edit-cpf').value;

            const telefone = document.getElementById('edit-telefone').value;

            const email = document.getElementById('edit-email').value;

            const endereco = document.getElementById('edit-endereco').value;


            // Localizar o botão do tutor selecionado
            const botao = document.querySelector(
                `.btn-editar[data-id="${id}"]`
            );

            // Atualizar os dados armazenados
            botao.dataset.nome = nome;
            botao.dataset.cpf = cpf;
            botao.dataset.telefone = telefone;
            botao.dataset.email = email;
            botao.dataset.endereco = endereco;

            // Atualizar a tabela
            const linha = botao.closest('tr');

            linha.cells[1].textContent = nome;
            linha.cells[2].textContent = cpf;
            linha.cells[3].textContent = telefone;
            linha.cells[4].textContent = email;

            alert('Tutor atualizado com sucesso!');

            fechar();

        });

    </script>

</body>
</html>
