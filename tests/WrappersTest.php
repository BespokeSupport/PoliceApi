<?php
/**
 * Tests for Police UK API
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

namespace BespokeSupport\PoliceApi\Tests;

use BespokeSupport\PoliceApi\JsonListener;
use BespokeSupport\PoliceApi\PoliceJsonApi;
use Buzz\Message\Request;
use Buzz\Message\Response;

/**
 * Class LiveTest
 * @category Tests
 * @package  BespokeSupport\PoliceApi
 * @author   Richard Seymour <web@bespoke.support>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  Release: (as documented)
 * @link     https://github.com/BespokeSupport/PoliceApi
 */
class WrappersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test FileGetContents specific
     */
    public function testFileGetContents()
    {
        PoliceJsonApi::setClient(PoliceJsonApi::CLIENT_FILE_GET_CONTENTS);

        $police = new PoliceJsonApi();

        $this->assertEquals(PoliceJsonApi::CLIENT_FILE_GET_CONTENTS, $police::$client);
    }

    /**
     * Test JSON Listener for Buzz
     */
    public function testJsonListener()
    {
        $request = new Request();

        $response = new Response();

        $testJsonArray = ['test1' => 'test2'];

        $testJsonString = json_encode($testJsonArray);

        $response->setContent($testJsonString);

        $listener = new JsonListener();

        $listener->postSend($request, $response);

        /**
         * @var $return \stdClass
         */
        $return = $response->getContent();

        $this->assertObjectHasAttribute('test1', $return);

        $this->assertEquals('test2', $return->test1);

        $this->assertJson(json_encode($return), $testJsonString);
    }

    /**
     * Test JSON Listener for Buzz
     */
    public function testJsonListenerPreSend()
    {
        $request = new Request();

        $listener = new JsonListener();

        $listener->preSend($request);

        $this->assertTrue(true);
    }
}
