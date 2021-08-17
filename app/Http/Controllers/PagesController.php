<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Redis;

class PagesController extends Controller
{
    
    /**
     * 首页展示
     * 
     */
    public function root()
    {
        $page = request('page');
        if(!$page){
            $page = 1;
        }
        $cacheKey = "images:list:".$page;
        if (Redis::exists($cacheKey)) {
            $res = Redis::get($cacheKey);
            $res = unserialize($res);
        } else {
            $res = Image::orderBy('created_at', 'desc')->Released()->paginate(24,['*'],'page',$page);
            Redis::setex($cacheKey, 3600*mt_rand(1,24), serialize($res));
        }
        return view('pages.root', 
            [
                'images' => $res,
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
        $cacheKey = "images:show:".$id;
        if (Redis::exists($cacheKey)) {
            $res = Redis::get($cacheKey);
            $res = unserialize($res);
        } else {
            $res = Image::findOrFail($id);
            Redis::setex($cacheKey, 86400, serialize($res));
        }
        return view('pages.show',
            [
                'image' => $res
            ]
        );
    }

    /**
     * 网站版本权限说明
     */ 
    public function license()
    {
        return view('pages.license',
            [
                'title' => '版本说明'
            ]
        );
    }
}
