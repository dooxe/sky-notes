//
//
//
SkyNotes.factory('Notebook', ['$http', function($http){

    var Note = function(){
        return {
            title:      'new note',
            content:    '# My new note <'+(new Date())+'>'
        };
    };

    var Notebook = function(title){
        var notes = [];
        return {
            notes: notes,
            title: title,
            opened: true,
            addNote: function(){
                var n = new Note();
                notes.push(n);
                return n;
            },
            removeNote: function(index){
                notes.splice(index,1);
            }
        };
    };

    var notebooks = [];

    return {
        create: function(title){
            var nb = new Notebook(title);
            notebooks.push(nb);
            return this.save(nb);
        },

        remove: function(index){
            notebooks.splice(index,1);
        },

        addNote: function(index){
            return notebooks[index].addNote();
        },

        removeNote: function(nbIndex,nIndex){
            notebooks[nbIndex].removeNote(nIndex);
        },

        getAll: function(){
            return notebooks;
        },

        save: function(notebook){

            return notebook;
        }
    };
}]);
