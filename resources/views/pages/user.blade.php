@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="row">
  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 offset-xl-2 offset-lg-2 offset-md-2 offset-sm-2 offset-2 text-center">
    <div class="box-content text-truncate">
        <img src="{{ $user->avatar }}" style="height: 60px; width:60px;" class="rounded-circle">
        {{ $user->name }}
    </div>
  </div>
</div>
<div class="row mt-5">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="box-content text-truncate">
        <a class="btn btn-outline-danger btn-sm active" role="button" aria-pressed="true">{{ $user->images()->Released()->count() }}张图片</a>
    </div>
  </div>
</div>
<div class="row masonry mt-1">
    @foreach($images as $image)
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 item">
        <div class="box">
          <a href="{{ route('image.show', ['id'=>$image->id]) }}">
            <img src="{{ $image->newthumb640 }}" data-src="{{ $image->newthumb640 }}" class="img-fluid lazyload"/>
          </a>
          <div class="box-content">
              <span class="down">
                <i class="bi-heart-fill" style="font-size: 1.2rem;color:red;"></i>
              </span> 
              <span class="fav">
                <a href="#" onclick="downImg('{{ $image->newthumb }}')"><i class="bi-download" style="font-size: 1.2rem;"></i></a>
              </span>           
          </div>
        </div>
      </div>
    @endforeach
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center mt-3">
      {{ $images->links() }}
    </div>
</div>
@push('pbl-js')
<script src="https://cc0tuku.oss-cn-beijing.aliyuncs.com/js/jquery.lazyload.min.js"></script>
<script src="https://cc0tuku.oss-cn-beijing.aliyuncs.com/js/masonry.pkgd.min.js"></script>
<script src="https://cc0tuku.oss-cn-beijing.aliyuncs.com/js/imagesloaded.pkgd.min.js"></script>
<script src="https://cc0tuku.oss-cn-beijing.aliyuncs.com/js/download2.js"></script>
<script>
  $(function(){
      $(".lazyload").lazyload();//图片懒加载
      $('.masonry').masonry({
        itemSelector: '.item',
      });
      var $container = $('.masonry');
      $container.imagesLoaded(function(){
        $container.masonry({
          itemSelector: '.item',
          isAnimated: true,
        });
      });
  });

  function downImg(image_url){
      var x=new XMLHttpRequest();
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
