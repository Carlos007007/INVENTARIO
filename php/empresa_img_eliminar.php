<?php
    require_once "../inc/session_start.php";
    require_once "main.php";

    $id=limpiar_cadena($_POST['empresa_id_del']);

    // Verificar la empresa
    $check_empresa=conexion();
    $check_empresa=$check_empresa->query("SELECT * FROM empresa WHERE empresa_id='$id'");

    if($check_empresa->rowCount()==1){
        $datos=$check_empresa->fetch();
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen o logo de la empresa no existe en el sistema
            </div>
        ';
        exit();
    }
    $check_empresa=null;

    # Directorio de imagenes #
    $img_dir="../img/logo/";

    chmod($img_dir,0777);

    if(is_file($img_dir.$datos['empresa_foto'])){

        chmod($img_dir.$datos['empresa_foto'],0777);

        if(!unlink($img_dir.$datos['empresa_foto'])){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Error al intentar eliminar la foto o logo de la empresa, por favor intente nuevamente
                </div>
            ';
            exit();
        }
    }

    # Actualizar datos #
    $actualizar_empresa=conexion();
    $actualizar_empresa=$actualizar_empresa->prepare("UPDATE empresa SET empresa_foto=:foto WHERE empresa_id=:id");

    $marcadores=[
        ":foto"=>"",
        ":id"=>$id
    ];

    if($actualizar_empresa->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡FOTO o LOGO ELIMINADO!</strong><br>
                La foto o logo de la empresa ha sido eliminada con exito<br>

                <a href="index.php?vista=company_img&id='.$id.'" class="button is-link is-small" >Haga clic acá para recargar los cambios</a>
            </div>
        ';
    }else{
        echo '
            <div class="notification is-warning is-light">
                <strong>¡FOTO o LOGO ELIMINADO!</strong><br>
                Ocurrieron algunos inconvenientes, sin embargo la foto o logo de la empresa ha sido eliminada.<br>

                <a href="index.php?vista=company_img&id='.$id.'" class="button is-link is-small" >Haga clic acá para recargar los cambios</a>
            </div>
        ';
    }
    $_SESSION['logo']="";
    $actualizar_empresa=null;