<?php
    include "../includes/conexao.php";
    
    
    function retorna($id_turma, $con){
        $sql_turma = mysqli_query($con, "SELECT * FROM formandos WHERE turma = '$id_turma'");
        $sql_convite = mysqli_query($con, "SELECT * FROM dados_convite WHERE id_turma = '$id_turma'");   
       
        if (mysqli_num_rows($sql_turma)>0) {
            while($row_turma = mysqli_fetch_assoc($sql_turma)){
                
                $result[]= $row_turma["nome"]; 
              

            }   
                $valores['lista_nometurma'] =  $result;    
                       
        }else {
           $valores['lista_nometurma'] = 'Turma não encontrada';        
        }
    
        if (mysqli_num_rows($sql_convite)>0) {
            while($row_convite = mysqli_fetch_assoc($sql_convite)){

                $result2[]= $row_convite["patrono"];
                $result3[]=  $row_convite["parainfo"];
                $result4[]= $row_convite["professores"];
                $result5[]= $row_convite["colacaograu"];
                $result6[]= $row_convite["jantardospais"];
                $result7[]= $row_convite["cultoecumenico"];
                $result8[]= $row_convite["colacaograu"];
                $result9[]= $row_convite["bailedeformatura"];
            }   
                    
                $valores['patrono'] =  $result2;
                $valores['parainfo'] =  $result3;
                $valores['professores'] =  $result4;   
                $valores['colacaograuOfc'] =  $result5;
                $valores['jantardospais'] =  $result6;
                $valores['cultoecumenico'] =  $result7;
                $valores['colacaograu'] =  $result8;
                $valores['bailedeformatura'] =  $result9;          
        }else {
        
            $valores['patrono'] =  'Turma não encontrada';
            $valores['parainfo'] =  'Turma não encontrada';
            $valores['professores'] =  'Turma não encontrada';  
            $valores['colacaograuOfc'] =  'Turma não encontrada';
            $valores['jantardospais'] =  'Turma não encontrada';
            $valores['cultoecumenico'] =  'Turma não encontrada';
            $valores['colacaograu'] =  'Turma não encontrada';
            $valores['bailedeformatura'] =  'Turma não encontrada';
            
        }
        
        
        return  json_encode($valores);

    }  

    if (isset($_GET['id_turma'])) {
        
        echo retorna($_GET['id_turma'], $con);
    }                                                        
         

    
                                                                
?>