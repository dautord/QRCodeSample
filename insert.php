<?php
  session_start();
  $server = "localhost"; //change to server ip address
  $username = "root"; //admin
  $password = ""; //password123
  $dbname = "qrcodedb";

  $conn = new mysqli($server, $username, $password, $dbname);
  date_default_timezone_set('Asia/Manila');

  if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
  }

  if (isset($_POST['text'])){

    $text = $_POST['text'];
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $sql = "SELECT * FROM table_attendance WHERE EMPLOYEEID = '$text' AND LOGDATE = '$date' AND STATUS = '0'";
    $query = $conn->query($sql);

    if ($query -> num_rows > 0) {

      $sql = "UPDATE table_attendance SET TIMEOUT = '$time', STATUS = '1' WHERE EMPLOYEEID = '$text' AND LOGDATE = '$date'";
      $query = $conn->query($sql);
      $_SESSION['success'] = 'Successfully timed out';
    } else {

      $sql = "INSERT INTO table_attendance(EMPLOYEEID, TIMEIN, LOGDATE, STATUS) VALUES('$text', '$time', '$date', '0')";

      if ($conn->query($sql) === TRUE) {

        $_SESSION['success'] = 'Successfully timed in';
      } else {

        $_SESSION['error'] = $conn->error;
      }

    }



} else {
  $_SESSION['error'] = 'Please scan your QR Code';
}
  header("location: index.php");

  $conn->close();

?>