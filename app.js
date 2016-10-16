var angularTodo = angular.module('lostsysApp', []);
 
function mainController($scope, $http) {
    $scope.names = [ ];
 
    $http.get('model.php')
             .then(function (response) {$scope.names = response.data.names;});
 
    $scope.addNom = function() {
        $http.post('model.php', { op: 'add', nom: $scope.nom, telefon: $scope.telefon } )
                .then(function (response) {$scope.names = response.data.names;});
 
        $scope.nom="";
        $scope.telefon="";
        }
 
    $scope.delNom = function( nom ) {
        if ( confirm("Sure?") ) {
            $http.post('model.php', { op: 'delete', nom: nom } )
                .then(function (response) {$scope.names = response.data.names;});
            }
        }
 
    }