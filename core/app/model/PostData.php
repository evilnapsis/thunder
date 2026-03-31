<?php


class PostData extends Extra {
	public static $tablename = "post";

	public function __construct(){
		$this->image = "";
		$this->title = "";
		$this->content = "";
		$this->tags = "";
		$this->link = "";
		$this->video = "";
		$this->user_id = "";
		$this->category_id = "";
		$this->post_type_id = "";
		$this->place = "";
		$this->lastname = "";
		$this->name = "";
		$this->is_slide = "0";
		$this->is_quick = "0";
		$this->is_public = "0";
		$this->start_at = "";
		$this->finish_at = "";
		$this->created_at = "NOW()";
	}

	public function getCategory(){ return CategoryData::getById($this->category_id); }


	public function add(){
		$sql = "insert into ".self::$tablename." (image,title,content,created_at,user_id,is_slide,is_public) ";
		$sql .= "value (\"$this->image\",\"$this->title\",\"$this->content\",$this->created_at,\"$this->user_id\",\"$this->is_slide\",\"$this->is_public\")";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set title=\"$this->title\",content=\"$this->content\",image=\"$this->image\",is_slide=\"$this->is_slide\" where id=".$this->id;
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PostData());
	}


	public static function getAllByUser($user_id){
		$sql = "select * from ".self::$tablename." where user_id=$user_id and is_quick=0 and post_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}

	public static function getQuicks(){
		$sql = "select * from ".self::$tablename." where is_quick=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}

	public static function getEvents(){
		$sql = "select * from ".self::$tablename." where post_type_id=2 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}

	public static function getStartEvents(){
		$sql = "select *,DAY(start_at) as s_day,MONTH(start_at) as s_month,YEAR(start_at) as s_year from ".self::$tablename." where post_type_id=2 order by start_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}


	public static function getPosts(){
		$sql = "select * from ".self::$tablename."  order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}



	public static function getSlides(){
		$sql = "select * from ".self::$tablename." where is_slide=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}


	public static function getAll(){
 		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostData());
	}


}

?>