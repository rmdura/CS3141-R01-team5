<html>
<head>
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <title>MTU Student Socializing Platform</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
		<?php
		require_once('connection.php');
		$result = $conn->prepare("SELECT * FROM Student ORDER BY username ASC");
		$result->execute();
		?>
	<p>Successful login.</p>
</body>
</html>
