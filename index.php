<?php

require_once "vendor/autoload.php";
header('Content-Type: text/html; charset=utf-8');

session_start();
$model = new Diet\Models\Model;

if(isset($_GET['page']) && $_GET['page'] == 'listagem'){
	$controller = new Diet\Controllers\Listagem();
}elseif(isset($_GET['page']) && ($_GET['page'] == 'editar_alimentos' || $_GET['page'] == 'inserir_alimentos')){
	$controller = new Diet\Controllers\EdicaoAlimentos();
}elseif(isset($_GET['page']) && $_GET['page'] == 'inserir_dietas'){
	$controller = new Diet\Controllers\EdicaoDietas();
}else{
	$controller = new Diet\Controllers\Controller();
}

$view = new Diet\Views\View($controller, $model);



$page = 'home';

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}();
}

if(isset($_GET['page'])){
	$page = $_GET['page'];
}

echo $view->load($page);