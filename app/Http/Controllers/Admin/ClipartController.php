<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Clipart;

class ClipartController extends Controller
{


	public function __construct() {
	    View::share('menuHighlightId', "cliparts");
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scripts = [ 'adm/js/cliparts/cliparts_list.js' ];
        $styleSheets = [ ];
        $cliparts = Clipart::get();
        return view('admin.cliparts.cliparts_list', [
        	'scripts' => $scripts, 
        	'styleSheets' => $styleSheets,
            'cliparts' => $cliparts
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
            'adm/js/cliparts/add_clipart.js', 
            'external/bootstrap-select/js/bootstrap-select.min.js'
        ];
        $styleSheets = ['external/bootstrap-select/css/bootstrap-select.min.css'];

        return view('admin.cliparts.add_clipart', [
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
			$fileName = $image->getClientOriginalName();
			try {
				if ($image->isValid()) {
					$path  = $image->storeAs('public/cliparts', $fileName);	
					$clipart = new Clipart;
					$clipart->file_name = $fileName;
					$clipart->save();
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
        $clipart            = Clipart::find($id);
        $scripts = [ 
            'external/dropzone/dropzone.js', 
            'adm/js/cliparts/edit_clipart.js', 
            'external/bootstrap-select/js/bootstrap-select.min.js'
        ];
        $styleSheets = ['external/bootstrap-select/css/bootstrap-select.min.css'];

        return view('admin.cliparts.edit_clipart', [
            'scripts'       => $scripts, 
            'styleSheets'   => $styleSheets, 
            'clipart'       => $clipart, 
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
            $clipart = Clipart::find($id);
            $clipart->file_name   = $request->file_name;
            $clipart->save();
            if ($request->hasFile('images') && !is_array($request->file('images')) && $request->file('images')->isValid()) {
                $request->file('images')->storeAs('public/cliparts', $clipart->id);
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
        $clipart = Clipart::find($id);
        Storage::delete($clipart->id);
        $clipart->delete();
        return redirect('admin/cliparts');
    }
   
    public function remoteCheck(Request $request) 
    {
     	$clipartId 			= $request->input('id');
     	$response 			= ["status"=> true];
     	$duplicateFileNames	= array();
     	if (!is_array($request->images)) {
     		$request->images = array("0" => $request->images );
     	}

     	foreach ($request->images as $image) {
			$fileName 	= $image;
			try {
				if (isset($clipartId)) {
					if (isset($fileName) && $fileName !== "") {
						$clipartImage = Clipart::where('file_name', $fileName)->where('id', '!=', $clipartId)->first();
					} else {
						$clipartImage = null;
					}
				} else {
					$clipartImage = Clipart::where('file_name', $fileName)->first();
				}
			} catch (Exception $e) {
				return response()->json(["status" => false]);
			}
			if ($clipartImage != null) {
				$duplicateFileNames[] = $clipartImage->file_name;	
			}
    	}
    	if (sizeof($duplicateFileNames) > 0) {
    		$response['status'] = "duplicate file_names";
    		$response['files']	= $duplicateFileNames;
    	}
    	return response()->json($response);
    }
}
