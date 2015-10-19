<?php


class PostData {
	public static $tablename = "post";
	public function PostData(){
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


		$this->is_slide = "";
		$this->is_quick = "";
		$this->is_public = "";
		$this->start_at = "";
		$this->finish_at = "";

		$this->created_at = date("Y-m-d h:i:s",time());
		$this->updated_at = date("Y-m-d h:i:s",time());
	}

	public function getChannel(){ return ChannelData::getById($this->user_id); }
	public function getCategory(){ return CategoryData::getById($this->category_id); }

	public function getLikes(){ return IsLikeData::getAllLikeByImageId($this->id); }
	public function getDisLikes(){ return IsLikeData::getAllDisLikeByImageId($this->id); }
	public function getViews() { return ImageViewData::getAllByImageId($this->id); }


	public function add(){
		$sql = "insert into ".self::$tablename." (image,title,content,created_at,user_id,is_slide,is_public) ";
		$sql .= "value (\"$this->image\",\"$this->title\",\"$this->content\",\"$this->created_at\",\"$this->user_id\",\"$this->is_slide\",\"$this->is_public\")";
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

// partiendo de que ya tenemos creado un objecto PostData previamente utilizamos el contexto
	public function update(){
	//	print_r($this->country);
		$sql = "update ".self::$tablename." set title=\"$this->title\",content=\"$this->content\",image=\"$this->image\",is_slide=\"$this->is_slide\" where id=".$this->id;
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new PostData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->title = $r['title'];
			$data->image = $r['image'];
			$data->content = $r['content'];
			$data->is_public = $r['is_public'];
			$data->is_slide = $r['is_slide'];
			$data->created_at = $r['created_at'];
			$data->user_id = $r['user_id'];
			$found = $data;
			break;
		}
		return $found;
	}


	public static function getByName($name){
		$sql = "select * from ".self::$tablename." where name=\"$name\"";
		$query = Executor::doit($sql);
		$found = null;
		$data = new PostData();
		while($r = $query->fetch_array()){
			$data->id = $r['id'];
			$data->nick = $r['nick'];
			$data->name = $r['name'];
			$data->mail = $r['mail'];
			$data->password = $r['password'];
			$data->usertype = UserTypedata::getById($r['usertype_id']);
			$data->status = StatusData::getById($r['status_id']);
			$data->is_admin = $r['is_admin'];
			$data->is_verified = $r['is_verified'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllByUser($user_id){
echo		$sql = "select * from ".self::$tablename." where user_id=$user_id and is_quick=0 and post_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PostData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->title = $r['title'];
			$array[$cnt]->content = $r['content'];
			$array[$cnt]->tags = $r['tags'];
			$array[$cnt]->link = $r['link'];
			$array[$cnt]->video = $r['video'];
			$array[$cnt]->user_id = $r['user_id'];
			$array[$cnt]->is_slide = $r['is_slide'];
			$array[$cnt]->is_quick = $r['is_quick'];
			$array[$cnt]->is_public = $r['is_public'];
			$array[$cnt]->category_id = $r['category_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getQuicks(){
		$sql = "select * from ".self::$tablename." where is_quick=1 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PostData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->title = $r['title'];
			$array[$cnt]->content = $r['content'];
			$array[$cnt]->tags = $r['tags'];
			$array[$cnt]->link = $r['link'];
			$array[$cnt]->video = $r['video'];
			$array[$cnt]->user_id = $r['user_id'];
			$array[$cnt]->is_slide = $r['is_slide'];
			$array[$cnt]->is_quick = $r['is_quick'];
			$array[$cnt]->is_public = $r['is_public'];
			$array[$cnt]->category_id = $r['category_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getEvents(){
		$sql = "select * from ".self::$tablename." where post_type_id=2 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PostData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->title = $r['title'];
			$array[$cnt]->content = $r['content'];
			$array[$cnt]->tags = $r['tags'];
			$array[$cnt]->link = $r['link'];
			$array[$cnt]->video = $r['video'];
			$array[$cnt]->user_id = $r['user_id'];
			$array[$cnt]->start_at = $r['start_at'];
			$array[$cnt]->finish_at = $r['finish_at'];

			$array[$cnt]->place = $r['place'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->lastname = $r['lastname'];


			$array[$cnt]->is_slide = $r['is_slide'];
			$array[$cnt]->is_quick = $r['is_quick'];
			$array[$cnt]->is_public = $r['is_public'];
			$array[$cnt]->category_id = $r['category_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getStartEvents(){
		$sql = "select *,DAY(start_at) as s_day,MONTH(start_at) as s_month,YEAR(start_at) as s_year from ".self::$tablename." where post_type_id=2 order by start_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PostData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->title = $r['title'];
			$array[$cnt]->content = $r['content'];
			$array[$cnt]->tags = $r['tags'];
			$array[$cnt]->link = $r['link'];
			$array[$cnt]->video = $r['video'];
			$array[$cnt]->place = $r['place'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->lastname = $r['lastname'];
			$array[$cnt]->user_id = $r['user_id'];
			$array[$cnt]->start_at = $r['start_at'];
			$array[$cnt]->s_day = $r['s_day'];
			$array[$cnt]->s_month = $r['s_month'];
			$array[$cnt]->s_year = $r['s_year'];

			$array[$cnt]->finish_at = $r['finish_at'];


			$array[$cnt]->is_slide = $r['is_slide'];
			$array[$cnt]->is_quick = $r['is_quick'];
			$array[$cnt]->is_public = $r['is_public'];
			$array[$cnt]->category_id = $r['category_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


	public static function getPosts(){
		$sql = "select * from ".self::$tablename."  order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PostData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->title = $r['title'];
			$array[$cnt]->content = $r['content'];
			$array[$cnt]->user_id = $r['user_id'];
			$array[$cnt]->is_slide = $r['is_slide'];
			$array[$cnt]->is_public = $r['is_public'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}



	public static function getSlides(){
		$sql = "select * from ".self::$tablename." where is_slide=1 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PostData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->title = $r['title'];
			$array[$cnt]->content = $r['content'];
			$array[$cnt]->user_id = $r['user_id'];
			$array[$cnt]->is_slide = $r['is_slide'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


	public static function getAll(){
 		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PostData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->title = $r['title'];
			$array[$cnt]->content = $r['content'];
			$array[$cnt]->tags = $r['tags'];
			$array[$cnt]->user_id = $r['user_id'];
			$array[$cnt]->category_id = $r['category_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


}

?>