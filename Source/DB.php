<?php
class DB{
    private static $_instance = null;
    private $_pdo,
        $_error = false,
        $_results,
        $_count = 0,
        $_query,
        $_args = array();

    private function __construct(){
        try{
            $this->_pdo = new PDO(
                'mysql:host=' . Config::get('mysql/host') .
                ';dbname=' . Config::get('mysql/db'),
                Config::get('mysql/username'),
                Config::get('mysql/password'));

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public static function reConnect(){
        self::$_instance = new DB();
        return self::$_instance;
    }

    public function prepareSelect($table, $args = array()){
        if(!empty($args))
            $str = self::explode_args($args);
        else
            $str = "*";

        $this->_args = null;
        $this->_query = "SELECT {$str} FROM {$table}";
        return $this->_query;
    }

    public function prepareUpdate($table, $fields = array(), $where = array()){
        $this->_args = array();
        $set = '';
        $x = 1;

        foreach($fields as $name => $value){
            $set .= "{$name} = ?";
            $this->_args[] = $value;
            if($x < count($fields)){
                $set .= ',';
            }
            $x++;
        }

        $this->_query = "UPDATE {$table} SET {$set}";
        $this->prepareWereCondition($where);
        return $this->_query;
    }

    public function prepareDelete($table, $where = array()){
        $this->_args = array();
        $this->_query = "DELETE FROM {$table}";
        return $this->prepareWereCondition($where);
    }

    public function prepareInsert($table, $fields = array()){
        $this->_args = array();
        $keys = array();
        $values = null;
        $x = 1;

        foreach($fields as $field => $value){
            $values .= "?";
            $keys[] = $field;
            $this->_args[] = $value;

            if($x < count($fields)){
                $values .= ', ';
            }
                $x++;
        }

        $this->_query = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

        return $this->_query;
    }

    public function prepareOrderBy($var, $order){
            switch (strtoupper($order)){
            case 'ASC':
                $this->_query .= " ORDER BY {$var} ASC";
                return $this->_query;
            case 'DESC':
                $this->_query .= " ORDER BY {$var} DESC";
                return $this->_query;
            default:
                return false;
        }
    }

    public function prepareLimit($start, $end = null){
        $this->_query .= " LIMIT ";
        $this->_query .= ($end == null) ? $start : $start . ', ' . $end;
        return $this->_query;
    }

    private static function explode_args($args) {
        $str = "";

        for($i=0;$i < count($args);$i++){
            $str .= ($i != 0) ? ", " : "" ;
            $str .= $args[$i];
        }

        return $str;
    }

    public function prepareWereCondition($condition = array()){
        $operators = array('=', '<', '>', '<=', '>=');

        if(count($condition) % 3 === 0){
            $this->_query .= " WHERE 1 = 1";

            for($i=0;$i<count($condition);$i+=3){
                $field = $condition[($i)];
                $operator = $condition[($i + 1)];
                $value = $condition[($i + 2)];
                $this->_args[] = $value;

                if(in_array($operator, $operators)){
                    $this->_query .= " AND {$field} {$operator} ? ";
                }
            }
            return $this->_query;
        }
        return false;
    }


    private function query($sql){
        $this->_error = false;
        $query = $this->_pdo->prepare($sql);
        if($query) {
            if($query->execute()){
                $this->_results = $query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $query->rowCount();
            }else{
                $this->_error = true;
            }
        }
        return $this;
    }

    public function runQuery($sql = null){
        if($sql != null){
            $this->query($sql);
        }

        $this->_error = false;
        $query = $this->_pdo->prepare($this->_query);

        if($query) {

            $x = 1;
            if(count($this->_args)) {
                foreach($this->_args as $param) {
                    $query->bindValue($x, $param);
                    $x++;
                }
            }

            if($query->execute()){
                $this->_results = $query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $query->rowCount();
            }else{
                $this->_error = true;
            }
        }
        return $this->results();
    }

    public function results(){
        return $this->_results;
    }

    public function first(){
        return $this->results()[0];
    }

    public function error(){
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }

    public function setCharSetUTF8() {
        $this->_pdo->exec("SET CHARACTER SET utf8");
    }

} //end class