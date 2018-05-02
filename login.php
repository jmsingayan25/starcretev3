<!DOCTYPE html>
<?php

    include("includes/config.php");
    include("includes/function.php");
    
    session_start();
    if(isset($_SESSION['login_user']) && isset($_SESSION['login_office'])) {
        if($_SESSION['login_office'] == 'head'){
            header("location: admin/index.php");    
        }else{
            header("location: plant/index.php");
        }
    }
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Login Page | Starcrete Manufactoring Corporation</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-img3-body">
    <div class="container">
        <form class="login-form" action="login.php" method="post">        
            <div class="login-wrap">
                <p class="login-img"><i class="icon_lock_alt"></i></p>
                    <div class="alert alert-danger" id="error_msg" style="display: none;">
                        <span class="glyphicon glyphicon-remove"></span> Your Username or Password is invalid.
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon_profile"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>" required autofocus>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" required>
                    </div>
                    <div class="input-group">
                        <div class="col-lg-12">
                            <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" id="remember"> Remember me
                            </label>
                            </div>
                        </div>
                    </div>
                <input class="btn btn-primary btn-lg btn-block" name="login-submit" id="login-submit" type="submit" value="Login">
            </div>
        </form>
        <div class="text-right">
            <div class="credits">
                <!-- 
                All the links in the footer should remain intact. 
                You can delete the links only if you purchased the pro version.
                Licensing information: https://bootstrapmade.com/license/
                Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
                -->
                <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php

if(isset($_POST['login-submit'])){

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, crypt($_POST['password'],'$1$' . $_POST['password']));
    $sql = "SELECT user_id, office FROM users WHERE username = '$username' AND `password` = '$password'";

    $result = mysqli_query($db,$sql);
    $count = mysqli_num_rows($result);

    // $stmt = $db->prepare('SELECT user_id, office FROM users WHERE username = ? AND `password` = ?');
    // $stmt->bind_param('ss', $username, $password);
    // $stmt->bind_param('ss', $username, crypt($password,'$1$' . $password));

    // $stmt->execute();
    // $count = $stmt->get_result();
    if($count == 1) {

        if(!empty($_POST["remember"])) {
            setcookie ("username",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
            setcookie ("password",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
        } else {
            if(isset($_COOKIE["username"])) {
                setcookie ("username","");
            }
            if(isset($_COOKIE["password"])) {
                setcookie ("password","");
            }
        }

        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['login_user'] = $username;
        $_SESSION['login_office'] = $row['office'];
        if($row['office'] == 'head'){
            header("location: admin/index.php");
        }else if($row['office'] != 'head'){
            header("location: plant/index.php");
        }else{
            header("location: login.php");
        }
    }else{
        // phpAlert("Your Username or Password is invalid");
        echo "<script> 

            $(document).ready(function(){
                $('#error_msg').fadeTo(2000, 500).slideUp(500, function(){
                    $('#error_msg').slideUp(500);
                });
            });
        </script>";
    }
}   

?>
