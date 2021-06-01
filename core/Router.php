<?php

namespace core;

use core\controllers;

class Router {

    static public function init() {
        if (array_key_exists('REQUEST_URI', $_SERVER) && $_SERVER['REQUEST_URI'] != '/') {
            $array_url = explode('/', $_SERVER['REQUEST_URI']);
            $section = $array_url[1];
            $action = $array_url[2];
// TODO проверить что будит если section будет не Tasks
// TODO Если после $section написать слеш а $action стандартный то слетают стили
            if (empty($action)) {
                $action = 'index';
            }
        } else {
            $section = 'CP';
            $action = 'index';
        }
        $section = ucfirst(strtolower($section));
        if ($section == 'Cp') {
            $section = 'ControlPanel';
        }
        if ($section == 'Verification' && strlen($action) == 57) {
            $action = 'index';
        }


        $section = "\core\controllers\\" . $section;
        $action = strtolower($action);
        $action = 'action_' . $action;
        if (class_exists($section)) {
            $obj = new $section();
            if (method_exists($obj, $action)) {
                $obj->$action();
            } else {
                self::notFoundAction();
            }
        } else {
            self::notFound();
        }
    }

    static public function notFound() {
        header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
        include_once 'template/404.php';
        exit();
    }

    static public function notFoundAction() {
        header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
        include_once 'template/404.php';
        exit();
    }

    static public function root() {
        if (key_exists('HTTP_X_FORWARDED_PROTO', $_SERVER) && key_exists('HTTP_HOST', $_SERVER)) {
            return $_SERVER[HTTP_X_FORWARDED_PROTO] . "://" . $_SERVER[HTTP_HOST];
        }
        if (key_exists('REQUEST_SCHEME', $_SERVER) && key_exists('HTTP_HOST', $_SERVER)) {
            return $_SERVER[REQUEST_SCHEME] . "://" . $_SERVER[HTTP_HOST];
        }
    }

    static public function redirect($url) {
        header('Location: ' . self::root() . '/' . $url);
        exit();
    }

}
