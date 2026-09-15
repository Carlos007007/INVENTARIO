<?php
    require_once "../inc/session_start.php";
    require_once "main.php";

    # Verificando empresa #
    $check_empresa=conexion();
    $check_empresa=$check_empresa->query("SELECT empresa_id FROM empresa");
    if($check_empresa->rowCount()>=1){
        echo '
            <div class="notification is-warning is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Ya existe una empresa registrada.<br>
                <a href="index.php?vista=company" class="button is-link is-small" >Haga clic acá para recargar los cambios</a>
            </div>
        ';
        exit();
    }

    # Almacenando datos#
    $nombre=limpiar_cadena($_POST['empresa_nombre']);
    $telefono=limpiar_cadena($_POST['empresa_telefono']);
    $email=limpiar_cadena($_POST['empresa_email']);
    $direccion=limpiar_cadena($_POST['empresa_direccion']);

    # Verificando campos obligatorios #
    if($nombre=="" || $direccion==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    # Verificando integridad de los datos #
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,85}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}",$direccion)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La DIRECCION no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if($telefono!=""){
        if(verificar_datos("[0-9()+]{8,20}",$telefono)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El TELEFONO no coincide con el formato solicitado
                </div>
            ';
            exit();
        }
    }

    # Verificando email #
    if($email!=""){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El EMAIL ingresado no es valido
                </div>
            ';
            exit();
        }
    }

    # Directorio de imagenes #
    $img_dir="../img/logo/";

    # Comprobar si se selecciono una imagen #
    if($_FILES['empresa_foto']['name']!="" && $_FILES['empresa_foto']['size']>0){

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

        chmod($img_dir,0777);
        $img_nombre=renombrar_fotos($nombre);
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
    }else{
        $foto="";
    }


    # Guardando datos #
    $guardar_empresa=conexion();
    $guardar_empresa=$guardar_empresa->prepare("INSERT INTO empresa(empresa_nombre,empresa_telefono,empresa_email,empresa_direccion,empresa_foto) VALUES(:nombre,:telefono,:email,:direccion,:foto)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":telefono"=>$telefono,
        ":email"=>$email,
        ":direccion"=>$direccion,
        ":foto"=>$foto
    ];

    $guardar_empresa->execute($marcadores);

    if($guardar_empresa->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡EMPRESA REGISTRADA!</strong><br>
                La empresa se registro con exito. <br>
                <a href="index.php?vista=company" class="button is-link is-small" >Haga clic acá para recargar los cambios</a>
            </div>

        ';
    }else{

        if(is_file($img_dir.$foto)){
            chmod($img_dir.$foto,0777);
            unlink($img_dir.$foto);
        }

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar la empresa, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_empresa=null;