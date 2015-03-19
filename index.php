<?php

error_reporting(0);
include "includes/xtpl.php";
include "includes/global.php";
include "includes/class.shoppingcart.php";
include "includes/connection.php";
include "includes/function.php";
include "includes/function_page.php";
include "includes/footer.php";
//include "includes/left.php";
$flag = 'index';
session_unset();
include "includes/header.php";
//include "includes/right.php";

$xtpl = new XTemplate("templates/index.html");

//slide
//news
$sql_home = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = 125 ORDER BY news_id ASC LIMIT 0,3";
$rs_home = execSQL($sql_home);
while ($row_home = mysql_fetch_assoc($rs_home)) {
    if (($row_home['news_image'] != '') & (file_exists("upload/news/" . $row_home['news_image']))) {
        $row_home['image'] = '<img alt="" src="upload/news/' . $row_home['news_image'] . '" alt="' . $row_home['news_title'] . '" />';
    } else {
        $row_home['image'] = '<img src="images/gac1.png" alt="" />';
    }
    $row_home['news_brief'] = sub_string($row_home['news_brief'], 100, true);
    $xtpl->assign("row_home", $row_home);
    $xtpl->parse("MAIN.row_home");
}
//cong dung
//$sql_news_kt = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id IN (126, 127, 128, 129) ORDER BY news_id DESC LIMIT 0,4";
//$rs_news_kt = execSQL($sql_news_kt);
//while ($row_news_kt = mysql_fetch_assoc($rs_news_kt)) {
//$row_news_kt['news_brief'] = sub_string(strip_tags($row_news_kt['news_brief']), 100, true);
//    if (($row_news_kt['news_image'] != '') & (file_exists("upload/news/" . $row_news_kt['news_image']))) {
//        $row_news_kt['image'] = '<img alt="" src="upload/news/' . $row_news_kt['news_image'] . '" class="img-responsive" alt="' . $row_news_kt['news_title'] . '" />';
//    } else {
//        $row_news_kt['image'] = '<img src="images/congdung1.jpg" class="img-responsive" alt="" />';
//    }
//    $xtpl->assign("news_kt", $row_news_kt);
//    $xtpl->parse("MAIN.KT");
//}
$sql_kt = "SELECT category_id, category_name FROM tg_category WHERE category_parent = 114";
$rs_kt = execSQL($sql_kt);
$num = 1;
while ($row_kt = mysql_fetch_assoc($rs_kt)) {
    $sql_kt_hot = "SELECT n.news_image, md5(n.news_id) AS id, n.news_brief FROM tg_news AS n INNER JOIN tg_news_cate AS nc WHERE n.news_id = nc.news_id AND nc.cate_id = " . $row_kt['category_id'] . " AND n.news_is_hot = 1 ORDER BY n.news_id DESC LIMIT 0,1";
    $rs_kt_hot = execSQL($sql_kt_hot);
    $row_kt_hot = mysql_fetch_assoc($rs_kt_hot);

    $kt_hot_img = $row_kt_hot['news_image'];
    if (($kt_hot_img != '') && (file_exists("upload/news/" . $kt_hot_img))) {
        $row_kt['image'] = '<a href="congdung.php?id=' . $row_kt['category_id'] . '"><img alt="" src="upload/news/' . $kt_hot_img . '" class="img-responsive" /></a>';
    } else {
        $row_kt['image'] = '<img alt="" src="upload/product/' . $num . '.jpg" class="img-responsive" />';
    }
    $row_kt['news_brief'] = sub_string($row_kt_hot['news_brief'], 80, true);

    $xtpl->assign("KT", $row_kt);
    $xtpl->parse("MAIN.KT");
}

//chia se
$sql_cn = "SELECT * FROM tg_share ORDER BY id DESC LIMIT 0,2";
$rs_cn = execSQL($sql_cn);
$i = 0;
while ($row_cn = mysql_fetch_assoc($rs_cn)) {
    if ($i == 0) {
        $row_cn['class'] = " active";
    } else {
        $row_cn['class'] = "";
    }
    if($row_cn['news_image']){
        $xtpl->assign("image", $row_cn['news_image']);
        $xtpl->parse("MAIN.CN.image");
    }
    $i++;
    $row_cn['createDate'] = formatDateFromDatabase($row_cn['create_date'], true);
    $row_cn['content'] = sub_string(strip_tags($row_cn['content']), 200, true);
    $xtpl->assign("CN", $row_cn);
    $xtpl->parse("MAIN.CN");
}
//tin tuc su kien
$sql_bt1 = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image, news_date FROM tg_news_cate WHERE cate_id = 117 ORDER BY news_id DESC LIMIT 0,1";
$rs_bt1 = execSQL($sql_bt1);
$row_bt1 = mysql_fetch_assoc($rs_bt1);
if (($row_bt1['news_image'] != '') & (file_exists("upload/news/" . $row_bt1['news_image']))) {
    $row_bt1['image'] = '<img alt="" src="upload/news/' . $row_bt1['news_image'] . '" class="img-responsive" alt="' . $row_bt1['news_title'] . '" />';
} else {
    $row_bt1['image'] = '<img src="images/congdung1.jpg" class="img-responsive" alt="" />';
}

