<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 12/21/20
 * Time: 1:18 PM
 */

$error = array();

function base_url($url = ""){
    if (empty($url)){
        return HOME_DIR;
    }else{
        return HOME_DIR.$url;
    }
}

function page_title($page_title = ""){
    if (empty($page_title)){
        return WEB_TITLE;
    }else{
        return $page_title." &dash; ".WEB_TITLE;
    }
}

function image_url($src){
    return base_url('templates/images/'.$src);
}

function set_flash ($msg,$type){
    $_SESSION['flash'] = '<div class="alert alert-'.$type.' alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>'.$msg.'</div>';
}

function flash(){
    if (isset($_SESSION['flash'])) {
        echo $_SESSION['flash'];
        unset($_SESSION['flash']);
    }
}

function redirect($url){
    header("location:$url");
    exit();
}

function is_login(){
    if (!isset($_SESSION['loggedin'])){
        return 0;
    }else{
        return 1;
    }
}

function admin_details($value){
    global $db;
    $username = $_SESSION[USER_SESSION_HOLDER]['username'];
    $sql = $db->query("SELECT * FROM admin WHERE username='$username'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}

function student_details($id,$value){
    global $db;
    $sql = $db->query("SELECT * FROM students WHERE id='$id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}


function admin_info($id,$value){
    global $db;
    $sql = $db->query("SELECT * FROM admin WHERE id='$id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}

function student_class($id,$value){
    global $db;
    $sql = $db->query("SELECT * FROM class WHERE id='$id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}


function amount_format($amount){
    return "&#8358;".number_format($amount,2);
}

function checkemail($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}


function get_json($data){
    echo json_encode($data);
    exit();
}

function grade($sn){

    if ($sn >= 75 || $sn >= 100){
        return "A";
    }elseif ($sn >= 70 || $sn >= 74 ){
        return "AB";
    }elseif ($sn >= 65 || $sn >= 69){
        return "B";
    }elseif ($sn >= 60 || $sn >= 64){
        return "BC";
    }elseif ($sn >= 55 || $sn >= 59){
        return "C";
    }elseif ($sn >= 50 || $sn >= 54){
        return "CD";
    }elseif ($sn >= 45 || $sn >= 49){
        return "D";
    }elseif ($sn >= 40 || $sn >= 44){
        return "E";
    }else{
        return "F";
    }

}

function programme($name){
    if (in_array($name,array('nd 2 ft','nd 2 dpt','nd rpt yr3'))){
        return "NATIONAL DIPLOMA";
    }else{
        return "HIGHER NATIONAL DIPLOMA";
    }
}