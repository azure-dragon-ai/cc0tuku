@extends('layouts.app')
@section('title', $image->desc)
@section('keywords', implode(',',$image->keywords))
@section('content')
<div class="row">
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
    <div class="box-content text-truncate">
        <a href="{{ route('image.user', ['id'=>$image->user->id]) }}">
          <img src="{{ $image->user->avatar }}" style="height: 60px; width:60px;" class="rounded-circle">
        </a>
        {{ $image->user->name }}
    </div>
  </div>
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
        <div class="btn-group dropdown">
          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            免费下载
          </button>
          <form class="dropdown-menu dropdown-menu-right p-3 mt-0">
            <label>选择大小</label>
            <div class="dropdown-divider"></div>
            <div class="form-group">
              <div class="form-check">
                <input type="radio" class="form-check-input" name="inlineRadioOptions" id="inlineRadio1" value="{{ $image->newthumb }}" checked>
                <label class="form-check-label" for="inlineRadio1">
                  原始大小
                </label>
              </div>
              <div class="dropdown-divider"></div>
              <div class="form-check">
                <input type="radio" class="form-check-input" name="inlineRadioOptions" id="inlineRadio2" value="{{ $image->newthumb1920 }}">
                <label class="form-check-label" for="inlineRadio2">
                  1920px
                </label>
              </div>
              <div class="dropdown-divider"></div>
              <div class="form-check">
                <input type="radio" class="form-check-input" name="inlineRadioOptions" id="inlineRadio3" value="{{ $image->newthumb1280 }}">
                <label class="form-check-label" for="inlineRadio3">
                  1280px
                </label>
              </div>
              <div class="dropdown-divider"></div>
              <div class="form-check">
                <input type="radio" class="form-check-input" name="inlineRadioOptions" id="inlineRadio4" value="{{ $image->newthumb640 }}">
                <label class="form-check-label" for="inlineRadio4">
                  640px
                </label>
              </div>
              <div class="dropdown-divider"></div>
            </div>
            <div class="form-group text-center">
              <button type="button" class="btn btn-success" onclick="downImg()">免费下载</button>
            </div>
          </form>
        </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 offset-xl-2 offset-lg-2 offset-md-2 text-center" style="margin-top:20px;">
      <div class="box" style="background: #000;">
        <img src="{{ $image->newthumb1280 }}" class="img-fluid" style="width:960px;">
          <div class="box-content">
                <span class="down">
                  <a onclick="favorite('{{ $image->id }}')"><i class="bi-heart-fill"></i></a>
                </span>         
            </div>
      </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center" style="margin-bottom:20px;margin-top:5px;">
      @foreach($image->keywords as $keyword)
        <a role="button" class="btn btn-danger btn-sm" href="{{ route('image.tag', ['name'=>$keyword]) }}">{{ $keyword }}</a>
      @endforeach
  </div>
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center" style="margin-bottom:20px;margin-top:5px;">
      <a href="{{ route('image.license') }}"><i class="bi-check-circle-fill"></i>&nbsp;免费使用</a>
  </div>
</div>
<hr style="filter: progid:dximagetransform.microsoft.glow(color='red',strength=10)" width="80%" color="red" size=3>
<div class="row">
  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 offset-xl-2 offset-lg-2 offset-md-2 text-center">
    <div class="row">
      @foreach($more as $one)
        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12 col-12">
          <div class="box2">
            <a href="{{ route('image.show', ['id'=>$one->id]) }}">
              <img src="{{ $one->newthumb640 }}" class="img-fluid" style="max-height:300px;object-fit: cover;" />
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@push('pbl-js')
<script src="https://cc0tuku.oss-cn-beijing.aliyuncs.com/js/download2.js"></script>
<script type="text/javascript">
  function downImg(){
      var image_url = $("input[name='inlineRadioOptions']:checked").val();
      var x = new XMLHttpRequest();
      x.open("GET", image_url, true);
      x.responseType = 'blob';
      x.onload=function(e){
          var url = window.URL.createObjectURL(x.response);
          var a = document.createElement('a');
          a.href = url;
          a.download = '';
          a.click();
      }
      x.send();
  }

  function favorite(id){
     $.ajax({
        type: "post",
        url: "/favorite",
        contentType: "application/json",
        dataType: "json",
        data: JSON.stringify({ id:id }),
        success: function (result){
            if(result.msg=="success"){
                 alert('收藏成功');
            }
            if(result.msg=="hasFavorited"){
                 alert('已经收藏,无需重复收藏');
            }
        },
        error: function (xhr, status) {
          if(xhr.status==401){//跳转到验证页
            alert("请登录后再点击收藏功能");
            location.href="/login";
          }
        }
    });
  }
</script>
@endpush
@stop
