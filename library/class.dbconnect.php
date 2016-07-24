<?php

/**
*
* @file class-dbconnect.php
* This is a database wrapper for PDO or
* a database abstraction layer.
*
* With this class you can open and close a
* database connection, add and delete rows,
* make a query and delete a table.
* @author Joey Garcia
* @version Release: 1.0
* @copyright 2016
*/
class DbConnect
{

/**
*
* Class properties that are used to hold the database credentials
*/
protected $host;
protected $username;
protected $password;
protected $dbname;

/**
*
* Class property to hold the database connection
*/
protected $conn;

/**
*
* Class property Used to hold the results from a query
*/
protected $stmt;

/**
*
* Returned results from a query
*/
protected $row;
protected $rows;

/**
*
* Class property to hold the total row count from a query.
*/
protected $row_count;

/**
*
* Hold the database status
* Value true if the connection is active
* Value false if disconnected
*/
protected $is_connected;

/**
*
* Constructor
*/
public function __construct($host, $dbname, $username, $password)
{
$this->host = $host;
$this->dbname = $dbname;
$this->username = $username;
$this->password = $password;
}

/**
*
* Open database connection method
*/
public function openConnection()
{
$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';';
$this->conn = new PDO($dsn, $this->username, $this->password);
$this->is_connected = true;

/* Validate if the connection is active or not. */
if (!$this->checkDatabaseConnection()) {
throw new PDOException('Error connecting to the database.');
}

/* Set the default attributes. */
$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}

/**
*
* Method to close the database connnection
*/
public function closeConnection()
{
$this->conn = null;
$this->is_connected = false;
}

/**
*
* Method for making a query.
*/
public function executeQuery($sql, array $data = null)
{
$this->stmt = $this->conn->prepare($sql);

if (!$this->stmt->execute($data)) {
throw new Exception('There\'s Errors with your query.');
}

return $this->stmt;
}

/**
*
* Method to get the last inserted id
*/
public function getLastInserted_id()
{
return $this->conn->lastInsertId();
}

/**
*
* Method for fetching a single row
*/
public function getRow($sql, $data = null)
{
$this->executeQuery($sql, $data);
return $this->row = $this->stmt->fetch();
}

/**
*
* Method for fetching multiple rows
*/
public function getRows($sql, $data = null)
{
$this->executeQuery($sql, $data);
return $this->rows = $this->stmt->fetchAll();
}

/**
*
* Method for getting the total number of rows
*/
public function getRowCount()
{
return $this->row_count = $this->stmt->rowCount();
}

/**
*
* Returns true if row count is greater than 0 Returns false otherwise
*/
public function hasResults()
{
        return $this->getRowCount() > 0 ? true : false;
    }

/**
*
* Method to truncate a table
*/
public function deleteTable($table)
{
$sql = 'TRUNCATE ' . $table;
$this->executeQuery($sql);
$this->stmt->execute();
}

public function checkDatabaseConnection()
{
return $this->is_connected ? true : false;
}
}
