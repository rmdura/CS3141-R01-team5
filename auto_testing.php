<?php

// Connect to database	
$config = parse_ini_file("ProjectDB.ini"); // find database info in .ini file
$dbh = new PDO($config['dsn'], $config['username'], $config['password']); // create connection to database
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // error checking

echo "<h1>Database Setup Automatic Testing</h1>";

echo "<h2>Create test data</h2>";
// Set up test data

// counter variables for successful tests
$successes = 0;
$total = 0;

echo "<h3>Try to create test users</h3>";
try{
	$setupUser1 = $dbh->query("Insert into Student(username, email, password, birthdate) values('testUser1', 'test1@mtu.edu', 'pass1', '2000-01-01')");
	$setupUser2 = $dbh->query("Insert into Student(username, email, password, birthdate) values('testUser2', 'test2@mtu.edu', 'pass2', '2000-01-01')");
	$setupUser3 = $dbh->query("Insert into Student(username, email, password, birthdate) values('testUser3', 'test3@mtu.edu', 'pass3', '2000-01-01')");
	echo '<i style="color:green;font-family:calibri ;">Test users created successfully. </i> <br> ';	
	$successes++;
	$total++; 
} catch (PDOException $e){
	echo '<i style="color:red;font-family:calibri ;">Test users unable to be created.</i> <br> ';
	$total++; 
	print $e->getMessage();
}

echo "<h3>Try to create test events</h3>";
try{
	$setupEvent1 = $dbh->query("Insert into Event(event_index, name, event_time, event_date, location, description, owner) values('100', 'testEvent1', '12:00:00', '2022-05-01', 'testLocation', 'Test Description', 'testUser1')");
	$setupEvent2 = $dbh->query("Insert into Event(event_index, name, event_time, event_date, location, description, owner) values('200', 'testEvent2', '12:00:00', '2022-05-01', 'testLocation', 'Test Description', 'testUser1')");
	$setupEvent3 = $dbh->query("Insert into Event(event_index, name, event_time, event_date, location, description, owner) values('300', 'testEvent3', '12:00:00', '2022-05-01', 'testLocation', 'Test Description', 'testUser2')");
	echo '<i style="color:green;font-family:calibri ;">Test events created successfully. </i> <br> ';
	$successes++;
	$total++; 
} catch (PDOException $e){
	echo '<i style="color:red;font-family:calibri ;">Test events unable to be created.</i> <br> ';
	$total++; 
	print $e->getMessage();
}

echo "<h3>Try to create test event-tag pairs</h3>";
try{
	$setupEventTag1 = $dbh->query("Insert into Event_Tag(event_id, tag_name) values('100', 'Bingo')");
	$setupEventTag2 = $dbh->query("Insert into Event_Tag(event_id, tag_name) values('200', 'Bingo')");
	$setupEventTag3 = $dbh->query("Insert into Event_Tag(event_id, tag_name) values('300', 'Bowling')");
	echo '<i style="color:green;font-family:calibri ;">Test event-tag pairs created successfully. </i> <br> ';
	$successes++;
	$total++; 
} catch (PDOException $e){
	echo '<i style="color:red;font-family:calibri ;">Test event-tag pairs unable to be created.</i> <br> ';
	$total++; 
	print $e->getMessage();
}

echo "<h3>Try to create test student-tag pairs</h3>";
try{
	$setupStudentTag1 = $dbh->query("Insert into Student_Tag(student_name, tag_name) values('testUser1', 'Bingo')");
	$setupStudentTag2 = $dbh->query("Insert into Student_Tag(student_name, tag_name) values('testUser2', 'Bingo')");
	$setupStudentTag3 = $dbh->query("Insert into Student_Tag(student_name, tag_name) values('testUser3', 'Bowling')");
	echo '<i style="color:green;font-family:calibri ;">Test student-tag pairs created successfully. </i> <br> ';
	$successes++;
	$total++; 
} catch (PDOException $e){
	echo '<i style="color:red;font-family:calibri ;">Test student-tag pairs unable to be created.</i> <br> ';
	$total++; 
	print $e->getMessage();
}

