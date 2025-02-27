<?php
require_once '../../controllers/CategoriaController.php';
use Controllers\CategoriaController;

session_start();

$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$controller = new CategoriaController();
$categoriasPaginadas = $controller->obtenerCategoriasPaginadas($pagina);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoria</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <header class="header-form">
        <h1>Categorias</h1>
        <nav>
            <ul>
                <li><a href="formCategoria.php"><i class="fas fa-plus"></i> Añadir</a></li>
                <li><a href="editarCategoria.php"><i class="fas fa-pencil"></i> Editar</a></li>
                <li><a href="../../views/admin/panelAdmin.php">Volver atrás</a></li>
            </ul>
        </nav>
    </header>
    <main class="todas-categorias">
        <section class="categorias">
            <h2>Listado de categorías:</h2>
            
            <?php
                if(isset($_SESSION['mensaje'])){
                    $mensaje = $_SESSION['mensaje'];
                    $clase = $mensaje['tipo'] == 'success' ? 'mensaje-exito' : 'mensaje-error';
                    echo '<div class="' . $clase . '">' . $mensaje['contenido'] . '</div>';
                    unset($_SESSION['mensaje']);
                }
            ?>
            <ul>
                <?php foreach ($categoriasPaginadas->getCurrentPageResults() as $categoria): ?>
                    <li>
                        <a href="productos.php?categoria=<?= htmlspecialchars($categoria['id']) ?>">
                            <?= htmlspecialchars($categoria['nombre'])?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>


             <!-- Enlaces de paginación -->
             <div class="paginacion">
                <?php if ($categoriasPaginadas->hasPreviousPage()): ?>
                    <a href="?pagina=<?= $categoriasPaginadas->getPreviousPage() ?>">Anterior</a>
                <?php endif; ?>

                <span>Página <?= $pagina ?> de <?= $categoriasPaginadas->getNbPages() ?></span>

                <?php if ($categoriasPaginadas->hasNextPage()): ?>
                    <a href="?pagina=<?= $categoriasPaginadas->getNextPage() ?>">Siguiente</a>
                <?php endif; ?>
            </div>
            
        </section>
    </main>
    <footer>
        <?php
        include '../layout/footer.php';
        ?>
    </footer>
</body>
</html>