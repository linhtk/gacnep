<?php 
function get_news_content($news_id){
    $sql = "SELECT news_content FROM tg_news WHERE md5(news_id) = '".$news_id."'";
    $rs = execSQL($sql);
    $row = mysql_fetch_assoc($rs);
    return $row['news_content'];
}
?>