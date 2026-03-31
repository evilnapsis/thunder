<?php
class ClientData {
	public static $tablename = "client";
	public $id;
	public $empresa;
	public $image;
	public $name2;
	public $ine_lado1;
	public $ine_lado2;
	public $img_domicilio;
	public $img_garantia;
	public $password;
	public $stock_id;
	public $name;
	public $lastname;
	public $username;
	public $email;
	public $curp;
	public $fecha_nacimiento;
	public $clave_elector;
	public $estado;
	public $municipio;
	public $colonia;
	public $lastname2;
	public $phone;
	public $address_ref;
	public $created_at;
	public $dni;
	public $sexo;
	public $estado_civil;
	public $localidad;
	public $trabajo_nombre;
	public $trabajo_direccion;
	public $trabajo_telefono;
	public $observation;
	public $url_gps;
	public $phone2;
	public $address;
	public $company;
	public $user_id;
	public $status;

	public function __construct(){
		$this->name = "";
		$this->lastname = "";
		$this->username = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into client (empresa,trabajo_nombre, img_domicilio, img_garantia, fecha_nacimiento, clave_elector, image,ine_lado1,ine_lado2, user_id, curp,name,name2,lastname,lastname2,address, address_ref,estado, municipio, colonia,phone, email,created_at) ";
		 $sql .= "value (\"$this->empresa\",\"$this->trabajo_nombre\",\"$this->img_domicilio\",\"$this->img_garantia\",\"$this->fecha_nacimiento\",\"$this->clave_elector\",\"$this->image\",\"$this->ine_lado1\",\"$this->ine_lado2\",$this->user_id, \"$this->curp\",\"$this->name\",\"$this->name2\",\"$this->lastname\",\"$this->lastname2\",\"$this->address\",\"$this->address_ref\",\"$this->estado\",\"$this->municipio\",\"$this->colonia\",\"$this->phone\",\"$this->email\",$this->created_at)";
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
		  $sql = "update ".self::$tablename." set empresa=\"$this->empresa\",curp=\"$this->curp\",clave_elector=\"$this->clave_elector\",trabajo_nombre=\"$this->trabajo_nombre\",fecha_nacimiento=\"$this->fecha_nacimiento\",name=\"$this->name\",name2=\"$this->name2\",lastname=\"$this->lastname\",lastname2=\"$this->lastname2\",address=\"$this->address\",estado=\"$this->estado\",municipio=\"$this->municipio\",colonia=\"$this->colonia\",address_ref=\"$this->address_ref\",url_gps=\"$this->url_gps\",phone=\"$this->phone\",email=\"$this->email\",image=\"$this->image\",ine_lado1=\"$this->ine_lado1\",ine_lado2=\"$this->ine_lado2\",img_garantia=\"$this->img_garantia\",img_domicilio=\"$this->img_domicilio\" where id=$this->id";
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
		return Model::one($query[0],new ClientData());
	}


	public static function getByClaveElector($id){
		 $sql = "select * from ".self::$tablename." where clave_elector=\"$id\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ClientData());
	}

	public static function getByCurp($id){
		 $sql = "select * from ".self::$tablename." where curp=\"$id\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ClientData());
	}

	public static function getBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ClientData());
	}

	public static function getAll(){
		 $sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ClientData());
	}

	public static function getAllBy($k,$v){
		 $sql = "select * from ".self::$tablename." where $k=\"$v\"";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ClientData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%' or curp like '%$q%' or clave_elector like '%$q%'  or id like '%$q%' ";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ClientData());
	}
	public static function getLikeOne($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%' or curp like '%$q%' or clave_elector like '%$q%'  or id like '%$q%' limit 1";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ClientData());
	}

}

?>