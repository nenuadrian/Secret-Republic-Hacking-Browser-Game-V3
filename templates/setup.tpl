{include file="header_home.tpl"}
  <form method="post">
		<div class="row-fluid">
		<div class="col-md-3"></div>
			<div class="col-md-6 col-xs-6 nopadding">
				<select name="DB_DRIVER" id="db-driver">
					<option value="mysql" selected>MYSQL</option>
					<option value="sqlite">SQLITE (LOCAL FILE)</option>
				</select>
				<input  type="text" placeholder="DB HOST" value="localhost" name="DB_HOST" id="db-host" required/>
				<input  type="text" placeholder="DB PORT" value="3306" name="DB_PORT" id="db-port" required/>
				<input  type="text" placeholder="DB USER" value="root" name="DB_USER" id="db-user" required/>
				<input  type="text" placeholder="DB PASS" value="" name="DB_PASS" id="db-pass"/>
				<input  type="text" placeholder="DB NAME" value="" name="DB_NAME" id="db-name" required/>
				<input  type="text" placeholder="SQLITE PATH (RELATIVE OR ABSOLUTE)" value="includes/local.sqlite" name="SQLITE_PATH" id="sqlite-path"/>
				<input  type="text" placeholder="ADMIN USER" value="" name="ADMIN_USER" required/>
				<input  type="text" placeholder="ADMIN PASS" value="" name="ADMIN_PASS" required/>
				<input  type="email" placeholder="ADMIN EMAIL" value="" name="ADMIN_EMAIL" required/>
				<br/><br/>
				<button type="submit" style="border-top:0;">SETUP</button>
			</div>
		</div>
	</form>
	<script>
	(function() {
		var driver = document.getElementById('db-driver');
		var mysqlFields = [
			document.getElementById('db-host'),
			document.getElementById('db-port'),
			document.getElementById('db-user'),
			document.getElementById('db-pass'),
			document.getElementById('db-name')
		];
		var sqliteField = document.getElementById('sqlite-path');

		function refreshFields() {
			var isSqlite = driver.value === 'sqlite';
			for (var i = 0; i < mysqlFields.length; i++) {
				mysqlFields[i].style.display = isSqlite ? 'none' : 'block';
				mysqlFields[i].required = !isSqlite && mysqlFields[i].id !== 'db-pass';
			}
			sqliteField.style.display = isSqlite ? 'block' : 'none';
		}

		driver.addEventListener('change', refreshFields);
		refreshFields();
	})();
	</script>
