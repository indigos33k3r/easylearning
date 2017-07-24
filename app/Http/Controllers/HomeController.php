<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Shape;
use App\Template;
use App\Project;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function termsOfUse() {
        return view('terms_of_use');
    }

    public function editor($eventId)
    {
        View::share('projectType', 'project');
        View::share('eventId', $eventId);
        return view('editor.editor');
    }
    
    public function getTemplateContent($templateId)
    {
        $content = Storage::get(config('app.templatesPath') . $templateId . '.json');
        return response()->json($content);
    }
}
