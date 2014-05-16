<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?
//http://cinema/?api=1&cinema=1&name=%D0%92%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%B0%20%D0%B3%D0%BE%D0%B4%D0%B0&schedule=1&hall=1
///api/cinema/<название кинотеатра>/schedule[?hall=номер зала]
//http://cinema/api/cinema/%D0%B2%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%B0%20%D0%B3%D0%BE%D0%B4%D0%B0/schedule?hall=2

//http://cinema/?api=1&film=1&name=%D0%9D%D0%BE%D0%B9&schedule=1
///api/film/<название фильма>/schedule
//http://cinema/api/film/22%20%D0%BC%D0%B8%D0%BD%D1%83%D1%82%D1%8B/schedule

//http://cinema/?api=1&session=1&id=1&places=1
///api/session/<id сеанса>/places

//POST /api/tickets/buy?session=<id сеанса>&places=1,3,5,7
//POST /api/tickets/reject/<уникальный код>

/*echo '<pre>';
print_r($_GET);
echo '</pre>';
echo '<pre>';
print_r($_POST);
echo '</pre>';*/

function __autoload($class_name) {
	include '/class/'.$class_name.'.php';
}
new MySQL('localhost', 'root', '1234', 'cinema');
if($_GET['api']){
	if($_GET['cinema'] && $_GET['schedule']){
		$res = API::getCinemaSchedule($_GET['name'], $_GET['hall']);
	}
	else if($_GET['film'] && $_GET['schedule']){
		$res = API::getMovieSchedule($_GET['name']);
	}
	else if($_GET['session'] && $_GET['places']){
		$res = API::getAvailablePlaces($_GET['id']);
	}
}
else if($_POST['api']){
	if($_POST['tickets'] && $_POST['buy']){
		$res = API::buyTickets($_POST['session'], $_POST['places']);
	}
	if($_POST['tickets'] && $_POST['reject']){
		$res = API::rejectTickets($_POST['id_order']);
	}
}

/*echo '<pre>';
print_r($res);
echo '</pre>';*/
echo json_encode($res);
?>