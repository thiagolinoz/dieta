<form action="index.php?page=inserir_alimentos&action=edita&dados=<?=$_GET['dados']?>" method="post">
	<input name="alimento" placeholder="Alimento" value="<?=$data['alimentos']->alimento?>"/><br/>
	
	<select name="tipo"> 
		<?php foreach($data['tipo_unidade'] as $v):?>
			<option value="<?=$v->tu_id?>" <?=$v->tu_id == $data['alimentos']->tu_id ? 'selected' : '' ?>><?=$v->tipo?></option>
		<?php endforeach;?>
	</select>
	<br/>
	<?php foreach($objeto->getComponentes($data['alimentos']->alimentos_id) as $key => $value):?>
		<input type='hidden' name="dados[<?=$key?>]['grupo']" value="<?=$value->ca_id?>"/>
		<?=$objeto->getGrupo($value->grupo_id)?><input name="dados[<?=$key?>]['valor']" placeholder="Valor" value="<?=$value->valor?>"/><br/>
	<?php endforeach;?>
	<input name="base" placeholder="Base" value="<?=$data['alimentos']->base?>"/><br/>
	<input type="submit"/>
</form>