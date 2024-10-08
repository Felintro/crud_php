<?php

require __DIR__ . "/vendor/autoload.php";

use \App\Entity\Vaga;

define('SUBMETER', 'Confirmar');

// Validação do Get
if(!isset($_GET['id']) or !is_numeric($_GET['id'])) {
	header('location: index.php?status=error');
	exit;
}

$obVaga = Vaga::getVaga($_GET['id']);

// Validação da vaga
if(!$obVaga instanceof Vaga) {
	header('location: index.php?status=error');
	exit;
}

// echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;

// Validação do Post
if(isset($_POST["excluir"])) {
	$obVaga->excluir();
	header('location: index.php?status=success');
	exit;
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/confirmar-exclusao.php';
include __DIR__ . '/includes/footer.php';