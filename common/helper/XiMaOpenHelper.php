<?php
/**
 * Created by PhpStorm.
 * User: 1455
 * Date: 2018/8/3
 * Time: 17:11
 */

namespace app\common\helper;


use app\index\extend\HttpClient;
use app\open\controller\Open;

class XiMaOpenHelper
{
    private $app_key = '7f63ff244577c2eb1716ef6385bedd8e';
    private $pack_id = 'com.ximalaya.ting.android.car.mapgoo';
    private $app_secret = '535549eb2ecd2434f0bd632f1df13e19';
    private $base_url = 'http://api.ximalaya.com';
    private $access_url = 'http://api.ximalaya.com/oauth2/secure_access_token';
    private $cat_url = 'http://api.ximalaya.com/categories/list';
    private $albums_url = 'http://api.ximalaya.com/v2/albums/list';
    private $browse_url = 'http://api.ximalaya.com/albums/browse';
    private $tracks_url = 'http://api.ximalaya.com/tracks/hot';
    private $tags_url = 'http://api.ximalaya.com/v2/tags/list';
    private $searchTracks_url = 'https://api.ximalaya.com/albums/browse';
    private $albumsTracks_url = 'https://api.ximalaya.com/albums/browse';
    protected $http;

    private $pubParam = [
        'app_key' => '7f63ff244577c2eb1716ef6385bedd8e',
        'device_id' => '863268030210602',
        'client_os_type' => 2,
        'pack_id' => 'com.ximalaya.ting.android.car.mapgoo',
        'access_token' => '',
    ];

    public function __construct()
    {
        $token = cache('xima_access_token');
        if (empty($token)) {
            $this->accessToken();
        }
        $this->pubParam['access_token'] = $token;
        $this->http = new HttpClient();
    }

    public function ximaBase()
    {
        $arr = [];
        $this->sign($arr);
    }

    public function baseRequest($param, $url)
    {
        $sig = $this->sign($param);
        $arr = $this->pubParam;
        $arr['sig'] = $sig;
        $arr = $arr + $param;
        $url = $this->tags_url . '?' . http_build_query($arr);
        $res = (new HttpClient())->Request($url);
    }

    public function sign($arr = [])
    {
        $array = $this->pubParam;
        $arr = array_merge($arr, $array);
        ksort($arr);
        $str = '';
        foreach ($arr as $k => $v) {
            $str .= $k . '=' . $v . '&';
        }
        $str = rtrim($str, '&');
        $str = base64_encode($str);
        $str = hash_hmac('sha1', $str, $this->app_secret, true);//("sha1",$data ,$key,$raw_output=true)
        return md5($str);
    }

    public function accessToken()
    {
        $arr = [
            'client_id' => $this->app_key,
            'grant_type' => 'client_credentials',
            'device_id' => '863268030210602',
            'nonce' => md5(time()),
            'timestamp' => millisecond(),
        ];
        $getparam = http_build_query($arr);
        $res = (new HttpClient())->Request($this->access_url, 'POST', $getparam);
        $res = json_decode($res, true);
        $access_token = $res['access_token'];
        $expires_in = $res['expires_in'];
        cache('xima_access_token', $access_token, $expires_in - 100);
    }

    public function catList()
    {
        $sig = $this->sign();
        $arr = $this->pubParam;
        $arr['sig'] = $sig;
        $url = $this->cat_url . '?' . http_build_query($arr);
        return (new HttpClient())->Request($url);
    }

    public function tagsList()
    {
        $param = ['category_id' => 2, 'type' => 0];
        $sig = $this->sign($param);
        $arr = $this->pubParam;
        $arr['sig'] = $sig;
        $arr = $arr + $param;
        $url = $this->tags_url . '?' . http_build_query($arr);
        $res = (new HttpClient())->Request($url);
        $res = json_decode($res , true);
        print_r($res);die;
        foreach ($res as $k => $v){
            echo '<br>';echo '.'.$k +1;
            print_r($v);
        }
        die;
    }

    /**
     * NAME: albumsList 分类专辑列表
     * @param array $req
     * @return mixed
     */
    public function albumsList(array $req = [])
    {
        $param = [
            'category_id' => $req['category_id'],
            'calc_dimension' => 1,
            'page' => 1,
            'count' => 100,
        ];
        $sig = $this->sign($param);
        $arr = $this->pubParam;
        $arr['sig'] = $sig;
        $arr = $arr + $param;
        $url = $this->albums_url . '?' . http_build_query($arr);
        $res = $this->http->Request($url);
        $res = json_decode($res, true);
        if ($this->http->status == 200 && !empty($res['albums'])) {
            return $res;
        } else {
            ajax_info(1, '网络错误');
        }
    }

