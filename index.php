<?php
$servername = "localhost";
$username = "simple-blog";
$password = "BlogSimple321";
$dbname = "simple-blog";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection gagal: " . $conn->connect_error);
}
$sql = "SELECT * from article";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	//article_id, article_date, category, title, article_content, author
        //echo "id: " . $row[""]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        echo "<h1 style ='font-size : 40px'>" . $row["title"] . "</h1>";
        echo "<p style='font-size : 14px'>" . $row["article_date"] . " &bull; " . $row["category"] . " &bull; " . $row["author"];
        echo "<p style='font-size : 20px'>" . $row["article_content"];
    }
} else {
    echo "0 results";
}
$conn->close();
?>
