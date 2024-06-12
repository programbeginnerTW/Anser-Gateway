<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Workerman\Protocols\Http\Response;
use Config\ZeroTrust as ZeroTrustConfig;
use SDPMlab\Anser\Service\Action;
use Psr\Http\Message\ResponseInterface;
use SDPMlab\Anser\Exception\ActionException;

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
        // return $this->response->withStatus(302)->withHeader("Location","https://keycloak.sdpmlab.org/realms/ZT/protocol/openid-connect/token");
        $action = (new Action(
            "ansergateway_userservice",
            "POST",
            "api/v1/user/login"
        ))
        ->addOption("json",[
            'email' => $this->request->post('username'),
            'password' => $this->request->post('password'),
        ])
        ->doneHandler(function(
            ResponseInterface $response,
            Action $runtimeAction,
        ) {
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            $runtimeAction->setMeaningData($data);
        })->failHandler(function (
            ActionException $e
        ) {
            if($e->isClientError()){
                $e->getAction()->setMeaningData([
                    "code" => $e->getStatusCode(),
                    "msg" => "client error"
                ]);
            }else if ($e->isServerError()){
                $e->getAction()->setMeaningData([
                    "code" => $e->getStatusCode(),
                    "msg" => "server error"
                ]);
            }else if($e->isConnectError()){
                $e->getAction()->setMeaningData([
                    "msg" => $e->getMessage()
                ]);
            }   
        });
        $data = $action->do()->getMeaningData();

        if (isset($data["code"])) {
            $res = json_encode([
                "status" => 200,
                "data" => $data["msg"]
            ]);
        } else {
            $res = json_encode([
                "status" => 200,
                "data" => $data["token"]
            ]);
        }
        return $this->response->withStatus(200)->withBody($res);
    }

    public function ztAdmin()
    {
        
        // $username = $this->request->post('username');
        // $pwd = $this->request->post('pwd');

        // $data = $this->request->rawBody();
        // $data = json_decode($data, true);
        // // $zt = new ZT();
        
        // $admintoken = ZT::getAdminToken($data["username"], $data["pwd"]);
        // return $this->response->withStatus(302)->withHeader("Location","https://keycloak.sdpmlab.org/realms/ZT/protocol/openid-connect/token");
        // \AnserGateway\ZeroTrust\ZeroTrust::initialization(new ZeroTrustConfig());
        // \AnserGateway\ZeroTrust\ZeroTrust::verifyEndpoint($this->request);
       
        $res = json_encode([
            "status" => 200,
            // "msg" => 
        ]);

        return $this->response->withStatus(200)->withBody($res);
    }

    public function login()
    {
        $ticket = $this->request->ticket;
        $accessToken = $this->request->accessToken;

        $action = (new Action(
            "ansergateway_userservice",
            "POST",
            "api/v1/user/login"
        ))
        ->addOption("headers",[
            'Authorization' => "Bearer {$accessToken}",
            'Permission-Ticket' => $ticket,
        ])
        ->addOption("json",[
            'email' => $this->request->username,
            'password' => $this->request->password,
        ])
        ->doneHandler(function(
            ResponseInterface $response,
            Action $runtimeAction,
        ) {
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            $runtimeAction->setMeaningData($data);
        })->failHandler(function (
            ActionException $e
        ) {
            if($e->isClientError()){
                $e->getAction()->setMeaningData([
                    "code" => $e->getStatusCode(),
                    "msg" => "client error"
                ]);
            }else if ($e->isServerError()){
                $e->getAction()->setMeaningData([
                    "code" => $e->getStatusCode(),
                    "msg" => "server error"
                ]);
            }else if($e->isConnectError()){
                $e->getAction()->setMeaningData([
                    "msg" => $e->getMessage()
                ]);
            }   
        });
        $data = $action->do()->getMeaningData();

        if (isset($data["code"])) {
            $res = json_encode([
                "status" => 200,
                "data" => $data["msg"]
            ]);
        } else {
            $res = json_encode([
                "status" => 200,
                "data" => $data["token"]
            ]);
        }
        return $this->response->withStatus(200)->withBody($res);
    }
}

?>