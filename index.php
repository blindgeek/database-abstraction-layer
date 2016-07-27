<?php

/**
*
* @file index.php
* This is the index page for the database website
* We have to instanciate the Page class
* to be used in creating and displaying the page
*/

// Fetch the autoloader
require_once 'autoload.php';

$page = new Page('Database Form'); // Instanciate the Page class

// Now assign the whole text to the object property using heredoc
$page->content = <<<_END
<form id="form" class="form" action="processform.php" method="post" role="form">
<label for="fname"><span class="fieldlabel">Enter your first name:</span></label>
<input type="text" id="fname" name="fname" size="30" maxlength="30">
<label for="lname"><span class="fieldlabel">Enter your last name:</span></label>
<input type="text" id="lname" name="lname" size="30" maxlength="30">
<label for="email"><span class="fieldlabel">Enter your email:</span></label>
<input type="email" id="email" name="email" size="30" maxlength="30">
<label for="olddata"><span class="fieldlabel">Enter old data</span></label>
<input type="text" id="olddata" name="olddata" size="30" maxlength="30">
<label for="newdata"><span class="fieldlabel">Enter your new data here</span></label>
<input type="text" id="newdata" name="newdata" size="30" maxlength="30">
<label for="id"><span class="fieldlabel">Enter ID you want to delete</span></label>
<input type="number" id="id" name="id" size="3" maxlength="3">
<select name="field">
<option value="first_name">First name</option>
<option value="last_name">Last name</option>
<option value="email">Email address</option>
</select>
<label for="operation"><span class="fieldlabel">What do you want to do?</span></label>
<select id="operation" name="operation">
<option value="insert">Insert</option>
<option value="update">Update the table</option>
<option value="delete">Delete from table</option>
<option value="select">Select</option>
<option value="rowcount">Get the Number of rows</option>
<option value="truncate">Truncate table</option>
</select>
<input type="submit" name="submit" value="Query table">
</form>
_END;
$page->display(); // Display the whole page
