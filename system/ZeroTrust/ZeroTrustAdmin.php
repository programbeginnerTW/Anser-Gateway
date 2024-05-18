<?php

namespace AnserGateway\ZeroTrust;

use SDPMlab\Anser\Service\Action;
use Psr\Http\Message\ResponseInterface;
use SDPMlab\Anser\Exception\ActionException;
use Config\ZeroTrust as ZeroTrustConfig;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak as ZTClient;

use function Swow\Debug\isStrictStringable;

class ZeroTrustAdmin{

    private static $ztConfig=null;

    private static $ztClient=null;

    private static $ztToken = null;
    private static $ztRefreshToken = null;

    // public static function __construct()
    // {
    //     $this->ztConfig = new ZeroTrustConfig();
    //     $this->ztClient = new ZTClient([
    //         'authServerUrl'         => $this->ztConfig->tokenauthurl,
    //         'realm'                 => $this->ztConfig->realm,
    //         'clientId'              => $this->ztConfig->clientID,
    //         'clientSecret'          => $this->ztConfig->clientSecret,
    //         'username'              => $this->ztConfig->username,
    //         'pasword'               => $this->ztConfig->password,
    //     ]);
    // }

    /**
     * Return $ztClient
     *
     * @return ztClient 
     */

    
    public static function getZTClient() : ZTClient
    {     
        if(!is_null(self::$ztClient)){
            return self::$ztClient;
        }
        self::$ztConfig = new ZeroTrustConfig();
        self::$ztClient = new ZTClient([
            'authServerUrl'         => self::$ztConfig->tokenauthurl,
            'realm'                 => self::$ztConfig->realm,
            'clientId'              => self::$ztConfig->clientID,
            'clientSecret'          => self::$ztConfig->clientSecret,
            'username'              => self::$ztConfig->username,
            'pasword'               => self::$ztConfig->password,
        ]);        
        return self::$ztClient;
    }

    /**
     * Get admin token
     *
     * @return string
     */
    public static function getAdminToken($username, $pwd) {

        if (!is_null(self::$ztToken) && !is_null(self::$ztRefreshToken)) {
            return self::$ztToken;
        }

        $action = (new Action(
            "https://keycloak.sdpmlab.org",
            "POST",
            "realms/ZT/protocol/openid-connect/token"
        ))
        ->addOption("form_params",[
            'grant_type'  => self::$ztConfig->grantType,
            'client_id' => self::$ztConfig->clientID,
            'client_secret' => self::$ztConfig->clientSecret,
            'username' => $username,
            'password' => $pwd,
        ])
        ->doneHandler(function(
            ResponseInterface $response,
            Action $runtimeAction,
        ) {
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            var_dump($body);
            var_dump("data=", $data);
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

        $adminToken = $action->do()->getMeaningData();
        var_dump($adminToken);
        self::$ztToken = $adminToken["access_token"];
        self::$ztRefreshToken = $adminToken["refresh_token"];
        return self::$ztToken;
    }

    // 先確定 Login 行為 (method)

    /**
     * Login using env configuration *(admin user)
     *
     * @return bool
     */
    public static function checkLogin($username, $pwd) {
        // Call the getAdminToken function to retrieve the admin token
        $adminToken = self::getAdminToken($username, $pwd);

        // Check if the admin token is null
        if (!is_null($adminToken)) {
            return false;
        }
        // 其他登入判斷 
        return true;
    }

    // 加上舊有使用者 register 行為 (user service 行為)  // 還要擴充 user service
    

    public static function verifyToken($token) {
        $action = (new Action(
            "https://keycloak.sdpmlab.org",
            "POST",
            "realms/ZT/protocol/openid-connect/introspect"
        ))
        ->addOption("form_params",[
            'grant_type'  => self::$ztConfig->grantType,
            'client_id' => self::$ztConfig->clientID,
            'client_secret' => self::$ztConfig->clientSecret,
            'token' => $token,
        ])
        ->doneHandler(function(
            ResponseInterface $response,
            Action $runtimeAction,
        ) {
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            var_dump($body);
            var_dump("data=", $data);
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

    }

    
}

?>