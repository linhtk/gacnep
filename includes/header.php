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
}
if($flag=='index'){
    $xtpl_header->parse("HEADER.slide");
}
$sql = "SELECT config_title_site, config_phone FROM tg_config";
$rs = execSQL($sql);
$row = mysql_fetch_assoc($rs);
$xtpl_header->assign("title", $row['config_title_site']);
$xtpl_header->assign("phone", $row['config_phone']);
$xtpl_header->parse("HEADER");
$header_tostring = $xtpl_header->text("HEADER");
?>
