<?php
/**
 * TOP SDK 入口文件
 * 请不要修改这个文件，除非你知道怎样修改以及怎样恢复
 * @author xuteng.xt
 */

/**
 * 定义常量开始
 * 在include("TopSdk.php")之前定义这些常量，不要直接修改本文件，以利于升级覆盖
 */
/**
 * SDK工作目录
 * 存放日志，TOP缓存数据
 */
if (!defined("TOP_SDK_WORK_DIR"))
{
	define("TOP_SDK_WORK_DIR", DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/');
}

/**
 * 是否处于开发模式
 * 在你自己电脑上开发程序的时候千万不要设为false，以免缓存造成你的代码修改了不生效
 * 部署到生产环境正式运营后，如果性能压力大，可以把此常量设定为false，能提高运行速度（对应的代价就是你下次升级程序时要清一下缓存）
 */
if (!defined("TOP_SDK_DEV_MODE"))
{
	define("TOP_SDK_DEV_MODE", true);
}


include_once DISCUZ_ROOT. 'source/plugin/xigua_login/lib/smssdk/aliyun/AliyunClient.php';

include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/TopClient.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/TopLogger.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/ApplicationVar.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/ClusterTopClient.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/HttpdnsGetRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/RequestCheckUtil.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/ResultSet.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/SpiUtils.php';

include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/domain/Area.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/domain/BizResult.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/domain/FcPartnerSmsDetailDto.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/domain/KfcSearchResult.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/domain/Result.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/domain/Subtask.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/domain/Task.php';

include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AlibabaAliqinFcFlowChargeProvinceRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AlibabaAliqinFcFlowChargeRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AlibabaAliqinFcFlowGradeRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AlibabaAliqinFcFlowQueryRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AlibabaAliqinFcSmsNumQueryRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AlibabaAliqinFcSmsNumSendRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AlibabaAliqinFcTtsNumSinglecallRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AlibabaAliqinFcVoiceNumDoublecallRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AlibabaAliqinFcVoiceNumSinglecallRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AppipGetRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/AreasGetRequest.php';
//include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/HttpdnsGetRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/KfcKeywordSearchRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/TimeGetRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/TopatsResultGetRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/TopatsTaskDeleteRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/TopAuthTokenCreateRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/TopAuthTokenRefreshRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/TopIpoutGetRequest.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/top/request/TopSecretGetRequest.php';