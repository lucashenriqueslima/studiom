<?php
define('SITE_KEY', '6LemvAEVAAAAAMvx2hXIVClqf770Y4QyW12YolZK');
define('SECRET_KEY', '6LemvAEVAAAAANihnIZdM1juNK0N7kx1QnWE0aJ2');
if ($_POST) {
	function getCaptcha($SecretKey)
	{
		$Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response=($SecretKey)");
		$Return = json_decode($Response);
		return $Return;
	}
	
	$Return = getCaptcha($_POST['g-recaptcha-response']);
	if ($Return->success == true && $Return->score > 0.5) {
		echo "Success!";
	}else {
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
    <link rel="icon" type="image/png" sizes="16x16" href="../layout/assets/images/favicon.png">
    <title>Studio M Fotografia</title>
    <!-- Custom CSS -->
    <link href="../layout/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
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
         style="background:url(../layout/assets/images/big/auth-bg.jpg) no-repeat center center;">
        <div class="auth-box">
            <div id="loginform">
                <div class="logo">
                    <span class="db"><img src="../layout/assets/images/logo-icon.png" alt="logo"/></span>
                    <br>
                    <br>
                    <h5 class="font-medium mb-3">Acesso ao Sistema</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form class="form-horizontal mt-3" method="POST" id="loginform" action="logando.php">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                </div>
                                <input type="text" name="usuario" class="form-control form-control-lg"
                                       placeholder="Nome de Usuário" aria-label="Usuário"
                                       aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                </div>
                                <input type="password" name="senha" class="form-control form-control-lg"
                                       placeholder="Sua Senha" aria-label="Sua Senha" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <input type="hidden" class="g-recaptcha" id="g-recaptcha-response"
                                       name="g-recaptcha-response"></div>

                            <div class="form-group">
                                <div style="margin-top: -4%" class="text-left">
                                    Não é cadastrado? <a href="../efetuarcadastro.html" class="text-info ml-1"><b>Faça
                                            seu
                                            cadastro</b></a>
                                    <br>
<!--                                    Esqueceu a senha?<a href="../recuperarsenha.php?u=1" class="text-info ml-1"><b>Recuperar Senha</b></a>-->
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn col-8 btn-md btn-info" type="submit">Entrar</button>
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
<script src="../layout/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="../layout/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="../layout/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
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