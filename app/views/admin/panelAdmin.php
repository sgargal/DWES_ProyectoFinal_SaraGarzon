<?php
session_start();

require_once '../../../config/Conexion.php';

use Config\Conexion;

$conex = Conexion::Conectar();

//Obtener todos los usuarios
$sql = 'SELECT id, nombre, apellidos, email, rol FROM usuarios';
$resultado = $conex->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <header class="header-form">
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="crearUsuario.php"><i class="fas fa-plus"></i> Crear Usuario</a></li>
                <li><a href="../categoria/crearCategoria.php">Administrar Categorias</a></li>
                <li><a href="crearProducto.php">Administrar Productos</a></li>
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