<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-06
 * Time: 11:47
 */

$page_title = "Project Grading";
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


            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Student</label>
                            <select name="student" id="" class="form-control select2">
                                <?php
                                    $sql = $db->query("SELECT * FROM students ORDER BY fname");
                                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                        <option value="<?= $rs['id'] ?>"> <?= strtoupper($rs['matric']) ?> (<?= ucwords($rs['fname']) ?>)</option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<?php require_once 'libs/foot.php';?>
