//
//
//
var skyNotes = angular.module("SkyNotes", ['ui.ace','showdown']);

//
//
//
var snMainController = skyNotes.controller('snMainController', [
    '$scope', '$showdown',
    function($scope, $showdown){
        var $self = $scope;

        var aceEditor = null;

        return angular.extend($self,{
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

                // Events
                session.on("change", function()
                {
                    var markdown = editor.getValue();
                    var preview = document.querySelector('#sn-markdown-preview');
                    var html = $showdown.makeHtml(markdown);
                    preview.innerHTML = html;
                    $self.selectedNote.content = markdown;
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
