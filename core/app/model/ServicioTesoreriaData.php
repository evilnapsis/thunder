<?php
class ServicioTesoreriaData {
	public static $tablename = "servicio_tesoreria";
	public $id;
	public $name;
	public $image;
	public $price;
	public $cat_tesoreria_id;
	public $es_contrato;
	public $description;
	public $created_at;

	public function __construct(){
		$this->name = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,cat_tesoreria_id,price) ";
		$sql .= "value (\"$this->name\",\"$this->cat_tesoreria_id\",\"$this->price\")";
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
		$sql = "update ".self::$tablename." set name=\"$this->name\",price=\"$this->price\" where id=$this->id";
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
		return Model::one($query[0],new ServicioTesoreriaData());
	}

	public static function getByToma($id){
		 $sql = "select * from ".self::$tablename." where tipo_toma_id=$id and es_contrato=1";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ServicioTesoreriaData());
	}


	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ServicioTesoreriaData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ServicioTesoreriaData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ServicioTesoreriaData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ServicioTesoreriaData());
	}


}

?>