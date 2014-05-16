<?
//POST /api/tickets/buy?session=<id сеанса>&places=1,3,5,7
//POST /api/tickets/reject/<уникальный код>
?>
<form action="/" method="post">
	<input type="hidden" name="api" value="1">
	<input type="hidden" name="tickets" value="1">
	<input type="hidden" name="buy" value="1">
	<input type="text" name="session" placeholder="session">
	<input type="text" name="places" placeholder="places">
	<input type="submit">
</form>

<form action="/" method="post">
	<input type="hidden" name="api" value="1">
	<input type="hidden" name="tickets" value="1">
	<input type="hidden" name="reject" value="1">
	<input type="text" name="id_order" placeholder="id_order">
	<input type="submit">
</form>