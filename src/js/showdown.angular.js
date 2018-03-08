//
//
//
angular.module('showdown', []).factory('$showdown', function() {
    var converter = new showdown.Converter({
        extensions: ['table']
    });
    return {
        makeHtml: function(md) {
            var pages = md.split('[page]');
            var html = '';
            for (var i = 0; i < pages.length; ++i) {
                var page = pages[i];
                if (page.trim() === '') {
                    continue;
                }
                html += "<div class='page'>" + converter.makeHtml(pages[i]) + "</div>";
                html += "<div style='page-break-after:always;'></div>";
            }
            return html;
        }
    };
});