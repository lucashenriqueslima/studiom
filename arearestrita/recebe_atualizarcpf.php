<?php

include"../includes/conexao.php";

     
session_start();

$cpfform = $_POST['cpf'];

/* Criando Interface para Exceptions */
interface ExceptionInterface {
}

/* Criando Exception exclusiva para CPF. Ajuda muito a descobrir o tipo da Exception */
class InvalidCpfException extends \InvalidArgumentException implements ExceptionInterface
{

}

class Cpf
{
    private $cpf;

    /**
     * Cpf constructor.
     * @param string $cpf
     */
    public function __construct($cpf)
    {
        if ($this->validate($cpf) === false) {
            throw new InvalidCpfException;
        }
        return $this->cpf = $cpf;
    }

    public function __toString()
    {
        return $this->cpf;
    }

    private function validate($cpf)
    {

        // Extrair somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }
}

//chamada de exemplo:

try{
    
$cpf = new Cpf($cpfform);

$sql = mysqli_query($con, "update formandos SET cpf = '$cpf' where id_formando = '$_SESSION[id_formando]'");

echo "<script> window.location.href='minhascompras.php'</script>";

} catch(InvalidCpfException $e){

echo "<script> alert('CPF inválido.')</script>";
echo "<script> window.location.href='javascript:window.history.go(-1)'</script>";

} catch (Exception $e){

echo "Erro Inesperado";

}