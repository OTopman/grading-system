<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-06
 * Time: 11:47
 */

$page_title = "Project Defense Grading";
require_once 'config/core.php';
if (!is_login()){
    redirect(base_url('index.php'));
    return;
}
require_once 'libs/head.php';
?>

<div class="col-md-12">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $page_title ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">




        </div>
    </div>
</div>


<?php require_once 'libs/foot.php';?>
