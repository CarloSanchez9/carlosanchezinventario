<?php
    $product_id_del=limpiar_cadena($_GET['product_id_del']);

    # Verificando producto #
    $check_producto=conexion();
    $check_producto=$check_producto->query("SELECT * FROM producto WHERE 
    producto_id='$producto_id_del'");
    if($check_producto->rowCount()==1){
        $datos=$check_producto->fetch();

        $eliminar_producto=conexion();
        $eliminar_producto=$eliminar_producto->prepare("DELETE FROM producto WHERE
        producto_id=:id");

        $eliminar_producto->execute([":id"=>$producto_id_del]);

        if($eliminar_producto->rowCount()==1){

            if(is_file("./img/producto/".$datos['producto_foto'])){
                chmod("./img/producto/".$datos['producto_foto'],0777);
                unlink("./img/producto/".$datos['producto_foto']);
            }

            echo '
        <div class="notification is-info is-light">
            <strong>¡Producto eliminado!</strong><br>
            Los datos del producto se eliminaron correctamente
        </div> 
           ';
        }else{
            echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La producto no se pudo eliminar
        </div> 
           ';
        }
        $eliminar_producto=null;
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El producto que intenta eliminar no existe
            </div> 
        ';
    }
    $check_producto=null;