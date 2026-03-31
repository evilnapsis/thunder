<?php
class DetenidoData {
	public static $tablename = "detenido";
	public $id;
	public $name;
	public $code;
	public $motivo;
	public $resolucion;
	public $amount;
	public $descuento;
	public $iva;
	public $periodo_id;
	public $date_at;
	public $description;
	public $client_id;
	public $created_at;
	public $time_at;
	public $status;
	public $user_id;
	public $tipo_servicio_id;
	public $tipo_detencion_id;
	public $forma_pago_id;

	public function __construct(){
		$this->name = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (code, date_at,time_at,tipo_detencion_id, client_id, motivo, resolucion, amount, created_at) ";
		 $sql .= "value (\"$this->code\",\"$this->date_at\",\"$this->time_at\",$this->tipo_detencion_id, \"$this->client_id\",\"$this->motivo\",\"$this->resolucion\",\"$this->amount\",NOW())";
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
		$sql = "update ".self::$tablename." set motivo=\"$this->motivo\",resolucion=\"$this->resolucion\",amount=\"$this->amount\",status=\"$this->status\" where id=$this->id";
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
		return Model::one($query[0],new DetenidoData());
	}

	public static function getByCode($id){
		 $sql = "select * from ".self::$tablename." where code=\"$id\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new DetenidoData());
	}

	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new DetenidoData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new DetenidoData());
	}

	public static function getLast(){
		 $sql = "select * from ".self::$tablename." order by created_at desc limit 1";
		$query = Executor::doit($sql);
		return Model::one($query[0],new DetenidoData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new DetenidoData());
	}

	public static function getAllByCatCli($k,$v){
		 $sql = "select * from ".self::$tablename." where tipo_detencion_id=$k and client_id=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new DetenidoData());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new DetenidoData());
	}

	public static function getAllByRange($start, $end){
		$sql = "select * from ".self::$tablename." where (date(created_at)>=\"$start\" and date(created_at)<=\"$end\")  order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new DetenidoData());
	}
}

?>