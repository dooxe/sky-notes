//
//
//
var snMainController = SkyNotes.controller('snMainController', [
    '$scope', '$showdown','$skyNotes',
    function($scope, $showdown, $skyNotes){
        var $self = $scope;

        var aceEditor = null;

        return angular.extend($self,{

            newNotebookTitle: '',

            currentNote: null,

            createNotebook: function(){
                if($self.newNotebookTitle != ''){
                    $skyNotes.createNotebook($self.newNotebookTitle);
                    $self.newNotebookTitle = '';
                }
            },

            removeNotebook: function(index){
                if(window.confirm('Are you sure to delete this notebook ?')){
                    $skyNotes.removeNotebook(index);
                }
            },

            getNotebooks: function(){
                return $skyNotes.getNotebooks();
            },

            addNote: function(index){
                $self.setCurrentNote($skyNotes.addNote(index));
            },

            removeNote: function(nbIndex,nIndex){
                if(window.confirm('Are you sure to delete this note from the notebook ?')){
                    $skyNotes.removeNote(nbIndex,nIndex);
                }
            },

            setCurrentNote: function(note){
                $self.currentNote = note;
                $(aceEditor.container).css('opacity','1');
                aceEditor.setReadOnly(false);
                aceEditor.setValue(note.content);
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
