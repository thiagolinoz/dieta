<?php
use Diet\Views\View;
namespace Diet\Libraries;

class Generic
{

	public function sanitize($post)
	{
		foreach($post as $k => $v){
			if(is_array($v)){
				foreach($v as $key => $val){
					foreach($val as $keys => $value){
						$cross = preg_match_all("/((\%3C)|<)((\%2F)|\/)*[a-z0-9\%]+((\%3E)|>)/ix", $value);
						$sqlinjection = preg_match_all("/(ALTER|CREATE|DELETE|DROP|EXEC(UTE){0,1}|INSERT( +INTO){0,1}|MERGE|SELECT|UPDATE|UNION( +ALL){0,1})/i",$value);	
					}
				}
			}else{
			
				$cross = preg_match_all("/((\%3C)|<)((\%2F)|\/)*[a-z0-9\%]+((\%3E)|>)/ix", $v);
				$sqlinjection = preg_match_all("/(ALTER|CREATE|DELETE|DROP|EXEC(UTE){0,1}|INSERT( +INTO){0,1}|MERGE|SELECT|UPDATE|UNION( +ALL){0,1})/i",$v);
			}	
			if($cross || $sqlinjection){
				return FALSE;
			}
		}
		return TRUE;	
	}

	public function carregaPagina($page)
	{
		$view = new View();
		$view->load($page);
	}
}