<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>          
<style>
    .builder-inner-from {
    position: relative;
    padding: 25px;
    overflow-y: auto;
}
.fle-upload {
    position: relative;
    float: left;
    cursor: pointer;
    border: 1px solid #dedede;
    width: 100%;
    border-radius: 3px;
    background: #fbfbfb;
}

label.fle-lbl {
    background: #096cbf !important;
    color: #fff;
    font-size: 13px;
    line-height: 37px;
    position: relative;
    text-transform: uppercase;
    width: auto;
    float: right;
    text-align: center;
    padding: 0px 36px;
    border-radius: 0 3px 3px 0;
}

.fle-upload .upload {
    width: 125px !important;
    right: 0% !important;
    cursor: pointer;
}


input[type="file"] {
    display: block;
}
.upload {
    opacity: 0;
    position: absolute !important;
    top: 0;
    margin: 0;
    font-size: 20px;
    z-index: 1;
}
.fle-upload .upload {
    width: 125px !important;
    right: 0% !important;
    cursor: pointer;
}

.upload-file-name {
    background: rgb(255, 255, 255) none repeat scroll 0 0;
    border: 0 none;
    cursor: pointer;
    height: 100%;
    left: 0;
    margin: 0;
    padding: 8px 12px;
    position: absolute;
    width: calc(100% - 124px);
    z-index: 0;
}
</style>

<div class="row clearfix">
    
    <div class="col-sm-6">
        
        <?php if(isset($video_file) && !empty($meta_title) && $type): if($type  == '3'):?>
            <link rel="stylesheet" href="<?php echo base_url('themes/default/plyr/plyr.css') ?>" />
                <div class="preivew-area  text-center">
                    <video id="player" controls height="480">
                    </video>
                 </div>
          <script>
          	 var __file='';
             var videoFile ='<?php echo $video_file ?>';
          </script>
          <script src="<?php echo base_url('themes/default/plyr/plyr.js')?>"></script>
          <script type="text/javascript">
           
            
            function getId(url) {
                var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                var match = url.match(regExp);
        
                if (match && match[2].length == 11) {
                    return match[2];
                } else {
                    return 'error';
                }
            }
        
            var videoId = getId(videoFile);
        
            const player = new Plyr('#player');
            if(videoId){
                player.source = {
                    type: 'video',
                    sources: [{
                        src: videoId, // From the YouTube video link
                        provider: 'youtube',
                    },],
                };
            }
            
        
            /*
            YouTube video link
            https://www.youtube.com/watch?v=aqz-KE-bpKQ
            */
        </script>
 
      <?php endif; endif; ?>
        
        
    </div>
    <div class="col-sm-5">
        <div class="card">
            <div class="header">
                <!-- Page Heading -->
                <h2 class="text-uppercase p-l-3-em"><?php echo !empty($id) ? lang('action_edit') : lang('action_create'); ?></h2>
                
                <!-- Back Button -->
                <a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2)) ?>" class="btn btn-default btn-circle waves-effect waves-circle waves-float pull-left"><i class="material-icons">arrow_back</i></a>

                <!-- Delete Button -->
                <?php if(!empty($id)) { echo '<a role="button" onclick="ajaxDelete('.$id.', ``, `'.lang('menu_course').'`)" class="btn btn-default btn-circle waves-effect waves-circle waves-float pull-right"><i class="material-icons">delete_forever</i></a>'; } ?>
            </div>
            <div class="body">
               
                
                  <div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#Basic">Basic Settings</a>
      </h4>
    </div>
    <div id="Basic" class="panel-collapse collapse">
      <div class="panel-body"> <?php echo form_open_multipart(site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.'lecture_save'), array('class' => 'form-horizontal', 'id' => 'form-create', 'role'=>"form")); ?>

                    <?php if(! empty($id)) { ?> <!-- in case of update courses -->
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <?php } ?>
                    <input type="hidden" name="course_id" value="<?php echo $this->uri->segment(4); ?>">
                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            Content Type
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line" id="show_sub_categoriess">
                                    <?php echo form_dropdown($category); ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            Content Name
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_input($title);?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                          video url
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_input($meta_title);?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix hidden">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('common_description', 'description', array('class'=>'description')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_textarea($description); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 form-control-label">
                                    <?php echo lang('common_status', 'status', array('class'=>'status')); ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <?php echo form_dropdown($status);?>
                                        </div>
                                    </div>
                                </div>
                            </div>      
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 form-control-label">
                                    Secture content
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <?php echo form_dropdown($featured);?>
                                        </div>
                                    </div>
                                </div>
                            </div>      
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                            <div class="btn-group">
                                <button type="submit" class="btn bg-<?php echo $this->settings->admin_theme ?> btn-lg waves-effect"><?php echo lang('action_submit') ?></button>
                            </div>
                            <span id="submit_loader"></span>
                        </div>
                    </div>

                <?php echo form_close();?></div>
      <div class="panel-footer">-</div>
    </div>
  </div>
