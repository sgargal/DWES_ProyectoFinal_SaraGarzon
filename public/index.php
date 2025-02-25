<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIENDA ONLINE</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
    session_start();

    include '../app/views/layout/header.php';

    require_once '../config/Conexion.php';

    use Config\Conexion;

    $conexion = Conexion::Conectar();
    ?>
    <main>
        <aside class="barraLateral">
            <h2>Categorías</h2>
            <ul>
                <li><a href="">Tecnología</a></li>
                <li><a href="">Nose tampoco</a></li>
                <li><a href="">Nolose</a></li>
            </ul>
        </aside>

        <section class="contenidoPrincipal">
            <?php
            if(isset($_SESSION['usuario'])){
                $usuario = $_SESSION['usuario'];
                echo '<h2>Bienvenido, ' .htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellidos']) . '</h2>';
                if($usuario['rol'] == 'admin'){
                    echo '<p>Aquí puedes gestionar la tienda</p>';

                }else{
                    echo '<p>Aquí puedes ver los productos de la tienda</p>';
                }
                echo '<form action="../app/controllers/UsuarioController.php" method="POST">
                            <input type="hidden" name="action" value="cerrarSesion">
                            <button type="submit">Cerrar sesión</button>
                        </form>';
            }else{
                echo '<h2>Bienvenido a la tienda online</h2>';
                echo '<p>Regístrate o inicia sesión para hacer tu pedido</p>';
            }
            ?>
        </section>

    </main>
    <footer>
        <?php
        include '../app/views/layout/footer.php';
        ?>
    </footer>
</body>
</html>
