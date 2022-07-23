                                    <?php 

                                    include"../includes/conexao.php";


                                    $id_chat = $_GET['id_chat'];

                                    ?>
                                    
                                    <?php 

                                    $sql_ultimas_mensagens = mysqli_query($con, "select * from chat_mensagens where id_chat = '$id_chat' order by id_mensagem DESC");
                                    
                                    while($vetor_mensagens = mysqli_fetch_array($sql_ultimas_mensagens)) { 

                                    if($vetor_mensagens['tipo'] == 1) {

                                    ?>

                                    <li class="odd chat-item">
                                        <div class="chat-content">
                                            <div class="box bg-light-inverse"><?php echo $vetor_mensagens['mensagem']; ?></div>
                                            <div class="chat-time"><?php echo date('d/m/Y', strtotime($vetor_mensagens['data'])); ?> / <?php echo $vetor_mensagens['hora']; ?></div>
                                            <br>
                                        </div>
                                    </li>

                                    <?php 

                                	} if($vetor_mensagens['tipo'] == 2) { 

                                	$sql_formando_chat = mysqli_query($con, "select * from formandos where id_formando = '$vetor_mensagens[id_usuario]'");
                                	$vetor_formando_chat = mysqli_fetch_array($sql_formando_chat);

                                	?>

                                    <li class="chat-item">
                                        <div class="chat-img"><img src="arquivos/<?php echo $vetor_formando['imagem']; ?>" alt="user"></div>
                                        <div class="chat-content">
                                            <h6 class="font-medium"><?php echo $vetor_formando_chat['nome']; ?></h6>
                                            <div class="box bg-light-info"><?php echo $vetor_mensagens['mensagem']; ?></div>
                                        </div>
                                        <div class="chat-time"><?php echo date('d/m/Y', strtotime($vetor_mensagens['data'])); ?> / <?php echo $vetor_mensagens['hora']; ?></div>
                                    </li>
                                    
                                    <?php } } ?>