</div>
                <div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#supportfile">Support files</a>
      </h4>
    </div>
    <div id="supportfile" class="panel-collapse collapse">
      <div class="panel-body"><div class="col-md-12 support-files-info">
            <div class="col-md-5 no-padding">Recommended File Formats :</div> 
            <div class="col-md-7 supported-formats no-padding"> .mp3,.doc,.docx, .pptx,.ppt,.pdf,.xlsx,.zip,.png,.jpg,.jpeg</div>
        </div>
        
        
        <div class="builder-inner-from">
                <div class="form-group clearfix">
                    <div class="fle-upload">
                    
                        <label class="fle-lbl">BROWSE</label>
                        <input type="file" class="form-control upload" id="lecture_support_file_upload" name="file">
                        <input value="" readonly="" class="form-control upload-file-name" id="upload_support_file_name" type="text">
                        
                    </div>
                </div>
                <div class="text-right">

                    <input type="hidden" id="support_file_lecture_id" name="support_file_lecture_id" value="4502">
                    <button type="button" id="save_support_file" onclick="save_support_files()" class="btn btn-green">SAVE<ripples></ripples></button>
                </div>
            </div>
        
        
        </div>
      <div class="panel-footer">-</div>
    </div>
  </div>
</div>
            </div>
        </div>
    </div>
</div>

<script>
var __allowed_files = [ "xls", "xlsx", "doc", "docx", "pdf", "ppt", "pptx", "odt", "mp3", "zip", "png", "jpg", "jpeg"];
    $(document).on('change', '#lecture_support_file_upload', function(e){
        __support_file = e.currentTarget.files;
        
       
        if( __support_file.length > 1 )
        {
            //lauch_common_message('Multiple file not allowed', 'more than one file not allowed.');    
            __support_file = '';
            return false;
        }
        var fileObj                     = new processFileName(__support_file[0]['name']);
            fileObj.uniqueFileName();   
   
   
        if(inArray(fileObj.fileExtension(), __allowed_files) == false)
        {
            //lauch_common_message('Invalid File', 'This type of file is not allowed.');
            __support_uploading_file = '';
            return false;        
        }
        
         console.log(__support_file[0]['name']);
        $('#upload_support_file_name').val(__support_file[0]['name']);
        __uploads_url = webConfigs('uploads_url');
    });
    
    
    function processFileName(fileName) {
    var __fileNameTemp = fileName;
    var __explodedFileName = '';
    this.trimFileName = function() {
        __fileNameTemp = trimFileName(__fileNameTemp);
    }

    this.explodeFileName = function() {
        return __explodedFileName = __fileNameTemp.split('.');
    }

    this.fileExtension = function() {
        return __explodedFileName[(__explodedFileName.length) - 1].toLowerCase();
    }

    this.uniqueFileName = function() {
        this.trimFileName();
        this.explodeFileName();
        var currentdate = new Date();
        var datetime = currentdate.getDate() + '-' + (currentdate.getMonth() + 1) + '-' + currentdate.getFullYear() + '-' + currentdate.getHours() + '-' + currentdate.getMinutes() + '-' + currentdate.getSeconds();
        var uniqueFileName = __explodedFileName[0].slice(0, 30) + datetime + "." + this.fileExtension();
        return uniqueFileName.replace(/\\/g, "");
    }
}

function trimFileName(file_name) {
    var trimed_filename = file_name.split(' ').join('-');
    trimed_filename = trimed_filename.split('&').join('-');
    trimed_filename = trimed_filename.split(';').join('-');
    trimed_filename = trimed_filename.split(':').join('-');
    trimed_filename = trimed_filename.split('/').join('-');
    trimed_filename = trimed_filename.split('{').join('-');
    trimed_filename = trimed_filename.split('}').join('-');
    trimed_filename = trimed_filename.split('(').join('-');
    trimed_filename = trimed_filename.split(')').join('-');
    trimed_filename = trimed_filename.split('\'').join('-');
    trimed_filename = trimed_filename.split('"').join('-');
    return trimed_filename;
}


function inArray(needle, haystack) {
    var length = haystack.length;
    for (var i = 0; i < length; i++) {
        if (haystack[i] == needle) return true;
    }
    return false;
}
function webConfigs(key)
{
    return localStorage.getItem(key);
}


