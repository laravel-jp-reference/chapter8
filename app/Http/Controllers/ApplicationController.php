<?php

namespace App\Http\Controllers;

use App\Services\RouteService;

/**
 * Class ApplicationController
 *
 * このクラスは書籍内では利用していません
 * サンプルリポジトリの紹介を扱っているクラスです
 */
class ApplicationController extends Controller
{
    /**
     * @param RouteService $route
     *
     * @return $this
     */
    public function index(RouteService $route)
    {
        return view('index')->with('list', $route->getRoutes());
    }
}
