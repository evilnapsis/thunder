<?php
class ContratoAguaData {
	public static $tablename = "contrato_agua";
	public $id;
	public $name;
	public $code;
	public $tarifa;
	public $diametro	;
	public $date_at;
	public $description;
	public $client_id;
	public $created_at;
	public $tipo_contrato;
	public $amount;
	public $iva;
	public $descuento;
	public $periodo_id;

	public function __construct(){
		$this->name = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (code,tarifa,diametro,amount, descuento, iva, periodo_id, date_at,tipo_contrato, client_id, description, created_at) ";
		$sql .= "value (\"$this->code\",\"$this->tarifa\",\"$this->diametro\",\"$this->amount\",\"$this->descuento\",\"$this->iva\",\"$this->periodo_id\",\"$this->date_at\",\"$this->tipo_contrato\",\"$this->client_id\",\"$this->description\",NOW())";
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
		$sql = "update ".self::$tablename." set date_at=\"$this->date_at\",diametro=\"$this->diametro\",tarifa=\"$this->tarifa\",description=\"$this->description\" where id=$this->id";
		Executor::doit($sql);
	}


	public function updateById($k,$v){
		$sql = "update ".self::$tablename." set $k=\"$v\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		 $sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ContratoAguaData());
	}

	public static function getLast(){
		 $sql = "select * from ".self::$tablename." order by created_at desc limit 1";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ContratoAguaData());
	}


	public static function getByCode($id){
		 $sql = "select * from ".self::$tablename." where code=\"$id\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ContratoAguaData());
	}

	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ContratoAguaData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ContratoAguaData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ContratoAguaData());
	}

	public static function getAllByRange($start, $end){
		  $sql = "select * from ".self::$tablename." where (date(date_at)>=\"$start\" and date(date_at)<=\"$end\")  order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ContratoAguaData());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ContratoAguaData());
	}


}

?>