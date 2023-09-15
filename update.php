<?php
$year='';
$db = new SQLite3('D:\project\face_reco_attendance\attendancedb.db');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value = $_POST["deletestudent"];
      if($value=='submit' && $_POST["suspend"]=='suspend'){
         $name=$_POST["st_id"];
         $name=strtoupper($name);
         $sql='Update attendance set suspended="yes" where id="';
         $sql=$sql.$name.'"';
         try{
        $results=$db->query($sql);
         
         if($results){
          echo '<script>alert("Student Suspended")</script>';
         }
         else{
          echo '<script>alert("not table found")</script>';
         }
         }
         catch(Exception $e){
          echo '<script>alert("Something Went Wrong....")</script>';
         }

    }
    else if($value=="submit" && $_POST["suspend"]=="unsuspend"){
      $name=$_POST["st_id"];
         $name=strtoupper($name);
         $sql='Update attendance set suspended="no" where id="';
         $sql=$sql.$name.'"';
         try{
         $results=$db->query($sql);
         
         if($results){
          echo '<script>alert("Student is UnSuspended")</script>';
         }
         else{
          echo '<script>alert("not table found")</script>';
         }
         }
         catch(Exception $e){
          echo '<script>alert("Something Went Wrong....")</script>';
         }
    }
    else if($value=="submit" && $_POST["attendance"]=="add"){
        $name=$_POST["st_id"];
        $name=strtoupper($name);
        $date=$_POST["date"];
        #echo $date;
        $sql="select count(*) from working_dates where date='".$date."'";
        $results=$db->query($sql);
        $row=$results->fetchArray();
        if($row[0]>0){
        $sql="Insert into '";
        $sql=$sql.$name."'(date,attend) values('".$date."','yes')";

        
        #echo $sql;
        try{
        $results=$db->query($sql);
        if($results){
          $sql="select count(*) from '".$name."'";
          $results=$db->query($sql);
          $row=$results->fetchArray();
          $at=$row[0];
          $sql="select count(*) from working_dates";
          $results=$db->query($sql);
          $row=$results->fetchArray();
          $td=$row[0];
          $per=round(($at*100)/$td,2);
          $per=intval($per);
          $sql="update attendance set attended=".$at." where id='".$name."'";
          $results=$db->query($sql);
          $sql="update attendance set percentage=".$per." where id='".$name."'";
          #echo $sql;
          $results=$db->query($sql);
          if($results){
          echo '<script>alert("Attendance Added")</script>';
          }
        }
        else{
            $msg="not deleted because table not available";
        }
        }
        catch(Exception $e){
           $msg=$e;
        }
      }
      else{
        echo '<script>alert("date is not a working day")</script>';
      }



   }
   else if($value=="submit" && $_POST["attendance"]=="remove"){
    $name=$_POST["st_id"];
    $name=strtoupper($name);
    $date=$_POST["date"];
    $sql="delete from '".$name."' WHERE date='".$date."'";
    try{
    $results=$db->query($sql);
    if($results){
      $sql="select count(*) from '".$name."'";
      $results=$db->query($sql);
      $row=$results->fetchArray();
      $at=$row[0];
      $sql="select count(*) from working_dates";
      $results=$db->query($sql);
      $row=$results->fetchArray();
      $td=$row[0];
      $per=round(($at*100)/$td,2);
      $per=intval($per);
      $sql="update attendance set attended=".$at." where id='".$name."'";
      $results=$db->query($sql);
      $sql="update attendance set percentage=".$per." where id='".$name."'";
          #echo $sql;
      $results=$db->query($sql);
      if($results){
      echo '<script>alert("Attendance removed")</script>';
          }
    }
    else{
        $msg="not deleted because row not available";
    }
    }
    catch(Exception $e){
       $msg=$e;
    }
  
}


   else if($value=="condation"){
    $year=$_POST["c_year"];

}
else{
  echo 'hello';
}


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
  body{
    background: linear-gradient(to bottom, rgba(224,243,250,1) 49%,rgba(184,226,246,1) 100%,rgba(182,223,253,1) 100%); 

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
}
    #footer{
        height:50px;
        position:absolute;

    }
    .invisible_div{
        float:center;
        position:relative;
        height:100%;
        width:100%;
        margin: 0 auto;
        padding: 20px;
        text-align:center;
        display:none;

    }
    .left{
      left:1px;
      height:200px;
      width:18%;
      float:left;
      margin:5px;
      border:1px solid dodgerblue;
      border-radius:5px;
      text-align:center;

    }
    .right{
      height:500px;
      float:right;
      width:80%;
      margin:5px;
      border:1px solid dodgerblue;
      border-radius:5px;
      text-align:center;

    }
	</style>
  <script>
           function delete_student() {
             $msg='';
                var x = document.getElementById("deletestudent");
                var y = document.getElementById("Add_attendance");
                var z = document.getElementById("delete_attendence");
                if (x.style.display === "none") {
    x.style.display = "block";
    y.style.display = "none";
    z.style.display = "none";
    } else {
    x.style.display = "none";
  }
}
function modify() {
  $msg='';
    var x = document.getElementById("deletestudent");
var y = document.getElementById("Add_attendance");
var z = document.getElementById("delete_attendence");
  if (y.style.display === "none") {
    y.style.display = "block";
    x.style.display = "none";
    z.style.display = "none";
  } else {
    y.style.display = "none";
  }
}
function condation() {
  $msg='';
    var x = document.getElementById("deletestudent");
var y = document.getElementById("Add_attendance");
var z = document.getElementById("delete_attendence");
  if (z.style.display === "none") {
    z.style.display = "block";
    y.style.display = "none";
    x.style.display = "none";
  } else {
    z.style.display = "none";
  }
}

 

  </script>
    </head>
    <?php include 'header_faculty.php'?>
    <body>
    
    <table>
        <tr><td class="button1"><Button onclick="modify()">Modify</button></td>
        <td class="button1"><Button onclick="condation()">condation</button></td>
        <td class="button1"><Button onclick="delete_student()">Suspend</button></td>
        </tr>
    </table>
     <div id="deletestudent" class="invisible_div">
      <div class="left">
        <h4>Suspend Student</h4>
        <br/>
        <form action="update.php" method="POST">
        <input type="radio" id="s_add" name="suspend" value="suspend"/>
        <label for="male">Suspend</label><br>
        <input type="radio" id="s_remove" name="suspend" value="unsuspend"/>
        <label for="female">Unsuspend</label><br>
            <input type="text" name="st_id" placeholder="enter roll number"/>
            <br/>
            <input type="submit" name="deletestudent" value="submit" class="button"/>
            </form>
      </div>
      
      <div class="right">
      
      </div>
      


    </div>
    <div id="Add_attendance" class="invisible_div">
      <div class="left">
        <h4>Modify Attendance</h4>
        <br/>
        <form action="update.php" method="POST">
        <input type="radio" id="at_add" name="attendance" value="add"/>
        <label for="male">Add</label><br>
        <input type="radio" id="at_remove" name="attendance" value="remove"/>
        <label for="female">Remove</label><br>
            <input type="text" name="st_id" placeholder="enter roll number"/>
            <br/>
            <input type="text" name="date" placeholder="yyyy-mm-dd"/>
            <br/>
            <input type="submit" name="deletestudent" value="submit" class="button"/>
            </form>
      </div>
      
      <div class="right">
      
      </div>
    </div>
    <div id="delete_attendence" class="invisible_div">
        <lable>Condation List</lable>
        <script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#printTbl").table2excel({
                filename: "Table.xls"
            });
        });
    });
    </script>
        <br/>
        <input type="button" id="btnExport" value="Export" />
        <form action="update.php" method="POST">
            <input type="text" name="c_year" placeholder="enter year">
            <br/>
            <input type="submit" name="deletestudent" value="condation" class="button">
            </form>
            <table id="printTbl" >
         <tr>
        <th>Student Id</th>
        <th>Total Days</th>
        <th>Attended days</th>
        <th>Percentage</th>
        </tr>

        <?php
        if($year!==''){
        $db = new SQLite3('E:\4-2\face_reco_attendance\attendancedb.db');
        $sql_days_c='select count(*) from working_dates';
        $results=$db->query($sql_days_c);
        $row=$results->fetchArray();
        $t_days=$row[0];
        $statement='select * from attendance where year="';
        $statement=$statement.$year.'" and suspended="no" and percentage<75 order by id';
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
    </div>

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