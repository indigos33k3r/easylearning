<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Template;
use App\Shape;


class TemplateController extends Controller
{
    public function __construct() {
        View::share('menuHighlightId', "products");
        View::share('submenuHighlightId', "templates");
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scripts      = [ "adm/js/templates/templates_list.js",
                          "/external/jplist/js/jplist.core.min.js", 
                          "/external/jplist/js/jplist.textbox-filter.min.js"
                        ];

        $styleSheets  = [ "/external/jplist/css/jplist.core.min.css", 
                          "/external/jplist/css/jplist.textbox-filter.min.css"
                          ];
        $templates    = Template::get();
        
        return view('admin.templates.templates_list', [
            'templates' => $templates, 
            'scripts' => $scripts,
            'styleSheets' => $styleSheets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        View::share('projectType', 'template');
        return view('editor.editor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $template = new Template;
            DB::transaction(function () use($request, $template) {
                $template->name = $request->input("templateName");
                $template->save();
                $img = str_replace('data:image/png;base64,', '', $request->input("templatePNG"));
                $img = str_replace(' ', '+', $img);
                $fileData = base64_decode($img);
                $imgFileName = $template->id . ".png";
                Storage::put(config('app.templatesPath') . $imgFileName, $fileData);
                Storage::put(config('app.templatesPath') . $template->id . ".json", $request->input('content'));
            });

            return $template->id;
        } catch(\Exception $e){
           return 'false';
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project            = Template::findOrFail($id);
        $project->content   =  Storage::get(config('app.templatesPath') . $id . '.json');
        View::share('projectType', 'template');
        return view('editor.editor', ['project' => $project]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $template = Template::findOrFail($id);
                $img = str_replace('data:image/png;base64,', '', $request->input("templatePNG"));
                $img = str_replace(' ', '+', $img);
                $fileData = base64_decode($img);
                $fileName = $template->id . ".png";
                Storage::put(config('app.templatesPath') . $fileName, $fileData);
                Storage::put(config('app.templatesPath') . $template->id . ".json", $request->input('content'));
            });
            return "true";
        } catch(\Exception $e){
            return "false";
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template = Template::find($id);
        $template->delete();
    	return redirect('admin/templates');
    }

    public function remoteCheck(Request $request) 
    {
    	$type 	= $request->input('type');
    	$value 	= $request->input($type);
        if ($type == "name") {
    		$value = $request->templateName !== null ? $request->templateName : $value;
    	}	
    	try {
    		$template 	= Template::where($type, $value)->first();	
    	} catch (Exception $e) {
    			
    	}
    	if ($template !== null) {
    		return response()->json(false);	
        } else {
    		return response()->json(true);
        }
    }

}
