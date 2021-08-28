@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="row masonry">
    @foreach($images as $image)
      <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 item">
        <div class="box">
          <a href="{{ route('image.show', ['id'=>$image->id]) }}">
            <img src="{{ $image->newthumb640 }}" data-src="{{ $image->newthumb640 }}" class="img-fluid lazyload"/>
          </a>
          <div class="box-content">
              <span class="user"> 
                <a href="{{ route('image.user', ['id'=>$image->user->id]) }}">
                  <img src="{{ $image->user->avatar }}" class="rounded-circle" style="height: 45px; width: 45px;background: red;">
                </a>
              </span>
              <span class="post d-inline-block text-truncate" style="max-width:30%;">
                {{ $image->user->name }}
              </span>
              <span class="down">
                <a onclick="favorite('{{ $image->id }}')"><i class="bi-heart-fill"></i></a>
              </span> 
              <span class="fav">
                <a onclick="downImg('{{ $image->newthumb }}')"><i class="bi-download"></i></a>
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
