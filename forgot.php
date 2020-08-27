<?php  use PHPMailer\PHPMailer\PHPMailer; ?>

<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php 
    require './phpmailer/vendor/autoload.php';
    require './classes/config.php';
?>
<?php 
    if (!ifItIsMethod('get') && !isset($_GET['forgot'])) { 
        // will find better solution later on the course
        //path without uniqid redirects to index immediately
        redirect('index');
    }
    
    if (ifItIsMethod('post')) { 
        
        if (isset($_POST['email'])) { 
            $email = $_POST['email'];
            $lenght = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($lenght));

            if (email_exists($email)) {

                if ($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email= ?")){
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt); 
                    
                    // Require phpmailer class config
                    // Configure PHPMAILER

                    $mail = new PHPMailer();
                    
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
                    $mail->isSMTP();                        
                    $mail->Host       = Config::SMTP_HOST;                 
                    $mail->Username   = Config::SMTP_USER;     
                    $mail->Password   = Config::SMTP_PASSWORD; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = Config::SMTP_PORT;
                    $mail->SMTPAuth   = true;  
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';


                    $mail->setFrom('murat@phpcmsproject.com', 'Murat');
                    $mail->addAddress($email);
                    $mail->Subject = 'PHP CMS Project';
                    $mail->Body = '<p> Please click to reset your password <a href="http://localhost/cms/reset.php?email='.$email.'&token='.$token.'">http://localhost/cms/reset.php?email='.$email.'&token='.$token.'</a</p>';
                    
                    if ($mail->send()) {
                        $emailSent = true;
                    } else {
                        echo "Error occured while sending email.";
                    }

                } 
            }
        }
    }
?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                        <?php if(!isset( $emailSent)): ?>


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                            <?php else: ?>


                                <h4>Please check your email</h4>


                            <?php endIf; ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

