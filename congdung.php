<?php

error_reporting(0);
include "includes/xtpl.php";
include "includes/global.php";
include "includes/connection.php";
include "includes/function.php";
include "includes/function_page.php";
include "includes/footer.php";
include "includes/benh.php";
$flag = 'phong';
include "includes/header.php";
include "includes/right.php";

$xtpl = new XTemplate("templates/phongbenh.html");
///tin tuc
$id = $_REQUEST['id'];
if ($id != ''){
    $id = $id;
} else {
    $id = 126;
}
$sql_tin = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = '$id' ORDER BY news_id ASC LIMIT 0,4";
$rs_tin = execSQL($sql_tin);
while ($row_tin = mysql_fetch_assoc($rs_tin)) {
    $row_tin['news_content'] = get_news_content($row_tin['news_id']);
    if ($row_tin['news_image']) {
        if (file_exists("upload/news/" . $row_tin['news_image'])) {
            $row_tin['news_image'] = '<img src="upload/news/' . $row_tin['news_image'] . '" class="img-responsive" width="120" height="89" />';
        } else {
            $row_tin['news_image'] = "";
        }
    } else {
        $row_tin['news_image'] = "";
    }
    $xtpl->assign("tin", $row_tin);
    $xtpl->parse("MAIN.tin");
}


$xtpl->assign("page", $page);
$xtpl->assign("header_tostring", $header_tostring);
$xtpl->assign("footer_tostring", $footer_tostring);
$xtpl->assign("benh_tostring", $benh_tostring);
$xtpl->assign("right_tostring", $right_tostring);
//Parse the main body
$xtpl->parse("MAIN");
eval("?" . ">" . $xtpl->text("MAIN"));
?>