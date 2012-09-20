<?php

/**
 * Cleanse the data to prevent SQL injection from outside sources.
 * Object Oriented Style again!
 * @author Bryan Bojorque
 */
class dataCleansing {

    //put your code here
    private $_data;

    public function stripAndEscape($data) {
        $this->_data = $data;
        
        $this->_data = stripslashes($this->_data);
        $this->_data = mysql_escape_string($this->_data);

        return $this->_data;
    }
}

$cleanData = new dataCleansing();
$clean = new dataCleansing();

?>