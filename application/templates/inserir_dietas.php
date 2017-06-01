<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="<?=$base_url?>assets/js/myApp.js?r=<?=rand(0,99)?>"></script>
<form action="index.php?page=inserir_dietas&action=insere" method="post">
	<div>
		<label>Dieta</label>
		<input type="text" name="dieta['nome_dieta']" placeholder="Nome da Dieta">
	</div>
	<div ng-app="myApp" ng-controller="macrosCtrl">
	<select name="grupo" ng-model="selectedGrupo"  ng-change="selectGrupo()">
		<option ng-repeat="g in grupos" value="{{g.id}}">{{g.grupo}}</option>
	</select><br/>
	<!-- caixa c/ alimentos -->
		<table>
			<tr ng-repeat="a in alimentos">
				<td>{{ a.alimento }}<a href="javascript:void(0)" ng-click="addValor(a.id,a.alimento)"> Add</a></td>
			</tr>
		</table>
		<div ng-bind-html="quantidadeAlimento"></div>
	</div>
	<input type="submit"/>
</form>
