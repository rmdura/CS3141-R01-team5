<!DOCTYPE html>
<html>
<?php
	$ID = $_POST['leave'];
	$user = $_COOKIE['username'];
	$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
	$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
	try{
		$joinQuery = $dbh->query("Delete from Student_Event where student_name = '$user' and event_id = '$ID'");
		?>
		<script> 
			alert ("Successfully left!")
			window.location.href='DashBoard.php'; 
		</script>
		<?php
	}
	catch (PDOException $e){
		?>
		<script> 
			alert ("Event could not be left.")
			window.location.href='DashBoard.php'; 
		</script>
		<?php
	}
?>
</html>