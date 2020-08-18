<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php 
    if (isset($_GET['islem'])) {
	
		if ($_POST['eposta']<>'' && $_POST['isim']<>'' && $_POST['konu']<>'' && $_POST['mesaj']<>'') {

	    require_once("class.phpmailer.php");

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "mail.alanadiniz.com veya IP";
        $mail->SMTPAuth = true;
        $mail->Username = "ornek@alanadiniz.com";
        $mail->Password = "*********";
        $mail->From = "ornek@alanadiniz.com";
        $mail->Fromname = $_POST['isim'];
        $mail->AddAddress("ornek@alanadiniz.com","Mail gönderimi");
        $mail->AddReplyTo('replyto@email.com', 'Reply to name');
        $mail->Subject = $_POST['konu'] . $_POST['eposta'];
        $mail->Body = $_POST['mesaj'];

        if(!$mail->Send())
        {
            echo '<font color="#F62217"><b>Gönderim Hatası: ' . $mail->ErrorInfo . '</b></font>';
            exit;
        }
            echo '<font color="#41A317"><b>Mesaj başarıyla gönderildi.</b></font>';
        }   else {
            echo '<font color="#F62217"><b>Tüm alanların doldurulması zorunludur.</b></font>';
        }
}

        // natrohost error log says:
        // PHP Warning:  mail() has been disabled for security reasons in /home/u9533406/public_html/cms/contact.php on line 11.
		// Implementing Natro code
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
                    <h1>Contact Us</h1>
                        <form method="post" action="iletisim.php?islem">

                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="subject" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
                            </div>
                           
                            <div class="form-group">
                                <textarea class="form-control" name="body" id="body" cols="30" rows="10" placeholder="Your message"></textarea>
                            </div>
                    
                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>
                    
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
        <hr>
<?php include "includes/footer.php";?>
