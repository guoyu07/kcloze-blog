<?php

require_once( dirname(__FILE__) . '/class.oauth.php' );
require_once( dirname(__FILE__) . '/class.basic.php' );

class MicroblogClient {

    private $verifyCredentialsURL = array(
        1 => 'http://api.t.sina.com.cn/account/verify_credentials.json',
        3 => 'http://api.twitter.com/1/account/verify_credentials.json',
        4 => 'http://api.t.163.com/account/verify_credentials.json',
        5 => 'http://api.t.sohu.com/account/verify_credentials.json',
        10 => 'http://api.douban.com/people/%40me'
    );
    private $userInfoURL = array(
        1 => 'http://api.t.sina.com.cn/users/show.json',
        2 => 'http://open.t.qq.com/api/user/info',
        3 => 'http://api.twitter.com/version/users/show.json',
        4 => 'http://api.t.163.com/users/show.json',
        5 => 'http://api.t.sohu.com/users/show.json',
//        6 => 'http://api.minicloud.com.cn/users/show/%s.json',
        7 => 'http://api.fanfou.com/users/show.json',
//        8 => 'http://api.zuosa.com/users/show.json',
//        9 => 'http://api.renjian.com/v2/users/show.json',
        10 => 'http://api.douban.com/people/%s'
    );
    private $userTimelineURL = array(
        1 => 'http://api.t.sina.com.cn/statuses/user_timeline.json',
        2 => 'http://open.t.qq.com/api/statuses/user_timeline',
        3 => 'http://api.twitter.com/1/statuses/user_timeline.json',
        4 => 'http://api.t.163.com/statuses/user_timeline.json',
        5 => 'http://api.t.sohu.com/statuses/user_timeline/%s.json',
//        6 => 'http://api.minicloud.com.cn/statuses/user_timeline.json',
        7 => 'http://api.fanfou.com/statuses/user_timeline.json',
//        8 => 'http://api.zuosa.com/statuses/user_timeline.json',
//        9 => 'http://api.renjian.com/v2/statuses/user_timeline.json',
        10 => 'http://api.douban.com/people/%s/miniblog'
    );

    function verifyCredentialsURL() {
        return isset($this->verifyCredentialsURL[$this->microblog]) ? $this->verifyCredentialsURL[$this->microblog] : $this->userInfoURL[$this->microblog];
    }

    function userInfoURL() {
        return $this->userInfoURL[$this->microblog];
    }

    function userTimelineURL() {
        return $this->userTimelineURL[$this->microblog];
    }

    function __construct($microblog, $authtype, $accecss_token_or_user, $accecss_token_secret_or_pass = NULL) {
        $this->microblog = $microblog;
        $this->authtype = $authtype;

        switch ($authtype) {
            case 1 :
                $this->auth = new MicroblogBasic($microblog, $accecss_token_or_user);
                break;
            case 2 :
                $this->auth = new MicroblogOAuth($microblog, $accecss_token_or_user, $accecss_token_secret_or_pass);
                break;
            case 8 :
                $this->auth = new MicroblogBasic($microblog, $accecss_token_or_user, $accecss_token_secret_or_pass);
                break;
        }
    }

    public function basic_verify_credentials() {
        if ($this->authtype != 8)
            return;
        $url = $this->verifyCredentialsURL();
        $params = array();
        if ($this->microblog == 2)
            $params['format'] = 'json';
        $params['id'] = $this->auth->user;
//        switch ($this->microblog) {
//            case 6 :
//                $url = sprintf($url, $this->auth->user);
//                break;
//            default :
//                $params['id'] = $this->auth->user;
//                break;
//        }
        $info = $this->auth->get($url, $params);
        return $this->user_info_filter($info);
    }

    function user_info($uid = NULL) {
        $params = array();
        if ($this->microblog == 2)
            $params['format'] = 'json';
        else if ($this->microblog == 10)
            $params['alt'] = 'json';
        if (!empty($uid)) {
            if ($this->authtype != 2)
                switch ($this->microblog) {
                    case 5 :
                        break;
//                    case 6 :
//                        $params['userIdOrName'] = $uid;
//                        break;
                    case 7 :
//                    case 8 :
//                    case 9 :
                        $params['id'] = $uid;
                        break;
                    default :
                        $params['user_id'] = $uid;
                }
        }
        if ($this->authtype == 2) {
            $url = $this->verifyCredentialsURL();
        } else {
            if (!empty($uid)) {
                $url = sprintf($this->userInfoURL(), $uid);
            } else {
                $url = $this->userInfoURL();
            }
        }

        $info = $this->auth->get($url, $params);
        return $this->user_info_filter($info);
    }

