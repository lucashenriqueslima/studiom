<?php

	include"../includes/conexao.php";

	 
	 session_start();

	if($_SESSION['id_formando'] == NULL && $_SESSION['comissao'] == NULL) {
	
	echo"<script language=\"JavaScript\">
	location.href=\"index.php\";
	</script>";
	
	} else {
		
	$sql_cadastro = "select * from formandos where id_formando = '$_SESSION[id_formando]'";
	$res_cadastro = mysqli_query($con, $sql_cadastro);
	$vetor_cadastro = mysqli_fetch_array($res_cadastro);

	$sql_turma = mysqli_query($con, "select * from turmas where id_turma = '$vetor_cadastro[turma]'");
	$vetor_turma = mysqli_fetch_array($sql_turma);
	
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Studiom Fotografia</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Studiom Fotografia" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link rel="stylesheet" href="../sistema/layout/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../sistema/layout/bower_components/fullcalendar/dist/fullcalendar.min.css">
<link rel="stylesheet" href="../sistema/layout/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
<!-- Custom Theme files -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery.min.js"> </script>
<!-- Mainly scripts -->
<script src="js/jquery.metisMenu.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<link href="css/custom.css" rel="stylesheet">
<script src="js/custom.js"></script>
<script src="js/screenfull.js"></script>
		<script>
		$(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

			if (!screenfull.enabled) {
				return false;
			}

			

			$('#toggle').click(function () {
				screenfull.toggle($('#container')[0]);
			});
			

			
		});
		</script>

<!----->

<!--pie-chart--->
<script src="js/pie-chart.js" type="text/javascript"></script>
 <script type="text/javascript">

        var colorStyle = document.getElementsByClassName('fc-title');

for (var i=0; i<colorStyle.length; i++) {
    colorStyle[i].style.color = '#000000';
}

    </script>
<!--skycons-icons-->
<script src="js/skycons.js"></script>

<style type="text/css">
	.img-circle {
		border-radius: 50%;
	}

  .portlet.calendar .fc-event .fc-time {
    color: #000000;
  }

  .fc-day-grid-event > .fc-content {
    white-space: inherit;
  }
</style>
<!--//skycons-icons-->
</head>
<body>
<div id="wrapper">

<!----->
        <nav class="navbar-default navbar-static-top" role="navigation">
             <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <h1> <a class="navbar-brand" href="index.php">Área da Comissão</a></h1>         
			   </div>
			 <div class=" border-bottom">
        	<div class="full-left">
        	  Seja Bem Vindo, <?php echo $vetor_cadastro['nome']; ?>.
            <div class="clearfix"> </div>
           </div>
     
       
            <!-- Brand and toggle get grouped for better mobile display -->
		 
		   <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="drop-men" >
		        <ul class=" nav_1">
		           
		    		
					<li class="dropdown">
		              
		            </li>
		           
		        </ul>
		     </div><!-- /.navbar-collapse -->
			<div class="clearfix">
       
     </div>
	  
		    <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">

                <div align="center"><img src="../sistema/arquivos/<?php echo $vetor_turma['logo']; ?>" width="100px" height="100px"></div>

                <ul class="nav" id="side-menu">
				
                    <?php include"includes/menu.php"; ?>
                    
                </ul>
            </div>
			</div>
        </nav>
        <div id="page-wrapper" class="gray-bg dashbard-1">
       <div class="content-main">
 
  		<!--banner-->	
		    <div class="banner">
		   
				<h2>
				<a href="index.php">Home</a>
				<i class="fa fa-angle-right"></i>
				<span>Calendário</span>
				</h2>
		    </div>
		<!--//banner-->
		<!--content-->
		<div class="content-top">
		
		<div class="grid-form table-responsive">

		  <div class="grid-form1 table-responsive">	
			
		<div class="row">
        
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
		
		</div>
		</div>
			
		</div>
		<!--//content-->

