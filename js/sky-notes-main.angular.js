//
//
//
var snMainController = SkyNotes.controller('snMainController', [
    '$scope', '$showdown','$skyNotes',
    function($scope, $showdown, $skyNotes){
        var $self = $scope;

        var aceEditor = null;

        return angular.extend($self,{

            // The notebook where the new note should be created
            newNoteNotebookId: null,

            // The model of the title inside 'new notebook' modal dialog
            newNotebookTitle: '',

            // The model of the title inside 'new note' modal dialog
            newNoteTitle: '',

            // The selected note
            currentNote: null,

            saveNotebook: function(notebook){
                $skyNotes.saveNotebook(notebook);
            },

            removeNotebook: function(notebook){
                if(window.confirm('Are you sure to delete this notebook "'+notebook.title+'" ?')){
                    $skyNotes.removeNotebook(notebook);
                }
            },

            getNotebooks: function(){
                return $skyNotes.getNotebooks();
            },

            //
            //
            //
            getAllNotes: function(){
                return $skyNotes.getAllNotes();
            },

            //
            //
            //
            showNewNotebookModal: function(){
                $self.newNotebookTitle = '';
                $('#sn-new-notebook-modal').modal('toggle');
            },

            //
            // Called when pressing 'OK' in new notebook modal
            //
            createNotebook: function(){
                if($self.newNotebookTitle != ''){
                    $skyNotes.createNotebook($self.newNotebookTitle).then(function(){
                        $('#sn-new-notebook-modal').modal('toggle');
                    });
                }
            },

            //
            //  Called when click '+' on the note book toolbar
            //
            showNewNoteModal: function(notebookId){
                $self.newNoteNotebookId = notebookId;
                $('#sn-new-note-modal').modal('toggle');
            },

            //
            //  Called when click 'OK' on new note modal
            //
            createNote: function(){
                $skyNotes.createNote($self.newNoteNotebookId,$self.newNoteTitle).then(function(response){
                    var note = response.data;
                    note = $skyNotes.getNote(note.id);
                    $self.setCurrentNote(note);
                    $self.notebook = null;
                    $self.newNoteTitle = '';
                    $('#sn-new-note-modal').modal('toggle');
                });
            },

            addNote: function(index){
                $self.setCurrentNote($skyNotes.addNote(index));
            },

            removeNote: function(note){
                if(window.confirm('Are you sure to delete the note "'+note.title+'" from the notebook ?')){
                    $skyNotes.removeNote(note);
                }
            },

            setCurrentNote: function(note){
                $self.currentNote = note;
                $(aceEditor.container).css('opacity','1');
                aceEditor.setReadOnly(false);
                aceEditor.setValue(note.content);
            },

            saveCurrentNote: function(){
                if($self.currentNote){
                    $skyNotes.saveNote($self.currentNote);
                }
            },

            selectedNotebookIndex: -1,
            selectedNoteIndex: -1,
            selectedNote: null,
            notebooks: [
                {
                    title: "Notebook 01",
                    notes: [
                        {
                            title:      "Note 01",
                            content:    "# Title1 !"
                        },
                        {
                            title: "Note 02",
                            content:    "# Title2 !"
                        }
                    ]
                },
                {
                    title: "Notebook 02",
                    notes: [
                        {
                            title: "Note 01",
                            content:    "# Title3 !"
                        },
                        {
                            title: "Note 02",
                            content:    "# Title4 !"
                        }
                    ]
                }
            ],
            aceLoaded: function(editor){
                // Editor part
                var session = editor.getSession();
                var renderer = editor.renderer;

                //
                $(editor.container).css('opacity','0.4');
                editor.setReadOnly(true);

                // Events
                session.on("change", function()
                {
                    if($self.currentNote){
                        var markdown = editor.getValue();
                        var preview = document.querySelector('#sn-markdown-preview');
                        var html = $showdown.makeHtml(markdown);
                        preview.innerHTML = html;
                        $self.currentNote.content = markdown;
                    }
                });

                aceEditor = editor;
            },
            aceChanged: function(e){

            },
            selectNotebook: function(notebookIndex){
                $self.notebooks[notebookIndex].selected = !$self.notebooks[notebookIndex].selected;
            },
            selectNote: function(notebookIndex,noteIndex){
                $self.selectedNotebookIndex = notebookIndex;
                $self.selectedNoteIndex = noteIndex;
                var note = $self.notebooks[notebookIndex].notes[noteIndex];
                $self.selectedNote = note;
                aceEditor.setValue(note.content);
            }
        });
    }
]);
