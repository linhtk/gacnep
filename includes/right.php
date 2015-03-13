<?php

$xtpl_right = new XTemplate("templates/right.html");
/////tab san pham
$i=0;
if($flag=='sanpham'){
    $sp = "SELECT product_id, product_name FROM tg_product WHERE product_id <> '1'";
    $rssp = execSQL($sp);
    while($rowsp = mysql_fetch_assoc($rssp)){
        $i++;
        $rowsp['i'] = $i;
        $xtpl_right->assign("TOPSP",$rowsp);
        $xtpl_right->parse("RIGHT.TOPSP");
    }
}
if($flag == 'phong'){
    $cd = "SELECT category_id, category_name FROM tg_category WHERE category_parent = 114 ORDER BY category_position ASC";
    $rscd = execSQL($cd);
    while($rowcd = mysql_fetch_assoc($rscd)){
        $i++;
        $rowcd['i'] = $i;
        $xtpl_right->assign("CD",$rowcd);
        $xtpl_right->parse("RIGHT.CD");
    }
}
/////news
$right_news = "SELECT md5(news_id) AS news_id, news_title, news_image, news_brief FROM tg_news WHERE news_is_hot = '1' AND news_active='1' ORDER BY news_date LIMIT 0 , 4";
$rs_right_news = execSQL($right_news);
$right_no = mysql_num_rows($rs_right_news);
if ($right_no) {
    while ($row_right_news = mysql_fetch_assoc($rs_right_news)) {
        if ($row_right_news['news_image']) {
            if (file_exists("upload/news/" . $row_right_news['news_image'])) {
                $row_right_news['news_image'] = '<img src="upload/news/' . $row_right_news['news_image'] . '" class="pull-left" width="120" height="89" />';
            } else {
                $row_right_news['news_image'] = "";
            }
        } else {
            $row_right_news['news_image'] = "";
        }
        $row_right_news['news_brief'] = sub_string($row_right_news['news_brief'], 50, true);
        $xtpl_right->assign("right_news", $row_right_news);
        $xtpl_right->parse("RIGHT.right_news");
    }
}
//san pham
$sql_sp = "SELECT * FROM tg_product ORDER BY product_id DESC LIMIT 0,4";
$rs_sp = execSQL($sql_sp);

while ($row_sp = mysql_fetch_assoc($rs_sp)) {
    
    if ($row_sp['product_image']) {
        if (file_exists("upload/products/" . $row_sp['product_image'])) {
            $row_sp['product_image'] = '<img src="upload/products/' . $row_sp['product_image'] . '" class="pull-left" width="120" height="89" />';
        } else {
            $row_sp['product_image'] = "";
        }
    } else {
        $row_sp['product_image'] = "";
    }
    $row_sp['product_desc'] = sub_string($row_sp['product_desc'], 50, true);
    $xtpl_right->assign("SP", $row_sp);
    $xtpl_right->parse("RIGHT.SP");
}
//quang cao
$sql_qc1 = "SELECT * FROM tg_adv WHERE adv_position = 4 ORDER BY adv_id DESC";
$rs_qc1 = execSQL($sql_qc1);
$a=0;
while ($row_qc1 = mysql_fetch_assoc($rs_qc1)) {
    if($a==0){$row_qc1['class']=' active';}
	$a++;
    if (($row_qc1['adv_image']!='')&(file_exists('upload/adv/' . $row_qc1['adv_image']))) {
        $xtpl_right->assign('RIGHTQC', $row_qc1);
        $xtpl_right->parse("RIGHT.RIGHTQC");
    }
}
//video
$sql_video = "SELECT config_video FROM tg_config LIMIT 0,1";
$rs_video = execSQL($sql_video);
$row_video = mysql_fetch_assoc($rs_video);
$video = $row_video['config_video'];
if ($video != '') {
    $xtpl_right->assign('video', $video);
    $xtpl_right->parse("RIGHT.video");
}
///
$xtpl_right->parse("RIGHT");
$right_tostring = $xtpl_right->text("RIGHT");
?>
