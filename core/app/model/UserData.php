<?php
class UserData extends Extra {
	public static $tablename = "user";

	public $id, $name, $lastname, $email, $image, $password, $is_active, $created_at, $username, $comision, $kind, $status, $stock_id, $is_admin, $is_mesero, $is_cajero;

	public function __construct(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->is_active = 1;
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,lastname,email,password,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->email\",\"$this->password\",$this->created_at)";
		Executor::doit($sql);
	}
	public function add_admin(){
		$sql = "insert into ".self::$tablename." (name,lastname,email,password,is_admin,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->email\",\"$this->password\",1,$this->created_at)";
		Executor::doit($sql);
	}

	public function add_cajero(){
		$sql = "insert into ".self::$tablename." (name,lastname,email,password,is_cajero,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->email\",\"$this->password\",1,$this->created_at)";
		Executor::doit($sql);
	}

	public function add_mesero(){
		$sql = "insert into ".self::$tablename." (name,lastname,email,password,is_mesero,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->email\",\"$this->password\",1,$this->created_at)";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",lastname=\"$this->lastname\",email=\"$this->email\",is_admin=\"$this->is_admin\",is_mesero=\"$this->is_mesero\",is_cajero=\"$this->is_cajero\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_password(){
		$sql = "update ".self::$tablename." set password=\"$this->password\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new UserData());
	}

	public static function getByMail($mail){
		$sql = "select * from ".self::$tablename." where email=\"$mail\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}


	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}

	public static function getAllMeseros(){
		$sql = "select * from ".self::$tablename." where is_mesero=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}


}

?>