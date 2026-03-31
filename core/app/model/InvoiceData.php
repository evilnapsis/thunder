<?php
class InvoiceData {
	public static $tablename = "invoice";
	public $id;
	public $name;
    public $invoice;
    public $code, $amount, $time_limit, $status_id, $invoice_file, $user_id;
	public $image;
	public $description;
	public $created_at;

	public function __construct(){
		$this->name = "";

	}

	public function add(){
		$sql = "insert into ".self::$tablename." (code, invoice, amount, time_limit, description, user_id, created_at) ";
		echo $sql .= "value (\"$this->code\",\"$this->invoice\",$this->amount,\"$this->time_limit\",\"$this->description\",$this->user_id, NOW())";
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
		$sql = "update ".self::$tablename." set code=\"$this->code\",invoice=\"$this->invoice\",description=\"$this->description\",amount=\"$this->amount\",time_limit=\"$this->time_limit\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_status(){
		$sql = "update ".self::$tablename." set status_id=\"$this->status_id\" where id=$this->id";
		Executor::doit($sql);
	}

	public function updateById($k,$v){
		$sql = "update ".self::$tablename." set $k=\"$v\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		 $sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new InvoiceData());
	}

	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new InvoiceData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new InvoiceData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new InvoiceData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new InvoiceData());
	}


}

?>