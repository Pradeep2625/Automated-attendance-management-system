<?php
session_start();
if(!isset($_SESSION['student_name']) || empty($_SESSION['student_name'])){

    header("Location: index.php");
    echo '<script type="text/javascript">';
    echo ' alert("login again")';  //not showing an alert box.
    echo '</script>';



}
else{
    $number=$_SESSION['student_name'];
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
        table {

  width:100%;
  height:100%;
  border:10px;
  border-color:#000;
  text-align:center;
  background: linear-gradient(to bottom, rgba(224,243,250,1) 49%,rgba(184,226,246,1) 100%,rgba(182,223,253,1) 100%);
}
#footer{
        height:50px;
        position:absolute;

    }
	</style>
    </head>
    <body>

    <?php include 'header_student.php';?>

   <!-- <form method="post" id="logout">
        <input type="submit" name="button1" value="Logout"/>
    </form>-->
    <br/>
    <form action="" method="POST" enctype="multipart/form-data">
        <table >
         <tr>
        <th>Date</th>
        <th>Attendeded</th>
        <th>Image</th>
        </tr>
        <?php

        $db = new SQLite3('D:\project\face_reco_attendance\attendancedb.db');
        $sql="select suspended from attendence where id='".$number."'";

        $statement='select * from ';
        $q='"';
        $sql_statement=$statement.$q.$number.$q;
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
        ?>

        <tr>
        <th>Total Days</th>
        <th>Attended days</th>
        <th>Percentage</th>
        <tr>
        <?php
        $sql_days_c='select count(*) from ';
        $tab_n='"working_dates"';
        $sql_statement=$sql_days_c.$tab_n;
        $results=$db->query($sql_statement);
        $row=$results->fetchArray();
        $t_days=$row[0];
        $sql_statement=$sql_days_c.$q.$number.$q;
        $results=$db->query($sql_statement);
        $row=$results->fetchArray();
        $at_days=$row[0];
        $per=round(($at_days*100)/($t_days),2);
        echo '<tr><td>'.$t_days.'</td>';
        echo '<td>'.$at_days.'</td>';
        echo '<td>'.$per.'%</td>';
        echo '</tr>'
        ?>



    <tr class="footer" id="footer">
<td colspan=3>
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
