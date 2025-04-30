<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class PonentesController {

    public static function index(Router $router) {
        if(!is_admin()){
            header('Location: /login');
            return;
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/ponentes?page=1');
        }
        $registros_por_pagina=10;
        $total = Ponente::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        
        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());
        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
        }
        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router) {
        if(!is_admin()){
            header('Location: /login');
        }
        $alertas = [];
        $ponente = new Ponente();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';
                //Crear la carpeta si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0777, true);
                }

                $manager = new Image(Driver::class);
                $imagen_png = $manager->read($_FILES['imagen']['tmp_name'])->contain(800, 800)->encodeByExtension('png', 80);
                $imagen_webp = $manager->read($_FILES['imagen']['tmp_name'])->contain(800, 800)->encodeByExtension('webp', 80);

                $nombre_Imagen = md5( uniqid( rand(), true) );

                $_POST['imagen'] = $nombre_Imagen;
            } 
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);
            //Validar Alertas
            $alertas = $ponente->validar();

            //Guardar el registro
            if(empty($alertas)) {
                //Guardar las imagenes
                $imagen_png->save($carpeta_imagenes . '/' .$nombre_Imagen . '.png');
                $imagen_webp->save($carpeta_imagenes . '/' .$nombre_Imagen. '.webp');
                //Guardar en la BD
                $resultado = $ponente->guardar();

                if($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
            }
        $alertas = Ponente::getAlertas();
        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar ponentes',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }
    public static function editar(Router $router) {
        if(!is_admin()){
            header('Location: /login');
        }
        $alertas = [];
        //Obtener el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) {
            header('Location: /admin/ponentes');
        }
        //Obtener el ponente a editar
        $ponente = Ponente::find($id);
        if(!$ponente) {
            header('Location: /admin/ponentes');
        }
        $ponente->imagen_actual = $ponente->imagen;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';
                //Crear la carpeta si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0777, true);
                }

                $manager = new Image(Driver::class);
                $imagen_png = $manager->read($_FILES['imagen']['tmp_name'])->contain(800, 800)->encodeByExtension('png', 80);
                $imagen_webp = $manager->read($_FILES['imagen']['tmp_name'])->contain(800, 800)->encodeByExtension('webp', 80);

                $nombre_Imagen = md5( uniqid( rand(), true) );

                $_POST['imagen'] = $nombre_Imagen;
            }  else {
                $_POST['imagen'] = $ponente->imagen_actual;
            }
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();

            if(empty($alertas)) {
                if(isset($nombre_Imagen)) {
                //Guardar las imagenes
                    $imagen_png->save($carpeta_imagenes . '/' .$nombre_Imagen . '.png');
                    $imagen_webp->save($carpeta_imagenes . '/' .$nombre_Imagen. '.webp');
                }
                $resultado = $ponente->guardar();
                if($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }
        $router->render('admin/ponentes/editar', [
            'titulo' => 'Editar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }
    public static function eliminar() {
        if(!is_admin()){
            header('Location: /login');
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $ponente = Ponente::find($id);
            if(isset($ponente)) {
                header('Location: /admin/ponentes');
            }
            $resultado = $ponente->eliminar();
            if($resultado) {
                header('Location: /admin/ponentes');
            }
        }
    }
}
