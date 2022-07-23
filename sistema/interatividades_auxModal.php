<?php
include "../includes/conexao.php";

$id = $_GET['id'];

$dado = mysqli_fetch_array(mysqli_query($con, "SELECT c.id_calendario,c.titulo,c.data,c.datafim,c.hora,c.horafim,c.descricao,c.departamento FROM calendario c WHERE id_calendario = '$id'"));
$depto = mysqli_fetch_array(mysqli_query($con, "SELECT d.nome FROM departamentos d WHERE d.id_departamento = '" . $dado['departamento'] . "'"));

echo "
<div id='myModal' class='modal' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-lg' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title'>" . $depto['nome'] . "</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <div class='row'>
                    <div class='col-lg-12'>
                        <fieldset class='form-group'>
                            <label class='form-label semibold' for='exampleInput'>Titulo</label>
                            <input type='text' name='titulo' class='form-control'
                                   value='" . $dado['titulo'] . "'
                                   placeholder='Digite o Tiulo' readonly>
                        </fieldset>
                    </div>
                </div><!--.row-->

                <div class='row'>
                    <div class='col-lg-12'>
                        <fieldset class='form-group'>
                            <label class='form-label semibold' for='exampleInput'>Data de início</label>
                            <input type='date' name='data' value='" . $dado['data'] . "'
                                   class='form-control' readonly>
                        </fieldset>
                    </div>
                </div><!--.row-->

                <div class='row'>
                    <div class='col-lg-12'>
                        <fieldset class='form-group'>
                            <label class='form-label semibold' for='exampleInput'>Hora de
                                início</label>
                            <input type='time' name='hora' value='" . $dado['hora'] . "'
                                   class='form-control' readonly>
                        </fieldset>
                    </div>
                </div><!--.row-->

                <div class='row'>
                    <div class='col-lg-12'>
                        <fieldset class='form-group'>
                            <label class='form-label semibold' for='exampleInput'>Data de Término</label>
                            <input type='date' name='data' value='" . $dado['datafim'] . "'
                                   class='form-control' readonly>
                        </fieldset>
                    </div>
                </div><!--.row-->

                <div class='row'>
                    <div class='col-lg-12'>
                        <fieldset class='form-group'>
                            <label class='form-label semibold' for='exampleInput'>Hora de
                                Término</label>
                            <input type='time' name='horafim'
                                   value='" . $dado['horafim'] . "' class='form-control'
                                   readonly>
                        </fieldset>
                    </div>
                </div><!--.row-->

                <div class='row'>
                    <div class='col-lg-12'>
                        <fieldset class='form-group'>
                            <label class='form-label semibold' for='exampleInput'>Descrição</label>
                            <textarea name='descricao' class='form-control'
                                      readonly>" . $dado['descricao'] . "</textarea>
                        </fieldset>
                    </div>
                </div><!--.row-->
            </div>
            
            <div class='modal-footer'>
                <a href='vertarefa.php?calendario=sim&id=" . $dado['id_calendario'] . "'>
                    <button type='button' class='btn btn-success'>Editar</button>
                </a>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
            </div>
        </div>
    </div>
</div>
";

?>
<!--    $(document).ready(function () {-->
<!--        $("#myModal").modal('show');-->
<!--    });-->
