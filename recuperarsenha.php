<?php
include "includes/conexao.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
if (isset($_POST['formando'])) {
    $mail = new PHPMailer(true);

    $email = $_POST['email'];

    $sql = mysqli_query($con, "select * from formandos where email = '$email'");
    
    if (mysqli_num_rows($sql) == 0) {

        echo "<script> alert('E-mail não encontrado, favor verificar!')</script>";
        echo "<script> window.location.href='recuperarsenha.php'</script>";

    } else {
	    $vetor = mysqli_fetch_array($sql);
	    $password = $vetor['cpf'];
	    $hash = password_hash($password,PASSWORD_DEFAULT);
	    $sql = mysqli_query($con, "update formandos SET senha = '$hash' where email = '$email'");

        $to = $email;

        $subject = 'Recuperação de Senha';

        $message = '<!DOCTYPE html>
  <html>
  <head>
      <title></title>
  </head>
  <body>
  <table width="100%">
      <tr>
          <td>
              <img src="https://studiomfotografia.com.br/sistema/imgs/LOGOS-LOGIN.png" width="200px">
          </td>
      </tr>
      <tr>
          <td><br><br></td>
      </tr>
      <tr>
          <td>
      Caro(a) ' . $vetor['nome'] . ', seu login e senha de acesso a Área do Formando é:

      <br>

	  <br>

      <strong>Login: ' . $vetor['email'] . '</strong>
      <br>
      <strong>Senha: ' . $vetor['cpf'] . '</strong>

      <br>
      <br>
      <br>

      Para alterar sua senha basta acessar o sistema e em meu cadastro clicar em alterar senha.

      <br>
      <br>
      <br>

      Obrigado.

	  <br>
	  <br>
	  <br>

	  Studio M Fotografia
	  </td>
	      </tr>
	  </table>
	  </body>
	  </html>';
        $remetente = 'cadastro@studiomfotografia.com.br';
        try {
            //Server settings
//    $mail->SMTPDebug = 1;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'studiomfotografia.com.br';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'contato@studiomfotografia.com.br';                 // SMTP username
            $mail->Password = 'c&GM^NM20gLE';                           // SMTP password
            $mail->SMTPSecure = 'TLS';                            // SMTP password
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->CharSet = "UTF-8";

            //Recipients
            $mail->setFrom($remetente, 'StudioM Fotografia');
            $mail->addAddress($to);    // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->MsgHTML($message);

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
        echo "<script> window.location.href='arearestrita/index.php'</script>";
    }
}elseif (isset($_POST['usuario'])){
    $mail = new PHPMailer(true);

    $email = $_POST['email'];

    $sql = mysqli_query($con, "select * from usuarios where email = '$email'");
    
    if (mysqli_num_rows($sql) == 0) {

        echo "<script> alert('E-mail não encontrado, favor verificar!')</script>";
        echo "<script> window.location.href='recuperarsenha.php'</script>";

    } else {
	    $vetor = mysqli_fetch_array($sql);
	    $password = 'gKD3@kp484';
	    $hash = password_hash($password,PASSWORD_DEFAULT);
	    $sql = mysqli_query($con, "update usuarios SET senha = '$hash' where email = '$email'");
	    
        $to = $email;

        $subject = 'Recuperação de Senha';

        $message = '<!DOCTYPE html>
  <html>
  <head>
      <title></title>
  </head>
  <body>
  <table width="100%">
      <tr>
          <td>
              <img src="https://studiomfotografia.com.br/sistema/imgs/LOGOS-LOGIN.png" width="200px">
          </td>
      </tr>
      <tr>
          <td><br><br></td>
      </tr>
      <tr>
          <td>
      Caro(a) ' . $vetor['nome'] . ', seu login e senha de acesso a Área Restrita é:

      <br>

	  <br>

      <strong>Login: ' . $vetor['email'] . '</strong>
      <br>
      <strong>Senha: ' . $password . '</strong>

      <br>
      <br>
      <br>

      Para alterar sua senha basta acessar o sistema e em meu cadastro clicar em alterar senha.

      <br>
      <br>
      <br>

      Obrigado.

	  <br>
	  <br>
	  <br>

	  Studio M Fotografia
	  </td>
	      </tr>
	  </table>
	  </body>
	  </html>';
        $remetente = 'cadastro@studiomfotografia.com.br';
        try {
            //Server settings
//    $mail->SMTPDebug = 1;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'studiomfotografia.com.br';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'contato@studiomfotografia.com.br';                 // SMTP username
            $mail->Password = 'c&GM^NM20gLE';                           // SMTP password
            $mail->SMTPSecure = 'TLS';                            // SMTP password
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->CharSet = "UTF-8";

            //Recipients
            $mail->setFrom($remetente, 'StudioM Fotografia');
            $mail->addAddress($to);    // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->MsgHTML($message);

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
        echo "<script> window.location.href='arearestrita/index.php'</script>";
    }
}


define('SITE_KEY', '6LemvAEVAAAAAMvx2hXIVClqf770Y4QyW12YolZK');
define('SECRET_KEY', '6LemvAEVAAAAANihnIZdM1juNK0N7kx1QnWE0aJ2');
if ($_POST) {
    function getCaptcha($SecretKey)
    {
        $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SECRET_KEY . "&response=($SecretKey)");
        $Return = json_decode($Response);
        return $Return;
    }

    $Return = getCaptcha($_POST['g-recaptcha-response']);
    if ($Return->success == true && $Return->score > 0.5) {
        echo "Success!";
    } else {
        "You are a Robot!";
    }
}
?>
<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="layout/assets/images/favicon.png">
    <title>Studio M Fotografia</title>
    <!-- Custom CSS -->
    <link href="layout/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>s
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<script src='https://www.google.com/recaptcha/api.js?render=<?php echo SITE_KEY; ?>'></script>
<body>
<div class="main-wrapper">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
         style="background:url(layout/assets/images/big/auth-bg.jpg) no-repeat center center;">
        <div class="auth-box">
            <div id="loginform">
                <div class="logo">
                    <span class="db"><img src="layout/assets/images/logo-icon.png" alt="logo"/></span>
                    <br>
                    <br>
                    <h5 class="font-medium mb-3">Esqueceu a Senha?</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form class="form-horizontal mt-3" method="POST" id="loginform" action="recuperarsenha.php">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                </div>
                                <input type="text" name="email" class="form-control form-control-lg"
                                       placeholder="Digite seu e-mail" aria-label="E-mail"
                                       aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <input type="hidden" class="g-recaptcha" id="g-recaptcha-response"
                                       name="g-recaptcha-response"></div>
                            <?php if (isset($_GET['f'])) {
                                echo "<input type='hidden'
                                       name='formando' value='1' hidden>";
                            }elseif (isset($_GET['u'])){
                                echo "<input type='hidden'
                                       name='usuario' value='1' hidden>";
                            } ?>
                            <div class="form-group text-center">
                                <button class="btn col-8 btn-md btn-info" type="submit">Recuperar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- All Required js -->
<!-- ============================================================== -->
<script src="layout/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- ============================================================== -->
<!-- This page plugin js -->
<!-- ============================================================== -->
<script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function () {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
</script>
<script>
    grecaptcha.ready(function () {
        grecaptcha.execute('<?php echo SITE_KEY; ?>', {action: 'index.php'}).then(function (token) {
            // console.log(token);
            document.getElementById('g-recaptcha-response').value = token
        });
    })
</script>
</body>

</html>