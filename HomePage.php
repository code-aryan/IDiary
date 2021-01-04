 <?php 
     $show_error = "";

     if($_SERVER['REQUEST_METHOD'] == "POST"){
     include '_dbconnect.php';   
       
       if(isset($_POST["name"]))
       {
           $username = $_POST["name"];
           $password = $_POST["password"];
           $confirmpassword = $_POST["confirmpassword"];
           $email = $_POST["email"];
           $number = $_POST["number"];
           
           $user = "SELECT * FROM `users` WHERE user_email='$email'";
           $result = mysqli_query($conn,$user);
           $num = mysqli_num_rows($result);
           if($num!=0)
           {
            $show_error = "Email already registered! Please Use another email to continue";
           }
           else if($password!=$confirmpassword){
             $show_error = "Password do not match! Please Try again";
           }
            else
           {
               $hash = password_hash($password, PASSWORD_DEFAULT);
               $sql = "INSERT INTO `users` (`UserName`, `user_email`, `user_password`, `user_contact_no`) VALUES ('$username', '$email', '$hash', '$number')";
               $result = mysqli_query($conn,$sql);
               
               if(!$result)
                $show_error = "Something Went Wrong! Please Try again later";
               else
                $show_error = "SignUp Successful! Please Login to continue ";
           }
           

       }
       else
       {
          $email = $_POST["email"];
          $password = $_POST["password"];

          $sql = "Select * from users where user_email='$email' ";
          $result = mysqli_query($conn,$sql);
          if($result)
            {
                 $num = mysqli_num_rows($result);

                 if($num == 1)
                 {
                       while ($row = mysqli_fetch_assoc($result)){
                        if(password_verify($password, $row['user_password']))
                        {
                             session_start();
                             $_SESSION['loggedin'] = true;
                             $_SESSION['email'] = $email;
                             $_SESSION['UserName'] = $row['UserName'];
                             header("location: welcome.php");
                        }
                        else
                        {
                           $show_error = "Password incorrect!";
                        }
                    }
                 }
                 else
                 {
                   $show_error = "Email Not Registered! Please SignUp to continue";
                 }
            } 
          else
             {
               $show_error = "Something went wrong! Please Try again later";
             }
       }
     }
     
 ?>


<!doctype html>
<html lang="en">

<head>
    <title>Login Form</title>
    <!-- Meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- font-awesome icons -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel='stylesheet' type='text/css' media="all">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body> <h1 class="error topline">Idiary Web App</h1>
    <?php 
          if($show_error)
          {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
         '.$show_error.'
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>';
          }
     ?>
    <div class="two-grids">
        <div class="mid-class">
            <div class="img-right-side">
                <h3>Welcome To IDiary</h3>
                <p>...</p>
                <img src="images/b11.png" class="img-fluid" alt="">
            </div>

             <div class="txt-left-side signin-form">
                <h2> Login Here </h2>
                <p>Use email for login</p>
                <form action="#" method="post">
                    <div class="form-left-to-l">
                        <span class="fa fa-envelope-o" aria-hidden="true"></span>
                        <input type="email" name="email" placeholder="Email" required="">

                        <div class="clear"></div>
                    </div>
                    <div class="form-left-to-l ">

                        <span class="fa fa-lock" aria-hidden="true"></span>
                        <input type="password" name="password" placeholder="Password" required="">
                        <div class="clear"></div>
                    </div>
                    <div class="main-two-ls">
                        <div class="left-side-forget">
                            <input type="checkbox" class="checked">
                            <span class="remenber-me">Remember me </span>
                        </div>
                        <div class="right-side-forget">
                            <a href="#" class="for">Forgot password...?</a>
                        </div>
                    </div>
                    <div class="btnn">
                        <button type="submit">Login </button>
                    </div>
                </form>
                <div class="more-buttn">
                    <h3>Don't Have an account..?
                        <a class="signupbutton">Register Here
                        </a>
                    </h3>
                </div>

            </div>

             <div class="txt-left-side signup-form" style="display: none; padding: 1em 2.7em;">
                <h2> SignUp Here </h2>
                <form action="/IDiary/HomePage.php" method="post">
                    <div class="form-left-to-l">
                        <span class="fa fa-user" aria-hidden="true"></span>
                        <input type="text" name="name" placeholder="Name" required="">

                        <div class="clear"></div>
                    </div>
                     <div class="form-left-to-l">
                        <span class="fa fa-envelope-o" aria-hidden="true"></span>
                        <input type="email" name="email" placeholder="Email" required="">

                        <div class="clear"></div>
                    </div>
                     <div class="form-left-to-l">
                        <span class="fa fa-mobile" aria-hidden="true"></span>
                        <input type="number" name=" number" placeholder="Mobile Number" required="">

                        <div class="clear"></div>
                    </div>
                     <div class="form-left-to-l">
                        <span class="fa fa-lock" aria-hidden="true"></span>
                        <input type="password" name="password" placeholder="Password" required="">

                        <div class="clear"></div>
                    </div>
                    <div class="form-left-to-l ">

                        <span class="fa fa-lock" aria-hidden="true"></span>
                        <input type="password" name="confirmpassword" placeholder="Confirm Password" required="">
                        <div class="clear"></div>
                    </div>
                  
                    <div class="btnn">
                        <button type="submit">Sign Up </button>
                    </div>
                </form>
                <div class="more-buttn">
                    <h3>Have an account..?
                        <a class="signinbutton">Login Here </a>
                    </h3>
                </div>
            </div>


        </div>
    </div>
 
    <script type="text/javascript">
     $('.signupbutton').click(function () {
            $('.signin-form').css('display','none');
             $('.signup-form').css('display','block');

        }); 
       $('.signinbutton').click(function () {
            $('.signup-form').css('display','none');
             $('.signin-form').css('display','block');
        }); 
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script
      src="https://code.jquery.com/jquery-3.5.1.js"
      integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
      crossorigin="anonymous"></script>

 </body>
</html>