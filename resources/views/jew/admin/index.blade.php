@extends('layout.layout')

@section('title')
    首页
@endsection


@section('content')
    <script type="text/javascript">(function($){$.fn.snow = function(options){var $flake = $('<div id="snowbox" />').css({'position': 'absolute','z-index':'9999', 'top': '-50px'}).html('&#10052;'),documentHeight = $(document).height(),documentWidth= $(document).width(),defaults = {minSize: 10,maxSize: 20,newOn: 1000,flakeColor: "#AFDAEF" /* 此处可以定义雪花颜色，若要白色可以改为#FFFFFF */},options= $.extend({}, defaults, options);var interval= setInterval( function(){var startPositionLeft = Math.random() * documentWidth - 100,startOpacity = 0.5 + Math.random(),sizeFlake = options.minSize + Math.random() * options.maxSize,endPositionTop = documentHeight - 200,endPositionLeft = startPositionLeft - 500 + Math.random() * 500,durationFall = documentHeight * 10 + Math.random() * 5000;$flake.clone().appendTo('body').css({left: startPositionLeft,opacity: startOpacity,'font-size': sizeFlake,color: options.flakeColor}).animate({top: endPositionTop,left: endPositionLeft,opacity: 0.2},durationFall,'linear',function(){$(this).remove()});}, options.newOn); };})(jQuery);$(function(){ $.fn.snow({ minSize: 5, /* 定义雪花最小尺寸 */ maxSize: 50,/* 定义雪花最大尺寸 */ newOn: 300 /* 定义密集程度，数字越小越密集 */ });});</script>
    <div class="alert alert-danger" role="alert">
        <div class="jumbotron" style="margin-top: 100px;">
            <div class="container">
                <h2>电子商务</h2>
                <div class="col-sm-6 col-md-5">
                    <div class="thumbnail">
                        <img alt="Brand" src="/bootstrap/img/333.jpg" >
                        <div class="caption">
                            <p>你总会站上巅峰，回首来的路都值得！！！</p>
                            <p><a href="http://www.exem.com/index/index" class="btn btn-primary" role="button">进入</a> <a href="#" class="btn btn-default" role="button">查看</a></p>
                        </div>
                    </div>
                </div>

                <p>有人十年征程孤军奋斗，有人南山墓底寂寞长眠。</p>
                <p><a class="btn btn-primary btn-lg" href="http://www.exem.com/index/index" role="button">进入主页</a></p>
            </div>
        </div>
    </div>
@endsection