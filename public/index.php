<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIENDA ONLINE</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <?php
    session_start();

    include '../app/views/layout/header.php';

    require_once '../config/Conexion.php';

    use Config\Conexion;

    $db = new Conexion();
    ?>
    <main>
        <aside class="barraLateral">
            <h2>Categorías</h2>
            <ul>
                <?php
                $sql = "SELECT id, nombre FROM categorias LIMIT 3";
                $stmt = $db->Conectar()->prepare($sql);
                $stmt->execute();
                $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($categorias as $categoria): ?>
                <li>
                    <a href="../app/views/producto/productos.php?=htmlspecialchars($categoria['id']) ?>">
                        <?= htmlspecialchars($categoria['nombre']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <a href="../app/views/categoria/categoria.php" class="ver-mas">Ver más</a>
        </aside>

        <section class="contenidoPrincipal">
            <?php
            if(isset($_SESSION['usuario'])){
                $usuario = $_SESSION['usuario'];
                echo '<h2>Bienvenido, ' . htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellidos']) . '</h2>';
               
            ?>
            <?php }  
             $sqlProductos = "SELECT id, nombre, descripcion, precio, imagen FROM productos";
             $stmtProductos = $db->Conectar()->prepare($sqlProductos);
             $stmtProductos->execute();
             $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

             if($productos): ?>
                <h3>Todos los productos</h3>
                <div class="productos">
                    <?php foreach($productos as $producto): ?>
                        <div class="producto">
                            <img src="../src/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="producto-img" width="135" height="150">
                            <h4><?= htmlspecialchars($producto['nombre']) ?></h4>
                            <p><?= htmlspecialchars($producto['descripcion']) ?></p>
                            <p>Precio: <?= number_format($producto['precio'], 2, ',', '.') ?>€</p>
                            <a href="../app/views/carrito/carrito.php"><i class="fa fa-shopping-cart"></i></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No hay productos disponibles en este momento.</p>
            <?php endif; ?>
            
        </section>
    </main>
    <footer>
        <?php
        include '../app/views/layout/footer.php';
        ?>
    </footer>
</body>
</html>
