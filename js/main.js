/*global free */
/*global plupload */
/*global FileProgress */
/*global hljs */

(function($) {
   uptokenobj = $.ajax({url:uptokenurl,async:false});
   uptoken = eval('(' + uptokenobj.responseText + ')').uptoken;
   console.log('ajax up token:'+uptoken);
   console.log('imageupurl :'+imageupurl);

   var imgFormData = '<form class="pure-form" id="upimageForm" action="'+imageupurl+'" method="post" enctype="multipart/form-data" onsubmit="windowOpener()" target="upimageFrame"><input type="file" name="Filedata" id="Filedata" onchange="onchangeFile();"></form>';
   $("body").append(imgFormData);
   
   var iframe = document.getElementById("upimageFrame");      
   if (iframe.attachEvent){
       iframe.attachEvent("onload", function() {      
           //iframe加载完成后你需要进行的操作    
    	   console.log('iframe加载完成后你需要进行的操作    ');
    	   iframe = document.getElementById("upimageFrame"); 
    	   var oBody=iframe.getElementByTagName("body")[0];
    	   console.log(oBody);
    	   console.log($(this).getElementByTagName("body")[0]);
    	   fileUploaded(oBody);
       });      
   } else {      
       iframe.onload = function() {      
                 //iframe加载完成后你需要进行的操作    
    	   console.log('iframe加载完成后你需要进行的操作 2   ');
    	   //var _iframe = document.getElementById('upimageFrame').contentWindow;
    	   var oBody= $("#upimageFrame").contents();
    	   //console.log(oBody.html());
    	   fileUploaded(oBody);
       };      
   }  
})(jQuery);

  function onchangeFile(){
   	jQuery("#upimageForm").submit();
   }
    
   function  windowOpener(){
	   var loadpos = '';
       controlWindow=window.open(loadpos,"upimageFrame","toolbar=yes,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=450,height=300");
       console.log('window.open"'+controlWindow);
   }
   
   function fileUploaded(info) {
       // 每个文件上传成功后,处理相关的事情
       // 其中 info 是文件上传成功后，服务端返回的json，形式如
       // {
       //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
       //    "key": "gogopher.jpg"
       //  }
	   console.log('fileUploaded_info:'+info);
       var title = '测试图片标题';
       console.log(title);
       freeurl = 'http://测试图片地址.jpg';
       var img = '';
       if (imgurl == true) {
            var img = '<a href="' + freeurl + '"><img src="' + freeurl
                    + '" alt="' + title
                    + '" title="' + title
                    + '"></a>';    
       } else {
             var img = '<img src="' + freeurl
                    + '" alt="' 
                    + title
                    + '" title="'
                    + title
                    + '">';   
       }
       console.log(img);
       tinyMCE.activeEditor.execCommand('mceInsertContent', 0, img);
       console.log('添加完成');
   }