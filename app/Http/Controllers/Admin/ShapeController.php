<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Shape;

class ShapeController extends Controller
{
    public function __construct() {
        View::share('menuHighlightId', "products");
        View::share('submenuHighlightId', "shapes");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shapes = Shape::all();
        $scripts = [ 'adm/js/shapes/shapes_list.js' ];
    	$styleSheets = [ ];
    	return view('admin.shapes.shapes_list', [
            'shapes' => $shapes, 
            'scripts' => $scripts, 
            'styleSheets' => $styleSheets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$scripts = [
            'external/dropzone/dropzone.js', 
            'adm/js/shapes/add_shape.js', 
            'external/bootstrap-select/js/bootstrap-select.min.js'
        ];
    	$styleSheets = ['external/bootstrap-select/css/bootstrap-select.min.css'];
    	return view('admin.shapes.add_shape', [
            'scripts' => $scripts, 
            'styleSheets' => $styleSheets
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		foreach ($request->images as $image) {
			$filename = $image->getClientOriginalName();
			try {
				if ($image->isValid()) {
					$shape = new Shape; 
                    $shape->file_name = $filename;
                    $shape->save();
                    $image->storeAs('public/shapes', $filename);   
				} else {
					return response()->json(false);
				}
			} catch (Exception $e) {
					return response()->json(false);
			}
   		}

   		return response()->json(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$shape 				= Shape::find($id);
    	$scripts 			= [ 
            'external/dropzone/dropzone.js', 
            'adm/js/shapes/edit_shape.js', 
    		'external/bootstrap-select/js/bootstrap-select.min.js'
        ];
    	$styleSheets = ['external/bootstrap-select/css/bootstrap-select.min.css'];
    	return view('admin.shapes.edit_shape', [
            'scripts' => $scripts, 
            'styleSheets' => $styleSheets, 
            'shape' => $shape
        ]); 
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
            $shape = Shape::find($id);
    		$shape->file_name  	= $request->file_name;
    	 	$shape->save();
            if ($request->hasFile('images') && !is_array($request->file('images')) && $request->file('images')->isValid()) {
                $request->file('images')->storeAs('public/shapes', $shape->id);
            }
    	 	return response()->json(true);
    	 } catch (QueryException $e) {
    	 	return response()->json(false);
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
        $shape = Shape::find($id);
    	Storage::delete($shape->id);
    	$shape->delete();
    	return redirect('admin/shapes');
    }

    public function remoteCheck(Request $request) 
    {
     	$shape_id 			= $request->input('id');
     	$response 			= ["status"=> true];
     	$duplicateFileNames	= array();
     	if (!is_array($request->images)) {
     		$request->images = array("0" => $request->images);
     	}
     	foreach ($request->images as $image) {
			$filename 	= $image;
			try {
				if (isset($shape_id)) {
					if (isset($filename) && $filename !== "") {
						$shape_image = Shape::where('file_name', $filename)->where('id', '!=', $shape_id)->first();
					}
					else {
						$shape_image = null;
					}
				}
				else {
					$shape_image = Shape::where('file_name', $filename)->first();
				}
			} catch (Exception $e) {
				return response()->json(["status" => false]);
			}
			if ($shape_image != null) {
				$duplicateFileNames[] = $shape_image->file_name;	
			}
    	}
    	if (sizeof($duplicateFileNames) > 0) {
    		$response['status'] = "duplicate file_names";
    		$response['files']	= $duplicateFileNames;
    	}
    	return response()->json($response);

    }

}
