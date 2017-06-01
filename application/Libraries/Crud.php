<?php

namespace Diet\Libraries;
use \PDO;
class Crud
{
	protected $statement;

	protected function getOne($obj, $table, $whr)
	{
		$sql = "SELECT * FROM {$table} WHERE {$whr}";
		$obj = get_class($obj);
		return $this->conexao->query($sql)->fetchObject($obj);
	}


	protected function getAll($obj, $table, $whr=null)
	{
		$sql = "SELECT * FROM {$table}";
		if(isset($whr)){
			$sql .= " WHERE $whr";
		}
		$obj = get_class($obj);
		return $this->conexao->query($sql)->fetchAll(PDO::FETCH_CLASS, $obj);
	}

	protected function getAssociative($obj, $table, $associative,$whr=null)
	{
		$obj = get_class($obj);
		
		$sql = "SELECT * FROM {$table} first";
		//caso nessecidade mais de uma tabela
		
		foreach($associative as $key => $value){
			$sql .= " INNER JOIN {$key} $value ON first.{$value} = $value.{$value}";
		}

		if(isset($whr)){
			$sql .= " WHERE {$whr}";
		}

		return $this->conexao->query($sql)->fetchAll(PDO::FETCH_CLASS, $obj);
	}

	protected function save($table, $post, $id=null)
	{
		if(isset($id) && is_array($id)){
			foreach($post as $key => $value){
				$coluna[] = "{$key} = '{$value}'";
			}
			$colunas = implode(',', $coluna);

			$sql = "UPDATE {$table} SET {$colunas} WHERE {$id[0]} = ?";
			//print_r($sql); exit();
			$this->statement = $this->conexao->prepare($sql);
			$this->statement->bindValue(1, $id[1]);

			return $this->statement->execute();

		}else{
			foreach($post as $key => $value){
					$coluna[] = $key;
					$valores[] = $value;
					$holder[] = '?';
			}
			$colunas = implode(',', $coluna);
			$holders = implode(',', $holder);
			
			$sql = "INSERT INTO $table ($colunas) VALUES ($holders)";
			
			$this->statement = $this->conexao->prepare($sql);
			//PDOStatement::bindParam an integer is changed to a string value upon PDOStatement::execute()
			foreach($valores as $k => $v){
				$this->statement->bindValue($k+1, $v);			
			}

			$this->statement->execute();
			return $this->conexao->lastInsertId();
		}	
	}

	protected function getSql($obj, $sql)
	{
		$obj = get_class($obj);
		return $this->conexao->query($sql)->fetchObject($sql);
	}

	protected function delete()
	{
		
	}

	protected function codifica($pass)
    {
        $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
        $salt = mcrypt_create_iv($size);
        $coficado = crypt($pass, $salt);

        return $coficado;
    }

    protected function verificaHash($obj, $table, $login, $pass)
    {
        
        $result = $this->getOne($obj, $table, "usuario = '{$login}' AND senha = '{$pass}'");
        if($result){
            $hash = $result->senha;
            //criptografa senha enviada e salva
            if(crypt($pass, $hash) === $hash){
                return true;
            }
        }    

        return false;
    }

}