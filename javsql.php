<?
Class JavSql{
    /* Author: Javidan Sadygov */

    var $db_name; 
    var $db_server; 
    var $db_prefix; 
    var $db_password; 
    var $db_user; 
    var $mysqli; 
    var $is_connected; 
    function __construct(){
        $is_connected=false;
    }
    function setDBNAME($val){
        $this->db_name=$val;
    }
    function setDBServer($val){
        $this->db_server=$val;
    }
    function setDBPrefix($val){
        $this->db_prefix=$val;
    }
    function setDBUser($val){
        $this->db_user=$val;
    }
    function setDBPassword($val){
        $this->db_password=$val;
    }
    function setDBParams($params){
        if(array_key_exists('host',$params)){
            $this->db_server=$params['host'];
        }
        if(array_key_exists('user',$params)){
            $this->db_user=$params['user'];
        }
        if(array_key_exists('name',$params)){
            $this->db_name=$params['name'];
        }
        if(array_key_exists('pass',$params)){
            $this->db_password=$params['pass'];
        }
    }
    function getDBPrefix(){
        return $this->db_prefix;
    }
    function Connect(){
        $this->mysqli=new mysqli($this->db_server,$this->db_user,$this->db_password,$this->db_name);
        if($this->mysqli->connect_errno){
            $this->is_connected=false;
            return false;
        }else{
            $this->is_connected=true;
            return true;
        }
    }
    function isConnected(){
        return $this->is_connected;
    }

    function getRowsCount($table_name,$where=""){
        if(!$this->is_connected){return false;}
        $tb_name=$this->db_prefix.$table_name;
        $sql="SELECT COUNT(*) AS `cnt` FROM `$tb_name` ";
        if($where!=""){
            $sql.="WHERE $where";
        }
        $res=$this->mysqli->query($sql);
        if($res->num_rows){
            while($row=$res->fetch_assoc()){
                $cnt=$row['cnt'];
            }
        }else{
            return false;
        }
        return $cnt;
    }
    function rawQuery($query){
        if(!$this->is_connected){return false;}
        $this->mysqli->query($query);
        return true;
    }
    function addQuery($table_name,$variables){
        if(!$this->is_connected){return false;}
        $tb_name=$this->db_prefix.$table_name;
        $sql="INSERT INTO `$tb_name` ";
        $sql = " SET ";
        $cnt=0;
        foreach($variables as $vax){            
            $sql.="`".$vax['column']."`='".$vax['value']."'";
            if($cnt!=count($variables)-1){
                $sql.=",";
            }
            $cnt++;
        }
        $res=$this->mysqli->query($sql);
        return true;
    }
    function updateQuery($table_name,$variables,$where=""){
        if(!$this->is_connected){return false;}
        $tb_name=$this->db_prefix.$table_name;
        $sql="UPDATE `$tb_name` ";
        $sql = " SET ";
        $cnt=0;
        foreach($variables as $vax){            
            $sql.="`".$vax['column']."`='".$vax['value']."'";
            if($cnt!=count($variables)-1){
                $sql.=",";
            }
            $cnt++;
        }
        if($where!=""){
            $sql.="WHERE $where";
        }
        $res=$this->mysqli->query($sql);
        return true;
    }
    function getRawRows($sql){
        if(!$this->is_connected){return false;}
        $ars=array();
        $res=$this->mysqli->query($sql);
        if($res->num_rows){
            while($row=$res->fetch_assoc()){
                $ars[]=$row;
            }
        }else{
            return false;
        }
        return $ars;
    }
    function getRows($table_name,$columns="",$where="",$order=""){
        if(!$this->is_connected){return false;}
        $tb_name=$this->db_prefix.$table_name;
        if($columns==""){
            $sql="SELECT *";
        }else{
            $sql="SELECT $columns";
        }
        $sql.=" FROM `$tb_name` ";
        if($where!=""){
            $sql.="WHERE $where";
        }
        if($order!=""){
            $sql.=" ORDER BY $order";
        }
        $ars=array();
        $res=$this->mysqli->query($sql);
        if($res->num_rows){
            while($row=$res->fetch_assoc()){
                $ars[]=$row;
            }
        }else{
            return false;
        }
        return $ars;
    }

}
