<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head> 
<body>

<?php
// define variables and set to empty values
$username = $password = "";
$usernameErr = $passwordErr = "";

$servername = "localhost";
$usernameDB = "simple-blog";
$passwordDB = "BlogSimple321";
$dbname = "simple-blog";

// Create connection
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * from user";
$result = $conn->query($sql);

$usernameMatch = $passwordMatch = False;
$user_id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["username"])) {
    $usernameErr = "Username is required";
  } else {
    $username = test_input($_POST["username"]);
    if ($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {
    		if ($username == $row["username"]) {
    			echo $row["username"];
    			$user_id = $row["user_id"];
    			$usernameMatch = True;
    		}
    	}
	}
  }

  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
    if ($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {
    		if ($password == $row["password"] AND $user_id == $row["user_id"]){
    			$passwordMatch = True;
    		}
    	}
	}
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Username: <input type="text" name="username">
  <span class="error">* <?php echo $usernameErr;?></span>
  <br><br>
Password: <input type="password" name="password">
<span class="error">* <?php echo $passwordErr;?></span>
  <br><br>
<input type="submit">
</form>

<?php
if ($usernameMatch == True AND $passwordMatch == True) {
	session_start();
	$_SESSION["user_id"] = $user_id;
	$_SESSION["username"] = $username;
	header( "Location: localhost/post.php" );
	exit;
}else{
	$message = "Username or password do not match";
	echo "<script type='text/javascript'>alert('$message');</script>";
	//alert("Username or password do not match");
}
?>

</body>
</html>