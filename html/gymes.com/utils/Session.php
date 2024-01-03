<?php
class Session {
    public function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public function has($key) {
        return isset($_SESSION[$key]);
    }

    public function remove($key) {
        unset($_SESSION[$key]);
    }

    public function destroy() {
        session_destroy();
    }

    public function generateCsrfToken() {
        if (!$this->has('csrf_token')) {
            $this->set('csrf_token', bin2hex(random_bytes(32)));
        }
    }

    public function getCsrfToken() {
        $this->generateCsrfToken(); // Asegura que el token está generado
        return $this->get('csrf_token');
    }

    public function isValidCsrfToken($token) {
        return $token === $this->get('csrf_token');
    }
}
?>