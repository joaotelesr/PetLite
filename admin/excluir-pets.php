<?php
// admin/tutores.php

require_once '../funcoes/banco-pets.php';

//1 receber o id do pet a ser excluido
$id_pet = $_GET["id_pet"];

//echo ("id_tutor: $id_tutor");

//2 excluir com a funcao excluirPet
ExcluirPet($conexao, $id_pet);

//3 redirecionar para a tela pets.php
header('Location: pets.php');

?>