<?php

function get_category_type($id) {
    $category_type = '<select name="adv_position">';
    $arrName = array(1=>'Trang chủ',2=>'Chân menu con',3=>'Chân bài viết chi tiết',4=>'Bên phải');
    for($i=1; $i<=4; $i++){
        if($id==$i){
            $category_type .= '<option value="'.$i.'" selected="selected">'.$arrName[$i].'</option>';
        }else{
            $category_type .= '<option value="'.$i.'">'.$arrName[$i].'</option>';
        }
    }
    $category_type .= '</select>';
    return $category_type;
}

function get_cate_name($id) {
    switch ($id) {
        case 1:
            $cate_name = 'Trang chủ';
            break;
        case 2:
            $cate_name = 'Chân menu con';
            break;
        case 3:
            $cate_name = 'Chân bài viết chi tiết';
            break;
        case 4:
            $cate_name = 'Bên phải';
            break;
    }
    return $cate_name;
}

?>