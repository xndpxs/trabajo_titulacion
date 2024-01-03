<?php
// Request.php
class Request {
    public function get($key, $default = null) {
        return $_GET[$key] ?? $default;
    }

    public function post($key, $default = null) {
        return $_POST[$key] ?? $default;
    }

    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Puedes agregar más métodos según lo necesites, como para manejar `$_FILES`, `$_SERVER`, etc.
}
?>