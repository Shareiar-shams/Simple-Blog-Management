<?php
    session_start();
    if(!empty($_SESSION['email'])) {
      header('location:index.php');
    }
    require_once 'db.php';

    $db = new Database();

    $usernameErr = $emailErr = $passwordErr = $retypepasswordErr = "";
    $username = $error = $password = $retypepassword = $message_login = $message_signup = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
      if(isset($_POST['login'])){
          $email = $_POST['email'];
          $pass = $_POST['pass'];

          if (empty($email) || empty($pass)) {
              $message = 'All fields are required';
          } else {

              $sql = "SELECT username, email, password FROM users WHERE email = ?";
              $query = $db->db->prepare($sql);
              $query->execute([$email]);
              $row = $query->fetch(PDO::FETCH_ASSOC);

              if ($row && password_verify($pass, $row['password'])) {
                  $_SESSION['email'] = $row['email'];
                  $_SESSION['name'] = $row['username'];
                  header('location:index.php');
                  exit();
              } else {
                  $message_login = "Email/Password is wrong";
              }
          
          }  
      }elseif(isset($_POST['singup'])){
          if (empty($_POST["username"])) {
             $usernameErr = "Username is required";
          } else {
             $username = $_POST["username"];
          }

          if (empty($_POST["signup_email"])) {
             $emailErr = "Email is required";
          } else {
             $email = $_POST["signup_email"];            
          }

          if (empty($_POST["password"])) {
              $passwordErr = "Password is required";
          } elseif (strlen($_POST["password"]) < 6) {
              $passwordErr = "Password must be at least 6 characters long.";
          } elseif (!preg_match('/[0-9]/', $_POST["password"])) {
              $passwordErr = "Password must include at least one number.";
          } elseif (!preg_match('/[\W]/', $_POST["password"])) {
              $passwordErr = "Password must include at least one special character.";
          } else {
            $password = $_POST["password"];
            $password = password_hash($password, PASSWORD_BCRYPT); 
          }

          if (empty($_POST["c_password"])) {
             $retypepasswordErr = "Password is required";
          } elseif( $_POST['c_password'] !== $_POST['password']) {
              $retypepasswordErr = "Password not matched";
          }else{
             $retypepassword = $_POST["c_password"];
          }

          if( empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($retypepasswordErr)){
              $store_data = "INSERT INTO users (`id`,`username`,`email`,`password`)VALUES (NULL, :username , :email , :password)";
              $query = $db->db->prepare($store_data); 
              $store_result = $query->execute([
                 ':username' => $username,
                 ':email' => $email,
                 ':password' => $password,

              ]);

              if($store_result) {
                $_SESSION['email'] = $email;
                header('location:index.php');
              } else {
                $message_signup = "Validation Error, User not register.";
              }
          }
      }
      
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="dist/css/login.css" />
  <title>Blog | Sign in & Sign up Form</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="sign-in-form">
          <h2 class="title">Sign in</h2>
          <?php
            if(isset($message_login)) {
                echo $message_login;
            }
          ?>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" name="email" placeholder="Email" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="pass" placeholder="Password" required />
          </div>
          <input type="submit" value="Login" name="login" class="btn solid" />
          
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="sign-up-form">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fa fa-user"></i>
            <input type="text" name="username" placeholder="Username" required />
          </div>
          <div class="error">
              <small class="input-small"><?php echo $usernameErr; ?></small>
          </div>
          <div class="input-field">
            <i class="fa fa-envelope"></i>
            <input type="email" name="signup_email" placeholder="Email" />
            
          </div>
          <div class="error">
              <small class="input-small"><?php echo $emailErr; ?></small>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" />
            
          </div>
          <div class="error">
              <small class="input-small"><?php echo $passwordErr; ?></small>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="c_password" placeholder="Retype Password" />
            
          </div>
          <div class="error">
              <small class="input-small"><?php echo $retypepasswordErr; ?></small>
          </div>
          <input type="submit" class="btn" name="singup" value="Sign up" />
        
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here ?</h3>
          
          <p>
            Click to below button for registration
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Sign up
          </button>
        </div>
        <img  src="dist/img/login/login.png" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <?php
            if(isset($message_signup)) {
                echo $message_signup;
            }
          ?>
          <p>
            Once a register user click below button for login.
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
        <img src="dist/img/login/signup.png"  class="image" alt="" />
      </div>
    </div>
  </div>

  <script type="text/javascript">
    const sign_in_btn = document.querySelector("#sign-in-btn");
    const sign_up_btn = document.querySelector("#sign-up-btn");
    const container = document.querySelector(".container");

    sign_up_btn.addEventListener("click", () => {
      container.classList.add("sign-up-mode");
    });

    sign_in_btn.addEventListener("click", () => {
      container.classList.remove("sign-up-mode");
    });
  </script>
</body>

</html>
