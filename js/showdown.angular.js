//
//
//
angular.module('showdown', []).factory('$showdown', function(){
    var converter = new showdown.Converter({extensions: ['table']});
    return {
        makeHtml: function(md){
            return converter.makeHtml(md);
        }
    };
});
