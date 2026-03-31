<?php
class ProductData extends Extra {
	public static $tablename = "product";

	public $id, $code, $name, $description, $preparation, $price_in, $price_out, $unit, $presentation, $duration, $use_ingredient, $is_active, $user_id, $category_id, $created_at;

	public function __construct(){
		$this->name = "";
		$this->price_in = "";
		$this->price_out = "";
		$this->unit = "";
		$this->user_id = "";
		$this->presentation = "0";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (code,name,category_id,price_out,user_id,unit,duration,description,preparation,use_ingredient) ";
		$sql .= "value (\"$this->code\",\"$this->name\",\"$this->category_id\",\"$this->price_out\",$this->user_id,\"$this->unit\",\"$this->duration\",\"$this->description\",\"$this->preparation\",\"$this->use_ingredient\")";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",price_in=\"$this->price_in\",price_out=\"$this->price_out\",unit=\"$this->unit\",presentation=\"$this->presentation\",category_id=\"$this->category_id\",code=\"$this->code\",duration=\"$this->duration\",description=\"$this->description\",preparation=\"$this->preparation\",use_ingredient=\"$this->use_ingredient\" where id=$this->id";
		Executor::doit($sql);
	}

	public function active(){
		$sql = "update ".self::$tablename." set is_active=1 where id=$this->id";
		Executor::doit($sql);
	}

	public function hide(){
		$sql = "update ".self::$tablename." set is_active=0 where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ProductData());
	}


	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getAllActive(){
		$sql = "select * from ".self::$tablename." where product.is_active=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}


	public static function getAllUnActive(){
		$sql = "select * from ".self::$tablename." where product.is_active=0";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}



	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where id>=$start_from limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}


	public static function getLike($p){
		$sql = "select * from ".self::$tablename." where name like '%$p%' or id like '%$p%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getActiveLike($p){
		$sql = "select * from ".self::$tablename." where (name like '%$p%' or id like '%$p%') and is_active=1 ";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}


	public static function getAllByUserId($user_id){
		$sql = "select * from ".self::$tablename." where user_id=$user_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}







}

?>