<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>StudioM Fotografia</title>
</head>
<link href="layout/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
<link href="layout/dist/css/style.min.css" rel="stylesheet">
<link rel="icon" type="image/png" sizes="32x32" href="imgs/logo1.png">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
<script type="text/javascript">
    /* MÃ¡scaras ER */
    function mascara(o, f) {
        v_obj = o
        v_fun = f
        setTimeout("execmascara()", 1)
    }

    function execmascara() {
        v_obj.value = v_fun(v_obj.value)
    }

    function mtel(v) {
        v = v.replace(/\D/g, "");             //Remove tudo o que nÃ£o Ã© dÃ­gito
        v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
        v = v.replace(/(\d)(\d{4})$/, "$1-$2");    //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
        return v;
    }

    function id(el) {
        return document.getElementById(el);
    }

    window.onload = function () {
        id('celular').onkeypress = function () {
            mascara(this, mtel);
        }
    }


</script>
<style>

    body {
        background-image: url("imgs/fundo.png");
    }

    #logo{
        text-align: center;
    }
    
    #fale_texto{
        margin-left: 26.5%;
        margin-bottom: -1%;
        font-family:"Nunito Sans",sans-serif;
        font-weight: 600;
    }
    #logo img{
        width: 16%;
        height: auto;
    }
    #enviar{
        bottom: 40px;
    }
</style>
<script type="text/javascript" src="aplicacoes/aplicjava.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>

<body>
<br>
<br>
<div class="container">
    <div id="logo">
        <img src="imgs/Studio%20M%20-%20Logo-01.png">
        <br>
        <br>
    </div>
    <h3 id="fale_texto">Fale Conosco</h3>
    <table width="100%">
        <tr>
            <td width="15%"></td>
            
        </tr>
    </table>
    <form action="fale_conosco_email.php" class="form-horizontal" method="post">
        <div class="card-body">
            <div class="form-group row">
                <label for="nome" class="col-sm-3 text-right control-label col-form-label">Nome:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu Nome" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 text-right control-label col-form-label">E-mail:</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu E-mail" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="celular" class="col-sm-3 text-right control-label col-form-label">Celular:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="celular" name="celular" placeholder="Número do seu celular" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="instituicao" class="col-sm-3 text-right control-label col-form-label">Instituição de Ensino:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="instituicao" name="instituicao" placeholder="Nome de sua Instituição de Ensino" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 text-right control-label col-form-label">Serviço:</label>
                <div class="col-sm-9">
                    <div class="custom-control custom-radio">
                        <input type="checkbox" class="custom-control-input" id="servico1" name="servico1">
                        <label class="custom-control-label" for="servico1">Convite</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="checkbox" class="custom-control-input" id="servico2" name="servico2">
                        <label class="custom-control-label" for="servico2">Fotografia</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="conteudo" class="col-sm-3 text-right control-label col-form-label">Assunto:</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="conteudo" rows="3" placeholder="Escreva Aqui" required></textarea>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group m-b-0 text-right">
                <button id="enviar" class="btn col-2 btn-primary btn-md waves-effect waves-light" type="submit"><span class="btn-label"><i class="far fa-envelope"></i></span> Enviar</button>
            </div>
        </div>
    </form>

</div>

</body>
</html>