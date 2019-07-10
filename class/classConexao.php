<?php 

/**
 *  Git     : https://github.com/angelopinto
 *  Author  : Angelo R. Pinto
 *  Updated : 2019-07-02
 *  Version : 0.2 
 */

class Conexao {

    private $_host     = 'localhost';
    private $_user     = 'root';
    private $_pass     = '';
    private $_database = 'employees';
    public  $_con;


    function __construct()
    {
        $this->conecta();
    }
 

    private function conecta()
    {
        $this->_con = new PDO('mysql:host=localhost; dbname='.$this->_database, $this->_user, $this->_pass);
    }


    /**
     * @param type | (0) => [field][index] | (1) => [index][field]
     */    
    public function select($sql, $type = 0, $bind = null)
    {       
        if ($bind == null) {
            // Faz a consulta sem bind
            $stmt = $this->_con->query($sql);
        } else {
            // Prepara a consulta para utilizar os binds
            $stmt = $this->_con->prepare($sql);

            // Faz os binds de acordo com o array recebido
            for ($i = 0; $i < count($bind['FIELD']); $i++) { 
                if (is_integer($bind['VALUE'][$i])) :
                    $stmt->bindParam($bind['FIELD'][$i], $bind['VALUE'][$i], PDO::PARAM_INT, $bind['SIZE'][$i]);
                else:
                    $stmt->bindParam($bind['FIELD'][$i], $bind['VALUE'][$i], PDO::PARAM_STR, $bind['SIZE'][$i]);
                endif;
            }
            // Executa a consulta
            $stmt->execute();
        }
        
        // Recupera todos os dados
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        foreach ($dados as $row) { 

            $fields = array_keys($row);

            foreach ($fields as $field) { 
                // Faz um typecasting em tipos numericos
                if (is_numeric($row[$field])) {
                    $valor = (float) $row[$field];
                } else {
                    $valor = $row[$field];
                }

                // Define como o array deve retornar as informações
                // 0 -> Retorna [field][index]
                // 1 -> Retorna [index][field]
                switch ($type) {
                    case 0:
                        $data[$field][$i] = $valor;
                        break; 
                    case 1:
                        $data[$i][$field] = $valor;
                        break; 
                }
            }
            $i++;
        }

        return $data;
    }


} // END CLASS

