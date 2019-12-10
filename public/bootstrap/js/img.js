// js文件上传
$(function(){

	$('#img').on('click',function(e){
		// 文件选择框
		$('#upload').click();
	});

	$('#upload').on('change',function(e){
		// alert(1);
		var $file = $(this)[0].files[0];
		// 将 图片 显示到图中
		var reader = new FileReader();
		reader.readAsDataURL($file);

		reader.onload = function(){
			$('.img-thumbnail').attr('src',reader.result);
		};
	})
});