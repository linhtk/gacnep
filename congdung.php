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
$page=$_POST['page']?$_POST['page']:1;
$pagegroup_size=10;
$limit=($show_result?$show_result:4);
$offset=($page-1)*$limit;
$LIMIT=" LIMIT $offset,$limit";
$id = $_REQUEST['id'];
if ($id != ''){
    $id = $id;
    $sql_tin = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = '$id' ORDER BY news_id ASC";
} else {
    $id = 126;
    $sql_tin = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id IN (126, 127, 128, 129) ORDER BY news_id ASC";
}

$rs_tin1 = execSQL($sql_tin);
$row_total=mysql_num_rows($rs_tin1);
$sql_tin.=$LIMIT;
$rs_tin=execSQL($sql_tin);
$pages=pagenavigator($page, $row_total, $limit, $pagegroup_size,'',$PHP_SELF) ;
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
$xtpl->assign("pages",$pages);

$xtpl->assign("header_tostring", $header_tostring);
$xtpl->assign("footer_tostring", $footer_tostring);
$xtpl->assign("benh_tostring", $benh_tostring);
$xtpl->assign("right_tostring", $right_tostring);
//Parse the main body
$xtpl->parse("MAIN");
eval("?" . ">" . $xtpl->text("MAIN"));
?>