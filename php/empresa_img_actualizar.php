<?php
    require_once "../inc/session_start.php";
    require_once "main.php";

    $id=limpiar_cadena($_POST['empresa_id']);

    // Verificar la empresa
    $check_empresa=conexion();
    $check_empresa=$check_empresa->query("SELECT * FROM empresa WHERE empresa_id='$id'");

    if($check_empresa->rowCount()==1){
        $datos=$check_empresa->fetch();
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen de la empresa no existe en el sistema
            </div>
        ';
        exit();
    }
    $check_empresa=null;

    # Directorio de imagenes #
    $img_dir="../img/logo/";

    # Comprobar si se selecciono una imagen #
    if($_FILES['empresa_foto']['name']=="" || $_FILES['empresa_foto']['size']==0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No ha seleccionado ninguna imagen valida
            </div>
        ';
        exit();
    }

    # Creando directorio #
    if(!file_exists($img_dir)){
        if(!mkdir($img_dir,0777)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Error al crear el directorio
                </div>
            ';
            exit();
        } 
    }

    chmod($img_dir,0777);

    # Verificando formato de imagenes #
    if(mime_content_type($_FILES['empresa_foto']['tmp_name'])!="image/png"){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen que ha seleccionado es de un formato no permitido
            </div>
        ';
        exit();
    }

    # Verificando peso de imagen #
    if(($_FILES['empresa_foto']['size']/1024)>5120){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen que ha seleccionado supera el peso permitido
            </div>
        ';
        exit();
    }

    $img_nombre=renombrar_fotos($datos['empresa_nombre']);
    $foto=$img_nombre.".png";

    # Moviendo imagen al directorio #
    if(!move_uploaded_file($_FILES['empresa_foto']['tmp_name'],$img_dir.$foto)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos subir la imagen al sistema en este momento
            </div>
        ';
        exit();
    }


    if(is_file($img_dir.$datos['empresa_foto']) && $datos['empresa_foto']!=$foto){
        chmod($img_dir.$datos['empresa_foto'], 0777);
        unlink($img_dir.$datos['empresa_foto']);
    }

    # Actualizar datos #
    $actualizar_empresa=conexion();
    $actualizar_empresa=$actualizar_empresa->prepare("UPDATE empresa SET empresa_foto=:foto WHERE empresa_id=:id");

    $marcadores=[
        ":foto"=>$foto,
        ":id"=>$id
    ];

    if($actualizar_empresa->execute($marcadores)){
        $_SESSION['logo']=$foto;
        echo '
            <div class="notification is-info is-light">
                <strong>¡FOTO O LOGO ACTUALIZADO!</strong><br>
                La foto o logo de la empresa ha sido actualizada con exito.<br>

                <a href="index.php?vista=company_img&id='.$id.'" class="button is-link is-small" >Haga clic acá para recargar los cambios</a>
            </div>
        ';
    }else{
        if(is_file($img_dir.$foto)){
            chmod($img_dir.$foto, 0777);
            unlink($img_dir.$foto);
        }

        echo '
            <div class="notification is-warning is-light">
                <strong>¡Ocurrio un error!</strong><br>
                No podemos subir la imagen en este momento, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_empresa=null;