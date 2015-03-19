<?
	$xtpl_footer = new XTemplate ("templates/footer.html");

	$sql = "SELECT * FROM tg_config";
	$rs = execSQL($sql);
	$row = mysql_fetch_assoc($rs);
	$xtpl_footer->assign("footer_content",$row);
//san pham
$sql_sp = "SELECT * FROM tg_product ORDER BY product_id DESC";
$rs_sp = execSQL($sql_sp);
$j = 0;
while ($row_sp = mysql_fetch_assoc($rs_sp)) {
    if ($j == 0) {
        $row_sp['class'] = 'active ';
    }
    $j++;
    $row_sp['product_desc'] = sub_string(strip_tags($row_sp['product_desc']), 50, true);
    $xtpl_footer->assign('SP', $row_sp);
    $xtpl_footer->parse("FOOTER.SP");
}
	$xtpl_footer->parse("FOOTER");
	$footer_tostring = $xtpl_footer->text("FOOTER");
?>
