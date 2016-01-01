<?php

/**
 * @see \App\Services\RouteService
 */
class RouteServiceTest extends \TestCase
{
    /** @var \App\Services\RouteService */
    protected $route;

    public function setUp()
    {
        parent::setUp();
        $this->route = new \App\Services\RouteService(
            $this->app['router']
        );
    }

    public function testGetRouteList()
    {
        $routes = $this->route->getRoutes();
        $this->assertInternalType('array', $routes);
        foreach ($routes as $route) {
            $this->assertArrayHasKey('method', $route);
            $this->assertArrayHasKey('uri', $route);
            $this->assertArrayHasKey('name', $route);
            $this->assertArrayHasKey('action', $route);
        }
    }
}
