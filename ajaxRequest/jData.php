<?php 

require_once ("./../class/classConexao.php");
require_once ("./../class/classEmployee.php");


// $_POST['EMP_NO']  = '10011';
// $_POST['DEPT_NO'] = 'd009';
// $_POST['metodo']  = 'ajax_departamento_funcionarios';


if (function_exists($_POST['metodo']))  {
    call_user_func_array($_POST['metodo'], $_POST);    
} else  {
    echo 'O metodo ' . $_POST['metodo'] . ' não existe';
}


function ajax_teste(){

    $conexao   = new Conexao();
    $Empregado = new Employee($conexao);
    
    $result = $Empregado->consulta_teste();

    if ($result == false){
        echo 0;
    } else {
        echo json_encode($result);    
    }
   
}


function ajax_funcionario_salario_todos(){

    $conexao   = new Conexao();
    $Empregado = new Employee($conexao);
    
    $result = $Empregado->funcionario_salario_todos();

    if ($result == false){
        echo 0;
    } else {
        echo json_encode($result);    
    }
   
}




function ajax_funcionario_salario_anual(){

    $emp_no   = $_POST['EMP_NO'];

    $conexao   = new Conexao();
    $Empregado = new Employee($conexao);
    
    $result = $Empregado->funcionario_salario_anual($emp_no);

    if ($result == false){
        echo 0;
    } else {
        echo json_encode($result);    
    }
   
}


function ajax_funcionario_inicial_nome(){

    $conexao   = new Conexao();
    $Empregado = new Employee($conexao);
    
    $result = $Empregado->funcionario_inicial_nome();

    if ($result == false){
        echo 0;
    } else {
        echo json_encode($result);
    }
   
}


function ajax_lista_departamentos(){

    $conexao   = new Conexao();
    $Empregado = new Employee($conexao);
    
    $result = $Empregado->departamentos();

    if ($result == false){
        echo 0;
    } else {
        echo json_encode($result);
    }
   
}

function ajax_departamento_funcionarios(){

    $dept_no   = $_POST['DEPT_NO'];
    $genero    = $_POST['GENERO'];
    $inicial   = $_POST['INICIAL'];

    $conexao   = new Conexao();
    $Empregado = new Employee($conexao);
    
    $result = $Empregado->departamento_funcionarios($dept_no, $genero, $inicial);

    if ($result == false){
        echo 0;
    } else {
        echo json_encode($result);
    }
   
}

function ajax_departamento_salarios(){

    $conexao   = new Conexao();
    $Empregado = new Employee($conexao);
    
    $result = $Empregado->departamento_salarios();

    if ($result == false){
        echo 0;
    } else {
        echo json_encode($result);    
    }
   
}