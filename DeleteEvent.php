<!DOCTYPE html>
<html>
<?php
	$ID = $_GET['event'];
	$user = $_COOKIE['username'];
	$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
	$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
	try{
		$joinQuery = $dbh->query("Delete from Event where owner = '$user' and event_index = '$ID'");
		?>
		<script> 
			alert ("Successfully deleted event!")
			window.location.href='DashBoard.php'; 
		</script>
		<?php
	}
	catch (PDOException $e){
		?>
		<script> 
			alert ("Event could not be deleted!")
			window.location.href='DashBoard.php'; 
		</script>
		<?php
	}
?>
</html>