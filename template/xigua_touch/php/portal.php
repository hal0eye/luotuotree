<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
if (!function_exists('category_get_list_more')) {
    function category_get_list_more($cat, $wheresql, $hassub = true, $hasnew = true, $hashot = true)
    {
        global $_G;
        $data = array();
        $catid = $cat['catid'];

        $cachearr = array();
        if ($hashot) $cachearr[] = 'portalhotarticle';
        if ($hasnew) $cachearr[] = 'portalnewarticle';

        if ($hassub) {
            foreach ($cat['children'] as $childid) {
                $cachearr[] = 'subcate' . $childid;
            }
        }

        $allowmemory = memory('check');
        foreach ($cachearr as $key) {
            $cachekey = $key . $catid;
            $data[$key] = $allowmemory ? memory('get', $cachekey) : false;
            if ($data[$key] === false) {
                $list = array();
                $sql = '';
                if ($key == 'portalhotarticle') {
                    $dateline = TIMESTAMP - 3600 * 24 * 90;
                    $query = C::t('portal_article_count')->fetch_all_hotarticle($wheresql, $dateline);
                } elseif ($key == 'portalnewarticle') {
                    $query = C::t('portal_article_title')->fetch_all_by_sql($wheresql, 'ORDER BY at.dateline DESC', 0, 10, 0, 'at');
                } elseif (substr($key, 0, 7) == 'subcate') {
                    $cacheid = intval(str_replace('subcate', '', $key));
                    if (!empty($_G['cache']['portalcategory'][$cacheid])) {
                        $where = '';
                        if (!empty($_G['cache']['portalcategory'][$cacheid]['children']) && dimplode($_G['cache']['portalcategory'][$cacheid]['children'])) {
                            $_G['cache']['portalcategory'][$cacheid]['children'][] = $cacheid;
                            $where = 'at.catid IN (' . dimplode($_G['cache']['portalcategory'][$cacheid]['children']) . ')';
                        } else {
                            $where = 'at.catid=' . $cacheid;
                        }
                        $where .= " AND at.status='0'";
                        $query = C::t('portal_article_title')->fetch_all_by_sql($where, 'ORDER BY at.dateline DESC', 0, 10, 0, 'at');
                    }
                }

                if ($query) {

                    foreach ($query as $value) {
                        $value['catname'] = $value['catid'] == $cat['catid'] ? $cat['catname'] : $_G['cache']['portalcategory'][$value['catid']]['catname'];
                        if ($value['pic']) $value['pic'] = pic_get($value['pic'], '', $value['thumb'], $value['remote'], 1, 1);
                        $value['timestamp'] = $value['dateline'];
                        $value['dateline'] = dgmdate($value['dateline']);
                        $list[] = $value;
                    }
                }

                $data[$key] = $list;
                if ($allowmemory) {
                    memory('set', $cachekey, $list, empty($list) ? 60 : 600);
                }
            }
        }
        return $data;
    }
}
if (!function_exists('article_title_style')) {
    function article_title_style($value = array())
    {

        $style = array();
        $highlight = '';
        if ($value['highlight']) {
            $style = explode('|', $value['highlight']);
            $highlight = ' style="';
            $highlight .= $style[0] ? 'color: ' . $style[0] . ';' : '';
            $highlight .= $style[1] ? 'font-weight: bold;' : '';
            $highlight .= $style[2] ? 'font-style: italic;' : '';
            $highlight .= $style[3] ? 'text-decoration: underline;' : '';
            $highlight .= '"';
        }
        return $highlight;

    }
}

if (!function_exists('category_get_wheresql')) {
    function category_get_wheresql($cat)
    {
        $wheresql = '';
        $wheresql .= " at.status='0'";
        return $wheresql;
    }
}
if (!function_exists('category_get_list')) {
    function category_get_list($cat, $wheresql, $page = 1, $perpage = 0)
    {
        global $_G;
        $cat['perpage'] = 10;
        $cat['maxpages'] = 1000;
        $perpage = intval($perpage);
        $page = intval($page);
        $perpage = empty($perpage) ? $cat['perpage'] : $perpage;
        $page = empty($page) ? 1 : min($page, $cat['maxpages']);
        $start = ($page - 1) * $perpage;
        if ($start < 0) $start = 0;
        $list = array();
        $pricount = 0;
        $multi = '';
        $count = C::t('portal_article_title')->fetch_all_by_sql($wheresql, '', 0, 0, 1, 'at');
        if ($count) {
            $query = C::t('portal_article_title')->fetch_all_by_sql($wheresql, 'ORDER BY at.dateline DESC', $start, $perpage, 0, 'at');
            foreach ($query as $value) {
                $value['catname'] = $value['catid'] == $cat['catid'] ? $cat['catname'] : $_G['cache']['portalcategory'][$value['catid']]['catname'];
                $value['onerror'] = '';
                if ($value['pic']) {
                    $value['pic'] = pic_get($value['pic'], '', $value['thumb'], $value['remote'], 1, 1);
                }
                $value['dateline'] = dgmdate($value['dateline']);
                if ($value['status'] == 0 || $value['uid'] == $_G['uid'] || $_G['adminid'] == 1) {
                    $list[] = $value;
                } else {
                    $pricount++;
                }
            }
            if (strpos($cat['caturl'], 'portal.php') === false) {
                $cat['caturl'] .= 'index.php';
            }
            $multi = multi($count, $perpage, $page, $cat['caturl'], $cat['maxpages']);
        }
        return $return = array(
            'list' => $list,
            'count' => $count,
            'multi' => $multi,
            'pricount' => $pricount
        );
    }
}

if(!function_exists('xg_currenturl')){
    function xg_currenturl($related = 0)
    {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
        return $related ? $relate_url : $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
    }
}