    function user_info_filter($info) {
        if (!(isset($info['screen_name']) || isset($info['data']['name']) || isset($info['db:uid'])))
            return;
        switch ($this->microblog) {
            case 1 :
                $msg = array(
                    'uid' => $info['id'],
                    'name' => $info['name'],
                    'nick' => $info['screen_name'],
                    'descrption' => $info['description'],
                    'head' => $info['profile_image_url']
                );
                break;
            case 2 :
                $msg = array(
                    'uid' => $info['data']['name'],
                    'name' => $info['data']['name'],
                    'nick' => $info['data']['nick'],
                    'descrption' => $info['data']['introduction'],
                    'head' => $info['data']['head'] . '/'
                );
                break;
            case 3 :
                $msg = array(
                    'uid' => $info['id'],
                    'name' => $info['screen_name'],
                    'nick' => $info['name'],
                    'descrption' => $info['description'],
                    'head' => $info['profile_image_url']
                );
                break;
            case 4 :
                $msg = array(
                    'uid' => $info['id'],
                    'name' => $info['screen_name'],
                    'nick' => $info['name'],
                    'descrption' => $info['description'],
                    'head' => $info['profile_image_url']
                );
                break;
            case 5 :
                $msg = array(
                    'uid' => $info['id'],
                    'name' => $info['screen_name'],
                    'nick' => $info['screen_name'],
                    'descrption' => $info['description'],
                    'head' => $info['profile_image_url']
                );
                break;
//            case 6 :
//                $msg = array(
//                    'uid' => $info['id'],
//                    'name' => $info['name'],
//                    'nick' => $info['screen_name'],
//                    'descrption' => $info['description'],
//                    'head' => str_replace('_24x24', '_48x48', $info['profile_image_url'])
//                );
//                break;
            case 7 :
                $msg = array(
                    'uid' => $info['id'],
                    'name' => $info['name'],
                    'nick' => $info['screen_name'],
                    'descrption' => $info['description'],
                    'head' => $info['profile_image_url']
                );
                break;
//            case 8 :
//                $msg = array(
//                    'uid' => $info['screen_name'],
//                    'name' => $info['screen_name'],
//                    'nick' => $info['name'],
//                    'descrption' => $info['description'],
//                    'head' => $info['profile_image_url']
//                );
//                break;
//            case 9 :
//                $msg = array(
//                    'uid' => $info['id'],
//                    'name' => $info['screen_name'],
//                    'nick' => $info['name'],
//                    'descrption' => $info['description'],
//                    'head' => $info['profile_image_url']
//                );
//                break;
            case 10 :
                $msg = array(
                    'uid' => $info['db:uid']['$t'],
                    'name' => $info['db:uid']['$t'],
                    'nick' => $info['title']['$t'],
                    'descrption' => $info['content']['$t'],
                    'head' => $info['link']['2']['@href']
                );
                break;
            default :
                $msg = array(
                    'uid' => $info['id'],
                    'name' => $info['name'],
                    'nick' => $info['screen_name'],
                    'descrption' => $info['description'],
                    'head' => $info['profile_image_url']
                );
                break;
        }
        return $msg;
    }

