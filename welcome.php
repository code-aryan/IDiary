<?php 

  session_start();

  if(!isset($_SESSION['loggedin']) || ($_SESSION['loggedin']!=true))
  {
     header("location: HomePage.php");
  }

  include '_dbconnect.php';

  $navbc = 1;

  $is_insertion = false;
  $is_update    = false;
  $is_delete    = false;
  $email = $_SESSION['email'];
  if(isset($_GET['delete']))
  {
           $sno = $_GET['delete'];
           $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
           $result = mysqli_query($conn,$sql);
           $is_delete = true;  
  }

  if( $_SERVER['REQUEST_METHOD'] == 'POST')
  {
     if(isset($_POST['snoEdit']))
     {
       // update the notes
           $sno = $_POST['snoEdit'];
           $title = $_POST['titleEdit'];
           $description = $_POST['descEdit'];

           $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description',`User_email` = '$email' WHERE `notes`.`sno` = $sno";
           $result = mysqli_query($conn,$sql);

           if($result)
           $is_update = true;
           else $navbc++;
   }
    else{
    $title = $_POST["title"];
    $description = $_POST["desc"];

    $sql = "INSERT INTO `notes` (`title`, `description`,`User_email`) VALUES ('$title', '$description','$email')";
    $result = mysqli_query($conn,$sql);

    if($result)
      $is_insertion = true;
    else $navbc++;
   }

  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">


    <title>Welcome! <?php echo $_SESSION['UserName'] ?></title>
     <style>
       #descript{
               text-align: center;
       }
     </style>
  </head>
  <!-- Here Body Starts -->
  <body>
      <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">  <!-- here modal body starts -->
        <form action="/iDiary/welcome.php" method="POST">
          <input type="hidden" name="snoEdit" id="snoEdit">
  <div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
  </div>

  <div class="mb-3">
  <label for="desc" class="form-label">Description</label>
  <textarea class="form-control" id="descEdit" name="descEdit" rows="4"></textarea>
</div>

  <button type="submit" class="btn btn-primary">Add Note</button>
</form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
       <!--  Navigation bar  -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">iDiary</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Contact us</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>

      </ul>

      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
  </nav>

  <?php 
    if($is_insertion)
    {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your note has been inserted successfully
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    }
    else if($is_update)
      {
      echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your note has been updated successfully
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    }
    else if($is_delete)
      {
      echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your note has been deleted successfully
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    }
    else if($navbc!=1){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Warning!</strong> Something went wrong! Do not use apostrophe in title and description.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
       $navbc = 1;
    }
   ?>

   <div class="container my-4">
    <h2>Add Note</h2>
     <form action="/IDiary/welcome.php" method="POST">
  <div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
  </div>

  <div class="mb-3">
  <label for="desc" class="form-label">Description</label>
  <textarea class="form-control" id="desc" name="desc" rows="4"></textarea>
</div>

  <button type="submit" class="btn btn-primary">Add Note</button>
</form>
   </div>

  <div class="container my-4">
   
      <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Title</th>
      <th scope="col" id="descript">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>

     <?php 
         
         $sql = "SELECT * From `notes`";
         $result = mysqli_query($conn,$sql);
         $sno = 0;
         while($row = mysqli_fetch_assoc($result))
         {
          if($row['User_email'] == $_SESSION['email']){
          $sno++;
          echo "<tr>
               <th scope='row'>".$sno ."</th>
               <td>".$row['title'] ."</td>
               <td>".$row['description'] ."</td>
              <td> 
                <div class='container'>
                <button class='edit btn btn-primary btn-sm' id=".$row['sno'].">Edit</button>
                <button class='delete btn btn-primary btn-sm' id=d".$row['sno'].">Delete</button>
              </div>  
              </td>
               </tr>";
             }
         }
   ?>
 
  </tbody>
  </table>
  </div>
  <hr>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script
      src="https://code.jquery.com/jquery-3.5.1.js"
      integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
      crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
      $('#myTable').DataTable();
        } );
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
        element.addEventListener("click",(e)=>{
          console.log("edit ",e.target.parentNode.parentNode);
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title,description);
          titleEdit = title;
          descEdit = description;
          snoEdit.value = e.target.id;
          console.log(snoEdit.value);
          // Modal script
          var myModal = new bootstrap.Modal(document.getElementById('editModal'), {
          keyboard: false
          })
          myModal.toggle(); 
          // model script end
        })
      })

         deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
        element.addEventListener("click",(e)=>{
          console.log("delete ",);
          sno = e.target.id.substr(1,);
          
          if(confirm("Do you want to delete this note ?"))
          {
             window.location = `/iDiary/welcome.php?delete=${sno}`;
          }

          })
      })
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    --> 
  </body>
</html>