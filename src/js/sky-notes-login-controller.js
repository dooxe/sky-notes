//
//
//
SkyNotes.controller('SkyNotesLoginController', ['$scope','$http',
function($scope,$http){
    var $self = $scope;
    $self = angular.extend($self, {
        error: false,
        loginData: {
            login: '',
            password: ''
        },
        tryLogin: function(){
            $http.post('api/login', $self.loginData).then(
            // ok !
            function(response){
                window.location.reload();
                return response;
            },
            // Error !
            function(response){
                $self.loginData.login = '';
                $self.loginData.password = '';
                $self.error = true;
                window.setTimeout(function(){
                    $self.$apply(function(){
                        $self.error = false;
                    });
                },4000);
            });
        }
    });
    return $self;
}]);
