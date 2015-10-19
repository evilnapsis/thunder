<?php
class SpentData {
	public static $tablename = "spent";

	public function SpentData(){
		$this->name = "";
		$this->price_in = "";
		$this->price_out = "";
		$this->unit = "";
		$this->user_id = "";
		$this->presentation = "0";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (q,concept,unit,price,category_id,created_at) ";
		$sql .= "value ($this->q,\"$this->name\",\"$this->unit\",\"$this->price\",$this->category_id,NOW())";
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

// partiendo de que ya tenemos creado un objecto SpentData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",price_in=\"$this->price_in\",price_out=\"$this->price_out\",unit=\"$this->unit\",presentation=\"$this->presentation\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new SpentData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->name = $r['name'];
//			$data->price_in = $r['price_in'];
//			$data->price_out = $r['price_out'];
//			$data->presentation = $r['presentation'];
			$data->unit = $r['unit'];
//			$data->user_id = $r['user_id'];
			$found = $data;
			break;
		}
		return $found;
	}



	public static function getAll(){
		$sql = "select *,date(created_at) as day from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SpentData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['concept'];
			$array[$cnt]->price = $r['price'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllDates(){
		$sql = "select *,date(created_at) as d from ".self::$tablename." group by date(created_at)";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SpentData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['concept'];
			$array[$cnt]->price = $r['price'];
			$array[$cnt]->d = $r['d'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByDate($date){	
	$sql = "select *,spent.id as sid from ".self::$tablename." inner join category on (spent.category_id=category.id) where date(created_at)=\"$date\" order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SpentData();
			$array[$cnt]->id = $r['sid'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->unit = $r['unit'];
			$array[$cnt]->concept = $r['concept'];
			$array[$cnt]->price = $r['price'];
			$array[$cnt]->category_id = $r['category_id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}
	public static function getAllByDateAndCategoryId($date,$cat_id){	
	$sql = "select *,spent.id as sid from ".self::$tablename." inner join category on (spent.category_id=category.id) where date(created_at)=\"$date\" and category_id=$cat_id order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SpentData();
			$array[$cnt]->id = $r['sid'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->unit = $r['unit'];
			$array[$cnt]->concept = $r['concept'];
			$array[$cnt]->price = $r['price'];
			$array[$cnt]->category_id = $r['category_id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


	public static function getAllByPage($start_from,$limit){
		$sql = "select *,product.name as pname,category.name as cname from ".self::$tablename." inner join category on (product.category_id=category.id) where product.id>=$start_from limit $limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SpentData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['pname'];
			$array[$cnt]->cname = $r['cname'];
			$array[$cnt]->price_in = $r['price_in'];
			$array[$cnt]->price_out = $r['price_out'];
			$array[$cnt]->presentation = $r['presentation'];
			$array[$cnt]->unit = $r['unit'];
			$array[$cnt]->user_id = $r['user_id'];
			$cnt++;
		}
		return $array;
	}


	public static function getLike($p){
		$sql = "select * from ".self::$tablename." where name like '%$p%' or id like '%$p%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SpentData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->price_in = $r['price_in'];
			$array[$cnt]->price_out = $r['price_out'];
			$array[$cnt]->presentation = $r['presentation'];
			$array[$cnt]->unit = $r['unit'];
			$array[$cnt]->user_id = $r['user_id'];
			$cnt++;
		}
		return $array;
	}



	public static function getAllByUserId($user_id){
		$sql = "select * from ".self::$tablename." where user_id=$user_id order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SpentData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->price_in = $r['price_in'];
			$array[$cnt]->price_out = $r['price_out'];
			$array[$cnt]->presentation = $r['presentation'];
			$array[$cnt]->unit = $r['unit'];
			$array[$cnt]->user_id = $r['user_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}







}

?>