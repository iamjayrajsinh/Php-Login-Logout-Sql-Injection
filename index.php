<?php
    /* Start the session */
    session_start();
    // check if session exist
    if(isset($_SESSION['id'])){
        // redirect to dashboard
        header("location: dashboard.php");
    }

    // db connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "sql-test";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $db_name);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sql Injection</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div id="main">
    <div id="header">
      <h1>User Login</h1>
    </div>
    <div id="content">
      <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <div class="form-group">
          <label>Username</label>
          <input  type="text" name="username" autocomplete="off" />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" />
        </div>
        <input type="submit" class="btn" name="login" id="submit" value="Submit" />
      </form>
      <?php
        if(isset($_POST['login'])){
          if(!isset($_POST['username']) || $_POST['username'] == ''){

            echo '<div class="message error">Please Fill All The Fields.</div>';

          }else if(!isset($_POST['password']) || $_POST['password'] == ''){

            echo '<div class="message error">Please Fill All The Fields.</div>';
          }else{
            $username = $_POST["username"];
            $password = $_POST["password"];

            $sql = $conn->prepare("SELECT * FROM users WHERE user_email = ? AND password = ?");
            $sql->bind_param("ss",$username,$password);
            $sql->execute();
            //  ' or ''='

            $result = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
            // echo "<pre>";
            // print_r($result);
            // echo "</pre>";
            // exit;
            if (count($result) > 0) {
             
              /* Start the session */
              session_start();
              /* Set session variables */
             $_SESSION["id"] = $result[0]['id'];
             $_SESSION["first_name"] = $result[0]['first_name'];
              header("location: dashboard.php");              

            }else{
                echo "<div class='message error'>Email and Password Not Matched.</div>";
            }
            $sql->close();
          }
        }
        // db close connection                
        $conn->close();
      ?>
    </div>
  </div>
</body>
</html>