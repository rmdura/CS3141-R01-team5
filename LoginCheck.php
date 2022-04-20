<!DOCTYPE html>

<html>
<?php
	if(!isset($_COOKIE['username'])) {
   	?>
	<script> 
		alert ("You must login before accessing the website!")
		window.location.href='index.php'; 
	</script>
	<?php
}
?>

</html>