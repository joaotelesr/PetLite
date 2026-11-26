<?php
// admin/consultas.php

require_once '../funcoes/banco-consultas.php';

//1 receber o id da consulta a ser excluido
$id_consulta = $_GET["id_consulta"];

//echo ("id_tutor: $id_tutor");

//2 excluir com a funcao excluirTutor
ExcluirConsultas($conexao, $id_consulta);

//3 redirecionar para a tela tutores.php
header('Location: consultas.php');

?>