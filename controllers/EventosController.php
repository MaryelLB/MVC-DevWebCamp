<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Ponente;
use MVC\Router;

class EventosController {

    public static function index(Router $router) {
        if(!is_admin()){
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/eventos?page=1');
        }
        $por_pagina = 10;
        $total = Evento::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $eventos = Evento::paginar($por_pagina, $paginacion->offset());
        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/eventos?page=1');
        }
        foreach($eventos as $evento){
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
        }

        //debuguear($eventos);

        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops',
            'eventos' => $eventos,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
    public static function crear(Router $router) {
        if(!is_admin()){
            header('Location: /login');
        }
        $alertas = [];
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');

        $evento = new Evento();


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento->sincronizar($_POST);
            $alertas = $evento->validar();

            if(empty($alertas)) {
                $resultado = $evento->guardar();
                if($resultado) {
                    header('Location: /admin/eventos');
                }
            }
        }
        $alertas = Evento::getAlertas();
        $router->render('admin/eventos/crear', [
            'titulo' => 'Registrar evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }

    public static function editar(Router $router){
        if(!is_admin()){
            header('Location: /login');
        }
        $alertas = [];
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) {
            header('Location: /admin/eventos');
        }
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');
        $evento = Evento::find($id);
        if(!$evento){
            header('Location: /admin/eventos');
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento->sincronizar($_POST);
            $alertas = $evento->validar();

            if(empty($alertas)) {
                $resultado = $evento->guardar();
                if($resultado) {
                    header('Location: /admin/eventos');
                }
            }
        }
        $alertas = Evento::getAlertas();
        $router->render('admin/eventos/editar', [
            'titulo' => 'Editar evento',
            'evento' => $evento,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas
        ]);
    }

    public static function eliminar() {
        if(!is_admin()){
            header('Location: /login');
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $evento = Evento::find($id);
            if(isset($ponente)) {
                header('Location: /admin/eventos');
            }
            $resultado = $evento->eliminar();
            if($resultado) {
                header('Location: /admin/eventos');
            }
        }
    }
}
