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
            (response)=>{
                window.location.reload();
                return response;
            },
            // Error !
            (response)=>{
                $self.loginData.login = '';
                $self.loginData.password = '';
                $self.error = true;
                window.setTimeout(()=>{$self.$apply(()=>{$self.error = false;});},4000);
            });
        }
    });
    return $self;
}]);
