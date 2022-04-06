<?php

//process_data.php

$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
$connect = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking

if(isset($_POST["query"]))
{	

	$data = array();

	$condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]);

	$query = "
	SELECT name FROM Attribute 
		WHERE name LIKE '%".$condition."%' 
		LIMIT 10
	";

	$result = $connect->query($query);

	$replace_string = '<b>'.$condition.'</b>';

	foreach($result as $row)
	{
		$data[] = array(
			'name'		=>	str_ireplace($condition, $replace_string, $row["name"])
		);
	}

	echo json_encode($data);
}
?>