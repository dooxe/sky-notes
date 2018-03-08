//
//
//
SkyNotes.factory('$skyNotes', ['$http', 'Notebook', function($http, Notebook) {

    var $service = {

        getNotebooks: function() {
            return Notebook.getAll();
        },

        createNotebook: function(title) {
            return Notebook.create(title);
        },

        saveNotebook: function(notebook) {
            return Notebook.save(notebook);
        },

        removeNotebook: function(notebook) {
            return Notebook.remove(notebook);
        },

        createNote: function(notebookId, title) {
            return Notebook.createNote(notebookId, title);
        },

        getAllNotes: function() {
            return Notebook.getAllNotes();
        },

        getNote: function(id) {
            return Notebook.getNote(id);
        },

        addNote: function(index) {
            return Notebook.addNote(index);
        },

        removeNote: function(note) {
            Notebook.removeNote(note);
        },

        updateNote: function(content) {

        },

        deleteNote: function() {

        },

        saveNote: function(note) {
            return Notebook.saveNote(note);
        }
    };

    return $service;
}]);