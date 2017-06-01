var app = angular.module('myApp', []);

app.controller('macrosCtrl', function($scope, $http, $sce){
	$http.get('index.php?page=inserir_dietas&action=gruposAngular')
	.then(function(response){
		$scope.grupos = response.data;
		$scope.selectGrupo = function(){
			$http.get('index.php?page=inserir_dietas&action=alimentosAngular', {params: {grupo:$scope.selectedGrupo}})
			.then(function(response){
				$scope.alimentos = response.data;
			});
		}
		$scope.quantidadeAlimento = '';
		$scope.addValor = function(id,alimento){
			$scope.quantidadeAlimento = $sce.trustAsHtml(
				$scope.quantidadeAlimento + "<p>"+alimento +"<input type='text' name='dados[][quantidade]' placeholder='inserir valores'><input type='text' name='dados[][observacao]' placeholder='inserir observacao'><input type='hidden' name='dados[][alimentos_id]' value='"+id+"'></p>");
		}
	});
});

