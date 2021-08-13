<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Image extends Model
{
	
	/**
	 * Thumb字段访问器 
	 */ 
	
	protected function getThumbAttribute($value){
		return "https://cc0tuku.oss-cn-beijing.aliyuncs.com/".$value;
	}

	protected function getThumb1920Attribute($value){
		return "https://cc0tuku.oss-cn-beijing.aliyuncs.com/".$value;
	}

	protected function getThumb1280Attribute($value){
		return "https://cc0tuku.oss-cn-beijing.aliyuncs.com/".$value;
	}

	protected function getThumb640Attribute($value){
		return "https://cc0tuku.oss-cn-beijing.aliyuncs.com/".$value;
	}

	/**
	 * 获取图片用户信息
	 */ 
	public function user(){
		return $this->belongsTo('\App\Models\User');
	}

	/**
     * 只显示发布的图片
     */
    public function scopeReleased($query)
    {
        return $query->where('released', '=', 1);
    }
}
