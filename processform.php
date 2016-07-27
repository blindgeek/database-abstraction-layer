<!DOCTYPE html>
<html>
<head
<title>Process Form</title>
<meta charset="UTF-8">
</head>
<body>
<?php
require_once 'autoload.php';
require_once 'config/config.php';

/**
*
* @file processform.php
*
* Open a database connection
* Query the database
* Display the result
*/

// Check whether the submit is set
if (isset($_POST['submit'])) {

// Short variable names
$fname = clean_data($_POST['fname']);
$lname = clean_data($_POST['lname']);
$email = clean_data($_POST['email']);
$old_data = clean_data($_POST['olddata']);
$new_data = clean_data($_POST['newdata']);
$field = clean_data($_POST['field']);
$id = clean_data($_POST['id']);
$id = (int)$id;
$operation = clean_data($_POST['operation']);

// Get the database credentials
$host = $config['db']['host'];
$dbname = $config['db']['dbname'];
$username = $config['db']['username'];
$password = $config['db']['password'];

// Instanciate the database class
try {
$pdo = new DbConnect($host, $dbname, $username, $password);
$pdo->openConnection();
} catch (PDOException $e) {
echo 'Unable to connect to the database.' . '<br>' . $e->getMessage();
echo '<a href="index.php">Go back to the form</a>';
exit;
}

// Select an option
switch ($operation) {
case 'insert':
if (empty($fname) || empty($lname) || empty($email)) {
$error = 'Required fields are missing.' . '<br>' . '<a href="index.php">Go back to the previous page.</a>';
echo $error, '<br>';
exit;
}

$stmt = $pdo->executeQuery('INSERT INTO contacts (first_name, last_name, email) VALUES (:fname, :lname, :email)', array('fname' => $fname, 'lname' => $lname, 'email' => $email));

$message = 'Successfully inserted ' . $pdo->getRowCount() . ' new data.';
echo $message . '<br>';
echo 'Last ID inserted: ', $pdo->getLastInsertedId(), '<br>';
echo '<a href="index.php">Go back to the form.</a>';
break;
case 'update':
switch ($field) {
case 'first_name':
$pdo->executeQuery('UPDATE contacts SET first_name = ? WHERE first_name = ?', array($new_data, $old_data));

if ($pdo->hasResults()) {
echo 'Successfully changed your first name from ', $old_data, ' to ', $new_data, '. ', '<br>';
echo '<a href="index.php">Go back to the form.</a>';
} else {
echo 'Error updating the table. Check your input.', '<br>';
echo '<a href="index.php">Go back to the form.</a>';
}
break;
case 'last_name':
$pdo->executeQuery('UPDATE contacts SET last_name = ? WHERE last_name = ?', array($new_data, $old_data));

if ($pdo->hasResults()) {
echo 'Successfully changed your last name from ', $old_data, ' to ', $new_data, '. ', '<br>';
echo '<a href="index.php">Go back to the form.</a>';
} else {
echo 'Error updating the table. Check your input.', '<br>';
echo '<a href="index.php">Go back to the form.</a>';
}
break;
case 'email':
$pdo->executeQuery('UPDATE contacts SET email = ? WHERE email = ?', array($new_data, $old_data));

if ($pdo->hasResults()) {
echo 'Successfully changed your email from ', $old_data, ' to ', $new_data, '. ', '<br>';
echo '<a href="index.php">Go back to the form.</a>';
} else {
echo 'Error updating the table. Please check your input.', '<br>';
echo '<a href="index.php">Go back to the form.</a>';
}
break;
default:
echo 'Unable to update.', '<br>';
exit;
break;
}
break;
case 'select':
echo '<h3>Current data</h3>', '<br>';
get_data();
echo '<a href="index.php">Go back to the form.</a>';
break;
case 'rowcount':
$pdo->getRows('SELECT * FROM contacts');
$row = $pdo->getRowCount();
echo 'There ', $row == 1 ? 'is ' : 'are ', $row, ' ', $row == 1 ? 'row ' : 'rows ', 'in the table.', '<br>';
echo '<a href="index.php">Go back to the form.</a>';
break;
case 'delete':
$pdo->executeQuery('DELETE FROM contacts WHERE ID = ?', array($id));

if ($pdo->hasResults()) {
echo 'Successfully deleted ID number ', $id, '.', '<br>';
echo 'You deleted ', $pdo->getRowCount(), ' row in the table.', '<br>';
$pdo->getRows('SELECT * FROM contacts');
echo 'Only ', $pdo->getRowCount(), ' rows left.', '<br>';
echo '<a href="index.php">Go back to the form.</a>';
} else {
echo 'There\'s an error.', '<br>';
echo '<a href="index.php">Go back to the form.</a>';
}
break;
case 'truncate':
$pdo->getRows('SELECT * FROM contacts');

if (!$pdo->hasResults()) {
$error = 'Error truncating the table.' . '<br>';
echo $error, '<br>';
echo '<a href="index.php">Go back to the form.</a>';
exit;
} else {
$pdo->deleteTable('contacts');
echo 'Successfully truncated the table!', '<br>';
echo 'Table now has ', $pdo->getRowCount(), ' rows.', '<br>';
}
echo '<a href="index.php">Go back to the form.</a>';
break;
default:
echo 'Nothing selected.', '<br>';
break;
}

$pdo->closeConnection();
} else {
echo 'You did not access the form.';
exit;
}

// Function to clean the data coming from the form
function clean_data($data)
{

// Sanitize the $data variable
$data = trim($data);
$data = strip_tags($data);
$data = addslashes($data);
return $data; // Return the cleaned $data
}

// Function to query and display the rows from a database table
function get_data()
{
global $pdo; // Make the $pdo accessible globally

$rows = $pdo->getRows('SELECT * FROM contacts');

if ($pdo->hasResults()) {
echo '<table id="tabledisplay">';
echo '<tr><th>ID</th><th>First name</th><th>Last name</th><th>Email</th></tr>';

foreach ($rows as $row) {
echo '<tr><th>', $row['id'], '</th>';
echo '<td>', $row['first_name'], '</td>';
echo '<td>', $row['last_name'], '</td>';
echo '<td>', $row['email'], '</td></tr>';
}
echo '</table>';
} else {
echo '0 records found.', '<br>';
}
}
?>
</body>
</html>