<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
          
           <div class="col-6">
            <a href="admindashboard.php"><button type="button" class="btn btn-primary" style="margin-top:10px;margin-left:10px;margin-bottom:10px;">Back to Dashboard</button></a>
            </div>
            <div class="col-6">
            <!-- <a href="#"><button type="button" class="btn btn-primary" style="margin-top:10px;margin-left:10px;margin-bottom:10px;float:right;">Download as Excel</button></a> -->
            </div>
            <main role="main" class=" px-4">
<center> <h3>Guide Allotment Details</h3> </center>
                <hr>
                <form action="guideallotmentresults.php" method="POST">
                <div class="table-responsive">
                   <center>
                   <div class="dropdown">
                     
                <span>&nbsp;&nbsp;&nbsp;Branch</span>
                <select id="branch" name="field4">
                  <!-- <optgroup> -->
                 
                    <option value="0"><b>Select Branch</b></option>
                    <option value=1  <?php $val1=1?>>CMPN</option>
                    <option value=2  <?php $val1=2?>>IT</option>
                    <option value=3  <?php $val1=3?>>EXTC</option>
                    <option value=4  <?php $val1=4?>>ETRX</option>
                    <option value=5  <?php $val1=5?>>BIOM  </option>
                  <!-- </optgroup> -->
                </select>
               
               
                <span>&nbsp;&nbsp;&nbsp;Year</span>
                <select id="year" name="fieldyear">
                  <!-- <optgroup> -->
                    <option value="0"><b>Select Year</b></option>

                    <option value=1>FE</option>
                    <option value=2>SE</option>
                    <option value=3>TE</option>
                    <option value=4>BE</option>
                  <!-- </optgroup> -->
                </select>

              
             
              
              
              <input id="sub1" type="submit" name="submit" value="Submit"/>      
              </div>      
              </form> 
              <?php 
              
              
              ?>
<style>
 table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;

}

tr:nth-child(even) {
    background-color: white;
}
#sub1{
   
    margin:5px;
    margin-left: 20px;
   padding: 2px;
}
.dropdown{
  margin:10px;
  display:inline-block;
}

