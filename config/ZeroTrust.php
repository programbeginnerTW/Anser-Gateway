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
   public bool $enabledzero = true;

   /**
    * host
    *
    * @var string
    */
   public string $host = '';
  /**
   * Feature Zero Trust enabled or not
   *
   * @var string
   */
   public string $tokenauthurl = '';

   public string $introspecturl = '';

  /**
   * Realm of Zero Trust
   * 
   * @var string
   */
   public string $realm='';

  /**
   * Client ID of ZT realm
   *
   * @var string 
   */
   public string $clientID='';

  /**
   * clientSecret of ZT realm
   *
   * @var string 
   */
   public string $clientSecret='';

  /**
   * grantType of ZT realm
   *
   * @var string 
   */
   public string $grantType='';

  /**
   * Account of ZT realm
   *
   * @var string 
   */
   public string $username='';

  /**
   * Password of ZT realm
   *
   * @var string 
   */
  public string $password='';

  public function __construct()
  {
      parent::__construct();
  }
}
