<?php
namespace Diet\Controllers;
use Diet\Libraries\Generic;
class EdicaoDietas extends Generic
{
	private $model;
	public $resultado;

	public function __construct()
	{
		$this->model =  new \Diet\Models\ModelDieta;
	}

	public function dados()
	{
		$retorno = $this->model->getDados();

		return $this->resultado = $retorno;
	}

	public function alimentosAngular()
	{
		if(isset($_GET['grupo'])){
			$retorno = $this->model->getDados($_GET['grupo']);

			$data = array();
			foreach($retorno['alimentos'] as $k => $v){

				$data[$k]['id'] = $v->alimentos_id;
				$data[$k]['alimento'] = $v->alimento;
			}

			$data = json_encode($data);
		}else{
			$data = 'sem grupo selecionado';
		}		
			echo $data;
		exit;
	}

	public function gruposAngular()
	{

		$retorno = $this->model->getDados();
		$data = array();
		foreach($retorno['grupo'] as $k => $v){

			$data[$k]['id'] = $v->grupo_id;
			$data[$k]['grupo'] = $v->grupo;
		}

		$data = json_encode($data);
		
		echo $data;
		exit;
	}

	public function insere()
	{
		//if($this->sanitize($_POST['dieta'])){
			$this->model->inserirDietaUser($_POST);
		//}else{
			//$this->model->inserirDietaUser('Caracteres Invalidos',TRUE);
		//}
	}

}