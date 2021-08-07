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


            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Passport</th>
                        <th>Matric Number</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th>Dressing </th>
                        <th>Presentation </th>
                        <th>Report</th>
                        <th>Question & Answer</th>
                        <th>Grading Year</th>
                        <th>Comment</th>
                        <th>Total Grade</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Passport</th>
                        <th>Matric Number</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th>Dressing </th>
                        <th>Presentation </th>
                        <th>Report</th>
                        <th>Question & Answer</th>
                        <th>Grading Year</th>
                        <th>Comment</th>
                        <th>Total Grade</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        $sql = $db->query("SELECT g.*, s.fname, s.matric, s.level, d.name FROM grading g INNER JOIN students s ON g.student_id = s.id INNER JOIN departments d ON s.dept = d.id ORDER BY g.id DESC ");
                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><img src="https://www.federalpolyede.edu.ng/passport/Reg<?= $rs['matric'] ?>.jpg" style="width: 50px; height: 50px;" class="img-circle" alt=""></td>
                                <td><?= $rs['matric'] ?></td>
                                <td><?= $rs['fname'] ?></td>
                                <td><?= $rs['name'] ?></td>
                                <td><?= $rs['level'] ?></td>
                                <td><?= $rs['dressing'] ?></td>
                                <td><?= $rs['presentation'] ?></td>
                                <td><?= $rs['report'] ?></td>
                                <td><?= $rs['question'] ?></td>
                                <td><?= $rs['grading_year'] ?></td>
                                <td><?= $rs['comment'] ?></td>
                                <td><?= $rs['dressing'] + $rs['presentation'] + $rs['report'] + $rs['question'] ?></td>
                                <td><a href="view.php?id=<?= $rs['student_id'] ?>" class="btn btn-warning btn-sm">View</a></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>


<?php require_once 'libs/foot.php';?>
