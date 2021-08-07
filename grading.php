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

if (isset($_POST['add'])){
    $student_id = $_POST['student'];
    $dressing = $_POST['dressing'];
    $report = $_POST['report'];
    $presentation = $_POST['presentation'];
    $comment = $_POST['comment'];
    $question = $_POST['question'];

    $error = array();

    $sql = $db->query("SELECT * FROM grading WHERE student_id='$student_id'");
    if ($sql->rowCount() >= 1){
        $error[] = student_details($student_id,'matric')." has already been grade";
    }

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

        $in = $db->query("INSERT INTO grading (student_id,dressing,report,presentation,comment,question)VALUES ('$student_id','$dressing','$report','$presentation','$comment','$question')");

        set_flash("Project Grading has been successful ","warning");

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

            <?php flash() ?>


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

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Dressing</label>
                            <input type="number" name="dressing" placeholder="Dressing" class="form-control" required id="">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Report</label>
                            <input type="number" name="report" placeholder="Report" class="form-control" required id="">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Presentation</label>
                            <input type="number" name="presentation" placeholder="Presentation" class="form-control" required id="">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Question &amp; Answer</label>
                            <input type="number" name="question" placeholder="Question &amp; Answer" class="form-control" required id="">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Comment (optional)</label>
                            <textarea name="comment" class="form-control" id="" placeholder="Comment"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-warning" value="Submit" name="add" id="">
                </div>
            </form>

        </div>
    </div>
</div>


<?php require_once 'libs/foot.php';?>
