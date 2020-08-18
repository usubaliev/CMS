<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?> 

<?php 
    //if(isset($_POST['register'])) {
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $username = trim($_POST['username']);
            $email    = trim($_POST['email']);
            $password = trim($_POST['password']);
        
            $error = [
                'username'=> '',
                'email'=>'',
                'password'=>''
            ];
        
            if (strlen($username) < 4 ) {
                $error['username'] = "<div class='inlineError_Warning'>Username too short!</div>";
            }
    
            if (strlen($username) =='' ) {
                $error['username'] = "<div class='inlineError_Warning'>Username cannot be empty!</div>";
            }
    
            if (username_exists($username)) {
                $error['username'] = "<div class='inlineError_Warning'>Username already exists! <a href='index.php'>Login here</a></div>";
            }
        
            if ($email =='' ) {
                $error['email'] = "<div class='inlineError_Warning'>Email cannot be empty!</div>"; 
            }
    
            if (email_exists($username)) {
                $error['email'] = "<div class='inlineError_Warning'>Email already exists! <a href='index.php'>Login here</a></div>" ;
            }
    
            if ($password == '') {
                $error['password'] = "<div class='inlineError_Warning'>Enter your password.</div>"; 
            }
        
            foreach ($error as $key => $value) {
                if(empty($value)){
                    unset($error[$key]);  
                }
            } // foreach
            
            if(empty($error)){
                register_user($username, $email, $password);
                login_user($username, $password);
            }
        } 
?>
    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
    
    <!-- Page Content -->
    <div class="container">
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1>Register</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username"
                                    autocomplete="on" value="<?php echo isset($username) ? $username : '' ;?>">
                                    <?php echo isset($error['username']) ? $error['username'] : '' ;?>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com"
                                    autocomplete="on" value="<?php echo isset($email) ? $email : '' ;?>">
                                    <?php echo isset($error['email']) ? $error['email'] : '' ;?>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                    <?php echo isset($error['password']) ? $error['password'] : '' ;?>
                                </div>
                        
                                <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>
                        
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>
    <hr>
<?php include "includes/footer.php";?>
