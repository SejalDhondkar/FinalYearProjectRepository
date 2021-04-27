<?php
session_start();

require_once "pdo.php";

// Demand a GET parameter
if ( ! isset($_SESSION['username']) || strlen($_SESSION['username']) < 1  ) {
    die('Name parameter missing');
}


if(isset($_SESSION['username'])){
  $stmtb = $pdo->prepare('SELECT * FROM vdummy WHERE name=:urnm');
  $stmtb->execute(array(
	  ':urnm' => $_SESSION['username'])
	);
  $rowb = $stmtb->fetchAll(PDO::FETCH_ASSOC);
}

if(isset($_POST['submit'])){

  if(1){

try{
  $stmt = $pdo->prepare('INSERT INTO student_guide_form
	  (user_id, department_id, year_study, mem_1_lead,roll_no_1,mem_2,roll_no_2,mem_3,roll_no_3,mem_4,roll_no_4,domain_id,teacher_1_id,teacher_2_id,teacher_3_id)
     VALUES (:user_id, :branch, :year, :name1, :roll1, :name2, :roll2, :name3, :roll3, :name4, :roll4, :domain, :guide1, :guide2, :guide3)');

	$stmt->execute(array(
	  // ':title' => $_POST['fiel1'],
	  // ':year' => $_POST['year'],
    ':branch'=>(int)$_POST['field4'],
    ':year'=>$_POST['fieldyear'],
    ':name1'=>$_POST['field1'],
    ':roll1'=>$_POST['a1'],
    ':name2'=>$_POST['fielda'],
    ':roll2'=>$_POST['a2'],
    ':name3'=>$_POST['fieldb'],
    ':roll3'=>$_POST['a3'],
    ':name4'=>$_POST['fieldc'],
    ':roll4'=>$_POST['a4'],
    ':domain'=>(int)$_POST['fielddoamin'],
    ':guide1'=>(int)$_POST['fieldguide1'],
    ':guide2'=>(int)$_POST['fieldguide2'],
    ':guide3'=>(int)$_POST['fieldguide3'],
    ':user_id'=>$rowb[0]['user_id'],
  )
	);

  $stmtz = $pdo->query('SELECT mentor_id, live_proj_count FROM mentor');
  $rowz = $stmtz->fetchAll(PDO::FETCH_ASSOC);

  

  foreach($rowz as $z){
    if($z['mentor_id']==$_POST['fieldguide1'] && (int)$z['live_proj_count']<3){
        // Save mentor and team details
        $stmt2 = $pdo->prepare('INSERT INTO alloted_guide (team_leader_id, mentor_id)
                            VALUES (:user_id, :mentor_id)');
        $stmt2->execute(array(
          ':user_id'=>$rowb[0]['user_id'],
          ':mentor_id'=>(int)$z['mentor_id']
        )
        );

        // Update live project count of mentor
        $m_id = (int)$z['mentor_id'];
        $proj_count = (int)$z['live_proj_count'] + 1;
        $updatequery = 'UPDATE mentor set live_proj_count=:proj_count where mentor_id=:m_id ';
        $stmtg = $pdo->prepare($updatequery);
        $stmtg->execute([':proj_count'=>$proj_count, ':m_id'=>$m_id]);

        break;
      }elseif((int)$z['mentor_id']==(int)$_POST['fieldguide2'] && (int)$z['live_proj_count']<3){
          $stmt2 = $pdo->prepare('INSERT INTO alloted_guide (team_leader_id, mentor_id)
                              VALUES (:user_id, :mentor_id)');
          $stmt2->execute(array(
            ':user_id'=>$rowb[0]['user_id'],
            ':mentor_id'=>(int)$z['mentor_id']
          )
          );

        // Update live project count of mentor
        $m_id = (int)$z['mentor_id'];
        $proj_count = (int)$z['live_proj_count'] + 1;
        $updatequery = 'UPDATE mentor set live_proj_count=:proj_count where mentor_id=:m_id ';
        $stmtg = $pdo->prepare($updatequery);
        $stmtg->execute([':proj_count'=>$proj_count, ':m_id'=>$m_id]);

          break;
      }elseif((int)$z['mentor_id']==(int)$_POST['fieldguide3'] && (int)$z['live_proj_count']<3){
        $stmt2 = $pdo->prepare('INSERT INTO alloted_guide (team_leader_id, mentor_id)
                            VALUES (:user_id, :mentor_id)');
        $stmt2->execute(array(
          ':user_id'=>$rowb[0]['user_id'],
          ':mentor_id'=>(int)$z['mentor_id']
        )
        );

        // Update live project count of mentor
        $m_id = (int)$z['mentor_id'];
        $proj_count = (int)$z['live_proj_count'] + 1;
        $updatequery = 'UPDATE mentor set live_proj_count=:proj_count where mentor_id=:m_id ';
        $stmtg = $pdo->prepare($updatequery);
        $stmtg->execute([':proj_count'=>$proj_count, ':m_id'=>$m_id]);

        break;
      }else{
        $msg = "No Guide Alloted";
        echo '<p>'.$msg.'</p>';
      }
    }


  $_SESSION['successform']="Details Submitted";
	header('Location: studentguideform.php');
	return;
}
  catch(Exception $e){
    $_SESSION['successform']="Details not submitted";
    header('Location: studentguideform.php');
    return;
  }
}
else{
  $_SESSION['successform']="Details not submitted";
  header('Location: studentguideform.php');
  return;
}
}
?>
<html>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <link rel="stylesheet" href="https://www.unpkg.com/tailwindcss@1.8.10/dist/tailwind-experimental.min.css">



</head>

<body>
  <div class="flex text-gray-800 min-h-screen">
    <aside class="hidden md:block bg-white px-6 py-5 h-full w-full sm:relative sm:w-64 lg:w-1/5">
      <a href="#" class="flex min-w-max-content items-center font-bold text-lg p-2 mb-12">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
          class="h-6 w-6 mx-0.5 mr-3 text-gray-400 flex-shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg></i>Student Dashboard
      </a>
      <nav class="text-gray-600 text-lg font-semibold min-w-max-content space-y-2">
        <a href="#profile"
          class="flex items-center flex-shrink-0 px-5 py-3 rounded-full text-indigo-700 bg-indigo-100 bg-opacity-25">
          <svg viewBox="0 0 20 20" fill="currentColor" class="h-7 w-7 mr-2.5 flex-shrink-0">
            <path
              d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
          </svg>
          Guide Allocation Form
        </a>

        <?php if($rowb[0]['year_study']!=4) : ?>
        <a href="repositorydashboard.php"
          class="flex items-center flex-shrink-0 px-5 py-3 rounded-full hover:bg-gray-100 hover:bg-opacity-50">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
            class="h-6 w-6 mx-0.5 mr-3 text-gray-400 flex-shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
          Repository
        </a>
        <?php endif; ?>

        <?php if($rowb[0]['year_study']==4) : ?>
          <a href="studentdashboard.php"
            class="flex items-center flex-shrink-0 px-5 py-3 rounded-full hover:bg-gray-100 hover:bg-opacity-50">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
              class="h-6 w-6 mx-0.5 mr-3 text-gray-400 flex-shrink-0">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            Dashboard
          </a>
        <?php endif; ?>
          <!-- <a href="repositorydashboard.php"
            class="flex items-center flex-shrink-0 px-5 py-3 rounded-full hover:bg-gray-100 hover:bg-opacity-50">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
              class="h-6 w-6 mx-0.5 mr-3 text-gray-400 flex-shrink-0">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            Dashboard
          </a> -->
        

        <a href="logout.php"
          class="flex items-center flex-shrink-0 px-5 py-3 rounded-full hover:bg-gray-100 hover:bg-opacity-50">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
            class="h-6 w-6 mx-0.5 mr-3 text-gray-400 flex-shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
          </svg>
          Logout
        </a>
      </nav>
    </aside>
    <div class="flex-grow bg-gray-100">
      <header class="flex items-center justify-between px-6 py-5 max-w-6xl mx-auto mb-4">
        <button class="block md:hidden p-2 text-gray-700 mr-2">
          <svg viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6">
            <path fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z"
              clip-rule="evenodd" />
          </svg>
        </button>
        <div class="relative w-full max-w-4xl mr-6 sm:mr-8 md:mr-16 lg:mr-24">
          <svg viewBox="0 0 20 20" fill="currentColor" class="absolute h-6 w-6 text-gray-400 mt-2 ml-3">
            <path fill-rule="evenodd"
              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
              clip-rule="evenodd" />
          </svg>
          <input type="text" placeholder="Search for objects, contacts, documents etc."
            class="pl-10 w-full pr-4 py-2 border border-gray-300 shadow-sm rounded-lg" />
        </div>
        <div class="flex flex-shrink-0">
          <button class="flex items-center p-2 sm:mr-2">
          <?php echo htmlentities($_SESSION['username']);?>
            <i class="fas fa-user-graduate"></i>
          </button>
          <div class="h-10 w-10 hidden sm:block border border-gray-400 bg-gray-300 overflow-hidden rounded-full">
            <img src="images.png" alt="user avatar" class="object-cover">
          </div>
        </div>
      </header>
      <main class="flex flex-col space-y-10 px-6 py-5 max-w-6xl mx-auto">
        <h5 align="center" style="color:red; background:white;">
					<?php
						if(isset($_SESSION['successproj'])){
							echo $_SESSION['successproj'];
							unset($_SESSION['successproj']);
						}
						?>
					</h5>
        <h1 class="text-3xl">
          <span class="text-gray-500">Welcome,</span>
          <span class="font-semibold"><?php echo htmlentities($_SESSION['username']);?></span>
        </h1>


        <style type="text/css">
          .form-style-5 {
            max-width: 900px;
            padding: 20px 20px;
            background: #ecebfa;
            margin: 10px auto;
            padding: 30px;
            background: #ecebfa;
            border-radius: 8px;
            font-family: "Segoe UI";
          }

          .form-style-5 fieldset {
            border: none;
          }

          .form-style-5 legend {
            font-size: 1.4em;
            margin-bottom: 10px;
          }

          .form-style-5 label {
            display: block;
            margin-bottom: 8px;
          }

          .form-style-5 input[type="text"],
          .form-style-5 input[type="date"],
          .form-style-5 input[type="datetime"],
          .form-style-5 input[type="email"],
          .form-style-5 input[type="number"],
          .form-style-5 input[type="search"],
          .form-style-5 input[type="time"],
          .form-style-5 input[type="url"],
          .form-style-5 textarea,
          .form-style-5 select {
            font-family: "Segoe UI";
            background: #e0ccff;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            margin: 0;
            outline: 0;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            background-color: #ecebfa;
            color: #8a97a0;
            -webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03) inset;
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03) inset;
            margin-bottom: 30px;
          }

          .form-style-5 input[type="text"]:focus,
          .form-style-5 input[type="date"]:focus,
          .form-style-5 input[type="datetime"]:focus,
          .form-style-5 input[type="email"]:focus,
          .form-style-5 input[type="number"]:focus,
          .form-style-5 input[type="search"]:focus,
          .form-style-5 input[type="time"]:focus,
          .form-style-5 input[type="url"]:focus,
          .form-style-5 textarea:focus,
          .form-style-5 select:focus {
            background: #d2d9dd;
          }

          .form-style-5 select {
            -webkit-appearance: menulist-button;
            height: 35px;
          }

          .form-style-5 .number {
            background: #5145cd;
            color: #fff;
            height: 30px;
            width: 30px;
            display: inline-block;
            font-size: 0.8em;
            margin-right: 4px;
            line-height: 30px;
            text-align: center;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.2);
            border-radius: 15px 15px 15px 0px;
          }

          .form-style-5 input[type="submit"],
          .form-style-5 input[type="button"] {
            position: relative;
            display: block;
            padding: 19px 39px 18px 39px;
            color: #FFF;
            margin: 0 auto;
            background: #5145cd;
            font-size: 18px;
            text-align: center;
            font-style: normal;
            width: 100%;
            border: 1px solid #5145cd;
            border-width: 1px 1px 3px;
            margin-bottom: 10px;
          }

          .form-style-5 input[type="submit"]:hover,
          .form-style-5 input[type="button"]:hover {
            background: #d6d6f5;
            color: black;
          }
        </style>
       <header class="text-xl font-semibold"> Guide Allocation Form</header>
        <div class="form-style-5" id="submit">

          <form method="post" enctype="multipart/form-data">
            <fieldset>
<!-- <legend><span class="number">1</span> project Details</legend>

<input type="text" name="fiel1" placeholder="Project  Name" required>
<input type="number" name="year" placeholder="Year upload" required> -->
              <legend><span class="number">1</span> Student Details</legend>

              <div class="dropdown">
                <span>&nbsp;&nbsp;&nbsp;Branch</span>
                <select id="branch" name="field4">
                  <!-- <optgroup> -->
                    <option value=""><b>Select Branch</b></option>
                    <option value=1>CMPN</option>
                    <option value=2>IT</option>
                    <option value=3>EXTC</option>
                    <option value=4>ETRX</option>
                    <option value=5>BIOM</option>
                  <!-- </optgroup> -->
                </select>

              </div>

              <div class="dropdown">
                <span>&nbsp;&nbsp;&nbsp;Year</span>
                <select id="year" name="fieldyear">
                  <!-- <optgroup> -->
                    <option value=""><b>Select Year</b></option>
                    <option value=1>FE</option>
                    <option value=2>SE</option>
                    <option value=3>TE</option>
                    <option value=4>BE</option>
                  <!-- </optgroup> -->
                </select>

              </div>


              <input type="text" name="field1" placeholder="Leader Name" required>
              <input type="text" name="a1" placeholder="Roll Number" required>
              <span>&nbsp;&nbsp;&nbsp;Members Name and Roll Number :</span>

              <input type="text" name="fielda" placeholder="Student 2" required>
              <input type="text" name="a2" placeholder="Roll Numbar" required>
              <input type="text" name="fieldb" placeholder="Student 3" required>
              <input type="text" name="a3" placeholder="Roll Numbar"required>
              <input type="text" name="fieldc" placeholder="Student 4">
              <input type="text" name="a4" placeholder="Roll Numbar">
              <!-- <input type="text" name="fieldd" placeholder="Student 4">
              <input type="text" name="a5" placeholder="Roll Numbar">
              <input type="text" name="fielde" placeholder="Student 5">
              <input type="text" name="a6" placeholder="Roll Numbar"> -->


              <legend><span class="number">2</span> Domain</legend>

              <select id="domain" name="fielddoamin" >
                <option value=""><b>select domain</b></option>
                <?php
                     $stmte = $pdo->query('SELECT domain_name,domain_id FROM domain');
                     $rowe = $stmte->fetchAll(PDO::FETCH_ASSOC);
                     foreach ($rowe as $rowse) {
                       $rce=$rowse['domain_name'];
                       echo
                       '<option value='.$rowse['domain_id'].'>'.$rce.'</option>';
                       $i++;
                     }
                ?>
                <!-- <optgroup label="DOMAIN">
                  <option value="webdev">Web Development</option>
                  <option value="AI and ML">Artificial Intelligence and Machine Learning</option>
                  <option value="Security">Security</option>
                  <option value="abc">abc</option>
                  <option value="gaming">Gaming</option>
                  <option value="abc">abc</option>
                  <option value="xyz">xyz</option>
                </optgroup> -->
              </select>
              <style>
                .upload-btn-wrapper {
                  position: relative;
                  overflow: hidden;
                  display: inline-block;
                  padding-bottom: 30px;
                }

                .btn {
                  border: 2px solid #5145cd;
                  color: gray;
                  width: 500px;
                  background-color: white;
                  padding: 15px 15px;
                  border-radius: 8px;
                  font-size: 10px;
                  font-weight: bold;
                }

                .upload-btn-wrapper input[type=file] {
                  font-size: 100px;
                  position: absolute;
                  left: 0;
                  top: 0;
                  opacity: 0;
                }
              </style>



            </fieldset>
            <fieldset>
              <legend><span class="number">3</span> Preferred Guide</legend>
              <select id="guide1" name="fieldguide1">
                <optgroup label="Teachers">
                  <option value=""><b>Guide Preference 1</b></option>
                  <?php $i=1;
                       $stmtc = $pdo->query('SELECT * FROM mentor');
                       $rowc = $stmtc->fetchAll(PDO::FETCH_ASSOC);
                       foreach ($rowc as $rowsc) {
                         $rcb=$rowsc['mentor_name'];
                         echo
                         '<option value='.$rowsc['mentor_id'].'>'.$rcb.'</option>';
                         $i++;
                       }
                  ?>
                </optgroup>
              </select>

              <select id="guide2" name="fieldguide2">
                <optgroup label="Teachers">
                  <option value=""><b>Guide Preference 2</b></option>
                  <?php $i=1;
                       $stmtc = $pdo->query('SELECT * FROM mentor');
                       $rowc = $stmtc->fetchAll(PDO::FETCH_ASSOC);
                       foreach ($rowc as $rowsc) {
                         $rcb=$rowsc['mentor_name'];
                         echo
                         '<option value='.$rowsc['mentor_id'].'>'.$rcb.'</option>';
                         $i++;
                       }
                  ?>
                </optgroup>
              </select>

              <select id="guide3" name="fieldguide3">
                <optgroup label="Teachers">
                  <option value=""><b>Guide Preference 3</b></option>
                  <?php $i=1;
                       $stmtc = $pdo->query('SELECT * FROM mentor');
                       $rowc = $stmtc->fetchAll(PDO::FETCH_ASSOC);
                       foreach ($rowc as $rowsc) {
                         $rcb=$rowsc['mentor_name'];
                         echo
                         '<option value='.$rowsc['mentor_id'].'>'.$rcb.'</option>';
                         $i++;
                       }
                  ?>
                </optgroup>
              </select>
              
            </fieldset>
            <input type="submit" name="submit" value="Submit"/>

          </form>
        </div>
        </section>

      </main>
    </div>
  </div>
  <script>
    $(document).ready(function () {
          // Add smooth scrolling to all links
          $("a").on('click', function (event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
              // Prevent default anchor click behavior
              event.preventDefault();

              // Store hash
              var hash = this.hash;

              // Using jQuery's animate() method to add smooth page scroll
              // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
              $('html, body').animate({
                scrollTop: $(hash).offset().top
              }, 800, function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
              });
            } // End if
          });
    });

  /*  var branchAndDomain = {};
    branchAndDomain[1] = ['Algorithms', 'Database', 'Image Processing', 'Web Development', 'App Development', 'Machine Learning'];
    branchAndDomain[2] = ['Algorithms', 'Database', 'Image Processing', 'Web Development', 'App Development', 'Machine Learning'];
    branchAndDomain[3] = ['Integrated Circuits', 'Signal Processing', 'Communications', 'Microelectronics'];
    branchAndDomain[4] = ['Integrated Circuits', 'Signal Processing', 'Communications', 'Microelectronics'];
    branchAndDomain[5] = ['Medical Devices', 'Biometrics', 'Biosignal Processing', 'Biomechanics'];

    function ChangeDomainList() {
      var branchList = document.getElementById("branch");
      var domainList = document.getElementById("domain");
      var selectDomain = branchList.options[branchList.selectedIndex].value;
      while (domainList.options.length) {
        domainList.remove(0);
      }
      var domains = branchAndDomain[selectDomain];
      if (domains) {
        var i;
        for (i = 0; i < domains.length; i++) {
          var domain = new Option(domains[i], i);
          domainList.options.add(domain);
        }
      }
      var yourDomain = document.getElementById("domain").options;
          if (yourDomain.text == 'Algorithms')
            yourDomain.setAttribute("value", 1);
          if (yourDomain.text == 'Database')
            yourDomain.setAttribute("value", 2);
          if (yourDomain.text == 'Image Processing')
            yourDomain.setAttribute("value", 3);
          if (yourDomain.text == 'Web Development')
            yourDomain.setAttribute("value", 4);
          if (yourDomain.text == 'App Development')
            yourDomain.setAttribute("value", 5);
          if (yourDomain.text == 'Machine Learning')
            yourDomain.setAttribute("value", 6);

          if (yourDomain.text == 'Integrated Circuits')
            yourDomain.setAttribute("value", 7);
          if (yourDomain.text == 'Signal Processing')
            yourDomain.setAttribute("value", 8);
          if (yourDomain.text == 'Communications')
            yourDomain.setAttribute("value", 9);
          if (yourDomain.text == 'Microelectronics')
            yourDomain.setAttribute("value", 10);

          if (yourDomain.text == 'Medical Devices')
            yourDomain.setAttribute("value", 11);
          if (yourDomain.text == 'Biometrics')
            yourDomain.setAttribute("value", 12);
          if (yourDomain.text == 'Biosignal Processing')
            yourDomain.setAttribute("value", 13);
          if (yourDomain.text == 'Biomechanics')
            yourDomain.setAttribute("value", 14);
    }


    var domainAndGuide = {};
    domainAndGuide['Algorithms'] = ['Prof. Dilip Motwani', 'Prof. Sanjeev Dwivedi', 'Prof. Rugved Deolekar', 'Prof. Swapnil Sonawane'];
    domainAndGuide['Database'] = ['Prof. Sachin Deshpande', 'Prof. Vipul Dalal', 'Prof. Pankaj Vanwari', 'Prof. Kavita Shirsat'];
    domainAndGuide['Image Processing'] = ['Dr. Murugan Gopal', 'Prof. Vipul Dalal', 'Prof. Mandar Sohani', 'Prof. Ravindra Sangale'];
    domainAndGuide['Web Development'] = ['Prof. Kavita Shirsat', 'Prof. Devendra Pandit', 'Prof. Ravindra Sangale', 'Prof. Sneha Annappanavar'];
    domainAndGuide['App Development'] = ['Prof. Devendra Pandit', 'Prof. Ravindra Sangale', 'Prof. Sneha Annappanavar', 'Prof. Swapnil Sonawane'];
    domainAndGuide['Machine Learning'] = ['Dr. S.A. Patekar', 'Prof. Sachin Deshpande', 'Prof. Mandar Sohani', 'Prof. Kavita Shirsat'];

    domainAndGuide['Integrated Circuits'] = ['A', 'B', 'C'];
    domainAndGuide['Signal Processing'] = ['D', 'E', 'F'];
    domainAndGuide['Communications'] = ['G', 'H', 'I'];
    domainAndGuide['Microelectronics'] = ['J', 'K', 'L'];

    domainAndGuide['Medical Devices'] = ['a', 'b', 'c'];
    domainAndGuide['Biometrics'] = ['d', 'e', 'f'];
    domainAndGuide['Biosignal Processing'] = ['g', 'h', 'i'];
    domainAndGuide['Biomechanics'] = ['j', 'k', 'l'];

    function ChangeGuideList() {
      var bdomainList = document.getElementById("domain");
      var guideList = document.getElementById("guide");
      var selectGuide = bdomainList.options[bdomainList.selectedIndex].value;

      while(guideList.options.length) {
        guideList.remove(0);
      }
      var guides = domainAndGuide[selectGuide];
      if(guides) {
        var i;
        for (i=0; i<guides.length; i++) {
          var guide = new Option(guides[i]);
          guideList.options.add(guide);
        }
      }
    }*/
  </script>
  <script>
  window.watsonAssistantChatOptions = {
      integrationID: "af6a3c19-9b95-48c7-a6cb-73ad128c30e1", // The ID of this integration.
      region: "eu-gb", // The region your integration is hosted in.
      serviceInstanceID: "dcee2fc2-7a8e-4f2b-b059-13b16d407752", // The ID of your service instance.
      onLoad: function(instance) { instance.render(); }
    };
  setTimeout(function(){
    const t=document.createElement('script');
    t.src="https://web-chat.global.assistant.watson.appdomain.cloud/loadWatsonAssistantChat.js";
    document.head.appendChild(t);
  });
</script>
</body>

</html>
