<table border="1">
	<tr>
		<td>Alimento</td>
		<?php foreach($data['grupo'] as $val):?>
			<td><?=$val->grupo?></td>
		<?php endforeach;?>	
		<td>Valor Base</td>
		<td>Edição</td>
		<td>Excluir</td>
	</tr>
	<?php foreach($data['alimentos'] as $v):?>
	<tr>
		<td><?=$v->alimento?></td>
		<?php foreach($objeto->getComponentes($v->alimentos_id) as $value):?>
			<td><?=$value->valor?></td>
		<?php endforeach;?>
		<td><?=$v->base.' '.$objeto->getTipoUnidade($v->tu_id)?></td>	
		<td><a href="index.php?page=editar_alimentos&action=edicao&dados=<?=$v->alimentos_id?>">e</a></td>
		<td><a href="index.php?action=exclui&dados=<?=$v->alimentos_id?>">x</a></td>
	</tr>
	<?php endforeach;?>
</table>	