<!-- Main content -->
  
     <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
      <div class="modal-content">
      <form class="form-horizontal" method="POST" action="addEvent.php">
      
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Adicionar um Evento</h4>
        </div>
        <div class="modal-body">
        
          <div class="form-group">
          <label for="title" class="col-sm-2 control-label">Titulo</label>
          <div class="col-sm-10">
            <input type="text" name="title" class="form-control" id="title" placeholder="Title">
          </div>
          </div>
          <div class="form-group">
          <label for="color" class="col-sm-2 control-label">Cor</label>
          <div class="col-sm-10">
            <select name="color" class="form-control" id="color">
              <option value="">Escolha</option>
              <option style="color:#0071c5;" value="#0071c5">&#9724; Azul escuro</option>
              <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
              <option style="color:#008000;" value="#008000">&#9724; Verde</option>             
              <option style="color:#FFD700;" value="#FFD700">&#9724; Amarelo</option>
              <option style="color:#FF8C00;" value="#FF8C00">&#9724; Laranja</option>
              <option style="color:#FF0000;" value="#FF0000">&#9724; Vermelho</option>
              <option style="color:#000;" value="#000">&#9724; Preto</option>
              
            </select>
          </div>
          </div>
          <div class="form-group">
          <label for="start" class="col-sm-2 control-label">Inicio</label>
          <div class="col-sm-10">
            <input type="text" name="start" class="form-control" id="start" >
          </div>
          </div>
          <div class="form-group">
          <label for="end" class="col-sm-2 control-label">Fim</label>
          <div class="col-sm-10">
            <input type="text" name="end" class="form-control" id="end" >
          </div>
          </div>
        
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
      </div>
      </div>
    </div>
    
    
    
    <!-- Modal -->
    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
      <div class="modal-content">
      <form class="form-horizontal" method="POST" action="reenvioagenda.php">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agenda</h4>
        </div>
        <div class="modal-body">
        
          <div class="form-group">
          <label for="title" class="col-sm-2 control-label">Titulo</label>
          <div class="col-sm-10">
            <input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
          </div>
          </div>
          <div class="form-group">
          <label for="color" class="col-sm-2 control-label">Texto</label>
          <div class="col-sm-10">
            <input type="text" name="color" class="form-control" id="color" placeholder="Texto">

          </div>
          </div>

          <div class="form-group">
          <label for="color" class="col-sm-2 control-label">Hora de início</label>
          <div class="col-sm-10">
            <input type="time" name="hora" class="form-control" id="hora" placeholder="Hora de início">

          </div>
          </div>  

          <div class="form-group">
          <label for="color" class="col-sm-2 control-label">Hora de Término</label>
          <div class="col-sm-10">
            <input type="time" name="horafim" class="form-control" id="horafim" placeholder="Hora de Término">

          </div>
          </div>         
            
          
          <input type="hidden" name="id" class="form-control" id="id">
        
        
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
        </div>
      </form>
      </div>
      </div>
    </div>
</div>
	 
		<!---->
<div class="copy">
            <p> &copy; 2019 Studiom Fotografia. Todos Direitos Reservados.</p>
	    </div>
		</div>
		<div class="clearfix"> </div>
       </div>
     </div>
<!---->
<!--scrolling js-->
	<script src="../sistema/layout/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../sistema/layout/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../sistema/layout/bower_components/moment/moment.js"></script>
<script src="../sistema/layout/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src='../sistema/layout/bower_components/fullcalendar/dist/locale/pt-br.js'></script>



<!-- Page specific script -->
<script>
  $(document).ready(function() {
    
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      },
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      selectable: true,
      selectHelper: true,
      
      eventClick: function(eventObj) {
        if (eventObj.url) {

          window.open(eventObj.url);

          return false; // prevents browser from following link in current tab.
        } else {
          
        }
      },
      
      events: [
      <?php 
    
    $categoria = $_POST['categoria'];
    
    $sql_calendario = mysqli_query($con, "select * from calendario where contrato = '$vetor_cadastro[turma]'");

    while($event = mysqli_fetch_array($sql_calendario)) { 

    $sql_departamento = mysqli_query($con, "select * from departamentos where id_departamento = '$event[departamento]'");
    $vetor_departamento = mysqli_fetch_array($sql_departamento);
      
        $start = explode(" ", $event['data']);
        $end = explode(" ", $event['data']);
        if($start[1] == '00:00:00'){
          $start = $start[0];
        }else{
          $start = $event['data'];
        }
        if($end[1] == '00:00:00'){
          $end = $end[0];
        }else{
          $end = $event['end'];
        }

        $horaexplode = explode(':', $event['hora']); 
        $horagerada = $horaexplode[0].':'.$horaexplode[1];

      ?>
        {
          id: '<?php echo $event['id_calendario']; ?>',
          title: '<?php echo $horagerada; ?> - <?php echo $event['titulo']; ?>',
          start: '<?php echo $start; ?>',
          backgroundColor: '<?php echo $vetor_departamento['corcalendario']; ?>',
          borderColor    : '#ffffff',
          end: '<?php echo $end; ?>',
          hora: '<?php echo $event['hora']; ?>',
          horafim: '<?php echo $event['horafim']; ?>',
          url: 'listareventos.php?id=<?php echo $event['id_calendario']; ?>',
          color: '',
        },
      <?php } ?>
      ]
    });
    
    function edit(event){
      start = event.start.format('YYYY-MM-DD HH:mm:ss');
      if(event.end){
        end = event.end.format('YYYY-MM-DD HH:mm:ss');
      }else{
        end = start;
      }
      
      id =  event.id;
      
      Event = [];
      Event[0] = id;
      Event[1] = start;
      Event[2] = end;
      
      $.ajax({
       url: 'editEventDate.php',
       type: "POST",
       data: {Event:Event},
       success: function(rep) {
          if(rep == 'OK'){
            alert('Saved');
          }else{
            alert('Foi alterado com sucesso!!!'); 
          }
        }
      });
    }
    
  });

</script>

</body>
</html>
<?php } ?>