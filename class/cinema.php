<?
class Cinema{
	
	public function __construct($name){
		if(!$name){
			return false;
		}
		$db = MySQL::$current;
		$name_sql = $db->escape($name);
		$sql = "SELECT * FROM cinema WHERE name = '$name_sql'";
		$res = $db->query($sql);
		if(!$res->num_rows){
			return false;
		}
		foreach($res->row as $f => $v){
			$this->$f = $v;
		}
	}
	
	
	public function getHalls($hall_name = ''){
		$db = MySQL::$current;
		$where = '';
		if($hall_name){
			$hall_name_sql = $db->escape($hall_name);
			$where .= " AND name = '$hall_name_sql'";
		}
		$sql = "SELECT * FROM hall WHERE id_cinema = '$this->id' $where";
		$db->query($sql);
		if($res->num_rows){
			unset($this->halls);
			foreach($res->rows as $row){
				foreach($res->rows as $f => $v){
					$this->halls[$row['id']]->$f = $v;
				}
			}
		}
	}
	
	
	public function getSchedule($hall_name = ''){
		
	}
	
}
?>