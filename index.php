<?php session_start(); ?>
<html>

  <head>
    <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CDBS QR Timekeeping</title>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      .navbar-nav li a {
        color: white;
      } 
      .navbar-brand {
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .logo{
        float:left;
      }
      .welcome{
        font-size: 20px;
      }
    </style>
   
  </head>

  <body onload="startTime()">

  

  <div class="container">

  <nav class="navbar navbar-inverse" style="background-color: #1c0f91;">
    <div class="container-fluid">
      <div class="navbar-header">
        <div id = "profile-image">
          <!-- <img src="images/CDBS School Logo with text.png"> -->
          <a class="navbar-brand" href="index.php" style="margin-bottom:3px;">
            <img class="logo" src="images/CDBS School Logo.png" width="50px" height="50px">
            <span>QR Timekeeping System</span>
          </a>
        </div>
      </div>
      <!-- <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
        <li><a href="#">Page 1-1</a></li>
        <li><a href="#">Page 1-2</a></li>
        <li><a href="#">Page 1-3</a></li>
        </ul>
      </li>
      <li><a href="#">Page 2</a></li>
      </ul> -->
      <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span>  Login</a></li>
      </ul>
    </div>
  </nav>
      <div class="row">
        <div class="col-md-6">
          <video id="preview" width=100%></video>
          <?php 

            if(isset($_SESSION['error'])){
            echo "
                <div class = 'alert alert-danger'>
                <h4>Error!</h4>
                ".$_SESSION['error']."
                </div>
              ";
            }

            if(isset($_SESSION['success'])){
              echo "
                  <div class = 'alert alert-success' style = 'background:green; color:white '>
                  <h4>Success!</h4>
                  ".$_SESSION['success']."
                  </div>
                ";
              }


          ?>
        </div>
        <div class="col-md-6">

        <form action="insert.php" method="post" class="form-horizontal">
          
          <label>
          <span class="welcome">Welcome Caritas Bosconian!</span>
          <div id="txt" style="font-size: 70px;"></div>

            <script>
            function startTime() {
              const today = new Date();
              let h = today.getHours();
              let m = today.getMinutes();
              let s = today.getSeconds();
              let am_pm = today.getHours() >= 12 ? "PM" : "AM";
              m = checkTime(m);
              s = checkTime(s);
              document.getElementById('txt').innerHTML =  h + ":" + m + ":" + s + " " + am_pm;
              setTimeout(startTime, 1000);
            }

            function checkTime(i) {
              if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
              return i;
            }
            </script>
          </label>
          <!--QR TO TEXT -->
          <input type="text" name="text" id="text" readonly="" placeholder="QR to Text" class="form-control"> 
          
        </form>

        <table id="example1" class="table table-bordered">

                    <thead>

                        <tr>

                            <td>ID</td>

                            <td>EMPLOYEE ID</td>

                            <td>TIME IN</td>

                            <td>TIME OUT</td>

                            <td>LOGDATE</td>

                            <td>STATUS</td>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $server = "localhost";

                        $username="root";

                        $password="";

                        $dbname="qrcodedb";

                    

                        $conn = new mysqli($server,$username,$password,$dbname);

						            $date = date('Y-m-d');

                        if($conn->connect_error){

                            die("Connection failed" .$conn->connect_error);

                        }

                           $sql ="SELECT * FROM table_attendance WHERE DATE(LOGDATE)=CURDATE()";

                           $query = $conn->query($sql);

                           while ($row = $query->fetch_assoc()){

                        ?>

                            <tr>

                                <td><?php echo $row['ID'];?></td>

                                <td><?php echo $row['EMPLOYEEID'];?></td>

                                <td><?php echo $row['TIMEIN'];?></td>

                                <td><?php echo $row['TIMEOUT'];?></td>

                                <td><?php echo $row['LOGDATE'];?></td>

                                <td><?php echo $row['STATUS'];?></td>

                            </tr>

                        <?php

                        }

                        ?>

                    </tbody>

                  </table>

        </div>
      </div>


  </div>


    <script>
      // Initialize camera scanner 
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});

      Instascan.Camera.getCameras().then(function(cameras) {

        if (cameras.length > 0){
          scanner.start(cameras[0]);
        } else {
          alert('No cameras detected');
        }
      }).catch(function(e) {
        console.error(e); 
      });
      
      scanner.addListener('scan', function(c){
        document.getElementById('text').value = c;
        document.forms[0].submit(); // submit form
      });

    </script>

  </body>

</html>