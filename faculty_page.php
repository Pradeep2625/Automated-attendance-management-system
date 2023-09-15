<?php
$year='';
session_start();
if(!isset($_SESSION['name']) || empty($_SESSION['name'])){

    header("Location: faculty.php");
    echo '<script type="text/javascript">';
    echo ' alert("login again")';  //not showing an alert box.
    echo '</script>';

    
}
else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $year=$_POST["year"];
}
?>
<!DOCTYPE html>

<html>
    <head>
        
        <noscript><meta http-equiv="refresh" content="0;url=no-js.php"></noscript>    
        
        
        <meta charset="UTF-8">
        <title>Student Page</title>
        <link rel="stylesheet" href="newcss.css">
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="table2excel.js" type="text/javascript"></script>
	<style>
    .dropdown-submenu {
  position: relative;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}
		#logout{
            float:left;
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
        position:absolute;

    }
    
	</style>
    
    </head>
    <body>
    <?php include 'header_faculty.php'?>
    <body>  
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#printTbl").table2excel({
                filename: "Table.xls"
            });
        });
    });
</script>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="year" placeholder="enter year"/>
        <input type="submit" name="submitBtn" value="Enter" class="button"/>

        <table id="printTbl" >
         <tr>
        <th>Student Id</th>
        <th>Total Days</th>
        <th>Attended days</th>
        <th>Percentage</th>
        </tr>

        <?php
        if($year!==''){
        $db = new SQLite3('D:\project\face_reco_attendance\attendancedb.db');
        $sql_days_c='select count(*) from working_dates';
        $results=$db->query($sql_days_c);
        $row=$results->fetchArray();
        $t_days=$row[0];
        $statement='select * from attendance where year="';
        $statement=$statement.$year.'" and suspended="no" order by id';
        if($results = $db->query($statement)){
            while($row=$results->fetchArray()){
            $date=$row[0];
            $at=$row[2];
            $per=round(($at*100)/$t_days,2);
            echo '<tr>';

            echo '<td>'.$row[0].'</td>';
            echo '<td>'.$t_days.'</td>';
            echo '<td>'.$at.'</td>';
            echo '<td>'.$per.'%</td>';
            echo '</tr>';
        

            }
        }
    }
        ?>
</table>
<input type="button" id="btnExport" value="Export" />
<table>
<tr class="footer" id="footer">
<td colspan=4>
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
    </body>
</html> 