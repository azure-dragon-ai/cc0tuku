<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Laravel\Scout\Searchable;

class Image extends Model
{
	use Searchable,Favoriteable;

	/**
     * 获取模型的索引名称.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'images_index';
    }

    public function shouldBeSearchable()
	{
    	return $this->isReleased();
	}

	/**
	 * Thumb字段访问器,防止后台修改原字段后台无法删除oss图片问题
	 */ 

	protected function getNewThumbAttribute(){
		return "https://cc0tuku.oss-cn-beijing.aliyuncs.com/".$this->thumb;
	}

	protected function getNewThumb1920Attribute(){
		return "https://cc0tuku.oss-cn-beijing.aliyuncs.com/".$this->thumb1920;
	}

	protected function getNewThumb1280Attribute(){
		return "https://cc0tuku.oss-cn-beijing.aliyuncs.com/".$this->thumb1280;
	}

	protected function getNewThumb640Attribute(){
		return "https://cc0tuku.oss-cn-beijing.aliyuncs.com/".$this->thumb640;
	}


	/**
	 * 获取图片用户信息
	 */ 
	public function user()
	{
		return $this->belongsTo('\App\Models\User');
	}

	/**
     * 只显示发布的图片
     */
    public function scopeReleased($query)
    {
        return $query->where('released', '=', 1);
    }

    /**
     * keywords访问器
     */ 
    public function getKeywordsAttribute($value)
    {
        return explode(',', $value);
    }
    /**
     * keywords修改器
     */ 
    // public function setKeywordsAttribute($value)
    // {
    //     $this->attributes['keywords'] = implode(',', $value);
    // }
}
