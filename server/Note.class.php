<?php
//
//
//
class Note {

    public $id;

    public $title;

    public $notebookId;

    public $content;

    function __construct($notebookId = null){
        $this->id = md5(uniqid(rand(), true));
        $this->title    = "New note";
        $this->content      = "# My note ".date('d-m-Y');
        if($notebookId){
            $this->notebookId = $notebookId;
        }
    }

    function save(){
        $path = Note::getPath($this);
        return file_put_contents($path,json_encode($this));
    }

    static function fromArray($a){
        $note = new Note();
        $note->id           = $a['id'];
        $note->title        = $a['title'];
        $note->notebookId   = $a['notebookId'];
        $note->content      = $a['content'];
        return $note;
    }

    static function getPath($note){
        return Note::getPathById($note->id);
    }

    static function getPathById($id){
        return 'data/notes/'.$id.'.json';
    }

    static function create($notebookId){
        return new Note($notebookId);
    }

    static function load($id){
        $filename = Note::getPathById($id);
        return json_decode(file_get_contents($filename));
    }

    static function getAll(){
        $notes = [];
        if ($handle = opendir('data/notes')) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $id = preg_replace('/\\.[^.\\s]{3,4}$/', '', $entry);
                    $notes []= Note::load($id);
                }
            }
            closedir($handle);
        }
        return $notes;
    }
}
?>
