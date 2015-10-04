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

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;

/**
 * Class JsonListener
 * @category API
 * @package  BespokeSupport\PoliceApi
 * @author   Richard Seymour <web@bespoke.support>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  Release: (as documented)
 * @link     https://github.com/BespokeSupport/PoliceApi
 */
class JsonListener implements ListenerInterface
{
    /**
     * Convert JSON string to array/object
     * @param RequestInterface $request Request
     * @param MessageInterface $response Response
     * @return object|array|null
     */
    public function postSend(RequestInterface $request, MessageInterface $response)
    {
        $response->setContent(json_decode($response->getContent()));
    }

    /**
     * No modification of Request
     * @param RequestInterface $request Request
     * @return void
     */
    public function preSend(RequestInterface $request)
    {
    }
}
