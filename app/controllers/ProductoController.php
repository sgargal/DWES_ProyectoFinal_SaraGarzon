<?php
    namespace Controllers;

    require_once __DIR__. '/../models/Producto.php';
    require_once __DIR__. '/../models/Categoria.php';

    use App\Models\Producto;
    use App\Models\Categoria;
    use PDOException;

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
            $_SESSION['categorias'] = $categoriaModel->obtenerCategorias();

            // Redirigir a la vista
            header('Location: ../views/producto/crear.php');
            exit();
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

        public function editar(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = $_POST['precio'];
                $stock = $_POST['stock'];
                $categoria_id = $_POST['categoria_id'];
                $imagen = $_FILES['imagen'];

                $productoModel = new Producto();

                try{
                    //Imagen
                    $nombreImagen = null;
                    if(!empty($imagen['name'])){
                        $directorio = '../../../src';
                        if (!is_dir($directorio)) {
                            mkdir($directorio, 0777, true);
                        }
                        $nombreImagen = time() . '_' . basename($imagen['name']);
                        $rutaImagen = $directorio . $nombreImagen;

                        if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
                            $_SESSION['mensaje'] = [
                                'tipo' => 'error',
                                'contenido' => 'Error al subir la imagen'
                            ];
                            header('Location: ../views/producto/editar.php?id=' . $id);
                            exit();
                        }
                    }

                    // Obtener la imagen anterior si no se sube una nueva
                    $productoActual = $productoModel->obtenerProductoPorId($id);
                    if (!$nombreImagen) {
                        $nombreImagen = $productoActual['imagen']; // Mantener la imagen anterior
                    }

                    // Actualizar el producto en la base de datos
                    $actualizado = $productoModel->editar($id, $nombre, $descripcion, $precio, $stock, $categoria_id, $nombreImagen);

                    if ($actualizado) {
                        $_SESSION['mensaje'] = [
                            'tipo' => 'success',
                            'contenido' => 'Producto actualizado correctamente'
                        ];
                    } else {
                        $_SESSION['mensaje'] = [
                            'tipo' => 'error',
                            'contenido' => 'Error al actualizar el producto'
                        ];
                    }

                    header('Location: ../views/producto/gestion.php');
                    exit();
                }catch(PDOException $error){
                    die("Error en la base de datos: " . $error->getMessage());
                }
            }
        }

        public function eliminar($id){
            $productoModel = new Producto();


            $productoEliminado = $productoModel->eliminar($id);

            if($productoEliminado){
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'contenido' => 'Producto eliminado correctamente'
                ];
                header('Location: ../views/producto/gestion.php');
                exit();
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'contenido' => "Hubo un problema al eliminar el prodcuto"
                ];
                header('Location ../views/producto/gestion.php');
                exit();
            }
        }
    }
?>