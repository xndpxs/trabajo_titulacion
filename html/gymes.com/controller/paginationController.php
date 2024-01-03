<?php

class PaginationController
{

    private $model;

    public function __construct($modelInstance)
    {
        $this->model = $modelInstance;
    }

    public function getPaginationData($query = '', $page = 1, $records_per_page = 10)
    {
        $items = $this->model->getItems($query, $page, $records_per_page); // Cambié 'getDoctors' por 'getItems' para que sea más genérico.

        // Imaginando que tienes un método que devuelve el total de registros.
        $total_records = $this->model->getTotalItems($query); // Cambié 'getTotalDoctors' por 'getTotalItems' para que sea más genérico.
        $total_pages = ceil($total_records / $records_per_page);

        // Esto determinará cuántos números de página mostrar antes y después de la página actual.
        $range = 2;
        $start_page = max(1, $page - $range);
        $end_page = min($total_pages, $page + $range);

        return [
            'items' => $items,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'start_page' => $start_page,
            'end_page' => $end_page,
            'current_page' => $page
        ];
    }
}
