<?php
    namespace Controllers;

    require_once __DIR__. '/../models/Producto.php';
    require_once __DIR__. '/../models/Categoria.php';

    use Models\Producto;
    use Models\Categoria;

    class ProductoController{
        public function crear(){
            session_start();

            // Verificar si el usuario es administrador
            if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error', 
                    'contenido' => 'No tienes permisos para crear productos'
                ];
                header('Location: ../views/productos/crear.php');
                exit();
            }

            $categoriaModel = new Categoria();
            $categorias = $categoriaModel->obtenerCategorias();

            require_once __DIR__. '/../views/producto/crear.php';
        }

        public function guardar(){
            session_start();

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = $_POST['precio'];
                $stock = $_POST['stock'];
                $categoria_id = $_POST['categoria_id'];
                $imagen = $_FILES['imagen'];


                //VALIDACIÓN DE LOS DATOS
                if(empty($nombre) || empty($descripcion) || empty($precio) || empty($stock) || empty($categoria_id) || empty($imagen['name'])){
                    $_SESSION['mensaje'] = [
                        'tipo' => 'error',
                        'contenido' => 'Todos los campos son obligatorios'
                    ];
                    header('Location: ../views/producto/crear.php');
                    exit();
                }

                //Subir imagen
                $directorio = __DIR__ . '/../../src/';
                if(!is_dir($directorio)){
                    mkdir($directorio, 0777, true);
                }

                $nombreImagen = time() . '_' . basename($imagen['name']);
                $rutaImagen = $directorio . $nombreImagen;

                if(move_uploaded_file($imagen['tmp_name'], $rutaImagen)){
                    $productoModel = new Producto();
                    $resultado = $productoModel->crearProducto($nombre, $descripcion, $precio, $stock, $categoria_id, $nombreImagen);

                    $_SESSION['mensaje'] = $resultado
                    ? ['tipo' => 'success', 'contenido' => 'Producto creado correctamente']
                    : ['tipo' => 'error', 'contenido' => 'Error al crear el producto'];

                    header('Location: ../views/producto/gestion.php');
                    exit();
                }else{
                    $_SESSION['mensaje'] = [
                        'tipo' => 'error',
                        'contenido' => 'Error al subir la imagen'
                    ];

                    header('Location: ../views/producto/crear.php');
                    exit();
                }
            }
        }
    }
?>