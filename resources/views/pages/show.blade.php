@extends('layouts.app')
@section('title', $image->desc)
@section('content')
<div class="row">
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
    <div class="box-content text-truncate">
        <img src="{{ $image->user->avatar }}" style="height: 60px; width:60px;" class="rounded-circle">
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
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center" style="margin-top:20px;">
    <img src="{{ $image->newthumb640 }}" class="img-fluid">
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
</script>
@endpush
@stop
