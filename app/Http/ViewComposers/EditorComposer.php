<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Shape;
use App\Clipart;
use App\Template;

class EditorComposer
{
	public function compose(View $view)
	{
        $cliparts  = Clipart::get();
        $shapes    = Shape::get();
        $templates = Template::get();

        $fonts = [
           (object) array( "id" => 1, "name" => "Alegreya-SC"),
           (object) array( "id" => 2, "name" => "Abril-Fatface"),
           (object) array( "id" => 2, "name" => "Roboto")
        ];
       
		$view->with('cliparts', $cliparts);
		$view->with('shapes', $shapes);
    $view->with('fonts', $fonts);
		$view->with('templates', $templates);
	}
}