<?php

namespace Diet\Models;
use Diet\Config\Configuracoes;

class ModelDieta extends Configuracoes
{
	public $objeto;
	public $conn;

	public function __construct()
	{
		$this->conn = Configuracoes::instanciar();
		$this->objeto = $this;
	}

	public function checkin($post,$falha=null)
	{
		if(isset($falha)){
			$_SESSION['msg'] = $post;
		}else{
			$nome = $_POST['user'];
			$senha = $_POST['password'];	
			$retorno = $this->conn->getOne($this, "usuario", "usuario = '{$nome}' AND senha = '{$senha}'");
			if($retorno){
				$_SESSION[NOME_PROJETO]['user'] = $retorno->nome;
				$_SESSION[NOME_PROJETO]['user_id'] = $retorno->usuario_id;
				header('Location: index.php?page=painel');
			}else{
				$_SESSION['msg'] = 'Usuario/senha incorretos';
			}	
		}	
	}

	public function logout()
	{
		unset($_SESSION[NOME_PROJETO]);
		header('Location: index.php');
	}

	public function listar()
	{
		
		$retornoGrupo = $this->conn->getAll($this, 'grupo');
		$retornoAlimento = $this->conn->getAll($this, 'alimentos','usuario_id = '. $_SESSION[NOME_PROJETO]['user_id'] .' AND ativo = 1');

		$resultado['grupo'] = $retornoGrupo;
		$resultado['alimentos'] = $retornoAlimento;

		return $resultado;
		
	}

	public function inserir($post,$falha=null)
	{
		if(isset($falha)){
			$this->resultado = $post;
		}else{
			$postAlimento = array(
							'alimento' => $post['alimento'], 
							'usuario_id'=> $_SESSION[NOME_PROJETO]['user_id'],
							'base' => 	$post['base'],
							'tu_id' => 	$post['tipo'],
						  );
			$retorno = $this->conn->save('alimentos', $postAlimento);
			if($retorno){
				foreach($post['dados'] as $k => $v){
						$postRetorno = array(
												'alimentos_id' => $retorno,
												'grupo_id' => $v["'grupo'"],
												'valor' => 	$v["'valor'"],
											);
						$this->conn->save('componentes_alimentos', $postRetorno);
				}
				
				header('Location: index.php?page=listagem&action=lista');
			}
		}		
	}

	public function atualizar($post,$dados,$falha=null)
	{
		if(isset($falha)){
			$this->resultado = $post;
		}else{
			$postAlimento = array(
							'alimento' => $post['alimento'], 
							'tu_id' => 	$post['tipo'],
						  );
			$postAlimentoId = array('alimentos_id', $dados);
			
			$retorno = $this->conn->save('alimentos', $postAlimento, $postAlimentoId);
			if($retorno){
				foreach($post['dados'] as $k => $v){
				$postRetorno = array(
						'alimentos_id' => $dados,
						'valor' => 	$v["'valor'"]
					);
					$postComponente = array('ca_id', $v["'grupo'"]);

					$this->conn->save('componentes_alimentos', $postRetorno, $postComponente);
				}	

				header('Location: index.php?page=listagem&action=lista');
			}
		}
	}

	public function getDados($whr=null)
	{
		$retorno = array();
		$associative = array('alimentos' => 'alimentos_id');
		if(!is_null($whr)){
			$whr = "first.grupo_id = {$whr} AND alimentos_id.usuario_id = {$_SESSION[NOME_PROJETO]['user_id']} AND first.valor > 0";
			$retorno['alimentos'] = $this->conn->getAssociative($this,'componentes_alimentos', $associative, $whr);
		}	
		
		$retorno['grupo'] = $this->conn->getAll($this,'grupo');

		return $retorno;
	}

	public function getEdicao($dados)
	{
		$resultado['alimentos'] = $this->conn->getOne($this, 'alimentos', " alimentos_id = {$dados} AND ativo = 1");
		$resultado['tipo_unidade'] = $this->conn->getAll($this, 'tipo_unidade');

		return $resultado;
	}

	public function desativa($dados)
	{
	
		$postAlimento = array(
						'ativo' => 0, 
					  );
		$postAlimentoId = array('alimentos_id', $dados);
		
		$retorno = $this->conn->save('alimentos', $postAlimento, $postAlimentoId);
		if($retorno){
			header('Location: index.php?page=listagem&action=lista');
		}
	}


	public function getComponentes($id)
	{
		return $this->conn->getAll($this, 'componentes_alimentos', "alimentos_id = {$id}");
	}

	public function getTipoUnidade($id)
	{
		$result = $this->conn->getOne($this, 'tipo_unidade', "tu_id = {$id}");

		return $result->tipo;
	}

	public function getGrupo($id)
	{
		$result = $this->conn->getOne($this, 'grupo', "grupo_id = {$id}");

		return $result->grupo;
	}

	public function completeInsere($termo)
	{
		$result = $this->conn->getAll($this, 'alimentos', 'alimento LIKE "%'.$termo.'%" AND ativo = 1');
		$data = array();
		foreach($result as $v){
			$data[$v->alimento] = $v->alimento;
		}
		print json_encode($data);
		exit();
	}

	public function inserirDietaUser($post,$falha=null)
	{
		if(isset($falha)){
			$this->resultado = $post;
		}else{
			if(isset($post['dieta']['nome_dieta'])){
				$postAlimento = array(
					'nome_dieta' => $post['dieta']['nome_dieta'], 
					'usuario_id'=> $_SESSION[NOME_PROJETO]['user_id'],
				  );
				$retorno = $this->conn->save('dieta', $postAlimento);
			}else{
				$retorno = $post['dieta']['dieta_id'];
			}	
			if($retorno){
				foreach($post['dados'] as $k => $v){
						$postRetorno = array(
												'alimentos_id' => $v["'alimentos_id'"],
												'dieta_id' => $retorno,
												'usuario_id' => $_SESSION[NOME_PROJETO]['user_id'],
												'quantidade' => $v["'quantidade'"],
												'observacao' => $v["'observacao'"],
											);
						$this->conn->save('alimento_usuario', $postRetorno);
				}
				
				header('Location: index.php?page=listagem&action=lista');
			}
		}
	}

}