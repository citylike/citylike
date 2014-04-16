<?php
function esc_html($str){
	$str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
	return $str;
}

function esc_url($str){
	$str = htmlentities(urldecode($str));
	return $str;
}
?>