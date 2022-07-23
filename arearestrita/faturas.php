<?php  
  $valor       = 50; //Valor da parcela  
  $parcelas     = 10; //Número de parcelas  
  $datapagamento1  = "2019-08-30"; //Data do primeiro pagamento  
  $diavencimento   = 30; //Dia de vencimento das parcelas  
  $gravadata     = $datapagamento1;    
  echo '<table border="1">';  
    echo "<tr>";   
      echo "<td>Parcela</td>";    
      echo "<td>Vencimento</td>";        
    echo "</tr>";      
  for ($i = 1; $i <= $parcelas; $i++){      
    //Parcela  
    $parcela = $i."a"; //grava o número da parcela assim: 1a, 2a, 3a, etc...  
    echo "<tr>";  
      echo "<td>";  
        echo $parcela;  
      echo "</td>";      
    //Vencimento      
      echo "<td>";  
        echo $gravadata;  
      echo "</td>";      
    echo "</tr>";  
    if (!empty($diavencimento)){ //Se o dia de vencimento não tiver em branco  
      $dia = $diavencimento; //o dia será igual ao dia de vencimento  
    }else{  
      $dia = date("d",strtotime($gravadata)); //se o dia de vencimento tiver em branco, então o dia será igual ao dia da data de vencimento  
    }  
    $mes = date("m",strtotime($gravadata)) + 1;  
    $ano = date("Y",strtotime($gravadata));  
      if ($mes == 13) { //se passar do mês 12, então inicia com o mes 1 do próximo ano  
      $mes = 1;  
      $ano = $ano + 1;    
    }  
    if ($dia == 30 && $mes == 2){ //fevereiro não pode ter 30 dias não é. kkk  
      $gravadata = $ano."-".$mes."-28";  
    }else{  
      $gravadata = $ano."-".$mes."-".$dia;  
    }  
  }  
  echo "</table>";  
 
  ?>