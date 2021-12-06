<?php
session_start();
require_once('_db.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['password']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $adminCode = trim($_POST['admincode']);
        $adminAccessCode = "12345"; // Admin password
        $options = array("cost" => 4);
        $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
        $date = date('Y-m-d H:i:s');
        

        $sql = 'select * from users where username = :username';
        $stmt = $db->prepare($sql);
        $p = ['username' => $username];
        $stmt->execute($p);
       
        $isAdmin = "no";
        if ($adminCode == $adminAccessCode) {  // Checking if the code for admin rights is correct
            $isAdmin = 'yes';
        } 

        if ($stmt->rowCount() == 0) {
            $sql = "insert into users (first_name, last_name, username, `password`, isAdmin, created_at,updated_at) values(:fname,:lname,:username,:pass,:isAdmin,:created_at,:updated_at)";

            try {
                $handle = $db->prepare($sql);
                $params = [
                    ':fname' => $firstName,
                    ':lname' => $lastName,
                    ':username' => $username,
                    ':pass' => $hashPassword,
                    'isAdmin' => $isAdmin,
                    ':created_at' => $date,
                    ':updated_at' => $date
                ];

                $handle->execute($params);

                $success = 'User has been created successfully';

            } catch (PDOException $e) {
                $errors[] = $e->getMessage();
            }
        } else {
            $valFirstName = $firstName;
            $valLastName = $lastName;
            $valUsername = '';
            $valPassword = $password;
            $valAdminCode = $adminCode;

            $errors[] = 'Username already in use';
        }
    } else {
        if (!isset($_POST['first_name']) || empty($_POST['first_name'])) {
            $errors[] = 'Sisesta eesnimi';
        } else {
            $valFirstName = $_POST['first_name'];
        }
        if (!isset($_POST['last_name']) || empty($_POST['last_name'])) {
            $errors[] = 'Sisesta perenimi';
        } else {
            $valLastName = $_POST['last_name'];
        }

        if (!isset($_POST['username']) || empty($_POST['username'])) {
            $errors[] = 'Sisesta email';
        } else {
            $valUsername = $_POST['username'];
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $errors[] = 'Sisesta salasõna';
        } else {
            $valPassword = $_POST['password'];
        }

        
    }
}
?>


<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Registreeri</title>
  <meta name="author" content="">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/logform.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
</head>

<body>

    <div class="register-div">
        
         <div class="title">Registreeri</div> 

        <?php
        if (isset($errors) && count($errors) > 0) {
            foreach ($errors as $error_msg) {
                echo '<div class="alert alert-danger">' . $error_msg . '</div>';
            }
        }

        if (isset($success)) {

            echo '<div class="alert alert-success">' . $success . '</div>';
            
            header("Location:login.php");
        }
        ?>
        <form autocomplete="off" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">


        <div class="fields2">


            <div class="form-group username">
                
                <input autocomplete="off" type="text" name="first_name" placeholder="Eesnimi" class="form-control" value="<?php echo ($valFirstName ?? '') ?>">
            </div>
            <div class="form-group username">
                
                <input autocomplete="off" type="text" name="last_name" placeholder="Perekonnanimi" class="form-control" value="<?php echo ($valLastName ?? '') ?>">
            </div>

            <div class="form-group username">
                
                <input autocomplete="off" type="text" name="username" placeholder="Email" class="form-control" value="<?php echo ($valUsername ?? '') ?>">
            </div>
            <div class="form-group username">
                
                <input autocomplete="off" type="password" name="password" placeholder="Salasõna" class="form-control" value="<?php echo ($valPassword ?? '') ?>">
            </div>
            <div class="form-group username">
                
                <input autocomplete="off" type="text" name="admincode" placeholder="Admin Kood" class="form-control" value="<?php echo ($valAdminCode ?? '') ?>">
            </div>

            <button type="submit" name="submit" id="submit" class="signin-button">REGISTREERI</button>
            <div class="link">
                <a href="#"></a>Mine <a href="login.php">Tagasi</a>
            </div>

        </div>
        </form>
          
    </div>
</body>

</html>