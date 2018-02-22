//
//
//
angular.module('showdown', []).factory('$showdown', function(){
    var converter = new showdown.Converter({extensions: ['table']});
    return {
        makeHtml: function(md){
            var html = '';
            if(md.search('\\[page\\]') != -1){
                var pages = md.split('[page]');
                for(var i = 0; i < pages.length; ++i){
                    var page = pages[i];
                    if(page.trim() === ''){
                        continue;
                    }
                    html += "<div class='page'>"+converter.makeHtml(pages[i])+"</div>";
                    html += "<div style='page-break-after:always;'></div>";
                }
            }
            else {
                html = converter.makeHtml(md);
            }
            return html;
        }
    };
});
