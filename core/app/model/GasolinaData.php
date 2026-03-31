<?php
class GasolinaData {
	public static $tablename = "gasolina";
	public $id;
	public $description;
	public $car_id;
	public $driver_id;
	public $litros;
	public $date_at;
	public $created_at;

	public function __construct(){
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (description,litros,car_id,driver_id,date_at,created_at) ";
		$sql .= "value (\"$this->description\",\"$this->litros\",\"$this->car_id\",\"$this->driver_id\",\"$this->date_at\",NOW())";
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
		$sql = "update ".self::$tablename." set description=\"$this->description\",litros=\"$this->litros\",car_id=\"$this->car_id\",driver_id=\"$this->driver_id\",date_at=\"$this->date_at\" where id=$this->id";
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
		return Model::one($query[0],new GasolinaData());
	}

	public static function getByToma($id){
		 $sql = "select * from ".self::$tablename." where tipo_toma_id=$id and es_contrato=1";
		$query = Executor::doit($sql);
		return Model::one($query[0],new GasolinaData());
	}


	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new GasolinaData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new GasolinaData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new GasolinaData());
	}
	public static function getAllByRange($start, $end){
		  $sql = "select * from ".self::$tablename." where (date(date_at)>=\"$start\" and date(date_at)<=\"$end\")  order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new GasolinaData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new GasolinaData());
	}


}

?>