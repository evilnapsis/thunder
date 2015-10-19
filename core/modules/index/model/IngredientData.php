<?php
class IngredientData {
	public static $tablename = "ingredient";

	public function IngredientData(){
		$this->name = "";
		$this->price_in = "";
		$this->price_out = "";
		$this->unit = "";
		$this->user_id = "";
		$this->presentation = "0";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (code,name,price_out,user_id,unit) ";
		$sql .= "value (\"$this->code\",\"$this->name\",\"$this->price_out\",$this->user_id,\"$this->unit\")";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto IngredientData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",price_in=\"$this->price_in\",price_out=\"$this->price_out\",unit=\"$this->unit\",presentation=\"$this->presentation\",category_id=\"$this->category_id\",code=\"$this->code\",duration=\"$this->duration\" where id=$this->id";
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
		return Model::one($query[0],new IngredientData());
	}



	public static function getAll(){
		$sql = "select * from ".self::$tablename." ";
		$query = Executor::doit($sql);
		return Model::many($query[0],new IngredientData());
	}

	public static function getAllActive(){
		$sql = "select * from ".self::$tablename."  where is_active=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new IngredientData());
	}


	public static function getAllUnActive(){
		$sql = "select * from ".self::$tablename."  where is_active=0";
		$query = Executor::doit($sql);
		return Model::many($query[0],new IngredientData());
	}



	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where id>=$start_from limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0],new IngredientData());
	}


	public static function getLike($p){
		$sql = "select * from ".self::$tablename." where name like '%$p%' or id like '%$p%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new IngredientData());
	}

	public static function getActiveLike($p){
		$sql = "select * from ".self::$tablename." where (name like '%$p%' or id like '%$p%') and is_active=1 ";
		$query = Executor::doit($sql);
		return Model::many($query[0],new IngredientData());
	}


	public static function getAllByUserId($user_id){
		$sql = "select * from ".self::$tablename." where user_id=$user_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new IngredientData());
	}







}

?>