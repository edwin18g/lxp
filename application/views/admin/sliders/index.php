<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <!-- Page Heading -->
                <h2 class="text-uppercase p-l-3-em">
                    Sliders
                </h2>

                <!-- Back Button -->
                <a href="<?php echo site_url($this->uri->segment(1)) ?>"
                    class="btn btn-default btn-circle-wave-effect btn-tooltip-back">
                    <i class="material-icons">chevron_left</i>
                </a>

                <!-- Add Button -->
                <ul class="header-dropdown m-r--5">
                    <li>
                        <a href="<?php echo site_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/form') ?>"
                            class="btn btn-primary btn-circle-wave-effect btn-tooltip-add">
                            <i class="material-icons">add</i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="table" class="table table-bordered table-striped table-hover dataTable ajax-table">
                        <thead>
                            <tr>
                                <?php foreach ($t_headers as $header): ?>
                                    <th>
                                        <?php echo $header; ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>