<?php

require_once __DIR__ . '/../modelos/modeloEntradas.php';

class ControladorEntradas {
    public function listarEntradas() {
        $postModelo=new Post();
        $entradas=$postModelo->obtenerTodas();
        require __DIR__ . '/../vistas/index.php';
    }
}