<?php
namespace Diet\Views;

class View
{
	private $model;
	private $controller;

	public function __construct($controller,$model)
	{
		$this->controller = $controller;
		$this->model = $model;
	}

	public function load($page, $data=null, $objeto=null)
	{
		if(!$page){
			return false;
		}

		$data = $this->controller->resultado;
		$objeto = $this->model->objeto;
		$base_url = "http://".$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI'])."/";
		include_once 'application/templates/common/head.php';
		
		if(file_exists("application/templates/{$page}.php")){
			require("application/templates/{$page}.php");
		}else{
			echo 'View não localizada';
		}

		include_once 'application/templates/common/footer.php';
	}
}