<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Image;
use Image as Intervention;
use Storage;

class UserController extends Controller
{

    /**
     * 添加验证中间件
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 显示密码修改框
     *
     * @return void
     */
    public function showRequestForm()
    {
        return view('user.passwords.reset');
    }

    /**
     * 判断密码规则及修改入库
     *
     * @return void
     */
    public function passwordrest(Request $request)
    {

        $request->validate($this->rules(), $this->validationErrorMessages());
        Auth::user()->password = bcrypt($request->get('password'));
        Auth::user()->save();
        return redirect()->back()->withMessage('更新成功');
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'password' => 'required|confirmed|min:8',
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    /**
     * 显示Profile修改框
     *
     * @return void
     */
    public function showProfileForm()
    {
        return view('user.profile');
    }

    /**
     *
     * 更新profile
     * @return void
     */
    public function profile(Request $request)
    {
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $path = $request->file('avatar')->store('avatars');
            Auth::user()->avatar = $path;
        }
        $name = $request->get('name');
        Auth::user()->name = $request->get('name');
        Auth::user()->save();

        return redirect()->back()->withMessage('更新成功');
    }

     /**
     * 显示图片修改框
     * @return void
     */
    public function showImageForm()
    {
        return view('user.image');
    }

    /**
     * 上传图片
     * @return void
     */
    public function image(Request $request)
    {
        $model = new Image();
        if ($request->hasFile('thumb') && $request->file('thumb')->isValid()) {

            $file = $request->file('thumb');
            $model->thumb = $file->store('thumbs');
            $imageName = uniqid(date('YmdHis')).$file->getClientOriginalName();

            //生成1920宽度图片
            $resource1920 = Intervention::make($file)->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream()->detach();
            Storage::disk('oss')->put('thumb1920/'.$imageName,$resource1920);
            $model->thumb1920 = 'thumb1920/'.$imageName;

            //生成1280宽度图片
            $resource1280 = Intervention::make($file)->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream()->detach();
            Storage::disk('oss')->put('thumb1280/'.$imageName,$resource1280);
            $model->thumb1280 = 'thumb1280/'.$imageName;

            //生成640宽度图片
            $resource640 = Intervention::make($file)->resize(640, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream()->detach();
            Storage::disk('oss')->put('thumb640/'.$imageName,$resource640);
            $model->thumb640 = 'thumb640/'.$imageName;

        }
        $model->desc = $request->get('desc');
        $model->lens = $request->get('lens');
        $model->size = $request->get('size');
        $model->resolution = $request->get('resolution');
        $model->aspect_ratio = $request->get('aspect_ratio');
        $model->released = 0;
        $model->user_id = Auth::user()->id;
        $model->save();

        return redirect()->back()->withMessage('图片上传成功,审核通过后展示');
    }

}
