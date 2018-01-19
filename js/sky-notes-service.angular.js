//
//
//
SkyNotes.factory('$skyNotes', ['$http', 'Notebook', function($http, Notebook){

    var $service = {

        getNotebooks: function(){
            return Notebook.getAll();
        },

        createNotebook: function(title){
            return Notebook.create(title);
        },

        removeNotebook: function(index){
            Notebook.remove(index);
        },

        addNote: function(index){
            return Notebook.addNote(index);
        },

        removeNote: function(nbIndex,nIndex){
            Notebook.removeNote(nbIndex,nIndex);
        },

        createNote: function(notebookIndex){

        },

        updateNote: function(content){

        },

        deleteNote: function(){

        },

        saveNote: function(note){
            return Notebook.saveNote(note);
        }
    };

    return $service;
}]);
