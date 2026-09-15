<?php
    require_once "main.php";

    $id=limpiar_cadena($_POST['empresa_id']);

    // Verificar la empresa
    $check_empresa=conexion();
    $check_empresa=$check_empresa->query("SELECT * FROM empresa WHERE empresa_id='$id'");

    if($check_empresa->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La empresa no existe en el sistema
            </div>
        ';
        exit();
    }else{
        $datos=$check_empresa->fetch();
    }
    $check_empresa=null;

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

    # Actualizar datos #
    $actualizar_empresa=conexion();
    $actualizar_empresa=$actualizar_empresa->prepare("UPDATE empresa SET empresa_nombre=:nombre,empresa_telefono=:telefono,empresa_email=:email,empresa_direccion=:direccion WHERE empresa_id=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":telefono"=>$telefono,
        ":email"=>$email,
        ":direccion"=>$direccion,
        ":id"=>$id
    ];

    if($actualizar_empresa->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡EMPRESA ACTUALIZADA!</strong><br>
                Los datos de la empresa se actualizaron con éxito<br>
                <a href="index.php?vista=company" class="button is-link is-small" >Haga clic acá para recargar los cambios</a>
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar los datos de empresa, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_empresa=null;