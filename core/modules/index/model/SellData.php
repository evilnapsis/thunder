<?php
class SellData {
	public static $tablename = "sell";

	public function SellData(){
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (item_id,q,mesero_id,created_at) ";
		$sql .= "value (\"$this->item_id\",q,$this->mesero_id,$this->created_at)";
		return Executor::doit($sql);
	}

	public function apply(){
		$sql = "update ".self::$tablename." set is_applied=1,cajero_id=$this->cajero_id where id=$this->id";
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


	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new SellData());
	}



	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());

	}

	public static function getAllUnApplied(){
		$sql = "select * from ".self::$tablename." where is_applied=0 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());

	}

	public static function getAllUnAppliedByItemId($itid){
		$sql = "select * from ".self::$tablename." where is_applied=0 and item_id=$itid order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());

	}

	public static function getAllTotalByMesero($mesero_id){
		$sql = "select mesero_id,product.name,operation.q,price_out,operation.q*price_out as total,operation.created_at as c from operation inner join sell on (sell.id=operation.sell_id) inner join product on (product.id=operation.product_id) where mesero_id=$mesero_id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}


	public static function getAllMonthlyByMesero($mesero_id){
		$sql = "select mesero_id,product.name,q,price_out,q*price_out as total,operation.created_at as c from operation inner join sell on (sell.id=operation.sell_id) inner join product on (product.id=operation.product_id) where month(operation.created_at)=month(now()) and year(operation.created_at)=year(now()) and mesero_id=$mesero_id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAllDayliByMesero($mesero_id){
		$sql = "select mesero_id,product.name,operation.q,price_out,operation.q*price_out as total,operation.created_at as c from operation inner join sell on (sell.id=operation.sell_id) inner join product on (product.id=operation.product_id) where mesero_id=$mesero_id and is_applied=1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}


	public static function getAllApplied(){
		$sql = "select * from ".self::$tablename." where is_applied=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());

	}

	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where id<=$start_from limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());

	}

	public static function getAllUnAppliedByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where id<=$start_from and is_applied=0 limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());

	}

	public static function getAllAppliedByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where id<=$start_from and is_applied=1 limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());

	}


}

?>