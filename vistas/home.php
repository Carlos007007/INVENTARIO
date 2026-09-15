<div class="container is-fluid">
	<h1 class="title">Home</h1>
	<h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
</div>
<?php
	require_once "./php/main.php";

	$conexion=conexion();

	$usuario=$conexion->query("SELECT usuario_id FROM usuario WHERE usuario_id!='1'");
	$producto=$conexion->query("SELECT producto_id FROM producto");
	$categoria=$conexion->query("SELECT categoria_id FROM categoria");
?>
<div class="container pb-6 pt-6">

	<div class="columns pb-6">
		<div class="column">
			<nav class="level is-mobile">

				<div class="level-item has-text-centered">
			    	<a href="index.php?vista=user_list">
			      		<p class="heading"><i class="fa-solid fa-user-tie fa-fw"></i> &nbsp; Usuarios</p>
			      		<p class="title"><?php echo $usuario->rowCount(); ?></p>
			    	</a>
			  	</div>

			  	<div class="level-item has-text-centered">
				    <a href="index.php?vista=category_list">
				      	<p class="heading"><i class="fa-solid fa-tags fa-fw"></i> &nbsp; Categorías</p>
				      	<p class="title"><?php echo $categoria->rowCount(); ?></p>
				    </a>
			  	</div>
			  	
			  	<div class="level-item has-text-centered">
				    <a href="index.php?vista=product_list">
				      	<p class="heading"><i class="fa-solid fa-dolly fa-fw"></i> &nbsp; Productos</p>
				      	<p class="title"><?php echo $producto->rowCount(); ?></p>
				    </a>
			  	</div>

			</nav>
		</div>
	</div>

</div>