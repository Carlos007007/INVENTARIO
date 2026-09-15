<div class="container is-fluid mb-6">
    <h1 class="title">Configuraciones</h1>
    <h2 class="subtitle"><i class="fas fa-store-alt fa-fw"></i> &nbsp; Datos de empresa</h2>
</div>

<div class="container pb-6 pt-6">
    <div class="form-rest mb-6 mt-6"></div>
    <?php
        require_once "./php/main.php";

        $datos=conexion();
        $datos=$datos->query("SELECT * FROM empresa LIMIT 1");

        if($datos->rowCount()==1){
            $datos=$datos->fetch();
    ?>
    <h2 class="title has-text-centered"><?php echo $datos['empresa_nombre']; ?></h2>

    <form action="./php/empresa_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

        <input type="hidden" name="empresa_id" value="<?php echo $datos['empresa_id']; ?>">

        <div class="columns">
            <div class="column">
                <?php if(is_file("./img/logo/".$datos['empresa_foto'])){ ?>
                    <figure class="company-image">
                        <img src="./img/logo/<?php echo $datos['empresa_foto']; ?>">
                    </figure>
                <?php }else{ ?>
                    <figure class="company-image">
                        <img src="./img/logo.png">
                    </figure>
                <?php } ?>
                <p class="has-text-centered mt-3" >
                    <a href="<?php echo "index.php?vista=company_img&id=".$datos['empresa_id']; ?>" class="button is-link is-outlined"><i class="far fa-image"></i> &nbsp; Cambiar logo o imagen</a>
                </p>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="empresa_nombre" value="<?php echo $datos['empresa_nombre']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,85}" maxlength="85" required >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Teléfono</label>
                    <input class="input" type="text" name="empresa_telefono" value="<?php echo $datos['empresa_telefono']; ?>" pattern="[0-9()+]{8,20}" maxlength="20" >
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input class="input" type="email" name="empresa_email" value="<?php echo $datos['empresa_email']; ?>" maxlength="50" >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Dirección</label>
                    <input class="input" type="text" name="empresa_direccion" value="<?php echo $datos['empresa_direccion']; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}" maxlength="97" required >
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar</button>
        </p>
    </form>

    <?php }else{ ?>

    <form action="./php/empresa_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre</label>
                    <input class="input" type="text" name="empresa_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,85}" maxlength="85" required >
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Teléfono</label>
                    <input class="input" type="text" name="empresa_telefono" pattern="[0-9()+]{8,20}" maxlength="20" >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input class="input" type="email" name="empresa_email" maxlength="50" >
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Dirección</label>
                    <input class="input" type="text" name="empresa_direccion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}" maxlength="97" required >
                </div>
            </div>
            <div class="column">
                <label>Foto o logo de la empresa</label><br>
                <div class="file is-small has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="empresa_foto" accept=".png" >
                        <span class="file-cta">
                            <span class="file-label">Imagen</span>
                        </span>
                        <span class="file-name">.PNG (MAX 5MB)</span>
                    </label>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded"><i class="far fa-save"></i> &nbsp; Guardar</button>
        </p>
    </form>
    <?php } ?>
</div>