<!DOCTYPE html>
<html>
<?php
session_start();
setcookie("username", "", time()-3600); // unset cookie
unset($_SESSION);
session_destroy(); // destroy session
?>
<script> 
	alert ("Successful Logout!")
	window.location.href='index.php'; 
	</script>
</html>