echo "<h3>Try to create test student-event pairs</h3>";
try{
	$setupStudentEvent1 = $dbh->query("Insert into Student_Event(student_name, event_id) values('testUser1', '100')");
	$setupStudentEvent2 = $dbh->query("Insert into Student_Event(student_name, event_id) values('testUser1', '300')");
	$setupStudentEvent3 = $dbh->query("Insert into Student_Event(student_name, event_id) values('testUser2', '100')");
	echo '<i style="color:green;font-family:calibri ;">Test student-event pairs created successfully. </i> <br> ';
	$successes++;
	$total++; 
} catch (PDOException $e){
	echo '<i style="color:red;font-family:calibri ;">Test student-event pairs unable to be created.</i> <br> ';
	$total++; 
	print $e->getMessage();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "<h2>Test Set 1: Student Table</h2>";

echo "<h3>Try to create student without username (primary key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testUser1 = $dbh->query("Insert into Student(username, email, password, birthdate) values(NULL, 'test4@mtu.edu', 'pass', '2000-01-01')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student created without username.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student without email (cannot be null)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testUser2 = $dbh->query("Insert into Student(username, email, password, birthdate) values('testUser4', NULL, 'pass', '2000-01-01')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student created without email.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student without password (cannot be null)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testUser3 = $dbh->query("Insert into Student(username, email, password, birthdate) values('testUser4', 'test4@mtu.edu', NULL, '2000-01-01')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student created without password.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student with username already in use (unique)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testUser4 = $dbh->query("Insert into Student(username, email, password, birthdate) values('testUser3', 'test4@mtu.edu', 'pass', '2000-01-01')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student created with username already in use.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student with email already in use (unique)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testUser5 = $dbh->query("Insert into Student(username, email, password, birthdate) values('testUser4', 'test1@mtu.edu', 'pass', '2000-01-01')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student created with email already in use.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student without birthdate (cannot be null)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testUser6 = $dbh->query("Insert into Student(username, email, password, birthdate) values('testUser4', 'test4@mtu.edu', 'pass', NULL)");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student created successfully with null birthdate.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "<h2>Test Set 2: Event Table</h2>";

echo "<h3>Try to create event without event_index (primary key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testEvent1 = $dbh->query("Insert into Event(event_index, name, event_time, event_date, location, description, owner) values(NULL, 'testEvent4', '12:00:00', '2022-05-01', 'testLocation', 'Test Description', 'testUser1')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event created without event_index.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student with event_index already in use (unique)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testEvent2 = $dbh->query("Insert into Event(event_index, name, event_time, event_date, location, description, owner) values('100', 'testEvent4', '12:00:00', '2022-05-01', 'testLocation', 'Test Description', 'testUser1')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event created with event_index already in use.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create event with owner not in Student table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testEvent3 = $dbh->query("Insert into Event(event_index, name, event_time, event_date, location, description, owner) values('400', 'testEvent4', '12:00:00', '2022-05-01', 'testLocation', 'Test Description', 'testUser5')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event created with owner not in Student table.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student without owner (cannot be null)</h3>";

	echo '<p>Expected Result: Successful entry.</p> <br>';

	try{
		$testEvent4 = $dbh->query("Insert into Event(event_index, name, event_time, event_date, location, description, owner) values('400', 'testEvent4', '12:00:00', '2022-05-01', 'testLocation', 'Test Description', NULL)");		
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event created successfully without owner.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "<h2>Test Set 3: Attribute (interest tag) Table</h2>";

echo "<h3>Try to create attribute without name (primary key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testAttribute1 = $dbh->query("Insert into Attribute(name) values(NULL)");		
		$total++; 
		echo '<i style="color:green;font-family:calibri ;">Actual Result: Null test attribute created.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "<h2>Test Set 4: Event_Tag Table</h2>";

echo "<h3>Try to create event_tag pair without event_id (cannot be null)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testEventTag1 = $dbh->query("Insert into Event_Tag(event_id, tag_name) values(NULL, 'bowling')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event_tag pair created without event_id.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create event_tag pair without tag_name (cannot be null)</h3>";
	
	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testEventTag2 = $dbh->query("Insert into Event_Tag(event_id, tag_name) values('100', NULL)");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event_tag pair created without tag_name.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create event_tag pair that already exists (jointly unique)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testEventTag3 = $dbh->query("Insert into Event_Tag(event_id, tag_name) values('300', 'bowling')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event_tag pair created with pair that already exists.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create event_tag pair with event_id not in Event table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testEventTag4 = $dbh->query("Insert into Event_Tag(event_id, tag_name) values('600', 'bowling')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event_tag pair created with event_id not in Event table.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create event_tag pair with tag_name not in Attribute table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testEventTag5 = $dbh->query("Insert into Event_Tag(event_id, tag_name) values('100', 'Marathon running')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event_tag pair created with tag_name not in Attribute table.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to update event_tag pair with event_id not in Event table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testEventTag6 = $dbh->query("Update Event_Tag set event_id = '600' where event_id = '100' and tag_name = 'Bingo'");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event_tag pair updated with event_id not in Event table.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to update event_tag pair with tag_name not in Attribute table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testEventTag7 = $dbh->query("Update Event_Tag set tag_name = 'Marathon running' where event_id = '100' and tag_name = 'Bingo'");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test event_tag pair updated with tag_name not in Attribute table.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "<h2>Test Set 5: Student_Event Table</h2>";

echo "<h3>Try to create student_event pair without event_id (cannot be null)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentEvent1 = $dbh->query("Insert into Student_Event(student_name, event_id) values('testUser1', NULL)");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created without event_id.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student_event pair without student_name (cannot be null)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentEvent2 = $dbh->query("Insert into Student_Event(student_name, event_id) values(NULL, '100')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created without student_name.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student_event pair that already exists (jointly unique)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentEvent3 = $dbh->query("Insert into Student_Event(student_name, event_id) values('testUser1', '100')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created with pair that already exists.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student_event pair with event_id not in Event table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentEvent4 = $dbh->query("Insert into Student_Event(student_name, event_id) values('testUser1', '800')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created with event_id not in Event table.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student_event pair with student_name not in Student table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentEvent5 = $dbh->query("Insert into Student_Event(student_name, event_id) values('testUser8', '100')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created with student_name not in Student table.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to update student_event pair with event_id not in Event table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentEvent6 = $dbh->query("Update Student_Event set event_id = '800' where student_name = 'testUser1' and event_id = '100'");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair updated with event_id not in Event table.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to update student_event pair with student_name not in Student table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentEvent7 = $dbh->query("Update Student_Event set student_name = 'testUser7' where student_name = 'testUser1' and event_id = '100'");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair updated with student_name not in Student table.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "<h2>Test Set 6: Student_Tag Table</h2>";

echo "<h3>Try to create student_tag pair without tag_name (cannot be null)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentTag1 = $dbh->query("Insert into Student_Tag(student_name, tag_name) values('testUser1', NULL)");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created without tag_name.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student_tag pair without student_name (cannot be null)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentTag2 = $dbh->query("Insert into Student_Tag(student_name, tag_name) values(NULL, 'bowling')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created without student_name.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student_tag pair that already exists (jointly unique)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentTag3 = $dbh->query("Insert into Student_Tag(student_name, tag_name) values('testUser1', 'bingo')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created with pair that already exists.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student_tag pair with tag_name not in Attribute table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentTag4 = $dbh->query("Insert into Student_Tag(student_name, tag_name) values('testUser1', 'Marathon running')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created without tag_name.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to create student_tag pair with student_name not in Student table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentTag5 = $dbh->query("Insert into Student_Tag(student_name, tag_name) values('testUser8', 'bowling')");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created without tag_name.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to update student_tag pair with tag_name not in Attribute table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentTag6 = $dbh->query("Update Student_Tag set tag_name = 'Marathon running' where student_name = 'testUser1' and tag_name = 'bingo'");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created without tag_name.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h3>Try to update student_tag pair with student_name not in Student table (foreign key)</h3>";

	echo '<p>Expected Result: Error thrown.</p> <br>';

	try{
		$testStudentTag7 = $dbh->query("Update Student_Tag set student_name = 'testUser8' where student_name = 'testUser1' and tag_name = 'bingo'");
		$total++; 
		echo '<i style="color:red;font-family:calibri ;">Actual Result: Test student_event pair created without tag_name.</i> <br> ';
	}catch (PDOException $e){
		print $e->getMessage();
		echo '<br> <i style="color:green;font-family:calibri ;">Actual Result: Error thrown.</i> <br> ';
		$successes++;
		$total++; 
	}

echo "<h2>Delete Test Data</h2>";
// Delete test data
// Due to foreign keys, deleting the test users should delete all other test data due to cascading
	echo '<p>Expected Result: Successful delete.</p>';
	echo '<i>Note: Foreign keys were created using cascading, so deleting the test users should remove all test data other than events created without an owner.</i> <br>';
	
echo "<h3>Try to delete test users 1-4</h3>";

try{
	$deleteUsers = $dbh->query("Delete from Student where username = 'testUser1' or username = 'testUser2' or username = 'testUser3' or username = 'testUser4'");
	echo '<i style="color:green;font-family:calibri ;">Test users deleted successfully. </i> <br> ';
	$successes++;
	$total++; 	
} catch (PDOException $e){
	echo '<i style="color:red;font-family:calibri ;">Test users unable to be deleted.</i> <br> ';
	$total++; 
	print $e->getMessage();
}

echo "<h3>Try to delete test event 400</h3>";

try{
	$deleteUsers = $dbh->query("Delete from Event where event_index = '400'");
	echo '<i style="color:green;font-family:calibri ;">Test event deleted successfully. </i> <br> ';
	$successes++;
	$total++; 	
} catch (PDOException $e){
	echo '<i style="color:red;font-family:calibri ;">Test event unable to be deleted.</i> <br> ';
	$total++; 
	print $e->getMessage();
}

echo "<h2>Final Results</h2>";

if ($successes == $total)
{
	echo $successes.'/'.$total.'<br>';
	echo '<i style="color:green;font-family:calibri ;">All tests passed!</i> <br> ';
	$total++; 
}
else{
	echo $successes.'/'.$total.'<br>';
	echo '<i style="color:red;font-family:calibri ;">Some tests failed</i> <br> ';
	$total++; 
}


?>