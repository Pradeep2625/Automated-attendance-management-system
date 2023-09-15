<?php
// define variables and set to empty values
$name ="test";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["id"]);
  $name=strtoupper($name);



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
        <title>Employee Page</title>
        <link rel="stylesheet" href="newcss.css">
	<style>
		#logout{
            float:left;
        }
        #footer{
        height:50px;
        position:absolute;

    }
        table {
  position:relative;
  width:100%;
  height:100%;
  border-width: thin;
  border-color:#000;
  text-align:center;
  background: linear-gradient(to bottom, rgba(224,243,250,1) 49%,rgba(184,226,246,1) 100%,rgba(182,223,253,1) 100%);
}
    #footer{

        height:50px;

        position:relative;

    }
	</style>
    </head>
    <?php include 'header_faculty.php'?>
    <body>
    <form action='view_student.php' method='POST' enctype="multipart/form-data">
    <table>
        <tr>
        <th colspan=3>Enter Roll number:</th>
        </tr>
        <tr>
        <td><input type="text" name="id" placeholder="enter roll number" required/></td>
        </tr>
        <tr>

        <td><input type="submit" name="submitBtn" value="Submit" class="button"></td>
        </tr>
    </table>

    <?php
        if($name!=='test'){
        echo "<table>";
        echo "<tr>";
        echo "<th>Date</th>";
        echo "<th>Attendeded</th>";
        echo "<th>Image</th>";
        echo"<th>Location</th>";
        echo "</tr>";
        $db = new SQLite3('D:\project\face_reco_attendance\attendancedb.db');
        $statement='select * from ';
        $q='"';
        $sql_statement=$statement.$q.$name.$q;
        if($results = $db->query($sql_statement)){
            while($row=$results->fetchArray()){
            $date=$row[0];
            $at=$row[1];
            echo '<tr>';

            echo '<td>'.$row[0].'</td>';
            echo '<td>'.$row[1].'</td>';
            echo '<td><img src="data:image;base64,'.base64_encode($row[2]).'"alt="image" style="width:100px; height:100px;"/></td>';
            echo '</tr>';


            }
        }

        }
        ?>
        <table>
        <tr class="footer" id="footer">
<td colspan=3 >
<ul>
                    <div class="footer_content" >

                   <li><a href="#" target="_blank">SIST</a></li>
                   <li><a href="contact.php" target="_blank"> Contact</a></li>


                   <li style="padding-left:450px;">SIST ECE © All Rights Reserved</li>

                   </div>

                   </ul>


    </td>
 </div>
           </tr>
           </table>
    </form>
    </body>
</html>