    public function albumsIndex(array $req)
    {
        $catName = __FUNCTION__ . '_CatId_' . $req['category_id'];
        $cacheData = cache($catName);
        if (!cache($catName)) {//是否存在缓存
            $cacheData = $this->albumsList($req);
            cache($catName, $cacheData, 3600 * 24);
        }
        /* 重新分页处理 */
        $cacheData['total_count'] = count($cacheData['albums']);
        $cacheData['total_page'] = ceil($cacheData['total_count']/$req['count']);
        $cacheData['current_page'] = $req['page'];
        $cacheData['albums'] = $this->handlePage($req,$cacheData['albums']);
        return $cacheData;
    }

    public function trackIndex(array $req)
    {
        $data = $this->albumsTrack($req);
        /* 重新分页处理 */
        $data['total_count'] = count($data['tracks']);
        $data['total_page'] = ceil($data['total_count']/$req['count']);
        $data['current_page'] = $req['page'];
        $data['tracks'] = $this->handlePage($req,$data['tracks']);
        return $data;
    }

    /**
     * NAME: albumsTrack 专辑详情
     * @param $req
     * @return mixed
     */
    public function albumsTrack($req)
    {
        $param = [
            'album_id' => $req['album_id'],
            //'album_title'=> '新歌速递',
        ];
        $sig = $this->sign($param);
        $arr = $this->pubParam;
        $arr['sig'] = $sig;
        $arr = $arr + $param;
        $url = $this->albumsTracks_url . '?' . http_build_query($arr);
        $res = $this->http->Request($url);
        $res = json_decode($res, true);
        if ($this->http->status == 200 && !empty($res['tracks'])) {
            return $res;
        } else {
            ajax_info(1, '网络错误');
        }
    }

    public function searchAlbums()
    {
        $param = [
            'album_id'=> 18336945
            //'album_title'=> '新歌速递',
        ];
        $sig = $this->sign($param);
        $arr = $this->pubParam;
        $arr['sig'] = $sig;
        $arr = $arr + $param;
        $url = $this->searchTracks_url . '?' . http_build_query($arr);
        $res = (new HttpClient())->Request($url);
        print_r($res);
        die;
    }

    /**
     * NAME: randomMusic 没有收听记录随机音乐
     * @param $req
     * @return mixed
     */
    public function randomMusic($req)
{
    $param = [
        'category_id' => $req['catId'],  'page' => 1 ,'count' => $req['count']
    ];
    $sig = $this->sign($param);
    $arr = $this->pubParam;
    $arr['sig'] = $sig;
    $arr = $arr + $param;
    $url = $this->tracks_url . '?' . http_build_query($arr);
    $res = (new HttpClient())->Request($url);
    $res = json_decode($res,1);
    //shuffle($res['tracks']);
    return array_slice($res['tracks'], ($req['pageNum'] - 1) * $req['pageSize'], $req['pageSize']);
}

    public function tracksHot($req = [])
    {
        /*
         * 1.获取分类下24小时的标签top3
         * 2.根据top3获取相应比例的歌曲
         * 3.返回歌单
         */
        $songList = array();
        $list = array();
        $typeSong = array();
        $i = 0;
        $typeList = (new Open())->recommendMusic($req);
        $param = [
            'category_id' => $req['catId'], 'tag_name' => '', 'page' => 1
        ];
        $param['count'] = $req['count'];
        $http = new HttpClient();
        /* foreach
         * 1.组装数据 请求数据
         * 2.每个type获取多少歌曲
         */
        foreach ($typeList as $k => $v) {
            $typeSong[$k] = ceil($param['count'] * $v / 100);
            $param['tag_name'] = $k;
            $sig = $this->sign($param);
            $arr = $this->pubParam;
            $arr['sig'] = $sig;
            $push[$i]['Body'] = $arr + $param;
            $push[$i]['PushUrl'] = $this->tracks_url;
            $i++;
        }
        //TODO　存在redishash
        $list[] = $http->ConcurrentRequest($push);
        if (is_array($list)) {
            foreach ($list[0] as $key => $value) {
                if (isset($typeSong[$value['tag_name']])) {
                    //shuffle($value['tracks']);
                    $value['tracks'] = array_slice($value['tracks'], 0, $typeSong[$value['tag_name']]);
                }
                foreach ($value['tracks'] as $i => $o) {
                    $songList[] = $o;
                }
            }
        } else {
            return false;
        }
        return array_slice($songList, ($req['pageNum'] - 1) * $req['pageSize'], $req['pageSize']);
    }

    public function handlePage($req,$data)
    {
        $start=($req['page']-1)*$req['count'];//偏移量，当前页-1乘以每页显示条数
        return array_slice($data,$start,$req['count']);
    }
}