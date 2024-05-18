<?php

namespace App\Filters;

use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;
use AnserGateway\Filters\FilterInterface;
use AnserGateway\ZeroTrust\ZeroTrust;

class ZeroTrustFilter implements FilterInterface
{
    /**
     *
     * @param Request    $request
     * @param array|null $arguments
     *
     * @return void
     */
    public function before(Request $request, $arguments = null)
    {
        $client = ZeroTrust::getZTClient();
        
        var_dump("TestFilter2 before");

    }

    /**
     *
     * @param Request    $request
     * @param Response   $response
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function after(Request $request, Response $response, $arguments = null)
    {
        // $result = $response->rawBody();
        // $decode = json_decode($result);
        // $decode->asd = "TestFilter2 after";
        // return $response->withBody(json_encode($decode));
        var_dump("TestFilter2 after");
    }

}