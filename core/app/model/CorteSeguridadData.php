<?php
class CorteSeguridadData {
	public static $tablename = "corte_seguridad";
	public $id;
	public $amount_start;
	public $amount_end;
	public $start_at;
	public $finish_at;
	public $module;
	public $user_id;
	public $created_at;

	public function __construct(){
		$this->created_at = "NOW()";

	}

	public function add(){
		$sql = "insert into ".self::$tablename." (amount_start, start_at, user_id, created_at) ";
		$sql .= "value (\"$this->amount_start\",NOW(),\"$this->user_id\",NOW())";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public static function delBy($k,$v){
		$sql = "delete from ".self::$tablename." where $k=\"$v\"";
		Executor::doit($sql);
	}

    public function finish(){
		$sql = "update ".self::$tablename." set amount_end=\"$this->amount_end\",finish_at=NOW() where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set amount_end=\"$this->amount_end\",amount_start=\"$this->amount_start\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_passwd(){
		$sql = "update ".self::$tablename." set password=\"$this->password\" where id=$this->id";
		Executor::doit($sql);
	}

	public function updateById($k,$v){
		$sql = "update ".self::$tablename." set $k=\"$v\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		 $sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CorteSeguridadData());
	}

	public static function getLastByUser($id){
		 $sql = "select * from ".self::$tablename." where finish_at is NULL and user_id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CorteSeguridadData());
	}


	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CorteSeguridadData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new CorteSeguridadData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CorteSeguridadData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CorteSeguridadData());
	}


}

?>