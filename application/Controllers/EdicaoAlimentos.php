<?php
namespace Diet\Controllers;
use Diet\Libraries\Generic;
class EdicaoAlimentos extends Generic
{
	private $model;
	public $resultado;

	public function __construct()
	{
		$this->model =  new \Diet\Models\Model;
	}

	public function insere()
	{
		if($this->sanitize($_POST)){
			$this->model->inserir($_POST);
		}else{
			$this->model->inserir('Caracteres Invalidos',TRUE);
		}
	}

	public function edita()
	{
		if($_GET['dados']){
			if($this->sanitize($_POST)){
				$this->model->atualizar($_POST, $_GET['dados']);
			}else{
				$this->model->atualizar('Caracteres Inválidos',TRUE);
			}
		}	
	}

	public function dados()
	{
		$retorno = $this->model->getDados();
		return $this->resultado = $retorno;
	}

	public function edicao()
	{
		if($_GET['dados']){
			$retorno = $this->model->getEdicao($_GET['dados']);
		}

		return $this->resultado = $retorno;
	}

	public function exclui()
	{
		if($_GET['dados']){
			$this->model->desativa($_GET['dados']);
		}
	}

	public function autoComplete()
	{
		if($_GET['term']){
			$this->model->completeInsere($_GET['term']);
		}
	}
}