<div id="login">
	<div id="form-login">
		<div id="titleLogin"><h1><?php print $term["login"]["titulologin"]; ?></h1></div>
		<form id="frmLogin" name="frmLogin" autocomplete="off" method="post" action="index.php?p=login">
			<div id="form-fields">
				<div class="fieldForm">
					<label class="loginLabel"><?php print $term["login"]["usuario"]; ?></label>
					<select id="idtype" name="idtype" class="loginIdTypeSlt" title="Seleccione su tipo de identificación. Ejemplo: V, E, G, J." >
						<option name="idtype" class="loginIdTypeOpt" value="1">V</option> 
						<option name="idtype" class="loginIdTypeOpt" value="2">E</option> 
						<option name="idtype" class="loginIdTypeOpt" value="3">P</option> 
						<option name="idtype" class="loginIdTypeOpt" value="4">J</option> 
						<option name="idtype" class="loginIdTypeOpt" value="5">N</option> 
						<option name="idtype" class="loginIdTypeOpt" value="6">G</option> 
						<option name="idtype" class="loginIdTypeOpt" value="7">A</option>
					</select>
					<input id="id" name="id" class="loginInput loginId" type="text" autofocus='on' title="Escriba aquí su identificación. Ejemplo: 123456789." maxlength="20" value=""/>
				</div>
				<div class="fieldForm">
					<label class="loginLabel"><?php print $term["login"]["contrasena"]; ?></label>
					<input id="password" name="password" class="loginInput" type="password" maxlength="40" value="" title="Escriba aquí su contraseña. Ejemplo: $#@123abc_." />
				</div>
			</div>
			<div id="form-button">
				<div class="boxbtnLogin">
					<button class="btnLogin" type="submit" ><?php print $term["login"]["btnlogin"]; ?></button>
				</div>
				<div id="recoveryPass">
					<a class="recoveryPass" href="#" ><?php print $term["login"]["recuperarcontrasena"]; ?></a>
				</div>
			</div>
		</form>
	</div>
</div>
