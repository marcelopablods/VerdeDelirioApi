<?php 

    header("Access-Control-Allow-Headers:*");
    header("Access-Control-Allow-Origin: *");
    //header("Content-Type: application/json");
    //header("Access-Control-Allow-Methods", "POST");
    //header("Access-Control-Allow-Methods", "GET, POST, DELETE, PUT");

    /*http://localhost/apis/MercadoDelirioApi/controller/updateCategoria.php?id=2&nombre=verduritas*/
	function updateProducto( $id, $idTipoProducto, $idUnidadMedida, $nombre, $precio, $img)
    {

        try{

            require_once ('../connexionPoo.php');

            $pdo = new Conexion();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("SET CHARACTER SET utf8");   

            $stm    = $pdo->prepare("update producto 
                set IdTipoProducto= ?, IdUnidadMedida= ?, Nombre= ?, Precio= ?, Img= ? where IdProducto = ? ");

            $stm->execute(array($idTipoProducto, $idUnidadMedida, $nombre, $precio, $img, $id));

            $count  = $stm->rowCount();

            return $count;

        }catch (Exception $e){
            die($e->getMessage());
            return $e->getMessage();
        }
    }

    include "../entregarResponse.php";

    if(!empty($_GET['id']) &&
        !empty($_GET['idTipoProducto']) &&
        !empty($_GET['idUnidadMedida']) &&
        !empty($_GET['nombre']) &&
        !empty($_GET['precio']) &&
        !empty($_GET['img'])){

        $_GET['id'];
        $_GET['idTipoProducto'];
        $_GET['idUnidadMedida'];
        $_GET['nombre'];
        $_GET['precio'];
        $_GET['img'];

	    $response = updateProducto($_GET['id'], $_GET['idTipoProducto'], $_GET['idUnidadMedida'], $_GET['nombre'], $_GET['precio'], $_GET['img']);
        if($response===false){
            entregarResponse(200, "Los datos ingresados no corresponden", null);
        }else{
            entregarResponse(200, 0, $response);
        }
    }else{
        entregarResponse(400, "Bad request", null);
    }

?>