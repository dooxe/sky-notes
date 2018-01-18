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

    //
    //  Containers
    //
    var notes           = [];
    var notebooks       = [];
    var notebooksById   = {};

    //
    //  Load all
    //
    $http.get('api/notebooks/get/all').then(function(response){
        var data = response.data;
        for(var i = 0; i < data.length; ++i){
            var notebook = data[i];
            notebook.notes = [];
            notebooksById[notebook.id] = notebook;
            notebooks.push(notebook);
        }
        $http.get('api/notes/get/all').then(function(response){
            var notesData = response.data;
            for(var i = 0; i < notesData.length; ++i){
                var note = notesData[i];
                var notebook = notebooksById[note.notebookId];
                if(notebook){
                    notebook.notes.push(note);
                    notes.push(note);
                }
                else {
                    console.warn("Note '"+note.id+"' : notebookId not referencing any existing notebook");
                }
            }
        });
    });

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
            notebooks[nbIndex].notes.splice(nIndex,1);
        },

        getAll: function(){
            return notebooks;
        },

        save: function(notebook){

            return notebook;
        }
    };
}]);
