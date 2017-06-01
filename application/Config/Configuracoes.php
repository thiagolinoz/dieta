<?php

namespace Diet\config;
use Diet\Libraries\Crud;
use Diet\Libraries\Constants;
use \PDO;
class Configuracoes extends Crud
{
	protected $conexao;
	private $instancia;

	public static function instanciar()
	{
		$instancia = new Configuracoes();
		$instancia->conectar();
		return $instancia;
	}

	private function conectar()
	{
		try{
			$opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
			$this->conexao = new PDO('mysql:host=127.0.0.1;dbname=dieta', 'root', 'root', $opcoes);
			$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo "Não foi possivel conectar".$e->getMessage();
		}
	} 	
}	