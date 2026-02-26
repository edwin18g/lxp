<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>          
<style>
    .m-0 { margin: 0!important;}
.nav-content {
    width: calc(100% - 416px);
    position: relative;
    border-bottom: 1px solid #ececec;
    z-index: 99999;
    margin-left: 0px;
    background: #fff;
    box-sizing: border-box;
    position: sticky;
}
.row {
    margin-left: -15px;
    margin-right: -15px;
}
.d-flex {
    display: -webkit-box!important;
    display: -ms-flexbox!important;
    display: flex!important;
}
.pb-1 {
    padding-bottom: 10px!important;
}
.custom-page-header {
    border-bottom: 1px solid #ececec;
}
.justify-between {
    justify-content: space-between;
}
@media (min-width: 768px){

.col-sm-12 {
    width: 100%;
}
}
.rTable.content-nav-tbl {
    table-layout: auto;
    border-collapse: collapse;
    text-align: center;
    margin-bottom: 0px;
    border-top-width: 0px;
    font-weight: 400;
    border-right: 0px;
    width: 100%;
}
.rTable {
    display: table;
}
.rTable .rTableRow {
    display: table-row;
        padding: 10px;
    border-bottom: 1px solid #ececec;
}
.rTable.content-nav-tbl .rTableRow>.rTableCell.dropdown {
    height: 100%;
}
.rTable.content-nav-tbl .rTableRow>.rTableCell {
    min-height: 45px;
    vertical-align: middle;
    padding: 0px 0px;
    font-size: 13px;
    border-top-width: 0px;
    height: 0px;
    position: relative;
}
.rTable .rTableRow .rTableCell {
    display: table-cell;
}
.input-group {
    position: relative;
    display: table;
    border-collapse: separate;
}
.rTable.content-nav-tbl .rTableRow>.rTableCell input.form-control {
    padding: 11px;
    -webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0);
    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0);
}
#searchclear {
    position: absolute!important;
    z-index: 9;
    right: 65px;
    bottom: 0;
    height: 39px;
    margin: auto;
    font-size: 26px;
    cursor: pointer;
    color: silver;
}
.left-wrap {
    background: #fff;
    display: grid;
    grid-template-columns: auto 360px;
    padding: 0px;
}
.bulder-content-inner {
    padding: 0px 0px 0px 0px;
    position: relative;
    height: calc(100% - 1px);
}
.course-cont-wrap {
    padding-left: 15px;
}
.table.course-cont {
    margin-top: 10px;
}
.rTable .rTableRow {
    display: table-row;
}
.course-cont-wrap .course-cont .rTableRow:first-child .rTableCell {
    border-top: 0px;
}
.nav-content input[type="checkbox"] {
    margin-top: 0px;
    position: relative;
}
.course-cont-wrap .course-cont .rTableRow .wrap-mail {
    display: inline-block;
    vertical-align: middle;
    color: #2e3e4e;
    font-size: 12px;
}
.ellipsis-hidden.wrap-mail .ellipsis-style {
    font-style: normal;
    font-weight: normal;
}
label.manage-stud-list {
    display: unset !important;
}
label {
    text-transform: initial;
}
label {
    display: inline-block;
    max-width: 100%;
    color: #2e3e4e;
    text-transform: capitalize;
    font-size: 12px;
}
.manage-stud-list .list-user-name {
    cursor: pointer;
}
.manage-stud-list .list-user-name {
   
    display: inline-block;
    text-overflow: ellipsis;
    overflow: hidden;
    
    height: 18px;
    vertical-align: text-bottom;
}
.list-institute-code, .list-register-number {
    width: 20%;
    display: inline-block;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    line-height: 20px;
}
.list-institute-code, .list-register-number {
    width: 20%;
    display: inline-block;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    line-height: 20px;
}

