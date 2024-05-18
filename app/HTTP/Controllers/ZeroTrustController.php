<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Workerman\Protocols\Http\Response;
use AnserGateway\ZeroTrust\ZeroTrustAdmin as ZT;

class ZeroTrustController extends BaseController
{
    /**
     * method for Get
     *
     * @return  Response
     */
    public function index()
    {
        $res = json_encode([
            "status" => 200,
            "msg" => "index method"
        ]);

        return $this->response->withStatus(200)->withBody($res);
        // return $this->response->withStatus(302)->withHeader("Location","https://www.google.com");
    }

    public function ztAPI()
    {
        // $account = $this->request->post('account');
        // $pwd = $this->request->post('pwd');
        // \AnserGateway\ZeroTrust\ZeroTrust::getZTClient()->checkLogin($account, $pwd);`
        return $this->response->withStatus(302)->withHeader("Location","https://keycloak.sdpmlab.org/realms/ZT/protocol/openid-connect/token");
    }

    public function ztAdmin()
    {
        
        // $username = $this->request->post('username');
        // $pwd = $this->request->post('pwd');

        $data = $this->request->rawBody();
        $data = json_decode($data, true);
        // $zt = new ZT();
        
        $admintoken = ZT::getAdminToken($data["username"], $data["pwd"]);
        // return $this->response->withStatus(302)->withHeader("Location","https://keycloak.sdpmlab.org/realms/ZT/protocol/openid-connect/token");
    }
}

?>