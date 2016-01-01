<?php

namespace App\Services;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

/**
 * Class RouteService
 *
 * アプリケーションのトップページでルートリストを表示するために利用しています
 * 書籍内のサンプルアプリケーションでは利用していません
 */
class RouteService
{
    /** @var Router $router */
    protected $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Compile the routes into a displayable format.
     *
     * @return array
     */
    public function getRoutes()
    {
        $results = [];

        foreach ($this->router->getRoutes() as $route) {
            $results[] = $this->getRouteInformation($route);
        }

        return array_filter($results);
    }

    /**
     * @param Route $route
     *
     * @return array
     */
    protected function getRouteInformation(Route $route)
    {
        return [
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    }
}