.only-course .rTableRow .rTableCell:first-child {
    max-width: 350px;
}
.flex-2{
    flex:2;
}
.flex-5{
    flex:5;
}
.right-wrap {
    background: #ffffff;
    padding: 50px;
    width: 100%;
}
</style>

<div class="container-fluid m-0" style="width:100% !important;background: #fff;">
        <div class="row">
           
            <div style="border-bottom: 1px solid #ececec;">
                <div class="rTable content-nav-tbl">
                    <div class="rTableRow">
                                
                                    <div class="rTableCell">
                        <div class="input-group">
                            <input type="text" class="form-control srch_txt" id="user_keyword" placeholder="Search" />
                            <span id="searchclear" style="display: none;">×</span>
                            <a class="input-group-addon" id="basic-addon2">
                            <i class="icon icon-search"> </i>
                            </a>
                        </div>
                    </div>
                    <div class="rTableCell">
                        <!-- lecture-control start -->
                        <!-- lecture-control end -->
                    </div>
                    </div>
                </div>
            </div>

<div class="row">
    <div class="col-sm-8">  
        <div class="bulder-content-inner" style="height: calc(100vh - 284px);overflow-y: auto;">
            <div class="  course-cont-wrap" style="background: none;">
               
                             
                <div style="margin:0 !important">
                    <span class="pull-left" style="    padding: 20px 15px;">
                 
                        <div class="switch"><label><input type="checkbox" class="user-checkbox-parent" onchange="userSelectedParent(this)" ><span class="lever switch-col-blue"></span></label></div>
                    <a href="javascript:void(0)" class="select-all-style no-padding"><label> <input class="user-checkbox-parent " type="checkbox"><span id="selected_user_count"></span></label></a>
                    </span>
                    <div class="pull-right">
                    <!-- Header left items -->
                   
                    </div>
                    <!-- !.Header left items -->
                </div>
                <!-- !.top Header with drop down and action buttons -->
               <div class="table course-cont only-course rTable" style="margin-bottom:80px" id="user_row_wrapper"> 
              
              <!--< ?php  foreach($users as $key => $user): ?>-->
              <!--  <div class="rTableRow d-flex" id="user_row_901" data-name="alex antony" data-email="alex.antony+25@enfintechnologies.com"> -->
                   
              <!--     <div class="rTableCell flex-2"> -->
              <!--      <div class="switch"><label><input type="checkbox" class="user-checkbox" value="<?=$user['id']?>"  ><span class="lever switch-col-blue"></span></label></div>-->
              <!--     </div>-->
                   
                   
              <!--     <div class="rTableCell flex-5"> -->
                  
              <!--         <span class="wrap-mail ellipsis-hidden manage-stud-listwrapper"> -->
              <!--             <div class="ellipsis-style"> -->
              <!--             <a href="javascript:void(0)"> -->
              <!--                 <label class="manage-stud-list" for="user_details_901"> -->
              <!--                      <span class="list-user-name"> -->
              <!--                         <svg style="vertical-align: middle; margin: 0px 10px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="16px" height="18px" viewBox="0 0 16 18" enable-background="new 0 0 16 18" fill="#64277d" xml:space="preserve"><g> <path d="M8,1.54v0.5c1.293,0.002,2.339,1.048,2.341,2.343C10.339,5.675,9.293,6.721,8,6.724C6.707,6.721,5.66,5.675,5.657,4.382 C5.66,3.088,6.707,2.042,8,2.04V1.54v-0.5c-1.846,0-3.342,1.496-3.342,3.343c0,1.845,1.497,3.341,3.342,3.341 c1.846,0,3.341-1.496,3.341-3.341C11.341,2.536,9.846,1.04,8,1.04V1.54z"></path> <path d="M2.104,16.46c0-1.629,0.659-3.1,1.727-4.168C4.899,11.225,6.37,10.565,8,10.565s3.1,0.659,4.168,1.727 c1.067,1.068,1.727,2.539,1.727,4.168h1c0-3.808-3.087-6.894-6.895-6.895c-3.808,0-6.895,3.087-6.895,6.895H2.104z"></path></g></svg> <?=$user['first_name']?> <?=$user['last_name']?></span> -->
                                   
                                    
              <!--                  </label>-->
              <!--              </a> -->
              <!--          </div> -->
              <!--      </span> -->
              <!--  </div>-->
              <!--  <div class="rTableCell flex-5">-->
              <!--      <span class="list-register-number" style="display:inline;"><?=$user['mobile']?> </span> -->
              <!--      </div> -->
              <!--  </div>-->
              <!--  < ?php endforeach;?>-->
                </div>
               
            </div>
            <!-- right side bar section -->
        
    
                    <div id="pagination_wrapper"></div>
                
        </div>

    
    <div class="col-sm-4">
            <a href="javascript:void(0)" id="enroll_user_confirmed" class="btn btn-big btn-green selected full-width-btn">
            ENROLL LEARNERS 
            <ripples></ripples></a>
            <a href="" class="btn btn-big btn-blue full-width-btn">
            CANCEL
            <ripples></ripples></a>
    </div>
    </div>
