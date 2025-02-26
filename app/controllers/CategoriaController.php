<?php
    namespace Controllers;

    require_once __DIR__ . '/../models/Categoria.php';
    require_once __DIR__ . '/../../vendor/autoload.php';


    use Pagerfanta\Pagerfanta;
    use Pagerfanta\Adapter\ArrayAdapter;
    use Models\Categoria;

    class CategoriaController{
        public function obtenerCategoriasPaginadas($pagina, $limite = 5){
            $modeloCategoria = new Categoria();
            $todasCategorias = $modeloCategoria->obtenerCategorias();

            $adapter = new ArrayAdapter($todasCategorias);
            $pagerfanta = new Pagerfanta($adapter);
            $pagerfanta->setMaxPerPage($limite);
            $pagerfanta->setCurrentPage($pagina);
            
            return $pagerfanta;
        }
    }
?>