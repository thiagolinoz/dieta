<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<form action="index.php?page=inserir_alimentos&action=insere" method="post">
	<input name="alimento" placeholder="Alimento" id="tags"/><br/>
	<select name="tipo">
		<?php foreach($data['unidade'] as $v):?>
			<option value="<?=$v->tu_id?>"><?=$v->tipo?></option>
		<?php endforeach;?>	
	</select><br/>
	<?php foreach($data['grupo'] as $k => $v):?>
		<?=$v->grupo?>
		<input type="hidden" name="dados[<?=$k?>]['grupo']" value="<?=$v->grupo_id?>" placeholder="<?=$v->grupo?>"/>
		<input name="dados[<?=$k?>]['valor']" placeholder="Valor"/><br/>
	<?php endforeach;?>	
	<br/>
	<input name="base" placeholder="Base"/><br/>
	<input type="submit"/>
</form>

<script>
	$("#tags").autocomplete({
		source: function(request, response){
			$.ajax({
				dataType: "json",
				type: "get",
				data:{
                	term: request.term,
            	},
				url: "index.php?action=autoComplete",
				success: function(data){
					response(data);
				},
				error: function(result, status, error){
					console.log(response.Write);
				}
			});
		},
	});
</script>
