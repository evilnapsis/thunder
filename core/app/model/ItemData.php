<?php
class ItemData extends Extra {
	public static $tablename = "item";

	public $id, $name, $capacity;

	public function __construct(){
		$this->name = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name) ";
		$sql .= "value (\"$this->name\")";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function hide(){
		$sql = "update ".self::$tablename." set is_active=0 where id=$this->id";
		Executor::doit($sql);
	}

	public function active(){
		$sql = "update ".self::$tablename." set is_active=1 where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ItemData());
	}

	public static function getByName($name){
		 $sql = "select * from ".self::$tablename." where name=\"$name\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ItemData());
	}


	public static function getAll(){
		$sql = "select * from ".self::$tablename."";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ItemData());
	}

	public static function getAllActive(){
		$sql = "select * from ".self::$tablename." where is_active=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ItemData());
	}

	public static function getAllUnActive(){
		$sql = "select * from ".self::$tablename." where is_active=0";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ItemData());
	}


}

?>