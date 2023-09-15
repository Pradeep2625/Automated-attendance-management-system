<?php
// define variables and set to empty values
$name ="test";
$pwd =  "";
echo $name,$pwd;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
echo $name,$pwd;
  $name = test_input($_POST["uname"]);	
  $name = strtoupper($name);
  $pwd = test_input($_POST["pwd"]);
  $name=test_input($name);
echo $name,$pwd;
  $db = new SQLite3('D:\project\face_reco_attendance\attendancedb.db');
  $statement='select * from login where username=';
  $q='"';
  $con=' and password=';
  $sql_statement=$statement.$q.$name.$q.$con.$q.$pwd.$q;
echo $sql_statement;
  $results=$db->query($sql_statement);


if ($results !== false) {
    // Process the result set
    while ($row = $results->fetchArray()) {
        // Do something with each row
    }
} else {
    // Handle the error
}
  if($row[0]!==0){
	  session_start();
    $_SESSION['student_name'] = $name;
    header("Location: student.php");
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
        
        <noscript><meta http-equiv="refresh" content="0;url=no-js.php"></noscript>    
        
        
        <meta charset="UTF-8">
        <title> Smart Attendance Management System</title>
        <link rel="stylesheet" href="newcss.css">
	<style>
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
            <form action='index.php' method='POST'>
       	    <table>
            <tr><td><span class="caption">Student Login</span></td></tr>
            <tr><td colspan="2"><hr></td></tr>
            <tr><td>User ID number:</td></tr>
            <tr><td><input type="text" name="uname" required></td> </tr>
            <tr><td>Password:</td></tr>
            <tr><td><input type="password" name="pwd" required></td></tr>
            
            <tr><td class="button1"><input type="submit" name="submitBtn" value="Log In" class="button"></td></tr>
            </table>
            </form>
         </div>
        
       
         <?php include 'footer.php' ?>