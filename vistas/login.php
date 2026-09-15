<div class="main-container main-container-login">

    <form class="box login" action="" method="POST" autocomplete="off">
    	<p class="has-text-centered"><i class="fa-solid fa-circle-user fa-5x"></i></p>
		<h5 class="has-text-centered is-uppercase pb-4 pt-4">Inicia sesion con tu cuenta</h5>

		<div class="field">
			<label class="label"><i class="fa-solid fa-user"></i> &nbsp; Usuario</label>
			<div class="control">
			    <input class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
			</div>
		</div>

		<div class="field">
		  	<label class="label"><i class="fa-solid fa-lock"></i> &nbsp; Clave</label>
		  	<div class="control">
		    	<input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
		  	</div>
		</div>

		<p class="has-text-centered mb-4 mt-3">
			<button type="submit" class="button is-info is-rounded"><i class="fa-regular fa-paper-plane"></i> &nbsp; Iniciar sesion</button>
		</p>

		<?php
			if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
				require_once "./php/main.php";
				require_once "./php/iniciar_sesion.php";
			}
		?>
	</form>

</div>