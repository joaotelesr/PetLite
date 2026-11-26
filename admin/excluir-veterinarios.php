<?php 
// admin/veterinarios.php
require_once '../funcoes/banco-veterinarios.php';
//1 receber o id do veterinario a ser excluido
$id_vet = $_GET["id_veterinario"];


//2 excluir com a funcao excluirVeterinario
ExcluirVeterinario($conexao, $id_vet);

//3 redirecionar para a tela veterios.php
header('Location: veterinarios.php');


?>