    function user_timeline($uid = NULL, $user = NULL, $count = 20, $lasttime = NULL) {
        if (!(isset($uid) || isset($user)))
            return false;
        $params = array();
        if ($this->microblog == 3)
            $params['include_rts'] = true;      // Include RT of your tweets.
        else if ($this->microblog == 5)
            $params['cursor'] = -1;
        $count = min($count, 100);
        $step = min($count, 20);
        $i = 0;
        $key = 0;
        $flag = true;
        $max_id = 0;
        $timeline = array();
        while ($i < $count && $flag) {
            $limit = min($count - $i, 20);
            if ($i > 0) {
                switch($this->microblog) {
                    case 1 :
                    case 3 :
                    case 7 :
                        $params['max_id'] = $max_id;
                        $params['page'] = (int)($i / 20) + 1;
                        break;
                    case 2 :
                        $params['lastid'] = $last_id;
                        $params['pageflag'] = 1;
                        $params['pagetime'] = $pagetime;
                        break;
                    case 4 :
                        $params['since_id'] = $cursor_id;
                        break;
                    case 5 :
                        $params['cursor'] = $cursor_id;
                        break;
//                    case 6 :
//                        $params['since'] = $since;
//                        $params['page'] = (int)($i / 20) + 1;
//                        break;
                    case 10 :
                        $params['start-index'] = $i + 1;
                        break;
                }
            }
            if ($this->authtype == 1)
                $returns = $this->request_with_user(sprintf($this->userTimelineURL(), $user), $user, $limit, false, $params);
            else
                $returns = $this->request_with_uid(sprintf($this->userTimelineURL(), $uid), $uid, $limit, false, $params);
            wm_debug_print($returns);
            if (isset($returns)) {
                switch ($this->microblog) {
                    case 1 :
                        if (isset($returns[0])) {
                            if ($i == 0)
                                $user = array(
                                    'uid' => $returns[0]['user']['id'],
                                    'name' => $returns[0]['user']['name'],
                                    'nick' => $returns[0]['user']['screen_name'],
                                    'descrption' => $returns[0]['user']['description'],
                                    'head' => $returns[0]['user']['profile_image_url']
                                );
                            foreach ($returns as $return) {
                                $timeline[$key] = array(
                                    'tid' => $return['id'],
                                    'timestamp' => strtotime($return['created_at']),
                                    'text' => strip_tags($return['text'])
                                );
                                if (isset($return['original_pic']))
                                    $timeline[$key]['other']['pic'] = array(
                                        'small' => $return['thumbnail_pic'],
                                        'big' => $return['original_pic']
                                    );
                                if (isset($return['retweeted_status'])) {
                                    $timeline[$key]['other']['rt'] = array(
                                        'tid' => $return['retweeted_status']['id'],
                                        'nick' => $return['retweeted_status']['user']['screen_name'],
                                        'text' => strip_tags($return['retweeted_status']['text'])
                                    );
                                    $domain = $return['retweeted_status']['user']['domain']; // t.sina.com.cn/domain
                                    if (!$domain)
                                        $domain = $return['retweeted_status']['user']['id'];
                                    $timeline[$key]['other']['rt']['domain'] = $domain;
                                    if (isset($return['retweeted_status']['original_pic']))
                                        $timeline[$key]['other']['rt']['pic'] = array(
                                            'small' => $return['retweeted_status']['thumbnail_pic'],
                                            'big' => $return['retweeted_status']['original_pic']
                                        );
                                }
                                $key++;
                            }
//                            if(count($returns) < $limit)
//                                $flag = false;
                        } else
                            $flag = false;
                        break;
                    case 2 :
                        if (isset($returns['data']['info'][0])) {
//                            if ($returns['data']['hasnext'] == 1)
//                                $flag = false;
                            $returns = $returns['data']['info'];
                            if ($i == 0)
                                $user = array(
                                    'uid' => $returns[0]['name'],
                                    'name' => $returns[0]['name'],
                                    'nick' => $returns[0]['nick'],
                                    'descrption' => NULL,
                                    'head' => $returns[0]['head'] .'/'
                                );
                            foreach ($returns as $return) {
                                $timeline[$key] = array(
                                    'tid' => $return['id'],
                                    'timestamp' => $return['timestamp'],
                                    'text' => strip_tags($return['origtext'])
                                );
                                if (isset($return['image'][0]))
                                    $timeline[$key]['other']['pic'] = array(
                                        'small' => $return['image'][0] . '/160',
                                        'big' => $return['image'][0] . '/2000'
                                    );
                                if ($return['type'] != 1) {
                                    $timeline[$key]['other']['rt'] = array(
                                        'tid' => $return['source']['id'],
                                        'domain' => $return['source']['name'], // t.qq.com/domain
                                        'nick' => $return['source']['nick'],
                                        'text' => strip_tags($return['source']['origtext'])
                                    );
                                    if ($return['source']['image'][0])
                                        $timeline[$key]['other']['rt']['pic'] = array(
                                            'small' => $return['source']['image'][0] . '/160',
                                            'big' => $return['source']['image'][0] . '/2000'
                                        );
                                }
                                $key++;
                            }
                        } else
                            $flag = false;
                        break;
                    case 3 :
                        if (isset($returns[0])) {
                            if ($i == 0)
                                $user = array(
                                    'uid' => $returns[0]['user']['id_str'],
                                    'name' => $returns[0]['user']['screen_name'],
                                    'nick' => $returns[0]['user']['name'],
                                    'descrption' => $returns[0]['user']['description'],
                                    'head' => $returns[0]['user']['profile_image_url']
                                );
                            foreach ($returns as $return) {
                                $timeline[$key] = array(
                                    'tid' => $return['id_str'],
                                    'timestamp' => strtotime($return['created_at']),
                                    'text' => strip_tags($return['text'])
                                );
                                $key++;
            //                    if (isset($return['retweeted_status']))
            //                        $timeline[$key]['other']['rt'] = array(
            //                            'domain' => $return['retweeted_status']['user']['screen_name'], // twitter.com/domain
            //                            'nick' => $return['retweeted_status']['user']['name'],
            //                            'text' => strip_tags($return['source']['origtext'])
            //                        );
                            }
//                            if(count($returns) < $limit)
//                                $flag = false;
                        } else
                            $flag = false;
                        break;
                    case 4 :
                        if (isset($returns[0])) {
                            if ($i == 0)
                                $user = array(
                                    'uid' => $returns[0]['user']['id'],
                                    'name' => $returns[0]['user']['name'],
                                    'nick' => $returns[0]['user']['screen_name'],
                                    'descrption' => $returns[0]['user']['description'],
                                    'head' => $returns[0]['user']['profile_image_url']
                                );
                            foreach ($returns as $return) {
                                $timeline[$key] = array(
                                    'tid' => $return['id'],
                                    'timestamp' => strtotime($return['created_at']),
                                    'text' => strip_tags($return['text'])
                                );
                                if ($return['in_reply_to_user_id'])
                                    $timeline[$key]['other']['rt'] = array(
                                        'tid' => $return['in_reply_to_status_id'],
                                        'domain' => $return['in_reply_to_screen_name'], // t.163.com/domain
                                        'nick' => $return['in_reply_to_user_name'],
                                        'text' => strip_tags($return['in_reply_to_status_text'])
                                    );
                                $cursor_id = $return['cursor_id'];
                                $key++;
                            }
//                            if(count($returns) < $limit)
//                                $flag = false;
                        } else
                            $flag = false;
                        break;
                    case 5 :
                        if (isset($returns['statuses'][0])) {
                            $cursor_id = $returns['cursor_id'];
                            $returns = $returns['statuses'];
                            if ($i == 0)
                                $user = array(
                                    'uid' => $returns[0]['user']['id'],
                                    'name' => $returns[0]['user']['screen_name'],
                                    'nick' => $returns[0]['user']['screen_name'],
                                    'descrption' => $returns[0]['user']['description'],
                                    'head' => $returns[0]['user']['profile_image_url']
                                );
                            foreach ($returns as $return) {
                                $timeline[$key] = array(
                                    'tid' => $return['id'],
                                    'timestamp' => strtotime($return['created_at']),
                                    'text' => strip_tags($return['text'])
                                );
                                if ($return['original_pic'])
                                    $timeline[$key]['other']['pic'] = array(
                                        'small' => $return['small_pic'],
                                        'big' => $return['original_pic']
                                    );
                                if ($return['in_reply_to_user_id'])
                                    $timeline[$key]['other']['rt'] = array(
                                        'tid' => $return['in_reply_to_status_id'],
                                        'domain' => $return['in_reply_to_user_id'], // t.sohu.com/u/domain
                                        'nick' => $return['in_reply_to_screen_name'],
                                        'text' => strip_tags($return['in_reply_to_status_text'])
                                    );
                                $key++;
                            }
//                            if(count($returns) < $limit)
//                                $flag = false;
                        } else
                            $flag = false;
                        break;
//                    case 6 :
//                        if (isset($returns[0])) {
//                            if ($i == 0)
//                                $user = array(
//                                    'uid' => $returns[0]['user']['id'],
//                                    'name' => $returns[0]['user']['name'],
//                                    'nick' => $returns[0]['user']['screen_name'],
//                                    'descrption' => $returns[0]['user']['description'],
//                                    'head' => str_replace('_24x24', '_48x48', $returns[0]['user']['profile_image_url'])
//                                );
//                            foreach ($returns as $return) {
//                                $timeline[$key] = array(
//                                    'tid' => $return['id'],
//                                    'timestamp' => strtotime($return['created_at']),
//                                    'text' => strip_tags($return['text'])
//                                );
//                                if (isset($return['picPath'][0]))
//                                    $timeline[$key]['other']['pic'] = array(
//                                        'small' => $return['picPath'][0],
//                                        'big' => str_replace('_100x75', '_640x480', $return['picPath'][0])
//                                    );
//                                $key++;
//                            }
//                        } else
//                            $flag = false;
//                        break;
                    case 7 :
                        if (isset($returns[0])) {
                            if ($i == 0)
                                $user = array(
                                    'uid' => $returns[0]['user']['id'],
                                    'name' => $returns[0]['user']['name'],
                                    'nick' => $returns[0]['user']['screen_name'],
                                    'descrption' => $returns[0]['user']['description'],
                                    'head' => $returns[0]['user']['profile_image_url']
                                );
                            foreach ($returns as $return) {
                                $timeline[$key] = array(
                                    'tid' => $return['id'],
                                    'timestamp' => strtotime($return['created_at']),
                                    'text' => strip_tags($return['text'])
                                );
                                $key++;
                            }
//                            if(count($returns) < $limit)
//                                $flag = false;
                        } else
                            $flag = false;
                        break;
                    case 10 :
                        if (isset($returns['entry'][0])) {
                            if ($i == 0)
                                $user = array(
                                    'uid' => NULL,
                                    'name' => NULL,
                                    'nick' => $returns['author']['name']['$t'],
                                    'descrption' => NULL,
                                    'head' => $returns['author']['link']['2']['@href']
                                );
                            $returns = $returns['entry'];
                            foreach ($returns as $return) {
                                preg_match('/\d+$/i', $return['id']['$t'], $matches);
                                $timeline[$key] = array(
                                    'tid' => $matches[0],
                                    'timestamp' => strtotime($return['published']['$t']),
                                    'text' => $return['content']['$t']
                                );
                                if (isset($return['link'][1]) && $return['link'][1]['@rel'] == 'image' )
                                    $timeline[$key]['other']['pic'] = array(
                                        'small' => $return['link'][1]['@href'],
                                        'big' => str_replace('/spic/', '/lpic/', $return['link'][1]['@href'])
                                    );
                                $key++;
                            }
//                            if(count($returns) < $limit)
//                                $flag = false;
                        } else
                            $flag = false;
                        break;
                    default :
                        foreach ($returns as $return) {
                            $timeline[$key] = array(
                                'tid' => $return['id'],
                                'timestamp' => strtotime($return['created_at']),
                                'text' => strip_tags($return['text'])
                            );
                            $key++;
                        }
//                        if(count($returns) < $limit)
//                            $flag = false;
                        break;
                }
                if ($key > 0) {
                    if ($i == 0)
                        $max_id = $timeline[0]['tid'];
                    $last_id = $timeline[$key-1]['tid'];
                    $pagetime = $timeline[$key-1]['timestamp'];
                    if (isset($lasttime) && $lasttime >= $timeline[$key]['timestamp'])
                        $flag = false;
                } else
                    $flag = false;
                $i += $step;
            } else {
                $flag = false;
            }
        }
        if ($key == 0)
            return false;
        return array(
            'user' => $user,
            'timeline' => $timeline
        );
    }

