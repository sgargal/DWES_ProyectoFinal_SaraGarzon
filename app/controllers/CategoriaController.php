<?php
    namespace Controllers;

    require_once __DIR__ . '/../models/Categoria.php'; 
    require_once __DIR__ . '/../../vendor/autoload.php';


    use Pagerfanta\Pagerfanta;
    use Pagerfanta\Adapter\ArrayAdapter;
    use App\Models\Categoria;

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

        public function crearCategoria($nombre){
            if(empty($nombre)){
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'contenido' => 'El nombre de la categoria no puede estar vacío'
                ];
                header('Location: ../views/categoria/crearCategoria.php');
                exit();
            }

            $modeloCategoria = new Categoria();
            $resultado = $modeloCategoria->crearCategoria($nombre);

            if($resultado){
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'contenido' => 'Categoria creada correctamente'
                ];

                header('Location: ../views/categoria/crearCategoria.php');
                exit();
            }else{
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'contenido' => 'Error al crear la categoria'
                ];

                header('Location: ../views/categoria/formCategoria.php');
                exit();
            }
        }

    }
?>