<?php
require_once(dirname(__FILE__).'/App.class.php');
/**
*   The class of a note.
*
*   @author dooxe
*/
class Note {

    /**
    *
    */
    public $id;

    /**
    *
    */
    public $title;

    /**
    *
    */
    public $notebookId;

    /**
    *
    */
    public $content;

    /**
    *
    */
    function __construct($notebookId = null, $title = 'New note'){
        $this->id       = md5(uniqid(rand(), true));
        $this->title    = $title;
        $this->content  = "# My note ".date('d-m-Y');
        if($notebookId){
            $this->notebookId = $notebookId;
        }
    }

    /**
    *
    */
    function save(){
        $path = Note::getPath($this);
        return file_put_contents($path,json_encode($this));
    }

    /**
    *
    */
    static function fromArray($a){
        $note = new Note();
        $note->id           = $a['id'];
        $note->title        = $a['title'];
        $note->notebookId   = $a['notebookId'];
        $note->content      = $a['content'];
        return $note;
    }

    /**
    *
    */
    static function getPath($note){
        return Note::getPathById($note->id);
    }

    /**
    *
    */
    static function getPathById($id){
        return App::dataPath('notes/'.$id.'.json');
    }

    /**
    *
    */
    static function create($notebookId,$title = 'New note'){
        return new Note($notebookId,$title);
    }

    /**
    *
    */
    static function load($id){
        $filename = Note::getPathById($id);
        return json_decode(file_get_contents($filename));
    }

    /**
    *
    */
    static function delete($id){
        $filename = Note::getPathByid($id);
        return unlink($filename);
    }

    /**
    *
    */
    static function getAll(){
        $notes = [];
        if ($handle = opendir(App::dataPath('notes'))) {
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
