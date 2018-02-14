<?php
//------------------------------------------------------------------------------
//  NOTEBOOK API
//------------------------------------------------------------------------------
$klein->with('api/notebooks', function () use ($klein) {
    //
    $klein->respond('POST', '/new', function($request, $response){
        $data = (array)json_decode(file_get_contents('php://input'));
        $title = $data['title'];
        $notebook = Notebook::create($title);
        $notebook->save();
        return json_encode($notebook);
    });
    //
    $klein->respond('POST', '/save', function($request, $response){
        $json = file_get_contents('php://input');
        $notebookArray = json_decode($json,true);
        $notebook = Notebook::fromArray($notebookArray);
        return $notebook->save();
    });
    //
    $klein->respond('GET', '/get/all', function($request, $response){
        return json_encode(Notebook::getAll());
    });
    //
    $klein->respond('GET', '/get/id/[:id]', function($request, $response){
        $id = $request->param('id');
        return json_encode(Note::load($id));
    });
    //
    $klein->respond('DELETE', '/[:id]', function($request, $response){
        $id = $request->param('id');
        if(Notebook::delete($id)){
            return '';
        }
        return '';
    });
});
?>
