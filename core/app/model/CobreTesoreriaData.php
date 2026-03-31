<?php
class CobroTesoreriaData {
	public static $tablename = "cobro_tesoreria";
	public $id;
	public $name;
	public $code;
	public $contrato_agua;
	public $contrato_agua_id;
	public $amount;
	public $descuento;
	public $iva;
	public $periodo_id;
	public $date_at;
	public $description;
	public $client_id;
	public $created_at;
	public $tipo_contrato;
	public $user_id;
	public $cat_tesoreria_id;
	public $cobro_tesoreria_list_id;
	public $forma_pago_id;

	public function __construct(){
		$this->name = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (forma_pago_id,cobro_tesoreria_list_id,cat_tesoreria_id, code,date_at,amount, client_id, descuento, iva, description, created_at) ";
		echo $sql .= "value (\"$this->forma_pago_id\",\"$this->cobro_tesoreria_list_id\",\"$this->cat_tesoreria_id\",\"$this->code\",\"$this->date_at\",\"$this->amount\",\"$this->client_id\",\"$this->descuento\",\"$this->iva\",\"$this->description\",NOW())";
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
		$sql = "update ".self::$tablename." set code=\"$this->code\",date_at=\"$this->date_at\",tipo_contrato=\"$this->tipo_contrato\",client_id=\"$this->client_id\",description=\"$this->description\" where id=$this->id";
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
		return Model::one($query[0],new CobroTesoreriaData());
	}

	public static function getByCode($id){
		 $sql = "select * from ".self::$tablename." where code=\"$id\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CobroTesoreriaData());
	}

	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CobroTesoreriaData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CobroTesoreriaData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CobroTesoreriaData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CobroTesoreriaData());
	}


}

