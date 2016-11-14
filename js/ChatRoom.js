/* **************************** */
/* 16102401|聊天室 */
/* **************************** */

/*'use strict';*/

$(function(){
	timestamp=0;//全局变量
	var url="./php/backend.php";
	updateMsg();
	$('#chatform').submit(function(){
		$.post(url,{
			message: $('#msg').val(),
			name: $('#author').val(),
			action: "postmsg",
			time: timestamp
		},function(xml,success){//成功后的回调函数，回调函数只有数据成功（success）返回时才会调用，返回来的是xml文件
			$('#msg').val('');//清空消息框的值
			//移除掉等待提示
			$("#loading").remove();
			addMessages(xml);//将返回的xml数据追加到消息显示区中
		},'xml');//第四个参数是返回的数据类型
		//一共有三种数据类型：html：可以直接使用.html()方法输出到页面中，xml：输出需换成html，再用
		//.html()方法输出，较慢；JSON较快，也需要转成html格式
		return false;//阻止默认表单提交
	});
});

function addMessages(xml){
	if($('status',xml).text() ==2) return; //text获取节点的文本内容
		timestamp=$('time',xml).text();//更新时间戳
		//$.each循环数据
		$('message',xml).each(function(){
				var author=$('author',this).text();//发布者
				var content=$('msg',this).text();//内容
				var htmlcode='<strong>'+author+'</strong>:'+content+'<br />';
				$('#messagewindow').append(htmlcode);//添加到文档中
				$('#messagewindow').scrollTop($('#messagewindow')[0].scrollHeight);//$('#messagewindow')[0]转化为DOM对象
				//让滚动条始终保持在最底部
		});
}

function updateMsg(){
	$.post("./php/backend.php",{time:timestamp},
		function(xml,success){
		$('#loading').remove();//移除loading消息，等待提示
		addMessages(xml);
	});
	setTimeout('updateMsg()',4000);//每隔4秒，读取一次
}
