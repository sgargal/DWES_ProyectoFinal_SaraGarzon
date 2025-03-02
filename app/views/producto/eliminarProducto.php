<?php
    session_start();

    if(!isset($_GET['id'])){
        // Si no hay sesión o no hay ID, redirigir al panel de administración
        header('Location: ../views/admin/panelAdmin.php');
        exit();
    }

    require_once '../../models/Producto.php';
    use App\Models\Producto;

    $productoId = $_GET['id'];

    $productoModel = new Producto();

    $producto = $productoModel->obtenerProductoPorId($productoId);


    if (!$producto) {
        // Si no se encuentra el producto, redirigir a la lista de productos
        header('Location: gestion.php');
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $productoEliminado = $productoModel->eliminar($productoId);

        if($productoEliminado){
            header('Location: gestion.php');
            exit();
        } else {
            $error = 'Error al eliminar el producto';
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
<header class="header-form">
        <h1>Tienda Online - Confirmar Eliminación</h1>
        <nav>
            <ul>
                <li><a href="gestion.php">Volver atrás</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="formulario-container">
            <h2>¿Estás seguro de que deseas eliminar este producto?</h2>

            <p><strong>Nombre:</strong> <?= htmlspecialchars($producto['nombre']) ?></p>
            <p><strong>Descripción:</strong> <?= htmlspecialchars($producto['descripcion']) ?></p>
            <form action="../../controllers/procesarProducto.php" method="POST">
                <input type="hidden" name="action" value="eliminar">
                <input type="hidden" name="id" value="<?php echo $productoId; ?>">

                <div class="alerta">
                    <p>Una vez eliminado, no podrás recuperar este producto. ¿Deseas continuar?</p>
                </div>

                <button type="submit" class="btn-eliminar">Eliminar Producto</button>
                <a href="gestion.php" class="btn-cancelar">Cancelar</a>
            </form>
            
        </div>
    </main>
    
    
</body>
</html>