</style>

  
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "frepo2";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
//displaying data on page from database
if(isset($_POST['submit'])){
  $dept= $_POST['field4'];
  $yr=$_POST['fieldyear'];
  $dept=(int)$dept;
  $yr=(int)$yr;
  echo $dept,$yr;
if($dept!=0 && $yr!=0){
$sql= "SELECT domain.domain_name,student_guide_form.user_id,department.department_title,student_guide_form.year_study,mentor.mentor_name,student_guide_form.mem_1_lead,student_guide_form.mem_2,student_guide_form.mem_3,student_guide_form.mem_4,student_guide_form.roll_no_1,student_guide_form.roll_no_2,student_guide_form.roll_no_3,student_guide_form.roll_no_4
FROM domain, department, mentor,student_guide_form,alloted_guide 
WHERE student_guide_form.domain_id=domain.domain_id AND student_guide_form.department_id=department.department_id AND  student_guide_form.user_id=alloted_guide.team_leader_id AND alloted_guide.mentor_id=mentor.mentor_id 
AND student_guide_form.department_id=$dept AND student_guide_form.year_study=$yr ";}
elseif($dept==0 && $yr>0){
  $sql= "SELECT domain.domain_name,student_guide_form.user_id,department.department_title,student_guide_form.year_study,mentor.mentor_name,student_guide_form.mem_1_lead,student_guide_form.mem_2,student_guide_form.mem_3,student_guide_form.mem_4,student_guide_form.roll_no_1,student_guide_form.roll_no_2,student_guide_form.roll_no_3,student_guide_form.roll_no_4
  FROM project, domain, department, mentor,student_guide_form,alloted_guide 
  WHERE student_guide_form.domain_id=domain.domain_id AND student_guide_form.department_id=department.department_id AND  student_guide_form.user_id=alloted_guide.team_leader_id AND alloted_guide.mentor_id=mentor.mentor_id 
  AND  student_guide_form.year_study=$yr ";
}
elseif($yr==0 && $dept>0){
  $sql= "SELECT domain.domain_name,student_guide_form.user_id,department.department_title,student_guide_form.year_study,mentor.mentor_name,student_guide_form.mem_1_lead,student_guide_form.mem_2,student_guide_form.mem_3,student_guide_form.mem_4,student_guide_form.roll_no_1,student_guide_form.roll_no_2,student_guide_form.roll_no_3,student_guide_form.roll_no_4
  FROM project, domain, department, mentor,student_guide_form,alloted_guide 
  WHERE student_guide_form.domain_id=domain.domain_id AND student_guide_form.department_id=department.department_id AND  student_guide_form.user_id=alloted_guide.team_leader_id AND alloted_guide.mentor_id=mentor.mentor_id 
  AND  student_guide_form.department_id=$dept ";
}

else{
  $sql= "SELECT domain.domain_name,student_guide_form.user_id,department.department_title,student_guide_form.year_study,mentor.mentor_name,student_guide_form.mem_1_lead,student_guide_form.mem_2,student_guide_form.mem_3,student_guide_form.mem_4,student_guide_form.roll_no_1,student_guide_form.roll_no_2,student_guide_form.roll_no_3,student_guide_form.roll_no_4
FROM project, domain, department, mentor,student_guide_form,alloted_guide 
WHERE student_guide_form.domain_id=domain.domain_id AND student_guide_form.department_id=department.department_id AND  student_guide_form.user_id=alloted_guide.team_leader_id AND alloted_guide.mentor_id=mentor.mentor_id 
ORDER BY  student_guide_form.department_id";

}



$result = mysqli_query($conn, $sql);
//$row = mysqli_fetch_array($result);
//print_r($row);

//}

if ( mysqli_num_rows($result) > 0  ) {
?>
  <!-- <table>

  <tr>
    <th>Domain</th>
   
    <th>Department</th>
	<th>Year</th>
	<th>Guide/Mentor</th>
	<th>Member 1 (Leader)</th>
	<th>Member 2</th>
	<th>Member 3</th>
	<th>Member 4</th> -->

  <form method="POST" id="convert_form" action="export.php">
            <table class="table table-striped table-bordered" id="table_content">

  <tr>
    <th>Domain</th>
   
    <th>Department</th>
	<th>Year</th>
	<th>Guide/Mentor</th>
  <th>Roll No 1</th>
	<th>Member 1 (Leader)</th>
  <th>Roll No 2</th>
	<th>Member 2</th>
  <th>Roll No 3</th>
	<th>Member 3</th>
  <th>Roll No 4</th>
	<th>Member 4</th>
    
<?php
    foreach($result as $row)
    {
      echo '
      <tr>
        <td>'.$row["domain_name"].'</td>
        <td>'.$row["department_title"].'</td>
        <td>'.$row["year_study"].'</td>
        <td>'.$row["mentor_name"].'</td>
        <td>'.$row["roll_no_1"].'</td>
        <td>'.$row["mem_1_lead"].'</td>
        <td>'.$row["roll_no_2"].'</td>
        <td>'.$row["mem_2"].'</td>
        <td>'.$row["roll_no_3"].'</td>
        <td>'.$row["mem_3"].'</td>
        <td>'.$row["roll_no_4"].'</td>
        <td>'.$row["mem_4"].'</td>
      </tr>
      ';
    }
    ?>


</table>
<input type="hidden" name="file_content" id="file_content" />
  <button type="button" name="convert" id="convert" class="btn btn-primary">Convert</button>
</form>
 <?php
}
else{
    echo "No entries found";
}
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 </body>
</html>

<script>
$(document).ready(function(){
 $('#convert').click(function(){
    var table_content = '<table>';
    table_content += $('#table_content').html();
    table_content += '</table>';
    $('#file_content').val(table_content);
    $('#convert_form').submit();
  });
});
</script>