function save_support_files()
{
    //getting file details

    var errorCount                      = 0;
    var errorMessage                    = '';
    var extensions                      = ['mp4','avi','flv'];
    
    var i                               = 0;
    //var uploadURL                       = __uploads_url; 
    var uploadURL                       = admin_url+"coursebuilder/upload_to_home_server?supportfile=1";
    var fileObj                         = new processFileName(__support_file[i]['name']);
    var file_name                       = fileObj.uniqueFileName();        
    var extension                       = fileObj.fileExtension();
    

    __upload_path       = '';
    __upload_path       = __fileUploadPaths['supportfile_upload_path']+file_name
    if( __upload_path == '' )
    {
        $('#upload-lecture .modal-body').prepend(renderPopUpMessage('error', 'Upload path is empty'));
        scrollToTopOfPage();
        return false;
    }
    
    var param                           = new Array;
        param["key"]                    = __upload_path;
        param["file"]                   = __support_file[i];        
        param["file"]["key"]            = param["key"];
    
        //uploadFileToS3(uploadURL, param);
        if( __support_file.length > 0 )
        {
            $('#percentage_bar').show(); 
            $("#save_support_file").html('Saving...');
        }
        
        
        uploadURL                   = admin_url+"coursebuilder/upload_to_aws_server"; 
        uploadFiles(uploadURL, param, supportfileTouploadCompleted, 'xml');
        // console.log(param);
}

function uploadFiles(uploadURL, param, callback, __dataType) {
    console.log('uploadFiles system');
    var formDataType = (typeof __dataType == 'undefined') ? 'json' : __dataType;
    var formData = new FormData();
    for (key in param) {
        formData.append(key, param[key]);

    }
    var processingId = (typeof param['processing'] != 'undefined') ? param['processing'] : 'percentage_count';
    var jqXHR = $.ajax({
        xhr: function() {
            var xhrobj = $.ajaxSettings.xhr();
            if (xhrobj.upload) {
                xhrobj.upload.addEventListener('progress', function(uploadEvent) {
                    var event = uploadEvent;
                    var percent = 0;
                    var position = event.loaded || event.position;
                    var total = event.total;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);
                    }
                    $('.progress-bar').css('width', percent + '%');
                    $('.progress-bar .sr-only').html(percent + '%' + 'complete');
                    $('.percentage-text').html(percent + '%');
                    //Set progress
                    if (percent == 100) {
                        $('#' + processingId).parent().html('processing_please_wait');
                    }
                    //console.log(percent);
                }, false);
            }
            return xhrobj;
        },
        url: uploadURL,
        type: "POST",
        datatype: formDataType,
        contentType: false,
        processData: false,
        cache: false,
        data: formData,
        async: true,
        success: function(responseData) {
            var data = responseData;
            
            callback(data);
        }
    });
}

  function supportfileTouploadCompleted(file_response)
    {
        // //console.log(file_response, 'this is from supportfileTouploadCompleted');
        // if(__support_file == '')
        // {
        //     //alert('test');
        //     lauch_common_message('Invalid file', 'Please select any file.');
        //     return false;
        // }
        
        // var lecture_id = $("#support_file_lecture_id").val();
        // $.ajax({
        //     url: webConfigs('admin_url')+'coursebuilder/save_support_file',
        //     type: "POST",
        //     data:{ "is_ajax":true,"lecture_id":lecture_id,"course_id":__course_id,"file_response":file_response},
        //     success: function(response) 
        //     {
        //         var file_data     = typeof file_response == "string" ? $.parseJSON(file_response) : file_response;
        //         var data          = $.parseJSON(response);
        //         //console.log(file_data);
        //         // //console.log(data);
        //         if(data['error'] == false)
        //         {
        //             var encrypted_name      = file_data['file_object'].file_name
        //             var file_name           = typeof file_data['file_object'].client_name != 'undefined' ? file_data['file_object'].client_name : encrypted_name;
        //             var raw_filename        = file_data['file_object'].raw_name;
        //             var support_file_html   = '';
        //                 support_file_html  += '<span class="redactor-file-item"><a target="_blank" href="'+__support_file_path+'/'+encrypted_name+'">'+file_name+'</a><span onclick=removeSupportfile("'+raw_filename+'"); class="redactor-file-remover">×</span></span>';
        //         }
        //         else
        //         {
        //             lauch_common_message('Invalid File', 'This type of file is not allowed.'); 
        //         }
        //         $("#support-files").append(support_file_html);
        //         __support_file = '';
        //         $("#upload_support_file_name").val('');
        //         $("#lecture_support_file_upload").val('');
        //         $("#save_support_file").html('Save');
        //     }
        // });
    }
</script>