</div></div>


<script>

var __user_selected = [];
var __user_list     = "<?php echo base64_encode(json_encode($users))?>";
    __user_list      = JSON.parse(atob(__user_list)); 
var keyword         = '';

var courseId        = '<?php echo $course_id?>';

function getUsers() {

    keyword = $('#user_keyword').val().trim();
    $.ajax({
        url: `/admin/courses/users_form/${courseId}/ajaxcall`,
        type: "POST",
        data: {
            "is_ajax": true,
            "keyword": keyword,
            'limit': __limit,
            'offset': __offset
        },
        success: function (response) {
            var data            = $.parseJSON(response);
            var remainingUser   = 0;
            
            renderPagination(__offset, data.total_users);
            if (data.users.length > 0) {


      var htmldata  = data.users.map((user)=>{

                let id                = user['id'];
                let firstName         = user['first_name'];
                let lastName          = user['last_name'];
                let mobile            = user['mobile'];
          
           return  ` <div class="rTableRow d-flex" id="user_row_901" data-name="alex antony" data-email="alex.antony+25@enfintechnologies.com"> 
                   
                   <div class="rTableCell flex-2"> 
                     <div class="switch"><label><input type="checkbox" class="user-checkbox" value="${id}"  ><span class="lever switch-col-blue"></span></label></div>
                   </div>
                    
                    
                   <div class="rTableCell flex-5"> 
                   
                       <span class="wrap-mail ellipsis-hidden manage-stud-listwrapper"> 
                           <div class="ellipsis-style"> 
                           <a href="javascript:void(0)"> 
                               <label class="manage-stud-list" for="user_details_901"> 
                                     <span class="list-user-name"> 
                                       <svg style="vertical-align: middle; margin: 0px 10px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="16px" height="18px" viewBox="0 0 16 18" enable-background="new 0 0 16 18" fill="#64277d" xml:space="preserve"><g> <path d="M8,1.54v0.5c1.293,0.002,2.339,1.048,2.341,2.343C10.339,5.675,9.293,6.721,8,6.724C6.707,6.721,5.66,5.675,5.657,4.382 C5.66,3.088,6.707,2.042,8,2.04V1.54v-0.5c-1.846,0-3.342,1.496-3.342,3.343c0,1.845,1.497,3.341,3.342,3.341 c1.846,0,3.341-1.496,3.341-3.341C11.341,2.536,9.846,1.04,8,1.04V1.54z"></path> <path d="M2.104,16.46c0-1.629,0.659-3.1,1.727-4.168C4.899,11.225,6.37,10.565,8,10.565s3.1,0.659,4.168,1.727 c1.067,1.068,1.727,2.539,1.727,4.168h1c0-3.808-3.087-6.894-6.895-6.895c-3.808,0-6.895,3.087-6.895,6.895H2.104z"></path></g></svg>${firstName} ${lastName}  </span> 
                                    
                                     
                                 </label>
                             </a> 
                         </div> 
                     </span> 
                 </div>
                 <div class="rTableCell flex-5">
                     <span class="list-register-number" style="display:inline;">${mobile} </span> 
                     </div> 
                 </div>`;
                }).join('');



     $('#user_row_wrapper').html(htmldata);

             
            } else {
                // $('.user-count').html("No Learners");
                // $('#user_row_wrapper').html(renderPopUpMessagePage('error', 'No Learners found.'));
                // $('#popUpMessagePage .close').css('display', 'none');
            }
           
        }
    });  
}
  
  function generatePagination(currentPage, totalPages) {
    var pageHtml = '';
    if (totalPages >= currentPage && totalPages > 1) {
        var pageNumber = currentPage;
        var pageGap = 3;

        //rendering button "First Page"
        if ((currentPage - 1) > pageGap) {
            pageHtml += '<li><a href="javascript:void(0);" data-page="1" class="locate-page">First Page</a></li>';
        } else {
            pageHtml += '<li class="disabled"><a href="javascript:void(0);">First Page</a></li>';
        }
        //End of rendering button "First Page"

        //rendering button "Previous"
        var previousPage = (currentPage - 1);
        if (previousPage > 0) {
            pageHtml += '<li><a href="javascript:void(0);" data-page="' + previousPage + '" class="locate-page">&laquo</a></li>';
        } else {
            pageHtml += '<li class="disabled"><a href="javascript:void(0);" >&laquo</a></li>';
        }
        //End of rendering button "Previous"

        //rendering pages that comes before current page
        var beforeLoopLength = currentPage - pageGap;
        while (beforeLoopLength > 0 && beforeLoopLength <= (currentPage - 1)) {
            pageHtml += '<li><a href="javascript:void(0);" data-page="' + beforeLoopLength + '" class="locate-page">' + beforeLoopLength + '</a></li>';
            beforeLoopLength++;
        }
        if (currentPage <= pageGap) {
            beforeLoopLength = 1;
            while (currentPage > beforeLoopLength) {
                pageHtml += '<li><a href="javascript:void(0);" data-page="' + beforeLoopLength + '" class="locate-page">' + beforeLoopLength + '</a></li>';
                beforeLoopLength++;
            }
        }
        //end of rendering pages that comes before current page

        //rendering current page
        var lastPageClass = '';
        if (currentPage == totalPages) {
            lastPageClass = 'pagination-last-page';
        }
        pageHtml += '<li class="active"><a href="javascript:void(0);" data-page="' + pageNumber + '" class="' + lastPageClass + '">' + pageNumber + '</a></li>';
        pageNumber++;
        lastPageClass = '';
        //end of rendering current page


        //rendering pages that comes after current page
        var afterLoopLength = pageGap;
        while (afterLoopLength > 0 && pageNumber <= totalPages) {
            if (pageNumber == totalPages) {
                lastPageClass = 'pagination-last-page';
            }
            pageHtml += '<li><a href="javascript:void(0);" data-page="' + pageNumber + '" class="locate-page ' + lastPageClass + '">' + pageNumber + '</a></li>';
            afterLoopLength--;
            pageNumber++;
        }
        //end of rendering pages that comes after current page

        //rendering button "Next"
        if (totalPages > currentPage) {
            var nextPage = currentPage + 1;
            pageHtml += '<li><a href="javascript:void(0);" data-page="' + nextPage + '" class="locate-page">&raquo</a></li>';
        } else {
            pageHtml += '<li class="disabled"><a href="javascript:void(0);">&raquo</a></li>';
        }
        //End of rendering button "Next"

        //rendering button "Last Page"
        if ((totalPages - pageGap) > currentPage) {
            pageHtml += '<li><a href="javascript:void(0);" data-page="' + totalPages + '" class="locate-page">Last Page</a></li>';
        } else {
            pageHtml += '<li class="disabled"><a href="javascript:void(0);" >Last Page</a></li>';
        }
        //End of rendering button "Last Page"
    }
    // scrollToTopOfPage();
    return pageHtml;
}
  function renderPagination(offset, totalNotifications) {
    offset = Number(offset);
    totalNotifications = Number(totalNotifications);
    var totalNotification = Math.ceil(totalNotifications / __limit);
    if (offset <= totalNotification && totalNotification > 1) {
        var paginationHtml = '';
        paginationHtml += '<ul class="pagination pagination-wrapper"  style="left:65px;">';
        paginationHtml += generatePagination(offset, totalNotification);
        paginationHtml += '</ul>';
        $('#pagination_wrapper').html(paginationHtml);
       
       
    } else {
        $('#pagination_wrapper').html('');
    }
}

