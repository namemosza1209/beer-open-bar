<?php
class Database {
 
       private $host = 'localhost'; //ชื่อ Host 
	   private $user = 'admin'; //ชื่อผู้ใช้งาน ฐานข้อมูล
	   private $password = 'Mosza@1209'; // password สำหรับเข้าจัดการฐานข้อมูล
	   private $database = 'beeropenbar'; //ชื่อ ฐานข้อมูล

	//function เชื่อมต่อฐานข้อมูล
	protected function connect(){
		
		$mysqli = new mysqli($this->host,$this->user,$this->password,$this->database);
			
			$mysqli->set_charset("utf8");

			if ($mysqli->connect_error) {

			    die('Connect Error: ' . $mysqli->connect_error);
			}

		return $mysqli;
	}
	
	//function เรื่ยกดูข้อมูล all user
	public function get_all_user(){
		
		$db = $this->connect();
		$get_user = $db->query("SELECT * FROM stock WHERE statusflag = 'A' ORDER BY date desc");
		
		while($user = $get_user->fetch_assoc()){
			$result[] = $user;
		}
		
		if(!empty($result)){
			
			return $result;
		}
	}
	
	public function search_user($post = null){
		
		$db = $this->connect();
		$get_user = $db->query("SELECT * FROM stock WHERE statusflag = 'A' AND date LIKE '%".$post."%'  ORDER BY date desc");
		
		while($user = $get_user->fetch_assoc()){
			$result[] = $user;
		}
		
		if(!empty($result)){
			
			return $result;
		}
		
	}
	
	public function get_user($userid){
		
		$db = $this->connect();
		$get_user = $db->prepare("SELECT id,branduid,action,date, qty, price, tips  FROM stock  WHERE id = ? AND statusflag = 'A'");
		$get_user->bind_param('i',$userid);
		$get_user->execute();
		$get_user->bind_result($id,$branduid,$action,$date,$qty,$price,$tips);
		$get_user->fetch();
		
		$result = array(
			'id'=>$id,
			'branduid'=>$branduid,
			'action'=>$action,
			'date'=>$date,
			'qty'=>$qty,
			'price'=>$price,
			'tips'=>$tips
		);
		
		return $result;
	}
	
	//function เพื่ม user
	public function add_user($data){
		
		$db = $this->connect();
		
		$add_user = $db->prepare("INSERT INTO stock (id,branduid,action,date,qty,price,tips) VALUES(NULL,?,?,?,?,?,?) ");
		
		$add_user->bind_param("issiii",$data['send_branduid'],$data['send_action'],$data['send_date'],$data['send_qty'],$data['send_price'],$data['send_tips']);
		
		if(!$add_user->execute()){
			
			echo $db->error;
			
		}else{
			
			echo "บันทึกข้อมูลเรียบร้อย";
		}
	}
	
	//function edit user
	public function edit_user($data){
		
		$db = $this->connect();
		
		$add_user = $db->prepare("UPDATE stock SET branduid = ? , action = ? , date = ? , qty = ? , price = ? , tips = ? WHERE id = ?");
		
		$add_user->bind_param("issiiii",$data['edit_branduid'],$data['edit_action'],$data['edit_date'],$data['edit_qty'],$data['edit_price'],$data['edit_tips'],$data['edit_user_id']);
		
		if(!$add_user->execute()){
			
			echo $db->error;
			
		}else{
			
			echo "บันทึกข้อมูลเรียบร้อย";
		}
	}
	
	//function delete user
	public function delete_user($id){
		
		$db = $this->connect();
		
		$del_user = $db->prepare("DELETE FROM stock WHERE id = ?");
		
		$del_user->bind_param("i",$id);
		
		if(!$del_user->execute()){
			
			echo $db->error;
			
		}else{
			
			echo "ลบข้อมูลเรียบร้อย";
		}
	}
	
	
	
	
}
?>