<div class="container is-fluid mb-6">
	<h1 class="title">Reportes</h1>
	<h2 class="subtitle"><i class="fa-regular fa-file fa-fw"></i> &nbsp; Reporte de inventario</h2>
</div>
<?php
    require_once "./php/main.php";

    $datos=conexion();
    $datos=$datos->query("SELECT * FROM empresa LIMIT 1");

    if($datos->rowCount()==1){
?>
<div class="container is-fluid">
    <h4 class="title has-text-centered mt-6 mb-6">Generar reporte de inventario personalizado</h4>
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-two-thirds is-offset-one-fifth">
                <div class="field">
                    <label for="orden_reporte_inventario" class="label">Ordenar por</label>
                    <select class="input" name="orden_reporte_inventario" id="orden_reporte_inventario">
                        <option value="nasc" selected="" >Nombre (ascendente)</option>
                        <option value="ndesc">Nombre (descendente)</option>
                        <option value="sasc">Stock (menor - mayor)</option>
                        <option value="sdesc">Stock (mayor - menor)</option>
                        <option value="pasc">Precio (menor - mayor)</option>
                        <option value="pdesc">Precio (mayor - menor)</option>
                    </select>
                </div>
                <p class="has-text-centered mb-6" >
                    <button type="button" class="button is-link is-outlined" onclick="generar_reporte_inventario()" ><i class="far fa-file-pdf"></i> &nbsp; GENERAR REPORTE</button>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function generar_reporte_inventario(){

    	if (window.confirm("¿Quieres generar el reporte?")) {
	        let orden=document.querySelector('#orden_reporte_inventario').value;

	        orden.trim();

	        if(orden!=""){
	            url="pdf/report-inventory.php?order="+orden;
	            window.open(url,'Imprimir reporte de inventario','width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
	        }else{
	            alert("Debe de seleccionar un orden para generar el reporte.");
	        }
    	}
    }
</script>
<?php }else{ ?>
<div class="container is-fluid">
    <h4 class="title has-text-centered mt-6 mb-6">Generar reporte de inventario personalizado</h4>
    <div class="notification is-warning is-light mb-6 mt-6">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Para generar un reporte primero debe de registrar los datos de la empresa.<br>
        <a href="index.php?vista=company" class="button is-link is-small" >Haga clic acá para registrar los datos de la empresa</a>
    </div>
</div>
<?php } ?>