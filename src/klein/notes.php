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
            $markdownParser = new \Michelf\MarkdownExtra();
            $markdown = $note->content;

            $html = "";
            $pages = explode('[page]', $markdown);
            foreach($pages as $page){
                if(trim($page) === ''){ continue; }
                $html .= "<div class='page'>".$markdownParser->transform($page)."</div>";
            }

            $header = file_get_contents(App::path('src/dompdf/pdf-header.html'));
            $html = $header.$html;
            $config = json_decode(file_get_contents(App::dataPath('config.json')));
            $html = str_replace('{{docTheme}}',$config->docTheme,$html);
            $html .= "</body></html>";
            //file_put_contents(App::path('tmp/doc.html'),$html);

            // DOM -> PDF
            $dompdf = new \Dompdf\Dompdf();
            try {
                $dompdf->setPaper('a4', 'portrait');
                $dompdf->load_html($html);
                global $_dompdf_warnings;
                if(count($_dompdf_warnings) > 0){
                    //return '<pre>'.print_r($_dompdf_warnings,true).'</pre>';
                }
                $dompdf->render();
                $response->header('Content-Type','application/pdf');
                $response->header('Content-Disposition','attachment; filename="'.str_replace(' ', '_', $note->title).'"');
            }
            catch(Exception $e) {
                return print_r($e,true);
            }
            return $dompdf->stream();
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
