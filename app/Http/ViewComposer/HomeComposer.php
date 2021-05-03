<?php

namespace App\Http\ViewComposer;

use Illuminate\View\View;
use App\Models\Category;

class HomeComposer
{
    public function compose(View $view)
    {
        $view->with([
            "categories" => Category::has("posts")->get(),
        ]);
    }
}
