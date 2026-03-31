<?php
class CarData {
	public static $tablename = "car";
	public $id;
	public $name;
	public $serie;
	public $placa;
	public $marca;
	public $modelo;
	public $created_at;
	public $anio;

	public function __construct(){
		$this->name = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,serie,placa, marca,modelo,anio, created_at) ";
		$sql .= "value (\"$this->name\",\"$this->serie\",\"$this->placa\",\"$this->marca\",\"$this->modelo\",\"$this->anio\",NOW())";
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

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",serie=\"$this->serie\",placa=\"$this->placa\",marca=\"$this->marca\",modelo=\"$this->modelo\",anio=\"$this->anio\" where id=$this->id";
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
		return Model::one($query[0],new CarData());
	}

	public static function getByPlaca($placa){
		 $sql = "select * from ".self::$tablename." where placa=\"$placa\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CarData());
	}


	public static function getByCode($id){
		 $sql = "select * from ".self::$tablename." where code=\"$id\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CarData());
	}

	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CarData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new CarData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CarData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CarData());
	}


}

?>