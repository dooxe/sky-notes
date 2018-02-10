//
//
//
var snMainController = SkyNotes.controller('snMainController', [
    '$scope', '$http','$showdown','$skyNotes',
    function($scope, $http, $showdown, $skyNotes){

        var $self = $scope;

        var aceEditor = null;

        $self = angular.extend($self,{

            //
            config: {
                fontFamily: 'Arial',
                fontSize: 14
            },

            availableFonts: [
                'Monaco',
                'Menlo',
                'Ubuntu Mono',
                'Consolas',
                'source-code-pro',
                'monospace',
                'Dhurjati',
                'Dosis',
                'Share Tech Mono',
                'Space Mono',
                'Titillium Web'
            ],

            // The notebook where the new note should be created
            newNoteNotebookId: null,

            // The model of the title inside 'new notebook' modal dialog
            newNotebookTitle: '',

            // The model of the title inside 'new note' modal dialog
            newNoteTitle: '',

            // The selected note
            currentNote: null,

            //
            windowConfirmMessage: '',

            // The function called when the user confirm
            confirmAction: null,

            // The note book to be renamed
            renamedNotebook: null,

            //
            //
            //
            confirm: function(){
                if($self.confirmAction){
                    $self.confirmAction();
                }
            },

            //
            //
            //
            saveNotebook: function(notebook){
                $skyNotes.saveNotebook(notebook);
            },

            //
            //
            //
            removeNotebook: function(notebook){
                $self.windowConfirmMessage = 'Are you sure to delete the notebook <strong>'+notebook.title+'</strong> ?';
                $self.confirmAction = function(){
                    $skyNotes.removeNotebook(notebook);
                    $('#sn-confirm-modal').modal('hide');
                }
                $('#sn-confirm-modal').modal('show');
            },

            //
            //
            //
            getNotebooks: function(){
                return $skyNotes.getNotebooks();
            },

            //
            //
            //
            showRenameNotebookModal: function(notebook){
                $self.renamedNotebook = notebook;
                $('#sn-rename-notebook-modal').modal('show');
            },

            // Called when OK is clicked in the modal
            renameNotebook: function(){
                $skyNotes.saveNotebook($self.renamedNotebook).then(()=>{
                    $self.renamedNotebook = null;
                    $('#sn-rename-notebook-modal').modal('hide');
                });
            },

            //
            getAllNotes: function(){
                return $skyNotes.getAllNotes();
            },

            //  Show the modal to create a new notebook
            showNewNotebookModal: function(){
                $self.newNotebookTitle = '';
                $('#sn-new-notebook-modal').modal('toggle');
            },

            // Called when pressing 'OK' in new notebook modal
            createNotebook: function(){
                if($self.newNotebookTitle !== ''){
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
            getNumNotebooksByNotebookId: function(nbid){
                var n = 0;
                var notes = $skyNotes.getAllNotes();
                for(var i = 0; i < notes.length; ++i){
                    if(notes[i].notebookId == nbid){
                        ++n;
                    }
                }
                return n;
            },

            getNotesByNotebookId: function(nbid){
                var notes = [];
                var allNotes = $skyNotes.getAllNotes();
                for(var i = 0; i < allNotes.length; ++i){
                    if(allNotes[i].notebookId == nbid){
                        notes.push(allNotes[i]);
                    }
                }
                return notes;
            },

            //
            //  Called when click 'OK' on new note modal
            //
            createNote: function(){
                if($self.newNoteTitle.trim() !== ''){
                    $skyNotes.createNote($self.newNoteNotebookId,$self.newNoteTitle).then(function(response){
                        var note = response.data;
                        note = $skyNotes.getNote(note.id);
                        $self.setCurrentNote(note);
                        $self.notebook = null;
                        $self.newNoteTitle = '';
                        $('#sn-new-note-modal').modal('toggle');
                    });
                }
            },

            //
            //
            //
            addNote: function(index){
                $self.setCurrentNote($skyNotes.addNote(index));
            },

            //
            //
            //
            removeNote: function(note){
                $self.windowConfirmMessage = 'Are you sure to delete the note <strong>'+note.title+'</strong> from the notebook ?';
                $self.confirmAction = function(){
                    $skyNotes.removeNote(note);
                    $('#sn-confirm-modal').modal('hide');
                }
                $('#sn-confirm-modal').modal('show');
            },

            //
            //
            //
            setCurrentNote: function(note){
                $self.currentNote = note;
                $(aceEditor.container).css('opacity','1');
                aceEditor.setReadOnly(false);
                aceEditor.setValue(note.content);
            },

            //
            //
            //
            saveCurrentNote: function(){
                if($self.currentNote){
                    return $skyNotes.saveNote($self.currentNote);
                }
            },

            //
            //
            //
            selectNote: function(notebookIndex,noteIndex){
                $self.selectedNotebookIndex = notebookIndex;
                $self.selectedNoteIndex = noteIndex;
                var note = $self.notebooks[notebookIndex].notes[noteIndex];
                $self.selectedNote = note;
                aceEditor.setValue(note.content);
            },

            //
            //
            //
            gotoPDF: function(){
                var note = $self.currentNote;
                if(note){
                    $self.saveCurrentNote().then(()=>{
                        window.open('api/notes/'+note.id+'/generate/pdf', '_blank');
                    });
                }
            },

            //
            //
            //
            saveConfig: function(){
                $http.post('api/config', {config:$self.config}).then((response)=>{
                    if(aceEditor){
                        $(aceEditor.container)
                            .css('font-family',$self.config.fontFamily)
                            .css('font-size',$self.config.fontSize+'px')
                        ;
                    }
                    $('#sn-config-modal').modal('hide');
                });
            },

            //
            //
            //
            logout: function(){
                $http.post('api/logout', $self.loginData).then((response)=>{
                    window.location.reload();
                });
            },

            //
            //
            //
            aceLoaded: function(editor){
                // Editor part
                var session = editor.getSession();
                var renderer = editor.renderer;

                //
                var $editor = $(editor.container);
                $editor.css('opacity','0.4');
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

                $http.get('api/config').then((response)=>{
                    if(response.data !== {}){
                        var config = $self.config = response.data;
                        $editor
                            .css('font-family',config.fontFamily)
                            .css('font-size',config.fontSize+'px')
                        ;
                    }
                });

                aceEditor = editor;
            },
            aceChanged: function(e){

            }
        });

        $(window).keypress(function(event) {
            if (event.which == 112 && event.ctrlKey){
                $self.gotoPDF();
                return false;
            }
            if (!(event.which == 115 && event.ctrlKey) && !(event.which == 19)) return true;
            $self.saveCurrentNote();
            event.preventDefault();
            return false;
        });

        return $self;
    }
]);
