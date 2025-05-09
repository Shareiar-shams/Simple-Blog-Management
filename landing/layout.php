<?php
	function limit_words($text, $limit = 300) {
	    $words = explode(' ', $text);
	    if (count($words) <= $limit) {
	        return $text;
	    }
	    return implode(' ', array_slice($words, 0, $limit)) . '...';
	}
?>

<!DOCTYPE html>
<html>
<?php include 'include/head.php' ?>
<body>
	<?php include 'include/topbar.php' ?>


	<?php include 'include/menu.php' ?>
	<!-- Main News Slider Start -->
    <div class="container-fluid">
		<?php main_section() ?>
	</div>
	<!-- Main News Slider End -->
	
	
	<?php include 'include/footer.php' ?>
	<?php include 'include/mainjs.php' ?>
</body>
</html>