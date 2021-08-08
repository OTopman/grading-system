<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/1/21
 * Time: 2:28 PM
 */

require_once 'config/core.php';
$student_id = $_GET['id'];
if (!isset($student_id) or empty($student_id)){
    redirect(base_url('404.php'));
    return;
}

$sql = $db->query("SELECT s.*, d.name as dept FROM students s 
        LEFT JOIN departments d
            ON s.dept = d.id
        WHERE s.id='$student_id'");

if ($sql->rowCount() == 0){
    redirect(base_url('404.php'));
    return;
}

$data = $sql->fetch(PDO::FETCH_ASSOC);

$grading = $db->query("SELECT * FROM grading WHERE student_id='$student_id'");
$data_grading = $grading->fetch(PDO::FETCH_ASSOC);

$page_title = strtoupper($data['matric'])." - Dashboard";

if (isset($_POST['update'])){
    $dressing = $_POST['dressing'];
    $report = $_POST['report'];
    $presentation = $_POST['presentation'];
    $comment = $_POST['comment'];
    $question = $_POST['question'];

    $error = array();


    if (empty($dressing) or empty($presentation) or empty($report) or empty($question)){
        $error[] = "All field(s) are required";
    }

    if (!is_numeric($dressing)){
        $error[] = "Dressing score should be number";
    }

    if (!is_numeric($report)){
        $error[] = "Report score should be number";
    }

    if (!is_numeric($presentation)){
        $error[] = "Presentation score should be number";
    }

    if (!is_numeric($question)){
        $error[] = "Question score should be number";
    }

    $error_count = count($error);

    if ($error_count == 0){

        $up = $db->query("UPDATE grading SET dressing='$dressing', presentation='$presentation', report='$report', question='$question', comment='$comment' WHERE student_id='$student_id'");

        set_flash("Project Grading has been update successful ","warning");

    }else{
        $msg = ($error_count == 1) ? 'An error occurred' : 'Some error(s) occurred';
        foreach ($error as $value){
            $msg.= '<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}

require_once 'libs/head.php';
?>

<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">

    <?php flash(); ?>

    <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-yellow-gradient">
            <h3 class="widget-user-username"><?= ucwords($data['fname']) ?></h3>
            <h5 class="widget-user-desc">Level : <?= ucwords($data['level']) ?></h5>
        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="https://www.federalpolyede.edu.ng/passport/Reg<?= $data['matric'] ?>.jpg" style="width: 80px; height: 80px;" alt="User Avatar">

        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= ucwords($data['gender']) ?></h5>
                        <span class="description-text" style="text-transform: capitalize">Gender</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= $data['dept'] ?></h5>
                        <span class="description-text" style="text-transform: capitalize">Department</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                    <div class="description-block">
                        <h5 class="description-header"><?= $data['email'] ?></h5>
                        <span class="description-text" style="text-transform: capitalize">Email Address</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.widget-user -->
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Student Details</a></li>
            <li><a href="#tab_2" data-toggle="tab">Project Defense Grading</a></li>
         </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Matric No</td>
                            <td><?= strtoupper($data['matric']) ?></td>
                        </tr>
                        <tr>
                            <td>Student Name</td>
                            <td><?= ucwords($data['fname']) ?></td>
                        </tr>
                        <tr>
                            <td>Level</td>
                            <td><?= $data['dept'] ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td><?= $data['phone'] ?></td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td><?= $data['email'] ?></td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td><?= ucwords($data['gender']) ?></td>
                        </tr>
                    </table>

                </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Dressing</td>
                            <td><?= $data_grading['dressing'] ?></td>
                        </tr>
                        <tr>
                            <td>Presentation</td>
                            <td><?= $data_grading['presentation'] ?></td>
                        </tr>
                        <tr>
                            <td>Report</td>
                            <td><?= $data_grading['report'] ?></td>
                        </tr>
                        <tr>
                            <td>Question &amp; Answer</td>
                            <td><?= $data_grading['question'] ?></td>
                        </tr>
                        <tr>
                            <td>Comment</td>
                            <td><?= $data_grading['comment'] ?></td>
                        </tr>
                        <tr>
                            <td>Grading Year</td>
                            <td><?= $data_grading['grading_year'] ?></td>
                        </tr>
                        <tr>
                            <td>Total Score</td>
                            <td><?= $data_grading['dressing'] + $data_grading['presentation'] + $data_grading['report'] + $data_grading['question'] ?></td>
                        </tr>
                    </table>
                </div>

                <h5 class="page-header">Update Project Defense Grading</h5>

                <form action="" method="post">
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Dressing</label>
                                <input type="number" value="<?= $data_grading['dressing'] ?>" name="dressing" placeholder="Dressing" class="form-control" required id="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Report</label>
                                <input type="number" value="<?= $data_grading['report'] ?>" name="report" placeholder="Report" class="form-control" required id="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Presentation</label>
                                <input type="number" value="<?= $data_grading['presentation'] ?>" name="presentation" placeholder="Presentation" class="form-control" required id="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Question &amp; Answer</label>
                                <input type="number" value="<?= $data_grading['question'] ?>" name="question" placeholder="Question &amp; Answer" class="form-control" required id="">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Comment (optional)</label>
                                <textarea name="comment" class="form-control" id="" placeholder="Comment"><?= $data_grading['comment'] ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-warning" value="Update" name="update" id="">
                    </div>
                </form>
            </div>

        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->
</div>

<?php require_once 'libs/foot.php';?>