var timeOut = null;
 $(document).on('keyup', '#user_keyword', function() {
     
     
     
     clearTimeout(timeOut);
    timeOut = setTimeout(function () {
        __offset = 1;
     getUsers();
    }, 600);
     
     
  });
    $(document).on( 'click', '.user-checkbox',function(){
     
   var user_id = $(this).val();
  
    if ($('.user-checkbox:checked').length == $('.user-checkbox').length) {
        $('.user-checkbox-parent').prop('checked', true);
    }
    if ($(this).is(':checked')) {
        $('.list-button').removeClass('list-disabled');
        __user_selected.push(user_id);
    } else {
        $('.user-checkbox-parent').prop('checked', false);
        $('.list-button').addClass('list-disabled');
        removeArrayIndex(__user_selected, user_id);
    }
    if (__user_selected.length > 1) {
        $("#selected_user_count").html(' Selected (' + __user_selected.length + ')');
        //$("#user_bulk").css('display', 'block');
    } else {
        $("#selected_user_count").html('');
      //  $("#user_bulk").css('display', 'none');
    }   
  } );
    

  
  function removeArrayIndex(array, index) {
    for (var i = array.length; i--;) {
        if (array[i] === index) {
            array.splice(i, 1);
        }
    }
}
var __offset                = '1';
var __totalCounts           = 200;
var __limit                 = 700;
$(document).ready(function(){
//    renderPagination(__offset, __totalCounts); 
getUsers();
});
$(document).on('click', '.locate-page', function()  {
    __offset = $(this).attr('data-page');
    // __offset++;
    getUsers();
    // http://data.mykademy.com/admin/courses/users_form/22/basdf
});

