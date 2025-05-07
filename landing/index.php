<?php 
	
	function limit_words($text, $limit = 300) {
	    $words = explode(' ', $text);
	    if (count($words) <= $limit) {
	        return $text;
	    }
	    return implode(' ', array_slice($words, 0, $limit)) . '...';
	}

	function main_section(){

		include '../components/landingIndex.php';
	} 
	include('layout.php');
?>