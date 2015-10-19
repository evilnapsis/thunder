<?php
class ProductIngredientData {
	public static $tablename = "product_ingredient";

	public function ProductIngredientData(){
		$this->name = "";
		$this->price_in = "";
		$this->price_out = "";
		$this->unit = "";
		$this->user_id = "";
		$this->presentation = "0";
		$this->created_at = "NOW()";
	}

	public function getIngredient(){ return IngredientData::getById($this->ingredient_id); }

	public function add(){
		$sql = "insert into ".self::$tablename." (product_id,ingredient_id,is_required,q) ";
		$sql .= "value (\"$this->product_id\",\"$this->ingredient_id\",\"$this->is_required\",$this->q)";
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

// partiendo de que ya tenemos creado un objecto ProductIngredientData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set q=\"$this->q\",is_required=\"$this->is_required\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_q(){
		$sql = "update ".self::$tablename." set q=$this->q where id=$this->id";
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
		return Model::one($query[0],new ProductIngredientData());
	}



	public static function getAll(){
		$sql = "select * from ".self::$tablename." ";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductIngredientData());
	}

	public static function getAllByProductId($id){
		$sql = "select * from ".self::$tablename." where product_id=".$id;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductIngredientData());
	}

	public static function getAllActive(){
		$sql = "select * from ".self::$tablename."  where is_active=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductIngredientData());
	}


	public static function getAllUnActive(){
		$sql = "select * from ".self::$tablename."  where is_active=0";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductIngredientData());
	}



	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where id>=$start_from limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductIngredientData());
	}


	public static function getLike($p){
		$sql = "select * from ".self::$tablename." where name like '%$p%' or id like '%$p%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductIngredientData());
	}

	public static function getActiveLike($p){
		$sql = "select * from ".self::$tablename." where (name like '%$p%' or id like '%$p%') and is_active=1 ";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductIngredientData());
	}


	public static function getAllByUserId($user_id){
		$sql = "select * from ".self::$tablename." where user_id=$user_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductIngredientData());
	}







}

?>