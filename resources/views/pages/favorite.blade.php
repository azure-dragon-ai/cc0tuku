@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="box-content text-truncate">
        <a class="btn btn-outline-danger btn-sm active" role="button" aria-pressed="true">{{ Auth::user()->favorites()->count() }}张图片</a>
    </div>
  </div>
</div>
<div class="row masonry mt-1">
    @foreach($images as $image)
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 item">
        <div class="box">
          <a href="{{ route('image.show', ['id'=>$image->id]) }}">
            <img src="{{ $image->newthumb640 }}" data-src="{{ $image->newthumb640 }}" class="img-fluid lazyload fit" alt="{{ $image->desc }}" title="{{ $image->desc }}"/>
          </a>
          <div class="box-content">
              <span class="down">
                <a onclick="unfavorite('{{ $image->id }}')"><i class="bi-heart-fill" style="font-size: 1.2rem;cursor: pointer;"></i></a>
              </span> 
<!--               <span class="fav">
                <a href="#" onclick="downImg('{{ $image->newthumb }}')"><i class="bi-download" style="font-size: 1.2rem;"></i></a>
              </span>   -->         
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
<script src="https://tiangong2.wepromo.cn/js/jquery.lazyload.min.js"></script>
<script src="https://tiangong2.wepromo.cn/js/masonry.pkgd.min.js"></script>
<script src="https://tiangong2.wepromo.cn/js/imagesloaded.pkgd.min.js"></script>
<script src="https://tiangong2.wepromo.cn/js/download2.js"></script>
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

  function unfavorite(id){
     $.ajax({
        type: "post",
        url: "/unfavorite",
        contentType: "application/json",
        dataType: "json",
        data: JSON.stringify({ id:id }),
        success: function (result){
            if(result.msg=="unFavorited"){
                 alert('取消收藏成功');
                 location.href="/favorite";
            }
            if(result.msg=="unFavorite"){
                 alert('未收藏过该图片');
                 location.href="/favorite";
            }
        },
        error: function (xhr, status) {
          if(xhr.status==401){//跳转到验证页
            if(confirm('取消收藏需要登录,是否跳转到登录界面?')){
                location.href="/login";
            }
          }
        }
    });
  }
</script>
@endpush
@stop
