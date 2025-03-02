<?php
require_once '../../controllers/CategoriaController.php';
use Controllers\CategoriaController;

$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$controller = new CategoriaController();
$categoriasPaginadas = $controller->obtenerCategoriasPaginadas($pagina);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header-inicio">
        <h1>Categorías de Productos</h1>
        <nav>
            <ul>
                <li><a href="../../../public/index.php">Volver al inicio</a></li>
            </ul>
        </nav>
    </header>
    <main class="todas-categorias">
        <section class="categorias">
            <h2>Explora nuestras categorías:</h2>
            <ul>
                <?php foreach ($categoriasPaginadas->getCurrentPageResults() as $categoria): ?>
                    <li>
                        <a href="../producto/productos.php?categoria=<?= htmlspecialchars($categoria['id']) ?>">
                            <?= htmlspecialchars($categoria['nombre']) ?>
                            <i class="fa fa-arrow-right"></i>
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