//
//
//
SkyNotes.factory('Notebook', ['$http', function($http) {

    //
    //  Containers
    //
    var notes = [];
    var notesById = {};
    var notebooks = [];
    var notebooksById = {};

    //
    //  Load all
    //
    $http.get('api/notebooks/get/all').then(function(response) {
        var data = response.data;
        for (var i = 0; i < data.length; ++i) {
            var notebook = data[i];
            notebooksById[notebook.id] = notebook;
            notebooks.push(notebook);
        }
        $http.get('api/notes/get/all').then(function(response) {
            var notesData = response.data;
            for (var i = 0; i < notesData.length; ++i) {
                var note = notesData[i];
                note.isSaved = true;
                var notebook = notebooksById[note.notebookId];
                if (notebook) {
                    notes.push(note);
                    notesById[note.id] = note;
                }
            }
        });
    });

    return {
        create: function(title) {
            return $http.post('api/notebooks/new', {
                title: title
            }).then(function(response) {
                var nb = response.data;
                notebooks.push(nb);
                notebooksById[nb.id] = nb;
            });
        },

        save: function(notebook) {
            return $http.post('api/notebooks/save', notebook);
        },

        remove: function(notebook) {
            return $http.delete('api/notebooks/' + notebook.id).then(function(response) {
                var index = notebooks.indexOf(notebook);
                if (index > -1) {
                    notebooks.splice(index, 1);
                }
            });
        },

        createNote: function(nbid, title) {
            return $http.post('api/notes/new', {
                notebookId: nbid,
                title: title
            }).then(function(response) {
                var note = response.data;
                note.isSaved = true;
                notesById[note.id] = note;
                notes.push(note);
                return response;
            });
        },

        getNote: function(id) {
            return notesById[id];
        },

        getAllNotes: function() {
            return notes;
        },

        removeNote: function(note) {
            var notebook = notebooksById[note.notebookId];
            return $http.delete('api/notes/' + note.id).then(function(response) {
                var index = notes.indexOf(note);
                if (index > -1) {
                    notes.splice(index, 1);
                }
                delete notesById[note.id];
            });
        },

        getAll: function() {
            return notebooks;
        },

        saveNote: function(note) {
            return $http.post('api/notes/save', note).then(function(response) {
                return response;
            });
        }
    };
}]);