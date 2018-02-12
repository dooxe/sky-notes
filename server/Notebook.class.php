<?php
require_once(dirname(__FILE__).'/App.class.php');
/**
*
*
*
*/
class Notebook {

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
    function __construct($title = 'New notebook'){
        $this->id       = md5(uniqid(rand(), true));
        $this->title    = $title;
    }

    /**
    *
    */
    function save(){
        $path = Notebook::getPath($this);
        return file_put_contents($path,json_encode($this));
    }

    /**
    *
    */
    static function getPath($note){
        return Notebook::getPathById($note->id);
    }

    /**
    *
    */
    static function getPathById($id){
        return App::dataPath('notebooks/'.$id.'.json');
    }

    /**
    *
    */
    static function create($title = 'New notebook'){
        return new Notebook($title);
    }

    /**
    *
    */
    static function fromArray($a){
        $notebook = new Notebook($a['title']);
        $notebook->id = $a['id'];
        return $notebook;
    }

    /**
    *
    */
    static function load($id){
        $filename = Notebook::getPathById($id);
        return json_decode(file_get_contents($filename));
    }

    /**
    *
    */
    static function delete($id){
        $filename = Notebook::getPathByid($id);
        return unlink($filename);
    }

    /**
    *
    */
    static function getAll(){
        $notebooks = [];
        if ($handle = opendir(App::dataPath('notebooks'))) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $id = preg_replace('/\\.[^.\\s]{3,4}$/', '', $entry);
                    $notebooks []= Notebook::load($id);
                }
            }
            closedir($handle);
        }
        return $notebooks;
    }
}
?>
