<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-07
 * Time: 08:57
 */

$page_title = "Export Project Defense Grading Sheet";
require_once 'config/core.php';
if (!is_login()){
    redirect(base_url('index.php'));
    return;
}

if (isset($_POST['export'])){
    $department = $_POST['department'];
    $grading_year = $_POST['grading-year'];
    $level = $_POST['level'];

    $error = array();

    if (empty($department) or  empty($grading_year) or empty($level)){
        $error[] = "All field(s) are required";
    }

    $data = array(
        array("NAME" => "John Doe", "EMAIL" => "john.doe@gmail.com", "GENDER" => "Male", "COUNTRY" => "United States"),
        array("NAME" => "Gary Riley", "EMAIL" => "gary@hotmail.com", "GENDER" => "Male", "COUNTRY" => "United Kingdom"),
        array("NAME" => "Edward Siu", "EMAIL" => "siu.edward@gmail.com", "GENDER" => "Male", "COUNTRY" => "Switzerland"),
        array("NAME" => "Betty Simons", "EMAIL" => "simons@example.com", "GENDER" => "Female", "COUNTRY" => "Australia"),
        array("NAME" => "Frances Lieberman", "EMAIL" => "lieberman@gmail.com", "GENDER" => "Female", "COUNTRY" => "United Kingdom")
    );

    $error_count = count($error);

    if ($error_count == 0){

        // Excel file name for download
        $fileName = "project_defense_grading_" . time() . ".xlsx";
        // Headers for download
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Type: application/vnd.ms-excel");

        $flag = false;
        foreach($data as $row) {
            if(!$flag) {
                // display column names as first row
                echo implode("\t", array_keys($row)) . "\n";
                $flag = true;
            }
            // filter data
            array_walk($row, 'filterData');
            echo implode("\t", array_values($row)) . "\n";
        }


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
                            <label for="">Department</label>
                            <select name="department" class="form-control" required id="">
                                <option value="" selected disabled>Select</option>
                                <?php
                                $sql = $db->query("SELECT * FROM departments ORDER BY name");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <option value="<?= $rs['id'] ?>"><?= ucwords($rs['name']) ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Grading Year</label>
                            <select name="grading-year" required id="" class="form-control">
                                <option value="" selected disabled>Select</option>
                                <?php
                                foreach (range(2021,date('Y')) as $value){
                                    $start = $value-1;
                                    ?>
                                    <option value="<?= $start.' - '.$value ?>"><?= $start.' - '.$value ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Export</label>
                            <select name="grading-year" required id="" class="form-control">
                                <option>Excel</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Level</label>
                            <select name="level" class="form-control" required id="">
                                <option value="" selected>Select</option>
                                <?php
                                foreach (array('nd 2 ft','nd 2 dpt','nd rpt yr3','hnd 2 ft','hnd 2 dpt') as $value){
                                    ?>
                                    <option value="<?= $value ?>"><?= strtoupper($value) ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-warning" value="Export" name="export" id="">
                </div>
            </form>

        </div>
    </div>
</div>

<?php require_once 'libs/foot.php'?>
