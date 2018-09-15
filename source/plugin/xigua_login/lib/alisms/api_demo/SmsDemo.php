<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/AcsRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/AcsResponse.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/IAcsClient.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Config.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/DefaultAcsClient.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/RoaAcsRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/RpcAcsRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Regions/Endpoint.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Regions/EndpointConfig.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Regions/EndpointProvider.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Regions/ProductDomain.php';

include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Auth/Credential.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Auth/ISigner.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Auth/ShaHmac1Signer.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Auth/ShaHmac256Signer.php';

include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Profile/IClientProfile.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Profile/DefaultProfile.php';

include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Exception/ClientException.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Exception/ServerException.php';

include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Http/HttpHelper.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Core/Http/HttpResponse.php';


include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Api/Sms/Request/V20170525/QueryInterSmsIsoInfoRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Api/Sms/Request/V20170525/QuerySendDetailsRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Api/Sms/Request/V20170525/SendInterSmsRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/alisms/api_sdk/lib/Api/Sms/Request/V20170525/SendSmsRequest.php';


use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;

Aliyun\Core\Config::load();

class SmsDemo
{
    public function __construct($accessKeyId, $accessKeySecret)
    {
        $product = "Dysmsapi";

        $domain = "dysmsapi.aliyuncs.com";

        $region = "cn-hangzhou";

        $endPointName = "cn-hangzhou";

        $profile = Aliyun\Core\Profile\DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

        Aliyun\Core\Profile\DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

        $this->acsClient = new DefaultAcsClient($profile);
    }

    public function sendSms($signName, $templateCode, $phoneNumbers, $templateParam = null, $outId = null) {
        $request = new SendSmsRequest();

        $request->setPhoneNumbers($phoneNumbers);

        $request->setSignName($signName);

        $request->setTemplateCode($templateCode);

        if($templateParam) {
            $request->setTemplateParam(json_encode($templateParam));
        }
        if($outId) {
            $request->setOutId($outId);
        }

        $acsResponse = $this->acsClient->getAcsResponse($request);

        return $acsResponse;

    }

}