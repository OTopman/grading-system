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

<?php require_once 'libs/foot.php';?>
