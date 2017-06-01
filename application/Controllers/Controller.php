<?php
namespace Diet\Controllers;
use Diet\Libraries\Generic;
class Controller extends Generic
{
	private $model;
	public $resultado;

	public function __construct()
	{
		$this->model = new \Diet\Models\Model;
	}

	public function check()
	{

		if($this->sanitize($_POST)){
			$this->model->checkin($_POST);
		}else{
			$this->model->checkin('Caracteres Invalidos',TRUE);
		}
	}

	public function logout()
	{
		$this->model->logout();
	}

	public function autoComplete()
	{
		if($_GET['term']){
			$this->model->completeInsere($_GET['term']);
		}
	}

}