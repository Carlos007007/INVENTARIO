<div class="container is-fluid mb-6">
    <h1 class="title">Categorías</h1>
    <h2 class="subtitle"><i class="fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar categoría</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        if(isset($_POST['modulo_buscador'])){
            require_once "./php/buscador.php";
        }

        if(!isset($_SESSION['busqueda_categoria']) && empty($_SESSION['busqueda_categoria'])){
    ?>
    <div class="columns">
        <div class="column">
            <form action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="categoria">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" >
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit" ><i class="fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php }else{ ?>
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="categoria"> 
                <input type="hidden" name="eliminar_buscador" value="categoria">
                <p><i class="fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Estas buscando <strong>“<?php echo $_SESSION['busqueda_categoria']; ?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded"><i class="fa-solid fa-trash-can-arrow-up fa-fw"></i> &nbsp; Eliminar busqueda</button>
            </form>
        </div>
    </div>
    <?php
            // Eliminar categoria
            if(isset($_GET['category_id_del'])){
                require_once "./php/categoria_eliminar.php";
            }

            if(!isset($_GET['page'])){
                $pagina=1;
            }else{
                $pagina=(int) $_GET['page'];
                if($pagina<=1){
                    $pagina=1;
                }
            }
    
            $pagina=limpiar_cadena($pagina);
            $url="index.php?vista=category_search&page=";
            $registros=15;
            $busqueda=$_SESSION['busqueda_categoria'];
    
            require_once "./php/categoria_lista.php";
        }
    ?>
</div>