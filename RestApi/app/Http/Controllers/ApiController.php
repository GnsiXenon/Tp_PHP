<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{

/** @OA\Get(
*      path="/api",
*      operationId="api",
*      tags={"Endpoints"},
*      summary="Get list of endpoints",
*      description="Returns list of endpoints",
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent()
*       ),
*      @OA\Response(
*          response=404,
*          description="No endpoints found",
*          @OA\JsonContent()
*       )
*     )
*/
public function getAllEndpoints()
{
    $routes = app()->routes->getRoutes();

    $endpoints = [];

    foreach ($routes as $route) {
        $endpoints[] = $route->uri();
    }

    return $endpoints;
}

}