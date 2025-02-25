<?php
session_start();

require_once '../../../config/Conexion.php';

use Config\Conexion;

$conex = Conexion::Conectar();

//Obtener todos los usuarios
$query = 'SELECT id, nombre, apellidos, email, rol FROM usuarios';
$resultado = $conex->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
    <header class="header-form">
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="crearUsuario.php">Crear Usuario</a></li>
                <li><a href="crearCategoria.php">Crear Categoria</a></li>
                <li><a href="crearProducto.php">Crear Producto</a></li>
                <li><a href="../../../public/index.php">Volver a inicio</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="admin-container">
            <h2>Lista de Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($usuario = $resultado->fetch(PDO::FETCH_ASSOC)) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre'] . " " . $usuario['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                            <td>
                                <a href="editarUsuario.php?id=<?php echo $usuario['id']; ?>" class="btn-editar">Editar</a>
                                <a href="eliminarUsuario.php?id=<?php echo $usuario['id']; ?>" class="btn-eliminar" >Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <?php
            include '../layout/footer.php';
        ?>
    </footer>
</body>
</html>