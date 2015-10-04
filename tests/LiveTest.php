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

use BespokeSupport\PoliceApi\PoliceJsonApi;
use BespokeSupport\PoliceApi\PoliceUK;

/**
 * Class LiveTest
 * @category Tests
 * @package  BespokeSupport\PoliceApi
 * @author   Richard Seymour <web@bespoke.support>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  Release: (as documented)
 * @link     https://github.com/BespokeSupport/PoliceApi
 */
class LiveTest extends \PHPUnit_Framework_TestCase
{
    const FORCE = 'lancashire';
    const GEO_LATITUDE = 53.7724;
    const GEO_LONGITUDE = -2.7242;
    const NEIGHBOURHOOD = 'D18';

    /**
     * Get the API Class
     * @return PoliceUK
     */
    private function getClient()
    {
        return new PoliceUK();
    }

    /**
     * API: Categories
     * @return void
     */
    public function testLiveCategories()
    {
        $police = $this->getClient();

        $return = $police->crime_categories('2015-09');

        $this->assertGreaterThan(0, count($return));
        $this->assertObjectHasAttribute('name', $return[0]);
        $this->assertObjectHasAttribute('url', $return[0]);
    }

    /**
     * API: CrimeLocate
     * @return void
     */
    public function testLiveCrimeLocate()
    {
        $police = $this->getClient();

        $return = $police->crime_locate(self::GEO_LATITUDE, self::GEO_LONGITUDE);

        $this->assertGreaterThan(0, count($return));
        $this->assertObjectHasAttribute('category', $return[0]);
        $this->assertObjectHasAttribute('location_type', $return[0]);
        $this->assertObjectHasAttribute('location', $return[0]);
        $this->assertObjectHasAttribute('persistent_id', $return[0]);
        $this->assertObjectHasAttribute('id', $return[0]);
        $this->assertObjectHasAttribute('month', $return[0]);
    }

    /**
     * API: Force
     * @return void
     */
    public function testLiveForce()
    {
        $police = $this->getClient();

        $return = $police->force(self::FORCE);
        $this->assertObjectHasAttribute('id', $return);
        $this->assertObjectHasAttribute('name', $return);
        $this->assertEquals(self::FORCE, $return->id);
    }

    /**
     * API: Forces
     * @return void
     */
    public function testLiveForces()
    {
        $police = $this->getClient();

        $return = $police->forces();

        $this->assertGreaterThan(0, count($return));
        $this->assertObjectHasAttribute('id', $return[0]);
        $this->assertObjectHasAttribute('name', $return[0]);
    }

    /**
     * API: Geo-locate
     * @return void
     */
    public function testLiveGeoLocate()
    {
        $police = $this->getClient();

        $return = $police->neighbourhood_locate(
            self::GEO_LATITUDE,
            self::GEO_LONGITUDE
        );

        $this->assertObjectHasAttribute('force', $return);
        $this->assertObjectHasAttribute('neighbourhood', $return);
        $this->assertEquals(self::FORCE, $return->force);
        $this->assertEquals(self::NEIGHBOURHOOD, $return->neighbourhood);
    }

    /**
     * API: Neighbourhood
     * @return void
     */
    public function testLiveNeighbourhood()
    {
        $police = $this->getClient();

        $return = $police->neighbourhood(self::FORCE, self::NEIGHBOURHOOD);

        $this->assertObjectHasAttribute('id', $return);
        $this->assertObjectHasAttribute('population', $return);
        $this->assertObjectHasAttribute('name', $return);
        $this->assertObjectHasAttribute('locations', $return);
        $this->assertObjectHasAttribute('centre', $return);
        $this->assertObjectHasAttribute('contact_details', $return);
    }

    /**
     * API: NeighbourhoodEvents
     * @return void
     */
    public function testLiveNeighbourhoodEvents()
    {
        $police = $this->getClient();

        $return = $police->neighbourhood_events(self::FORCE, self::NEIGHBOURHOOD);

        $this->assertGreaterThan(0, count($return));
        $this->assertObjectHasAttribute('type', $return[0]);
        $this->assertObjectHasAttribute('title', $return[0]);
        $this->assertObjectHasAttribute('start_date', $return[0]);
    }

    /**
     * API: NeighbourhoodTeam
     * @return void
     */
    public function testLiveNeighbourhoodTeam()
    {
        $police = $this->getClient();

        $return = $police->neighbourhood_team(self::FORCE, self::NEIGHBOURHOOD);

        $this->assertGreaterThan(0, count($return));
        $this->assertObjectHasAttribute('bio', $return[0]);
        $this->assertObjectHasAttribute('name', $return[0]);
        $this->assertObjectHasAttribute('rank', $return[0]);
        $this->assertObjectHasAttribute('contact_details', $return[0]);
    }

    /**
     * API: Neighbourhoods
     * @return void
     */
    public function testLiveNeighbourhoods()
    {
        $police = $this->getClient();

        $return = $police->neighbourhoods(self::FORCE);
        $this->assertGreaterThan(0, count($return));
        $this->assertObjectHasAttribute('id', $return[0]);
        $this->assertObjectHasAttribute('name', $return[0]);
    }

    /**
     * API: LastUpdated
     * @return void
     */
    public function testLiveUpdatedCurl()
    {
        PoliceJsonApi::setClient(PoliceJsonApi::CLIENT_CURL);

        $police = $this->getClient();

        $return = $police->lastupdated();

        $this->assertObjectHasAttribute('date', $return);

        $date = \DateTime::createFromFormat('Y-m-d', $return->date);

        $this->assertEquals('DateTime', get_class($date));
    }

    /**
     * API: LastUpdated
     * @return void
     */
    public function testLiveUpdatedFileGetContents()
    {
        PoliceJsonApi::setClient(PoliceJsonApi::CLIENT_FILE_GET_CONTENTS);

        $police = $this->getClient();

        $return = $police->lastupdated();

        $this->assertObjectHasAttribute('date', $return);

        $date = \DateTime::createFromFormat('Y-m-d', $return->date);

        $this->assertEquals('DateTime', get_class($date));
    }
}
