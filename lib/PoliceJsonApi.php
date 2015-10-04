<?php
/**
 * UK Police JSON API class
 *
 * PHP version 5.4
 *
 * @category API
 * @package  PoliceUK
 * @author   Richard Seymour <web@bespoke.support>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  GIT: $Id
 * @link     https://github.com/BespokeSupport/PoliceApi
 */

namespace BespokeSupport\PoliceApi;

use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Client\FileGetContents;
use Buzz\Message\Form\FormRequest;
use Buzz\Message\MessageInterface;
use Buzz\Message\Request;
use Buzz\Message\Response;

/**
 * Class JsonListener
 * @category API
 * @package  BespokeSupport\PoliceApi
 * @author   Richard Seymour <web@bespoke.support>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  Release: (as documented)
 * @link     https://github.com/BespokeSupport/PoliceApi
 */
class PoliceJsonApi
{
    // base url for API
    const BASE_URL = 'https://data.police.uk/api/';

    // use Buzz Curl
    const CLIENT_CURL = 'curl';

    // use Buzz FileGetContents
    const CLIENT_FILE_GET_CONTENTS = 'file-get-contents';

    /**
     * client selected above or guess
     * @var null|string
     */
    public static $client;

    /**
     * Which API Endpoints can be HTTP POST
     * @var array
     */
    private static $postEndpoints = [
        'crime-categories',
        'crimes-street\/all-crime'
    ];

    /**
     * Fetch from the API
     * @param string $endpoint Fetch from the endpoint
     * @param array $params Any parameters
     * @return \stdClass|\stdClass[]
     */
    public static function fetch($endpoint, array $params = [])
    {
        $client = self::getClient();

        $browser = new Browser($client);

        $method = Request::METHOD_GET;

        foreach (self::$postEndpoints as $check) {
            if (preg_match("/^$check$/", $endpoint)) {
                $method = Request::METHOD_POST;
            }
        }

        $request = new FormRequest($method, $endpoint, self::BASE_URL);

        $request->setFields($params);

        $response = new Response();

        $listener = new JsonListener();

        $browser->addListener($listener);

        $response = $browser->send($request, $response);

        return $response->getContent();
    }

    /**
     * Get Curl/FileGetContents
     * @param null $client Select client
     * @return Curl|FileGetContents
     */
    private static function getClient($client = null)
    {
        if (!$client) {
            $client = self::$client;
        }

        switch ($client) {
            case self::CLIENT_FILE_GET_CONTENTS:
                return new FileGetContents();
                break;
            case self::CLIENT_CURL:
                return new Curl();
                break;
            // @codeCoverageIgnoreStart
            default:
                if (function_exists('curl_init')) {
                    return new Curl();
                } else {
                    return new FileGetContents();
                }
                break;
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * @param $client
     */
    public static function setClient($client)
    {
        self::$client = $client;
    }
}
