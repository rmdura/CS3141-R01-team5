<!DOCTYPE html>
<html>
<?php
	$ID = $_POST['join'];
	$user = $_COOKIE['username'];
	$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
	$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking
	try{
		$joinQuery = $dbh->query("Insert into Student_Event(student_name, event_id) values('$user', '$ID')");
		?>
		<script> 
			alert ("Successfully joined!")
			window.location.href='FindEvents.php'; 
		</script>
		<?php
	}
	catch (PDOException $e){
		?>
		<script> 
			alert ("Event could not be joined.")
			window.location.href='FindEvents.php'; 
		</script>
		<?php
	}
?>
</html>