$(document).on('click', '.user-checkbox-parent', function() {
    var parent_check_box = this;
    __user_selected = new Array();
    $('.user-checkbox').not(':disabled').prop('checked', $(parent_check_box).is(':checked'));
    $('.list-button').addClass('list-disabled');
    if ($(parent_check_box).is(':checked') == true) {
        $('.user-checkbox').not(':disabled').each(function (index) {
            __user_selected.push($(this).val());
        });
        $('.list-button').removeClass('list-disabled');
    }
    if (__user_selected.length > 1) {
        $("#selected_user_count").html(' (' + __user_selected.length + ')');
        $("#user_bulk").css('display', 'block');
    } else {
        $("#selected_user_count").html('');
        $("#user_bulk").css('display', 'none');
    }
});

 $(document).on('click', '#enroll_user_confirmed', function() {
    if(__user_selected.length > 0)
       {
      $.ajax({
        type     : 'POST',
        url      : '<?php echo base_url('admin/courses/user_save_beta')?>',
        data     : {'user_id':__user_selected.toString(),'course_id':'<?php echo $this->uri->segment(4); ?>'},
        dataType : 'json',
        async    : true,
        success  : function(results) {
           location.href = "<?php echo base_url('admin/courses/users/'.$this->uri->segment(4))?>";
        }
    });      
       } else {
           alert('please select  one or more  user to Add Course');
       }
   });
   
 
</script>