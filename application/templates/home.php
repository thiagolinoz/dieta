		<form method="post" action="index.php?action=check">
			<input type="text" name="user"/><br/>
			<input type="password" name="password"/><br/>
			<input type="submit"/>
		</form>
		<p>Faça seu Login</p>
		<?= isset($_SESSION['msg']) ? $_SESSION['msg'] : '' ?>
