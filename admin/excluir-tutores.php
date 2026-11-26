<?php 
// admin/tutores.php
require_once '../funcoes/banco-tutores.php';
//1 receber o id do tutor a ser excluido
$id_tutor = $_GET["id_tutor"];

//echo ("id_tutor: $id_tutor");

//2 excluir com a funcao excluirTutor
excluirTutor($conexao, $id_tutor);

//3 redirecionar para a tela tutores.php
header('Location: tutores.php');


?>