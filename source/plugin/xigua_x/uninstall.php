<?php
/**
 * Created by PhpStorm.
 * User: yangzhiguo
 * Date: 15/6/27
 * Time: 13:51
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}



$sql = <<<SQL
  DROP TABLE pre_xigua_x;

  DROP TABLE pre_xigua_x_log;
  
  DROP TABLE pre_xigua_x_user;
SQL;
runquery($sql);


$finish = TRUE;

function xigua_xdelete_all($directory, $empty = false) {
    if(substr($directory,-1) == "/") {
        $directory = substr($directory,0,-1);
    }

    if(!file_exists($directory) || !is_dir($directory)) {
        return false;
    } elseif(!is_readable($directory)) {
        return false;
    } else {
        @$directoryHandle = opendir($directory);

        while ($contents = @readdir($directoryHandle)) {
            if($contents != '.' && $contents != '..') {
                $path = $directory . "/" . $contents;

                if(is_dir($path)) {
                    @xigua_xdelete_all($path, $empty);
                } else {
                    @unlink($path);
                }
            }
        }

        @closedir($directoryHandle);

        if($empty == false) {
            if(!@rmdir($directory)) {
                return false;
            }
        }

        return true;
    }
}

xigua_xdelete_all(DISCUZ_ROOT.'./source/plugin/xigua_x', true);

@unlink(DISCUZ_ROOT . './source/plugin/xigua_x/discuz_plugin_xigua_x.xml');
@unlink(DISCUZ_ROOT . './source/plugin/xigua_x/discuz_plugin_xigua_x_SC_GBK.xml');
@unlink(DISCUZ_ROOT . './source/plugin/xigua_x/discuz_plugin_xigua_x_SC_UTF8.xml');
@unlink(DISCUZ_ROOT . './source/plugin/xigua_x/discuz_plugin_xigua_x_TC_BIG5.xml');
@unlink(DISCUZ_ROOT . './source/plugin/xigua_x/discuz_plugin_xigua_x_TC_UTF8.xml');
@unlink(DISCUZ_ROOT . 'source/plugin/xigua_x/uninstall.php');
@unlink(DISCUZ_ROOT . 'source/plugin/xigua_x/install.php');
@unlink(DISCUZ_ROOT . 'source/plugin/xigua_x/upgrade.php');
