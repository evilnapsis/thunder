<?php
class InventarioData {
	public static $tablename = "inventario";
	public $id;
	public $product_id;
	public $tipo_operacion;
	public $price_in;
	public $q;
	public $price_out;
	public $description;
	public $tot;
	public $created_at;

	public function __construct(){
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (product_id,q,price_in,price_out,tipo_operacion, created_at) ";
		$sql .= "value (\"$this->product_id\",\"$this->q\",\"$this->price_in\",\"$this->price_out\",\"$this->tipo_operacion\",NOW())";
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
		$sql = "update ".self::$tablename." set name=\"$this->name\",tipo_toma_id=\"$this->tipo_toma_id\",price=\"$this->price\",es_contrato=\"$this->es_contrato\" where id=$this->id";
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
		return Model::one($query[0],new InventarioData());
	}


	public static function countByPT($id,$tipo){
		 $sql = "select sum(q) as tot from ".self::$tablename." where product_id=$id and tipo_operacion=$tipo";
		$query = Executor::doit($sql);
		return Model::one($query[0],new InventarioData());
	}

	public static function getByToma($id){
		 $sql = "select * from ".self::$tablename." where tipo_toma_id=$id and es_contrato=1";
		$query = Executor::doit($sql);
		return Model::one($query[0],new InventarioData());
	}


	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new InventarioData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new InventarioData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new InventarioData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new InventarioData());
	}


}

?>