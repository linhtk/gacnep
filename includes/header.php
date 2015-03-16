<?php

$xtpl_header = new XTemplate("templates/header.html");
switch ($flag) {
    case 'index':
        $index = 'active';
        $xtpl_header->assign('index', $index);
        break;
    case 'benh':
        $benh = 'active';
        $xtpl_header->assign('benh', $benh);
        break;
    case 'phong':
        $phong = 'active';
        $xtpl_header->assign('phong', $phong);
        break;
    case 'hoidap':
        $hoidap = 'active';
        $xtpl_header->assign('hoidap', $hoidap);
        break;
    case 'tin':
        $tin = 'active';
        $xtpl_header->assign('tin', $tin);
        break;
    case 'share':
        $share = 'active';
        $xtpl_header->assign('share', $share);
        break;
    case 'lienhe':
        $lienhe = 'active';
        $xtpl_header->assign('lienhe', $lienhe);
        break;
    case 'sanpham':
        $sanpham = 'active';
        $xtpl_header->assign('sanpham', $sanpham);
        break;
    case 'nghiencuu':
        $nghiencuu = 'active';
        $xtpl_header->assign('nghiencuu', $nghiencuu);
        break;
}
$sql_sub = "SELECT * FROM tg_category WHERE category_parent = 114 ORDER BY category_position ASC";
$rs_sub = execSQL($sql_sub);
while($row_sub = mysql_fetch_assoc($rs_sub)){
    $xtpl_header->assign("sub",$row_sub);
    $xtpl_header->parse("HEADER.sub");
}
if($flag=='index'){
    $xtpl_header->parse("HEADER.slide");
}
$gac = get_menu_name(113);
$congdung = get_menu_name(114);
$nghiencuu = get_menu_name(130);
$tintuc = get_menu_name(117);
$xtpl_header->assign('gac',$gac);
$xtpl_header->assign('congdung',$congdung);
$xtpl_header->assign('nghiencuu',$nghiencuu);
$xtpl_header->assign('tintuc',$tintuc);

$sql = "SELECT config_title_site, config_phone FROM tg_config";
$rs = execSQL($sql);
$row = mysql_fetch_assoc($rs);
$xtpl_header->assign("title", $row['config_title_site']);
$xtpl_header->assign("phone", $row['config_phone']);
$xtpl_header->parse("HEADER");
$header_tostring = $xtpl_header->text("HEADER");
function get_menu_name($id){
    $sql = "SELECT category_name FROM tg_category WHERE category_id='$id'";
    $rs = execSQL($sql);
    $row = mysql_fetch_assoc($rs);
    return $row['category_name'];
}
?>