$row_bt1['news_brief'] = sub_string($row_bt1['news_brief'], 100, true);
$row_bt1['news_date'] = formatDateFromDatabase($row_bt1['news_date'], true);
$xtpl->assign("BT1", $row_bt1);
$xtpl->parse("MAIN.BT1");

$sql_bt2 = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image, news_date FROM tg_news_cate WHERE cate_id = 117 AND md5(news_id) != '" . $row_bt1['news_id'] . "' ORDER BY news_id DESC LIMIT 0,4";
$rs_bt2 = execSQL($sql_bt2);
while ($row_bt2 = mysql_fetch_assoc($rs_bt2)) {
    $row_bt2['news_brief'] = sub_string($row_bt2['news_brief'], 100, true);
    $row_bt2['news_date'] = formatDateFromDatabase($row_bt2['news_date'], true);
    if (($row_bt2['news_image'] != '') & (file_exists("upload/news/" . $row_bt2['news_image']))) {
        $row_bt2['image'] = '<img alt="" src="upload/news/' . $row_bt2['news_image'] . '" class="media-object" alt="' . $row_bt2['news_title'] . '" />';
    } else {
        $row_bt2['image'] = '<img src="images/congdung1.jpg" class="media-object" alt="" />';
    }
    $xtpl->assign("BT2", $row_bt2);
    $xtpl->parse("MAIN.BT2");
}
//quang cao
$sql_qc = "SELECT * FROM tg_adv WHERE adv_position = 1 ORDER BY adv_id DESC LIMIT 0,2";
$rs_qc = execSQL($sql_qc);
while ($row_qc = mysql_fetch_assoc($rs_qc)) {
    if (file_exists('upload/adv/' . $row_qc['adv_image'])) {
        $xtpl->assign('QC', $row_qc);
        $xtpl->parse("MAIN.QC");
    }
}
//san pham
//$sql_sp = "SELECT * FROM tg_product ORDER BY product_id DESC";
//$rs_sp = execSQL($sql_sp);
//$j = 0;
//while ($row_sp = mysql_fetch_assoc($rs_sp)) {
//    if ($j == 0) {
  //      $row_sp['class'] = 'active ';
    //}
    //$j++;
//    $row_sp['product_desc'] = sub_string(strip_tags($row_sp['product_desc']), 150, true);
//    $xtpl->assign('SP', $row_sp);
//    $xtpl->parse("MAIN.SP");
//}
//hoi dap
$sql_hd = "SELECT * FROM tg_support WHERE is_home = '1' ORDER BY support_id DESC LIMIT 0,2";
$rs_hd = execSQL($sql_hd);
$u = 0;
while ($row_hd = mysql_fetch_assoc($rs_hd)) {
    if ($u == 0) {
        $row_hd['class'] = ' active';
    }
    if($row_hd['support_img']){
        $xtpl->assign("image", $row_hd['support_img']);
        $xtpl->parse("MAIN.HD.image");
    }
    $u++;
    $row_hd['traloi'] = sub_string($row_hd['answer'], 100, true);
    $row_hd['cauhoi'] = sub_string(strip_tags($row_hd['content']), 90, true);
    $xtpl->assign("HD", $row_hd);
    $xtpl->parse("MAIN.HD");
}
//video
$sql_video = "SELECT config_video FROM tg_config LIMIT 0,1";
$rs_video = execSQL($sql_video);
$row_video = mysql_fetch_assoc($rs_video);
$video = $row_video['config_video'];
if ($video != '') {
    $xtpl->assign('video', $video);
    $xtpl->parse("MAIN.video");
}
$xtpl->assign("header_tostring", $header_tostring);
$xtpl->assign("footer_tostring", $footer_tostring);
$xtpl->assign("left_tostring", $left_tostring);
$xtpl->assign("right_tostring", $right_tostring);
//Parse the main body
$xtpl->parse("MAIN");
eval("?" . ">" . $xtpl->text("MAIN"));
?>