<?php
class Controller {
    protected function view($viewPath, $data = []) {
        extract($data);
        $fullPath = APP_PATH . '/views/' . $viewPath . '.php';
        if (file_exists($fullPath)) {
            require $fullPath;
        } else {
            echo "View not found: $viewPath";
        }
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user']);
    }

    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('login');
        }
    }

    protected function redirect($page) {
        header('Location: index.php?page=' . $page);
        exit;
    }

    protected function redirectWithQuery($page, array $params = []) {
        $qs = http_build_query(array_merge(['page' => $page], $params));
        header('Location: index.php?' . $qs);
        exit;
    }

    protected function currentUser() {
        return $_SESSION['user'] ?? null;
    }
}
