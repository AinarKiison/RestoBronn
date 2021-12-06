<!DOCTYPE html>
<?php
session_start();
require_once('_db.php');

if (isset($_POST['submit'])) {
  if (isset($_POST['username'], $_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    $sql = "select * from users where username = :username ";
    $handle = $db->prepare($sql);
    $params = ['username' => $username];
    $handle->execute($params);
    if ($handle->rowCount() > 0) {
      $getRow = $handle->fetch(PDO::FETCH_ASSOC);
      if (password_verify($password, $getRow['password'])) {
        if ($getRow['isAdmin'] == "yes") {
          
          header('location:indexAdmin.php');
        } else {
          header('location:index.php');
        }
        unset($getRow['password']);
        $_SESSION = $getRow;
        exit();
      } else {
        $errors[] = "Vale E-mail või Parool";
      }
    } else {
      $errors[] = "Vale E-mail või Parool";
    }
  } else {
    $errors[] = "Sisesta E-mail ja Parool";
  }
}
?>


<html>

<head>
  <meta charset="utf-8">
  <title>Logi Sisse</title>
  <meta name="author" content="">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=0.7">

  <link href="css/logform.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
</head>

<body>
  <script type="module">
    /* import {
      initializeApp
    } from "https://www.gstatic.com/firebasejs/9.3.0/firebase-app.js";
    import {
      getDatabase
    } from "https://www.gstatic.com/firebasejs/9.3.0/firebase-database.js";
    var firebaseConfig = {
      apiKey: "AIzaSyD4TvvjsF3V8PNYCgtggR7JeqQZ6yd4zKA",
      authDomain: "bron-dd8b9.firebaseapp.com",
      databaseURL: "https://bron-dd8b9-default-rtdb.europe-west1.firebasedatabase.app",
      projectId: "bron-dd8b9",
      storageBucket: "bron-dd8b9.appspot.com",
      messagingSenderId: "93398284427",
      appId: "1:93398284427:web:d363cb62211dfea9b57c8e"
    };
    const app = initializeApp(firebaseConfig);
    const db = getDatabase();

    function login() {
      var email = document.getElementById("username").value;
      var password = document.getElementById("password").value;
    }; */




    // IsloggedIn


    /* import {
      getAuth,
      onAuthStateChanged
    } from "https://www.gstatic.com/firebasejs/9.3.0/firebase-auth.js";
    const auth = getAuth();
    onAuthStateChanged(auth, (user) => {
      if (user) {
        // User is signed in, see docs for a list of available properties
        // https://firebase.google.com/docs/reference/js/firebase.User
        const uid = user.uid;
        // ...
      } else {
        // User is signed out
        // ...
      }
    });


    // Password authentication


    import {
      getAuth,
      createUserWithEmailAndPassword
    } from "https://www.gstatic.com/firebasejs/9.3.0/firebase-auth.js";

    const auth = getAuth();
    createUserWithEmailAndPassword(auth, email, password)
      .then((userCredential) => {
        // Signed in 
        const user = userCredential.user;
        // ...
      })
      .catch((error) => {
        const errorCode = error.code;
        const errorMessage = error.message;
        // ..
      }); */
  </script>
  <div class="login-div">
    <div class="logo"></div>
    <div class="title">RestoBronn</div>
    <div class="sub-title"></div>

    <?php
        if (isset($errors) && count($errors) > 0) {
            foreach ($errors as $error_msg) {
                echo '<div class="alert alert-danger">' . $error_msg . '</div>';
            }
        }

        if (isset($success)) {

            echo '<div class="alert alert-success">' . $success . " logout" . '</div>';
            
        }
        
        ?>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="fields">

        <div class="username"><svg class="svg-icon" viewBox="0 0 20 20">
            <path d="M17.388,4.751H2.613c-0.213,0-0.389,0.175-0.389,0.389v9.72c0,0.216,0.175,0.389,0.389,0.389h14.775c0.214,0,0.389-0.173,0.389-0.389v-9.72C17.776,4.926,17.602,4.751,17.388,4.751 M16.448,5.53L10,11.984L3.552,5.53H16.448zM3.002,6.081l3.921,3.925l-3.921,3.925V6.081z M3.56,14.471l3.914-3.916l2.253,2.253c0.153,0.153,0.395,0.153,0.548,0l2.253-2.253l3.913,3.916H3.56z M16.999,13.931l-3.921-3.925l3.921-3.925V13.931z"></path>
          </svg>
          <input class="form-control" type="username" name="username" id="username" placeholder="Email" />
        </div>

        <div class="password" class="form-group">
          <svg class="svg-icon" viewBox="0 0 20 20">
            <path d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path>
          </svg>
          <input type="password" name="password" id="password" class="pass-input" placeholder="Parool" />
        </div>

      </div>


      <button type="submit" name="submit" id="submit" class="signin-button">LOGIN</button>

      <div class="link">
        <a href="#"></a>Uus kasutaja? <a href="register.php">Registreeri</a>
      </div>
    </form>
  </div>
</body>

</html>