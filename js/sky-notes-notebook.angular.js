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
    var notesById       = {};
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
                    notesById[note.id] = note;
                }
                else {
                    console.warn("Note '"+note.id+"' : notebookId not referencing any existing notebook");
                }
            }
        });
    });

    return {
        create: function(title){
            return $http.post('api/notebooks/new', {title:title}).then((response)=>{
                var nb = response.data;
                notebooks.push(nb);
                notebooksById[nb.id] = nb;
            });
        },

        save: function(notebook){
            return $http.post('api/notebooks/save', notebook).then((response)=>{
                var data = response.data;
                console.log(data);
            });
        },

        remove: function(notebook){
            return $http.delete('api/notebooks/'+notebook.id).then((response)=>{
                var index = notebooks.indexOf(notebook);
                if(index > -1){
                    notebooks.splice(index,1);
                }
            });
        },

        createNote: function(nbid,title){
            return $http.post('api/notes/new', {notebookId:nbid,title:title}).then((response)=>{
                var note = response.data;
                notesById[note.id] = note;
                notebooksById[nbid].notes.push(note);
                return response;
            });
        },

        getNote: function(id){
            return notesById[id];
        },

        getAllNotes: function(){
            return notes;
        },

        addNote: function(index){
            return notebooks[index].addNote();
        },

        removeNote: function(note){
            var notebook = notebooksById[note.notebookId];
            return $http.delete('api/notes/'+note.id).then((response)=>{
                var index = notebook.notes.indexOf(note);
                if(index > -1){
                    notebook.notes.splice(index,1);
                }
            });
        },

        getAll: function(){
            return notebooks;
        },

        save: function(notebook){

            return notebook;
        },

        saveNote: function(note){
            console.log('Saving note "'+note.title+'"');
            console.log(note);
            $http.post('api/notes/save', note).then(function(data){
                console.log(data.data);
            });
        }
    };
}]);
