<?php

namespace AnserGateway\ZeroTrust;

use Config\ZeroTrust as ZeroTrustConfig;
use Config\GatewayRegister;
use SDPMlab\Anser\Service\Action;
use Psr\Http\Message\ResponseInterface;
use SDPMlab\Anser\Service\ConcurrentAction;
use SDPMlab\Anser\Exception\ActionException;
use SDPMlab\Anser\Service\ServiceSettings;

class ZeroTrust{
    // 先確定 Login 行為 (method)

    // 加上舊有使用者 register 行為

    // 還要擴充 user service 

    // 這邊吞吐 account/pwd，去 call keycloak auth，驗證行為發生在這

    // 開一個 api 出去
}