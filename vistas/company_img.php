<div class="container is-fluid mb-6">
	<h1 class="title">Configuraciones</h1>
	<h2 class="subtitle"><i class="far fa-image"></i> &nbsp; Actualizar logo o imagen de empresa</h2>
</div>
<div class="container pb-6 pt-6">
	<?php
		include "./inc/btn_back.php";
		
		require_once "./php/main.php";

		$id=(isset($_GET['id'])) ? $_GET['id'] : 0 ;
        $id=limpiar_cadena($id);

        $datos=conexion();
		$datos=$datos->query("SELECT * FROM empresa WHERE empresa_id='$id'");

		if($datos->rowCount()==1){
			$datos=$datos->fetch();
	?>

	<h2 class="title has-text-centered has-text-link"><?php echo $datos['empresa_nombre']; ?></h2>

	<div class="form-rest mb-6 mt-6"></div>

	<div class="columns">
		<div class="column is-two-fifths">
			<h4 class="subtitle is-4 has-text-centered pb-6">Imagen o logo actual de la empresa</h4>
            <?php if(is_file("./img/logo/".$datos['empresa_foto'])){ ?>
			<figure class="image mb-6">
                <img class="is-photo" src="./img/logo/<?php echo $datos['empresa_foto']; ?>">
			</figure>
			
			<form class="FormularioAjax" action="./php/empresa_img_eliminar.php" method="POST" autocomplete="off" >

				<input type="hidden" name="empresa_id_del" value="<?php echo $datos['empresa_id']; ?>">

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded"><i class="far fa-trash-alt"></i> &nbsp; Eliminar imagen o logo</button>
				</p>
			</form>
			<?php }else{ ?>
			<figure class="image mb-6">
			  	<img class="is-photo" src="./img/logo.png">
			</figure>
			<?php }?>
		</div>


		<div class="column">
			<h4 class="subtitle is-4 has-text-centered pb-6">Actualizar imagen o logo de empresa</h4>
			<form class="mb-6 has-text-centered FormularioAjax" action="./php/empresa_img_actualizar.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<input type="hidden" name="empresa_id" value="<?php echo $datos['empresa_id']; ?>">
				
				<label>Tipos de archivos permitidos: .PNG Tamaño máximo 5MB. Resolución recomendada 300px X 300px o superior manteniendo el aspecto cuadrado (1:1)</label><br><br>

				<div class="file has-name is-boxed is-justify-content-center mb-6">
				  	<label class="file-label">
						<input class="file-input" type="file" name="empresa_foto" accept=".png" >
						<span class="file-cta">
							<span class="file-label">
								Seleccione una imagen
							</span>
						</span>
						<span class="file-name">.PNG (MAX 5MB)</span>
					</label>
				</div>
				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar imagen o logo</button>
				</p>
			</form>
		</div>
	</div>
	<?php
		}else{
			include "./inc/error_alert.php";
		}
		$datos=null;
	?>
</div>