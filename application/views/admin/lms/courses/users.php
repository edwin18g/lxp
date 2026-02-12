<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*Common Table View*/
?>

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <!-- Page Heading -->
                <h2 class="text-uppercase p-l-3-em">Course Users List</h2>
                
                <!-- Back Button -->
                <a href="<?php echo site_url('admin/'.$this->uri->segment(2)) ?>" class="btn btn-default btn-circle waves-effect waves-circle waves-float pull-left"><i class="material-icons">arrow_back</i></a>

                <!-- Add Button -->
                <?php if($this->uri->segment(2) !== 'contacts') { ?>
                <a href="<?php echo site_url().'admin/'.$this->uri->segment(2).'/users_form/'.$this->uri->segment(4); ?>" class="btn bg-<?php echo $this->settings->admin_theme ?> btn-circle waves-effect waves-circle waves-float pull-right">
                <i class="material-icons">add</i></a>
                <?php } ?>
            </div>
            <div class="body table-responsive">
                <table id="users_course" class="table table-striped table-hover dataTable">
                    <thead>
                        <tr>
                            <?php foreach($t_headers as $val) { echo '<th>'.$val.'</th>'; } ?>
                        </tr>
                    </thead>
                    <tbody class="text-capitalize">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function ajaxDeleteUser(id)
    {
          $.ajax({
        type     : 'POST',
        url      : ' <?php echo site_url().'admin/'.$this->uri->segment(2).'/delete_user/'; ?>',
        data     : {'id':id},
        dataType : 'json',
        async    : true,
        success  : function(results) {
           location.href = location.href;
            
        },
        error    : function(error) {
            alert("Error " + error.status + ": " + error.statusText);
        }
    });
    }
</script>