<?php 

class Employee{

    private $conexao;

    function __construct($conexao){
        $this->conexao = $conexao;
    }

    function consulta_teste(){
        
        $sql = "SELECT * FROM employees limit 5";
        
        $data = $this->conexao->select($sql, 1);

        return $data;

    }

    function funcionario_salario_todos(){

        $sql = "SELECT 
                    E.EMP_NO     AS MATRICULA
                    ,CONCAT_WS(' ', E.FIRST_NAME, E.LAST_NAME) AS NOME
                    ,E.GENDER    AS SEXO
                    ,D.DEPT_NAME AS DEPARTAMENTO
                    ,(SELECT SALARY FROM SALARIES WHERE EMP_NO = E.EMP_NO AND FROM_DATE = (SELECT MAX(FROM_DATE) FROM EMPLOYEES.SALARIES WHERE EMP_NO = E.EMP_NO)) AS SALARIO
                FROM EMPLOYEES E
                INNER JOIN DEPT_EMP    DP ON DP.EMP_NO = E.EMP_NO
                INNER JOIN DEPARTMENTS D  ON D.DEPT_NO = DP.DEPT_NO
                ORDER BY SALARIO DESC";

        $data = $this->conexao->select($sql, 1);

        return $data;

    }


    function funcionario_salario_anual($emp_no){

        $sql = "SELECT  DISTINCT
                        DATE_FORMAT(S.FROM_DATE, '%Y') AS ANO
                        ,(SELECT MAX(S2.SALARY) FROM SALARIES S2 WHERE S2.EMP_NO = S.EMP_NO AND DATE_FORMAT(S2.FROM_DATE, '%Y') = DATE_FORMAT(S.FROM_DATE, '%Y')) AS SALARIO
                FROM SALARIES S
                WHERE S.EMP_NO = $emp_no
                ORDER BY ANO";

        $data = $this->conexao->select($sql, 0);

        return $data;

    }    


    function funcionario_inicial_nome(){

        $sql = "SELECT DISTINCT LEFT(E.FIRST_NAME, 1) AS INICIAL
                FROM EMPLOYEES E
                ORDER BY INICIAL";

        $data = $this->conexao->select($sql, 1);

        return $data;

    }        


    function departamentos(){

        $sql = "SELECT   D.DEPT_NO
                        ,D.DEPT_NAME AS DEPARTAMENTO
                FROM DEPARTMENTS D
                ORDER BY DEPT_NAME";

        $data = $this->conexao->select($sql, 1);

        return $data;

    }    

    function departamento_funcionarios($dept_no, $genero, $inicial){

        $sql = "SELECT   DE.EMP_NO
                        ,CONCAT_WS(' ', E.FIRST_NAME, E.LAST_NAME) AS NOME
                FROM DEPT_EMP DE
                
                -- GARANTE APENAS O SETOR ATUAL DO FUNCIONARIO
                INNER JOIN (
                            SELECT DISTINCT  DE2.EMP_NO
                                            ,(SELECT MAX(FROM_DATE) FROM DEPT_EMP WHERE EMP_NO = DE2.EMP_NO) AS MAX_FROM_DATE
                            FROM DEPT_EMP DE2
                            ) DEP    ON DEP.EMP_NO        = DE.EMP_NO 
                                    AND DEP.MAX_FROM_DATE = DE.FROM_DATE
                
                INNER JOIN EMPLOYEES E ON E.EMP_NO = DE.EMP_NO
                
                WHERE   DE.DEPT_NO            = '$dept_no'
                    AND E.GENDER              = '$genero'
                    AND LEFT(E.FIRST_NAME, 1) = '$inicial'

                ORDER BY NOME";

        $data = $this->conexao->select($sql, 1);

        return $data;

    }           

    function departamento_salarios(){

        $sql = "SELECT   DEPARTAMENTO
                        ,SALARIO
                        ,TOTAL
                        ,FORMAT((SALARIO / TOTAL) * 100, 2) AS PERC
                FROM (
                        SELECT D.DEPT_NAME AS DEPARTAMENTO
                            ,SUM(S.SALARY) AS SALARIO
                            ,(
                                SELECT SUM(S.SALARY) AS SALARIO
                                FROM DEPARTMENTS D
                                INNER JOIN DEPT_EMP DE ON DE.DEPT_NO = D.DEPT_NO
                                INNER JOIN SALARIES S ON S.EMP_NO = DE.EMP_NO
                                ) AS TOTAL
                        FROM DEPARTMENTS D
                        INNER JOIN DEPT_EMP DE ON DE.DEPT_NO = D.DEPT_NO
                        INNER JOIN SALARIES S ON S.EMP_NO = DE.EMP_NO
                        GROUP BY D.DEPT_NAME
                    ) TB01
                GROUP BY TB01.DEPARTAMENTO
                        ,TB01.SALARIO";

        $data = $this->conexao->select($sql, 0);

        return $data;                        

    }

} // END CLASS