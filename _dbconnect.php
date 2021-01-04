 <?php 
   
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "notes";

  $conn = mysqli_connect($servername,$username,$password,$database);

  if(!$conn)
    die("Sorry , we failed to connect to server : ". mysqli_connect_error());

 ?>