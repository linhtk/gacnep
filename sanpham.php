<?php

error_reporting(0);
include "includes/xtpl.php";
include "includes/global.php";
include "includes/connection.php";
include "includes/function.php";
include "includes/function_page.php";
include "includes/footer.php";
include "includes/benh.php";
$flag = 'sanpham';
include "includes/header.php";
include "includes/right.php";

$xtpl = new XTemplate("templates/category.html");

$sql_sp = "SELECT * FROM tg_product ORDER BY product_id DESC LIMIT 0,4";
$rs_sp = execSQL($sql_sp);
$i=0;
while ($row_sp = mysql_fetch_assoc($rs_sp)) {
    if($i==0){$row_sp['class'] = "active";}
    $i++;
    if ($row_sp['product_image']) {
        if (file_exists("upload/products/" . $row_sp['product_image'])) {
            $row_sp['product_image'] = '<img src="upload/products/' . $row_sp['product_image'] . '" style="max-height:250px;"/>';
        } else {
            $row_sp['product_image'] = "";
        }
    } else {
        $row_sp['product_image'] = "";
    }
//    $row_sp['product_desc'] = sub_string($row_sp['product_desc'], 150, true);
    $xtpl->assign("SP", $row_sp);
    $xtpl->parse("MAIN.SP");
    $xtpl->parse("MAIN.SPTAB");
}
$xtpl->assign("header_tostring", $header_tostring);
$xtpl->assign("footer_tostring", $footer_tostring);
$xtpl->assign("benh_tostring", $benh_tostring);
$xtpl->assign("right_tostring", $right_tostring);
//Parse the main body
$xtpl->parse("MAIN");
eval("?" . ">" . $xtpl->text("MAIN"));
?>