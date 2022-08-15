{include file="header_home.tpl"}
  <form method="post">
	<div class="row-fluid">
	<div class="col-md-3"></div>
		<div class="col-md-6 col-xs-6 nopadding">
			<input  type="text" placeholder="DB HOST" value="localhost" name="DB_HOST" required/>
			<input  type="text" placeholder="DB PORT" value="3306" name="DB_PORT" required/>
			<input  type="text" placeholder="DB USER" value="root" name="DB_USER" required/>
			<input  type="text" placeholder="DB PASS" value="" name="DB_PASS"/>
			<input  type="text" placeholder="DB NAME" value="" name="DB_NAME" required/>
			<input  type="text" placeholder="ADMIN USER" value="" name="ADMIN_USER" required/>
			<input  type="text" placeholder="ADMIN PASS" value="" name="ADMIN_PASS" required/>
			<input  type="email" placeholder="ADMIN EMAIL" value="" name="ADMIN_EMAIL" required/>
			<br/><br/>
			<p>Send anonymous minimal data to Adrian Nenu usage statistics server?</p>
			<p><small>This will send a ping to notify me of you installing the game without any IP information being recorded.</small></p>
			<br/>
			<select name="data" required>
				<option value="yes">YES</option>
				<option value="no">NO</option>
			</select>
			<br/><br/>
			<button type="submit" style="border-top:0;">SETUP</button>
		</div>
	</div>
</form>