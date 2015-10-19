<?php
class Operation2Data {
	public static $tablename = "operation2";

	public function Operation2Data(){
		$this->name = "";
		$this->ingredient_id = "";
		$this->q = "";
		$this->cut_id = "";
		$this->operation_type_id = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (ingredient_id,q,operation_type_id,sell_id,created_at) ";
		$sql .= "value (\"$this->ingredient_id\",\"$this->q\",$this->operation_type_id,$this->sell_id,$this->created_at)";
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

// partiendo de que ya tenemos creado un objecto Operation2Data previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set ingredient_id=\"$this->ingredient_id\",q=\"$this->q\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new Operation2Data();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->ingredient_id = $r['ingredient_id'];
			$data->q = $r['q'];
			$data->cut_id = $r['cut_id'];
			$data->operation_type_id = $r['operation_type_id'];
			$data->sell_id = $r['sell_id'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}



	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->cut_id = $r['cut_id'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$cnt++;
		}
		return $array;
	}



	public static function getAllByDateOfficial($start,$end){
 $sql = "select * from ".self::$tablename." where date(created_at) > \"$start\" and date(created_at) <= \"$end\" and is_oficial=1 order by created_at desc";
		if($start == $end){
		 $sql = "select * from ".self::$tablename." where date(created_at) = \"$start\" order by created_at desc";
		}
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->is_oficial = $r['is_oficial'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByDateOfficialBP($product, $start,$end){
 $sql = "select * from ".self::$tablename." where date(created_at) > \"$start\" and date(created_at) <= \"$end\" and is_oficial=1 and ingredient_id=$product order by created_at desc";
		if($start == $end){
		 $sql = "select * from ".self::$tablename." where date(created_at) = \"$start\" order by created_at desc";
		}
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}



	public function getProduct(){
		return IngredientData::getById($this->ingredient_id);
	}

	public function getOperationType(){
		return OperationTypeData::getById($this->operation_type_id);
	}


////////////////////////////////////////////////////////////////////
	public static function getQ($ingredient_id,$cut_id){
		$q=0;
		$operations = self::getAllByProductIdCutId($ingredient_id,$cut_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}


	public static function getQYesF($ingredient_id){
		$q=0;
		$operations = self::getAllByProductId($ingredient_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
				if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
				else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}

	public static function getQNoF($ingredient_id,$cut_id){
		$q = self::getQ($ingredient_id,$cut_id);
		$f = self::getQYesF($ingredient_id,$cut_id);
		return $q-$f;

	}


	public static function getAllByProductIdCutId($ingredient_id,$cut_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id and cut_id=$cut_id order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->cut_id = $r['cut_id'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByProductId($ingredient_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id  order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


	public static function getAllByProductIdCutIdOficial($ingredient_id,$cut_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id and cut_id=$cut_id and is_oficial=1 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->cut_id = $r['cut_id'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByProductIdCutIdUnOficial($ingredient_id,$cut_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id and cut_id=$cut_id and is_oficial=0 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->is_oficial = $r['is_oficial'];
			$array[$cnt]->cut_id = $r['cut_id'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


	public static function getAllProductsBySellId($sell_id){
		$sql = "select * from ".self::$tablename." where sell_id=$sell_id order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


	public static function getAllByProductIdCutIdYesF($ingredient_id,$cut_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id and cut_id=$cut_id and is_oficial=1 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
						$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->cut_id = $r['cut_id'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

////////////////////////////////////////////////////////////////////
	public static function getOutputQ($ingredient_id,$cut_id){
		$q=0;
		$operations = self::getOutputByProductIdCutId($ingredient_id,$cut_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}

	public static function getOutputQYesF($ingredient_id){
		$q=0;
		$operations = self::getOutputByProductId($ingredient_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}

	public static function getOutputQNoF($ingredient_id,$cut_id){
		$q=0;
		$operations = self::getOutputByProductIdCutIdNoF($ingredient_id,$cut_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}


	public static function getOutputByProductIdCutId($ingredient_id,$cut_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id and cut_id=$cut_id and operation_type_id=2 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->cut_id = $r['cut_id'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


	public static function getOutputByProductId($ingredient_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id and operation_type_id=2 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

////////////////////////////////////////////////////////////////////
	public static function getInputQ($ingredient_id,$cut_id){
		$q=0;
		$operations = self::getInputByProductIdCutId($ingredient_id,$cut_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}

	public static function getInputQYesF($ingredient_id){
		$q=0;
		$operations = self::getInputByProductId($ingredient_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}


	public static function getInputByProductIdCutId($ingredient_id,$cut_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id and cut_id=$cut_id and operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->cut_id = $r['cut_id'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getInputByProductId($ingredient_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id and operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getInputByProductIdCutIdYesF($ingredient_id,$cut_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id and cut_id=$cut_id and is_oficial=1 and operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->cut_id = $r['cut_id'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getInputByProductIdCutIdNoF($ingredient_id,$cut_id){
		$sql = "select * from ".self::$tablename." where ingredient_id=$ingredient_id and cut_id=$cut_id and is_oficial=0 and operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new Operation2Data();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ingredient_id = $r['ingredient_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->cut_id = $r['cut_id'];
			$array[$cnt]->operation_type_id = $r['operation_type_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}
////////////////////////////////////////////////////////////////////////////


}

?>