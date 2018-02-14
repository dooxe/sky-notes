<?php
//------------------------------------------------------------------------------
//  NOTE API
//------------------------------------------------------------------------------
$klein->with('api/notes', function () use ($klein) {
    //
    $klein->respond('GET', '/[:id]/generate/[pdf:format]',
    function($request, $response){
        $id = $request->param('id');
        $format = $request->param('format');
        $note = Note::load($id);
        if($format === 'pdf'){
            // MARKDOW -> HTML
            $markdown = $note->content;
            $markdownParser = new \Michelf\MarkdownExtra();
            $html = $markdownParser->transform($markdown);
            // HTML -> DOM
            $dom = \HTML5::loadHTML($html);
            $links = htmlqp($dom, 'a');
            foreach ($links as $link) {
                $href = $link->attr('href');
                if (substr($href, 0, 1) == '/' && substr($href, 1, 1) != '/') {
                    $link->attr('href', $domain_name . $href);
                }
            }
            $html = \HTML5::saveHTML($dom);
            $html = str_replace('<html>','<html><head><link rel="stylesheet" type="text/css" href="css/pdf.css"/><link rel="stylesheet" type="text/css" href="css/document.css"/></head><body class="sn-document">',$html);
            $html = str_replace('</html>','</body></html>',$html);
            // DOM -> PDF
            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->render();
            $response->header('Content-Type','application/pdf');
            //$response->file('',$note->title.'.pdf');
            return $dompdf->output();
        }
        return '';
    });
    //
    $klein->respond('POST', '/new', function($request, $response){
        $info = (array)json_decode(file_get_contents('php://input'),true);
        $notebookId = $info['notebookId'];
        $note = Note::create($notebookId,$info['title']);
        $note->save();
        return json_encode($note);
    });
    //
    $klein->respond('POST', '/save', function($request, $response){
        $contents = json_decode(file_get_contents('php://input'),true);
        $n = Note::fromArray($contents);
        $n->save();
        return true;
    });
    //
    $klein->respond('GET', '/get/all', function($request, $response){
        return json_encode(Note::getAll());
    });
    //
    $klein->respond('GET', '/get/id/[:id]', function($request, $response){
        $id = $request->param('id');
        return json_encode(Note::load($id));
    });
    //
    $klein->respond('DELETE', '/[:id]', function($request, $response){
        $id = $request->param('id');
        if(Note::delete($id)){
            return '';
        }
        return 'not deleted ...';
    });
});
?>
