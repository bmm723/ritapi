<?php
namespace Rit\Api;


use Illuminate\Support\Facades\Http;

/**
 * Class ApiConnection
 * @package Rit\Api
 */
class ApiConnection {

    /**
     * @var string
     */
    private $key;
    /**
     * @var \GuzzleHttp\Client
     */
    private $GuzzleClient;
    /**
     * @var string
     */
    private $authorizationKey;
    /**
     * @var string
     */
    private $version;
    /**
     * @var string
     */
    private $apiUrl;

    private $map;

    /**
     *
     */
    function __construct() {

        $this->key = (string)\Config::get('api.key');
        $this->authorizationKey = (string)\Config::get('api.authorizationKey');
        $this->apiUrl = (string)\Config::get('api.url');
        $this->version = (string)\Config::get('api.version');

        $this->map = \Config::get('api::map');

        $this->GuzzleClient = new \GuzzleHttp\Client(
            [
                'base_uri' => $this->apiUrl,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->authorizationKey,
                ]
            ]);

        //$this->GuzzleClient->setDefaultOptions(['verify' => false]);
    }

    public function getMap($key) {

        if(isset($this->map[$key])) {
            return $this->map[$key];
        } else {
            return false;
        }

    }

    function doQuery($url,$options = array()) {

        $res = $this->GuzzleClient->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->key,
                'Accept' => 'application/json',
            ],
            'options' => [$options]
        ]);


        if($res->getStatusCode() == 200) {
            return json_decode($res->getBody()->getContents(), true);
        } else {
            throw new Exception('API Error');
        }
    }


    /**
     * @param $username
     * @param array $expand
     * @return bool|User
     */
    public function getUser($username) {

        if(is_string($username)) {

            $json = $this->doQuery('api/users/'.$username);
            $user = new User($json);

            return $user;
        }

    }

    public function getRoom($building,$room) {

        if(is_string($building) && is_string($room)) {
            $json = $this->doQuery('api/rooms/'.$building."-".$room);
            $room = new Room($json);

            return $room;

        }
    }

    public function getRoomMeetings($building,$room) {

        if(is_string($building) && is_string($room)) {
            $json = $this->doQuery('api/rooms/'.$building."-".$room."/meetings");

            $meetings = array();
            foreach($json as $m) {

                $meetings[] = new Meeting(array("data" => $m));

            }

            return $meetings;

        }
    }

    public function getCourse($section, $term)
    {
        if(is_string($section) && is_string($term))
        {
            $json = $this->doQuery("api/courses/".$section.'?term='.$term);

            return new Course($json);

        }
    }

}
