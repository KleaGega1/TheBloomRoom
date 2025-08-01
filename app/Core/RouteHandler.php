<?php

namespace App\Core;

use AltoRouter;
use Exception;

class RouteHandler
{
    protected $match;
    protected $controller;
    protected $method;

    public function __construct(AltoRouter $altoRouter)
    {
        $this->match = $altoRouter->match();

        if (!$this->match) {
            return View::render()->view('general.errors.404');
        }

        $this->getTarget();

        $this->callTarget();
    }

    protected function getTarget(): void
    {
        list($controller, $this->method) = explode('@', $this->match['target']);
        $this->controller = "\App\Controllers\\" . $controller;

        if (!class_exists($this->controller))
            throw new Exception("Controller $this->controller is not exists.");

        if (!is_callable([new $this->controller, $this->method]))
            throw new Exception("Method $this->method is not defined in $this->controller.");
    }

    protected function callTarget(): void
    {
        if (empty($this->match['params'])) {
            call_user_func([new $this->controller, $this->method]);
        } else {
            call_user_func_array([new $this->controller, $this->method], array_values($this->match['params']));
        }
    }
}
