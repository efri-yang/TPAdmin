 
var $uploadfileUL=$("#J_uploader-list");
var $defaultNoPic=$("#J_no-pic");



 var uploader = WebUploader.create({
     pick: {
         id: '#filePicker',
         label: '点击上传本地头像'
     },
     formData: {
         uid: ""
     },
     accept: { // 只允许选择图片文件格式
         title: 'Images',
         extensions: 'gif,jpg,bmp,png',
         mimeTypes: 'image/jpg,image/jpeg,image/png'
     },
    server: './php/fileupload.php',
    swf: './plugin/webuploader-0.1.5/Uploader.swf',
     //限制文件的大小
     fileSingleSizeLimit: 2 * 1024 * 1024,
     fileNumLimit: 1,
     fileSizeLimit: 4 * 1024 * 1024
 });
console.dir(uploader);
uploader.percentages = {};
uploader.fileSize = 0;
uploader.fileCount = 0;

uploader.state = 'pedding';

 //显示错误函数
 function showError(txt) {
     if (window.layer) {
         layer.msg(txt);
     } else {
         alert(txt);
     }
 }

 //单个图片显示错误
 function showErrorForSingle(code, $elem) {
     switch (code) {
         case 'exceed_size':
             text = '文件大小超出';
             break;
         case 'interrupt':
             text = '上传暂停';
             break;
         default:
             text = '上传失败，请重试';
             break;
     }
     $elem.text(text).show();
 }
 //添加li
 function addFile(file) {
     var str = '<li id="' + file.id + '">' +
        '<div class="img-wrap preview"><span class="txt-1">预览中...</span><img src="" class="img-upload"></div>'+

        '<div class="handle-bar">'+
            '<span class="del-btn">删除</span>'+
            '<span class="upload-btn">上传</span>'+
        '</div>'+
        '<p class="progressing"><span style="width:0;"></span></p>'+
        '<span class="error">上传失败</span>'+
        '<span class="success-del"><i class="iconfont icon-shanchu"></i></span>'+
        '<span class="success"></span>'+
        '</li>';
     var $li = $(str);
     $uploadfileUL.append($li);

     var $imgWrap=$li.find(".img-wrap");
     var $handBar=$li.find(".handle-bar");
     var $prewTxtElem = $imgWrap.children('.txt-1');
     var $imgElem =$imgWrap.children(".img-upload");
     
     var $delBtnElem = $li.find(".del-btn");
     var $successDelBtnElem = $li.find(".success-del");
     var $uploadElem=$li.find(".upload-btn");
     var $successElem = $li.find(".success");
     var $progressElem = $li.find(".progressing");
     var $errorElem = $li.find(".error");





     //base64位预览
     uploader.makeThumb(file, function(error, src) {
         if (error) {
             $prewTxtElem.text('不能预览');
             return;
         }
         $imgWrap.removeClass("preview");
         $handBar.show();
         $prewTxtElem.hide();
         $imgElem.attr("src", src).show();
         $delBtnElem.show();
     });
     //进度信息
     uploader.percentages[file.id] = [file.size, 0];
     //记住 uploader.on("error"）主要对于intered的时候进行检测报错，这里是对于单个文件进行检测
     file.on('statuschange', function(cur, prev) {
         if (cur === 'error' || cur === 'invalid') {
             showErrorForSingle(file.statusText, $errorElem);
             uploader.percentages[file.id][1] = 1;
         } else if (cur === 'interrupt') {
             showError('interrupt');
         } else if (cur === 'queued') {
             uploader.percentages[file.id][1] = 0;
         } else if (cur === 'progress') {
             $delBtnElem.hide();
             $progressElem.show();
             $errorElem.hide();
         } else if (cur === 'complete') {
             $progressElem.hide();
             $successElem.show();
         }
     });

     $delBtnElem.on("click", function(event) {
         event.preventDefault();
         uploader.removeFile(file, true);
         console.dir(uploader.getFiles("inited"));
         console.dir(uploader.getFiles("cancelled"));
         

     });

     $uploadElem.on("click",function(event){
        event.preventDefault();
        uploader.upload();
     });

     //点击参数按钮以后要删除远程服务端的地址
     $successDelBtnElem.on("click",function(event){
        event.preventDefault();
        var $li=$("#"+file.id);
         var url=$li.data("url");
        var index=url.lastIndexOf("/");
       
         var imgName=url.slice(index+1);
    

        $.ajax({
            url:"./php/delfile.php",
            type:"post",
            data:{filename:imgName},
            dataType:"json",
            success:function(data){
                    if(data==1){
                        $li.remove();
                        showError("删除成功！");
                        $defaultNoPic.show();
                        uploader.removeFile( file);
                        $(uploader.options.pick.id).removeClass("disabled").siblings(".mask").hide();
                    }
            }

        })
        
     })

 }






 function setState(val) {
     var file, stats;
     if (val === uploader.state) {
         return;
     }
     
     uploader.state = val;
     switch (uploader.state) {
         case 'ready': //选完图片以后
             uploader.refresh();
             

             break;
         case 'pedding':
             uploader.refresh();
             break;
         case 'uploading':
             //上传进度条要显示，上传按钮要隐藏，继续添加按钮要隐藏
           
            
             break;
         case 'paused':
            
             break;
         case 'confirm':
             //上传进度条要隐藏
             stats = uploader.getStats();
             if (stats.successNum && !stats.uploadFailNum) {
                 setState('finish');
                 return;
             }
             break;
         case 'finish':
            
             break;

     }
    
 }

 function closeLayer() {
     var layerIndex = editor.$valueContainer.attr("layer-index");
     layer.close(layerIndex);
 }


 uploader.on('dialogOpen', function() {
     // console.dir("触发了：dialogOpen(本地上传窗口打开的时候)");
 });

 uploader.on("beforeFileQueued", function(file) {
     // console.group("触发了：beforeFileQueued事件(当文件被加入队列之前触发)");
 });

 //假设设定最多上传3个文件，那么第四个不会被上传，其他的三个会被上传，但是还是会报错
 uploader.on("fileQueued", function(file) {
     // console.group("触发了：fileQueued事件(当文件被加入队列以后触发)");
     if (file.getStatus() === 'invalid') {
         //文件不合格，不能重试上传。会自动从队列中移除。

     } else {
         uploader.fileCount++;
         uploader.fileSize += file.size;
         if (uploader.fileCount > 0) { 
             uploader.refresh();
         }

         //上传个数大于限定的个数 按钮禁用
         if(uploader.fileCount >=uploader.options.fileNumLimit){
             $(uploader.options.pick.id).addClass("disabled");
             $(uploader.options.pick.id).siblings(".mask").show();
         }
         //添加li，并绑定事件
         $defaultNoPic.hide();
         addFile(file);
         setState('ready');
         
     }

 });

 uploader.on("filesQueued", function(file) {
     // console.group("触发了：filesQueued事件(当一批文件添加进队列以后触发)");
 });

 uploader.on('fileDequeued', function(file) {
     uploader.fileCount--;
     uploader.fileSize -= file.size;

     if (!uploader.fileCount) {
         setState('pedding');
     }
     removeFile(file);

     if(uploader.fileCount <uploader.options.fileNumLimit){
         $(uploader.options.pick.id).removeClass("disabled");
         $(uploader.options.pick.id).siblings(".mask").hide();
     }
     
 });

 function removeFile(file) {
     var $li = $('#' + file.id);
     delete uploader.percentages[file.id];
     $li.remove();
     if(!uploader.percentages.length){
        $defaultNoPic.show();
     }
     
 }


 uploader.on("uploadStart", function(file) {
     //这个时候文件就会被加入队列
     // console.group("触发了：uploadStart事件(某个文件开始上传前触发，一个文件只会触发一次)");
     // console.dir(uploader.getFiles("inited"))
     // console.dir(uploader.getFiles("queued"))
     setState('uploading');
       var $li = $('#' + file.id);
      var $handBar = $li.find('.handle-bar');
      $handBar.hide();
 });

 uploader.on("stopUpload", function(file, data) {
     // console.group("触发了：uploadAccept事件");
     setState('paused');

 });


 uploader.on("uploadBeforeSend", function(file) {
     // console.group("触发了：uploadBeforeSend事件");

    
 });
 uploader.on("uploadProgress", function(file, percentage) {

     // console.group("触发了：uploadProgress事件");


     var $li = $('#' + file.id),
         $percent = $li.find('.progressing span');

     $percent.css('width', percentage * 100 + '%');
     uploader.percentages[file.id][1] = percentage;
     

 });

 uploader.on("uploadAccept", function(file, data) {
     // console.group("触发了：uploadAccept事件");
 });


 uploader.on("uploadSuccess", function(file, response) {
     // console.group("触发了：uploadSuccess");
     // console.dir(uploader.getFiles("progress"));
     // console.dir(uploader.getFiles("complete"))
     $("#" + file.id).attr("data-url", response);

      $("#" + file.id).find(".success-del").show();
 });

 uploader.on("uploadComplete", function(file, response) {
     // console.group("触发了：uploadComplete");
     // console.dir(uploader.getFiles("progress"));
     // console.dir(uploader.getFiles("error"))
 });

 uploader.on("uploadFinished", function(file, response) {
     // console.group("触发了：uploadFinished");
     setState('confirm');

 });

 uploader.on("error", function(code) {
     //如果上传同一张图片，那么就会报错！！
     switch (code) {
         case "F_EXCEED_SIZE":
             showError('上传单个文件最大不能超过' + WebUploader.formatSize(WebUploader.options.fileSingleSizeLimit));
             break;
         case "F_DUPLICATE":
             showError('您已经上传该文件了，无需重复上传！');
             break;
         case "Q_TYPE_DENIED":
             showError('您上传的' + uploader.options.accept.mineTypes + '类型文件！');
             break;
         case "Q_EXCEED_NUM_LIMIT":
             showError('每次最多上传' + uploader.options.fileNumLimit + "个,多出文件将不被上传！");
             break;
         default:
             showError("文件上传出错！");
     }
 });

 //*****点击上传按钮**************************************************
//  $uploadBtn.on("click", function(event) {
//      event.preventDefault();
//      if ($(this).hasClass('disabled')) {
//          return false;
//      }
//      if (uploader.state === 'ready') {
//          uploader.upload();
//      } else if (uploader.state === 'paused') {
//          uploader.upload();
//      } else if (uploader.state === 'uploading') {
//          uploader.stop();
//      }
// });