<?php
// define variables and set to empty values
$name ="test";
$pwd =  "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["uname"]);
  $pwd = test_input($_POST["pwd"]);
  $name=test_input($name);
  $db = new SQLite3('D:\project\face_reco_attendance\attendancedb.db');
  $statement='select count(*) from admin_login where name=';
  $q='"';
  $con=' and pwd=';
  $sql_statement=$statement.$q.$name.$q.$con.$q.$pwd.$q;
  $result = $db->query("SELECT * FROM login WHERE username = '$username' AND password = '$password'");

if ($result !== false) {
    // Process the result set
    while ($row = $result->fetchArray()) {
        // Do something with each row
    }
} else {
    // Handle the error
}
  if($row[0]!==0){
	  session_start();
    $_SESSION['name'] = $name;
    header("Location: faculty_page.php");
	}
    else{
	  echo '<script type="text/javascript">';
    echo ' alert("no user found")';  //not showing an alert box.
    echo '</script>';
	  }
    
}





function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin page</title>
<link rel="stylesheet" href="newcss.css">
        <style>
	
            .content_customer ul{
                margin-left:150px;
                margin-top:50px;
            }
            .content_customer li{
                padding-top:15px;
            }
		#log{
	margin-left:350px;
	width:30%;
	height:40%;

	}
        </style>
        
       
    </head>
<body>
        <?php include 'header.php' ?>
        <div class="user_login" id="log" >
            <form action='faculty.php' method='POST'>
       	    <table align="center">
            <tr><td><span class="caption">Admin Login</span></td></tr>
            <tr><td colspan="2"><hr></td></tr>
            <tr><td>Admin Id:</td></tr>
            <tr><td><input type="text" name="uname" required></td> </tr>
            <tr><td>Password:</td></tr>
            <tr><td><input type="password" name="pwd" required></td></tr>
            
            <tr><td class="button1"><input type="submit" name="submitBtn" value="Log In" class="button"></td></tr>
            </table>
            </form>
         </div>
        
       
         <?php include 'footer.php' ?>
            