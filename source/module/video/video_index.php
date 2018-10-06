<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

if (empty($_GET['action'])) {
    $_GET['action'] = 'index';
}

if ($_GET['action'] == 'index') {
    $page = intval($_GET['page']);
    if ($page < 1) $page = 1;
    $video_list = C::t('video')->get_video_list($page);
    $video_count = C::t('video')->count_video_info();
    $page_html = multi($video_count,10,$page,'video.php?mod=index&action=index');
    include template('video/video_index');
}