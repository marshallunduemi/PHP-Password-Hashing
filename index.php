<?php
/**
 * ---------------------------------------------
 *  DATABASE CONNECTION
 * ---------------------------------------------
 */

// Database credentials
$host = "localhost";
$user = "root";    // change to your DB username
$pass = "";        // change to your DB password
$db   = "tutorials";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}



/**
 * ---------------------------------------------
 *  PASSWORD HASHING & INSERTING INTO DATABASE
 * ---------------------------------------------
 *
 * This section demonstrates how to:
 * - Create a secure password hash
 * - Insert the hash into a database
 */

// Example plain password
$password = 'password1234';

// Generate a secure bcrypt hash
// $hash = password_hash($password, PASSWORD_BCRYPT);

// // Insert hashed password into the database
// $qryinsert = $conn->prepare("INSERT INTO password_test (hash_password) VALUES (?)");
// $qryinsert->bind_param("s", $hash);

// if ($qryinsert->execute()) {
//     echo "Password hash inserted successfully.<br>";
//     echo "Hashed Password: " . $hash . "\n";
// } else {
//     echo "Error inserting password hash: " . $qryinsert->error . "\n";
// }



/**
 * ---------------------------------------------
 *  FETCH STORED HASH FROM DATABASE
 * ---------------------------------------------
 *
 * We fetch a hash using pass_id (an integer primary key)
 * Never try to fetch hash by comparing it to plain password.
 */

$pass_id = 5; // ID of the record you want to verify

$qryselect = $conn->prepare("SELECT hash_password FROM password_test WHERE pass_id = ?");
$qryselect->bind_param("i", $pass_id);
$qryselect->execute();

// Fetch result as associative array
$result = $qryselect->get_result();
$data = $result->fetch_assoc();
$qryselect->close();

// Extract stored hash or set to null if not found
$storedHash = $data['hash_password'] ?? null;

//echo $storedHash;


/**
 * ---------------------------------------------
 *  VERIFY PASSWORD
 * ---------------------------------------------
 *
 * password_verify() compares:
 *    - User's entered password
 *    - Stored hash from database
 */

if ($storedHash && password_verify($password, $storedHash)) {
    echo "Correct password";
} else {
    echo "Incorrect password";
}

/**
 * ---------------------------------------------
 *  CLOSE DATABASE CONNECTION
 * ---------------------------------------------
 */

$conn->close();

?>
