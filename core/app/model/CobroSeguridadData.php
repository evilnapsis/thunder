<?php
class CobroSeguridadData {
	public static $tablename = "cobro_seguridad";
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
	public $servicio_seguridad_id;
	public $cobro_seguridad_list_id;
	public $forma_pago_id;
	public $suma;
	public $corte_id;
	public $corte_teso_id;

	public function __construct(){
		$this->name = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (forma_pago_id,cobro_seguridad_list_id,servicio_seguridad_id, code,date_at,amount, client_id, descuento, iva, description, corte_id, corte_teso_id, created_at) ";
		 echo $sql .= "value (\"$this->forma_pago_id\",\"$this->cobro_seguridad_list_id\",\"$this->servicio_seguridad_id\",\"$this->code\",\"$this->date_at\",\"$this->amount\",\"$this->client_id\",\"$this->descuento\",\"$this->iva\",\"$this->description\",$this->corte_id, $this->corte_teso_id, NOW())";
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
		return Model::one($query[0],new CobroSeguridadData());
	}

	public static function getByCode($id){
		 $sql = "select * from ".self::$tablename." where code=\"$id\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CobroSeguridadData());
	}

	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CobroSeguridadData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CobroSeguridadData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CobroSeguridadData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CobroSeguridadData());
	}

	public static function getSumByMonth(){
		 $sql = "select sum((amount-(amount*descuento/100)) + ((amount-(amount*descuento/100)))*(iva/100) ) as suma from ".self::$tablename." where month(date_at)=month(now())";
		$query = Executor::doit($sql);
		return Model::one($query[0],new CobroSeguridadData());
	}

	public static function getAllByRange($start, $end){
		$sql = "select * from ".self::$tablename." where (date(date_at)>=\"$start\" and date(date_at)<=\"$end\")  order by created_at desc";
	  $query = Executor::doit($sql);
	  return Model::many($query[0],new CobroTesoreriaData());
  }

	  public static function getAllByRangeCat($start, $end, $cat){
		$sql = "select * from ".self::$tablename." where (date(date_at)>=\"$start\" and date(date_at)<=\"$end\") and servicio_tesoreria_id=$cat order by created_at desc";
	  $query = Executor::doit($sql);
	  return Model::many($query[0],new CobroTesoreriaData());
  }

		  public static function sumAllByDate($start){
		$sql = "select sum(amount) as sx from ".self::$tablename." where date(date_at)=\"$start\"  order by created_at desc";
	  $query = Executor::doit($sql);
	  return Model::one($query[0],new CobroTesoreriaData());
  }


		  public static function sumAllByDateCat($start, $cat){
		$sql = "select * from ".self::$tablename." where (date(date_at)>=\"$start\" and date(date_at)<=\"$end\") and servicio_tesoreria_id=$cat order by created_at desc";
	  $query = Executor::doit($sql);
	  return Model::many($query[0],new CobroTesoreriaData());
  }




}

?>