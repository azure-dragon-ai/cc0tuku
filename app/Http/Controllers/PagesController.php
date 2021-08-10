<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class PagesController extends Controller
{
    
    /**
     * 首页展示
     * 
     */
    public function root()
    {
        $images = Image::orderBy('created_at', 'desc')->Released()->paginate(20);
        return view('pages.root', 
            [
                'images' => $images,
                'title' => '首页'
            ]
        );
    }

    /**
     * 详细图片页面展示
     * 
     */
    public function show($id)
    {
        $image = Image::findOrFail($id);
        return view('pages.show',
            [
                'image' => $image
            ]
        );
    }
}
