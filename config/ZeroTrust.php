<?php

namespace Config;

use AnserGateway\Config\BaseConfig;

class ZeroTrust extends BaseConfig
{
  /**
   * Feature Zero Trust enabled or not
   *
   * @var string
   */
   public string $enabled = 'true';

  /**
   * Feature Zero Trust enabled or not
   *
   * @var string
   */
   public string $issuerurl = 'https://keycloak.sdpmlab.org';

  /**
   * Realm of Zero Trust
   * 
   * @var string
   */
   public string $realm = 'zerotrust';
   

}
