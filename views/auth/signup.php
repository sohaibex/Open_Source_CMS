<?php
require_once "../../vendor/autoload.php";
require_once "../../core/init.php";

use classes\{Validation, Token, Hash, Session};
use models\User;

$login_failure_message = "";
$user_data = [
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'username' => ''
];

if (isset($_POST['signup'])) {
    if (Token::check($_POST['_csrf'], '_csrf')) {
        $user_data['firstname'] = $_POST['firstname'];
        $user_data['lastname'] = $_POST['lastname'];
        $user_data['username'] = $_POST['username'];
        $user_data['email'] = $_POST['email'];

        $validator = new Validation();

        $validator->check($_POST, array(
            "firstname" => array(
                "name" => "Firstname",
                "min" => 2,
                "max" => 50
            ),
            "lastname" => array(
                "name" => "Lastname",
                "min" => 2,
                "max" => 50
            ),
            "username" => array(
                "name" => "Username",
                "required" => true,
                "min" => 5,
                "max" => 20,
                "unique" => true
            ),
            "email" => array(
                "name" => "Email",
                "required" => true,
                "email-or-username" => true
            ),
            "password" => array(
                "name" => "Password",
                "required" => true,
                "min" => 6
            ),
            "confirm_password" => array(
                "name" => "Repeated password",
                "required" => true,
                "matches" => "password"
            ),
        ));

        if ($validator->passed()) {
            $salt = Hash::salt(16);

            $user = new User();
            $data = array(
                "firstname" => $_POST['firstname'],
                "lastname" => $_POST['lastname'],
                "username" => $_POST['username'],
                "email" => $_POST['email'],
                "password" => Hash::make($_POST['password'], $salt),
                "salt" => $salt,
                "joined" => date("Y/m/d h:i:s"),
            );
            $user->register($data);

            // Here try to create all folders needed to store everything about user
            //mkdir("../../data/users/" . $_POST['username']."/");

            /* The following flash will be shown in the index page if the user is new, and we'll also check if the user registered 
                is the same person log in because the user could create a new account but login with other account, in that case we won't
                show any welcome message*/

            Session::flash("register_success", "Your account has been created successfully !");
            header("location: login.php");
        } else {
            $login_failure_message = $validator->errors()[0];
            $login_failure_message = <<<L_ERR_MSG
                <div class="error-message-wrapper">
                    <p class="error-message">$login_failure_message</p>
                </div>
L_ERR_MSG;
        }
    }
}

$_csrf = Token::generate('_csrf');
?>

<link rel="stylesheet" href="../../public/css/global.css">
<?php include '../../layout/header.php' ?>
<div class="account-pages my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-md-12 p-5  mx-auto">
                                <div class="mx-auto mb-3">
                                    <a href="/">
                                        <h3 class="d-inline align-middle ml-1 text-logo">CMS</h3>
                                    </a>
                                </div>

                                <h6 class="h5 mb-0 mt-4">Create your account</h6>
                                <br>

                                <?php echo $login_failure_message; ?>

                                <form method="POST" action="" class="authentication-form">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">First Name</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-user"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" name="firstname" class="form-control " id="FirstName" placeholder="Enter Your First Name " value="<?php echo $user_data['firstname']; ?>" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-control-label">Last Name</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-user"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" name="lastname" class="form-control " id="lastname" placeholder="Enter Your Last Name " value="<?php echo $user_data['lastname']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <label class="form-control-label">Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-lock"></i>
                                                            </span>
                                                        </div>
                                                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" />
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Email Address</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-envelope"></i>
                                                            </span>
                                                        </div>
                                                        <input type="email" name="email" class="form-control" id="email" placeholder="Your Email" value="<?php echo $user_data['email']; ?>" />


                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-control-label">UserName</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-user"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" name="username" class="form-control" id="username" placeholder="Your Email" value="<?php echo $user_data['username']; ?>" />


                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label class="form-control-label">Re-Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-lock"></i>
                                                            </span>
                                                        </div>
                                                        <input type="password" name="confirm_password" class="form-control " id="confirm_password" placeholder="Confirm your password" />

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group mb-0 text-center d-flex justify-content-center mt-2">
                                        <button class="btn btn-primary btn-block d" name="signup" style="width: 50%" type="submit">Sign Up</button>
                                        <input type="hidden" name="_csrf" value="<?php echo $_csrf; ?>">
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Already have account? <a href="/Open_Source_CMS/views/auth/login.php" class="text-primary font-weight-bold ml-1">Login</a>
                            </p>
                        </div>
                    </div>


                </div>
            </div>

        </div>

    </div>