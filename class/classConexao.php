<?php 

/**
 *  Git     : https://github.com/angelopinto
 *  Author  : Angelo R. Pinto
 *  Created : 2019-07-02
 *  Version : 0.1 
 */

class Conexao {

    private $_host     = 'localhost';
    private $_user     = 'root';
    private $_pass     = '';
    private $_database = 'employees';
    public  $_con;
 
    function __construct() {
        $this->conecta();
    }
 
    function conecta() {
        $this->_con = new mysqli($this->_host, $this->_user, $this->_pass, $this->_database) or die("Falha ao conectar; " . mysql_error());
    }

    /**
     * @param type | (0) field - index | (1) index -> field
     */
    public function select($sql, $type = 0){
       
        $result = $this->_con->query($sql);

        if ($result->num_rows > 0) {
            $i = 0;
            while($row = $result->fetch_assoc()) {
                $fields = array_keys($row);
                foreach ($fields as $field) { 
                    if (is_numeric($row[$field])) {
                        $value = (float) $row[$field];
                    } else {
                        $value = $row[$field];
                    }
                    switch ($type) {
                        case 0:
                            $data[$field][$i] = $value;
                            break; 
                        case 1:
                            $data[$i][$field] = $value;
                            break; 
                    }
                }
                $i++;
            }
            
            $data_return = $data;

        } else {
            $data_return = false;
        }
        
        $this->_con->close();
        return $data_return;

    }


} // END CLASS