    protected function request_with_uid($url, $uid, $count = false, $post = false, $params = array()) {
        wm_debug($url);
        if ($uid !== NULL) {
            switch ($this->microblog) {
                case 1 :
                case 7 :
                case 8 :
                    $params['id'] = $uid;
                    break;
                case 2 :
                    $params['format'] = 'json';
                    $params['name'] = $uid;
                    break;
                case 5 :
                    break;
//                case 6 :
//                    $params['userIdOrName'] = $uid;
//                    break;
                case 10 :
                    $params['alt'] = 'json';
                default :
                    $params['user_id'] = $uid;
            }
        }

        if ($count) {
            switch ($this->microblog) {
                case 2 :
                    $params['reqnum'] = $count;
                    break;
                case 10 :
                    $params['max-results'] = $count;
                    break;
                default :
                    $params['count'] = $count;
            }
        }

        if ($post)
            $method = 'post';
        else
            $method = 'get';

        return $this->auth->$method($url, $params);
    }

    protected function request_with_user($url, $user, $count = false, $post = false, $params = array()) {
        wm_debug($url);
        if ($user !== NULL) {
            switch ($this->microblog) {
                case 1 :
                case 3 :
                case 4 :
                    $params['screen_name'] = $user;
                    break;
                case 2 :
                    $params['format'] = 'json';
                    $params['name'] = $user;
                    break;
                case 5 :
                    break;
//                case 6 :
//                    $params['userIdOrName'] = $user;
//                    break;
                case 7 :
//                case 8 :
//                case 9 :
                    $params['id'] = $user;
                    break;
                case 10 :
                    $params['alt'] = 'json';
                    break;
            }
        }

        if ($count) {
            switch ($this->microblog) {
                case 2 :
                    $params['reqnum'] = $count;
                    break;
                default :
                    $params['count'] = $count;
            }
        }

        if ($post)
            $method = 'post';
        else
            $method = 'get';

        return $this->auth->$method($url, $params);
    }

}

?>