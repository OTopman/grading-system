<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-03-28
 * Time: 09:07
 */

require_once 'config/core.php';
require_once 'pdf/vendor/autoload.php';

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');

try {
    $mpdf = new \Mpdf\Mpdf([
        //'tempDir' => __DIR__ . '/pdf', // uses the current directory's parent "tmp" subfolder
        'setAutoTopMargin' => 'stretch',
        'setAutoBottomMargin' => 'stretch',
    ]);

    //$mpdf->useOnlyCoreFonts = true;    // false is default
    //$mpdf->SetAuthor("Sanros Trading Co.");
    $mpdf->SetWatermarkText("Project Defense Grading");
    $mpdf->SetWatermarkImage(image_url('logo2fade.png'));
    $mpdf->showWatermarkImage = true;
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

} catch (\Mpdf\MpdfException $e) {
    print "Creating an mPDF object failed with" . $e->getMessage();
}

@$action_data = @$_POST;
$data =  $student_info = array();

switch (@$action_data['action']){
    case 'login' :

        $matric = $action_data['matric'];
        $password = $action_data['password'];

        $sql = $db->query("SELECT s.*, d.name as dept FROM students s 
        INNER JOIN departments d
            ON s.dept = d.id
        WHERE s.matric='$matric' and s.password='$password'");

        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        if ($sql->rowCount() == 0){
            $data['error'] = 0;
            $data['msg'] = "Invalid login details, try again";
        }else{
            $data['error'] =1;
            $student_info = array(
                'id'=>$rs['id'],
                'matric'=>strtoupper($rs['matric']),
                'fname'=>ucwords($rs['fname']),
                'level'=>ucwords($rs['level']),
                'email'=>$rs['email'],
                'phone'=>$rs['phone'],
                'dept'=>ucwords($rs['dept']),
                'gender'=>ucwords($rs['gender'])
            );
        }

        $data = array(
            'status'=>$data,
            'student_info'=>$student_info
        );

        get_json($data);

        break;
    case 'download':
        $student_id = $action_data['student_id'];

        $sql = $db->query("SELECT g.*, s.fname, s.matric, s.level, d.name FROM grading g INNER JOIN students s ON g.student_id = s.id INNER JOIN departments d ON s.dept = d.id WHERE g.student_id='$student_id' ");

        if ($sql->rowCount() == 0){
            $data['error']=0;
            $data['msg'] = "No result found";
        }else{
            $data['error'] = 1;

            $info = $sql->fetch(PDO::FETCH_ASSOC);

            $file = file_get_contents('grade.html');
            $programme = str_replace("{{programme}}",programme($info['level']),$file);
            $year = str_replace("{{year}}",$info['grading_year'],$programme);

            $sn1 = str_replace("{{sn1}}","1",$year);
            $title1 = str_replace("{{title1}}","Dressing",$sn1);
            $score1 = str_replace("{{score1}}",$info['dressing'],$title1);

            $sn2 = str_replace("{{sn2}}","2",$score1);
            $title2 = str_replace("{{title2}}","Presentation",$sn2);
            $score2 = str_replace("{{score2}}",$info['presentation'],$title2);

            $sn3 = str_replace("{{sn3}}","3",$score2);
            $title3 = str_replace("{{title3}}","Report",$sn3);
            $score3 = str_replace("{{score3}}",$info['report'],$title3);

            $sn4 = str_replace("{{sn4}}","4",$score3);
            $title4 = str_replace("{{title4}}","Question &amp; Answer",$sn4);
            $score4 = str_replace("{{score4}}",$info['question'],$title4);

            $total = str_replace("{{total}}",$info['question'] + $info['dressing'] + $info['report'] + $info['presentation'],$score4);

            $matric = str_replace("{{matric}}",strtoupper($info['matric']),$total);
            $name = str_replace("{{name}}",ucwords($info['fname']),$matric);
            $dept = str_replace("{{department}}",$info['name'],$name);

            $total_score = $info['question'] + $info['dressing'] + $info['report'] + $info['presentation'];

            $grade = str_replace("{{grade}}",grade($total_score),$dept);

            $message = $grade;

            $mpdf->WriteHTML($message);
            $mpdf->Output('templates/images/'.$info['matric'].'.pdf','F');

            $data['error'] =1;
            $data['file'] = 'templates/images/'.$info['matric'].'.pdf';

        }

        get_json($data);

    default;
}