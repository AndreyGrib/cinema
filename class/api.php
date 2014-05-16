<?
class API{
	
	public static function getCinemaSchedule($cinema_name, $hall_name = ''){
		if(!$cinema_name){
			return false;
		}
		$db = MySQL::$current;
		$where = '';
		$cinema_name_sql = $db->escape($cinema_name);
		if($hall_name){
			$hall_name_sql = $db->escape($hall_name);
			$where .= " AND h.name = '$hall_name_sql'";
		}
		$sql = "
			SELECT
				c.name AS c_name,
				h.name AS h_name,
				s.date,
				m.name AS m_name
			FROM cinema c
			JOIN hall h ON h.id_cinema = c.id
			JOIN session s ON s.id_hall = h.id
			JOIN movie m ON m.id = s.id_movie
			WHERE 1 = 1
				AND c.name = '$cinema_name_sql'
				$where
		";
		$res = $db->query($sql);
		if(!$res->num_rows){
			return false;
		}
		return $res->rows;
	}
	
	
	public static function getMovieSchedule($movie_name){
		if(!$movie_name){
			return false;
		}
		$db = MySQL::$current;
		$movie_name_sql = $db->escape($movie_name);
		$sql = "
			SELECT
				c.name AS c_name,
				h.name AS h_name,
				s.date,
				m.name AS m_name
			FROM cinema c
			JOIN hall h ON h.id_cinema = c.id
			JOIN session s ON s.id_hall = h.id
			JOIN movie m ON m.id = s.id_movie
			WHERE m.name = '$movie_name_sql'
		";
		$res = $db->query($sql);
		if(!$res->num_rows){
			return false;
		}
		return $res->rows;
	}
	
	
	public static function getAvailablePlaces($id){
		if(!$id){
			return false;
		}
		$db = MySQL::$current;
		$id_sql = $db->escape($id);
		$sql = "
			SELECT
				c.name AS c_name,
				h.name AS h_name,
				s.date,
				m.name AS m_name,
				h.capacity,
				GROUP_CONCAT(o.place) AS places_reserved
			FROM cinema c
			LEFT JOIN hall h ON h.id_cinema = c.id
			LEFT JOIN session s ON s.id_hall = h.id
			LEFT JOIN movie m ON m.id = s.id_movie
			LEFT JOIN `order` o ON o.id_session = s.id
			WHERE s.id = '$id_sql'
			GROUP BY s.id
		";
		$res = $db->query($sql);
		if(!$res->num_rows){
			return false;
		}
		$places_available = array();
		$places_reserved = explode(',',  $res->row['places_reserved']);
		for($i = 1; $i <= $res->row['capacity']; $i++){
			if(!in_array($i, $places_reserved)){
				$places_available[] = $i;
			}
		}
		return $places_available;
	}
	
	
	public static function buyTickets($id_session, $place){
		if(!$id_session || !$place){
			return false;
		}
		if(is_object($place)){
			$place = (array) $place;
		}
		if(!is_array($place)){
			$place = explode(',', $place);
		}
		
		$db = MySQL::$current;
		$id_session_sql = $db->escape($id_session);
		
		$sql = "
			SELECT
				h.capacity,
				GROUP_CONCAT(o.place) AS places_reserved
			FROM session s
			LEFT JOIN hall h ON h.id = s.id_hall
			LEFT JOIN `order` o ON o.id_session = s.id
			WHERE s.id = '$id_session_sql'
		";
		$res = $db->query($sql);
		if(!$res->num_rows){
			return false;
		}
		
		$capacity = $res->row['capacity'];
		$places_reserved = explode(',',  $res->row['places_reserved']);
		$place_sql = array();
		foreach($place as $p){
			if(in_array($p, $places_reserved) || $p > $capacity){
				return false;
			}
			$place_sql[] = (int) $p;
		}
		$place_sql = implode(',', $place_sql);
		
		$sql = "
			INSERT INTO `order` (
				id_session,
				place
			)
			VALUES(
				'$id_session_sql',
				'$place_sql'
			)
		";
		$db->query($sql);
		return $db->getLastId();
	}
	
	
	public static function rejectTickets($id_order){
		if(!$id_order){
			return false;
		}
		$db = MySQL::$current;
		$id_order_sql = $db->escape($id_order);
		$limit = date('Y-m-d H:i:s', strtotime('+1 hour'));
		$sql = "
			SELECT
				s.date
			FROM `order` o
			LEFT JOIN session s ON s.id = o.id_session
			WHERE 1 = 1
				AND s.date > '$limit'
				AND o.id = '$id_order_sql'
		";
		$res = $db->query($sql);
		if(!$res->num_rows){
			return false;
		}
		$sql = "DELETE FROM `order` WHERE id = '$id_order_sql'";
		return $db->query($sql);
	}
	
}
?>