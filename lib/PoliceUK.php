<?php
/**
 * UK Police JSON API class - Legacy for backward compatibility with old cURL library
 * https://github.com/RickSeymour/Police.uk-API-PHP-Curl-Class
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

/**
 * Class PoliceUK
 * @category API
 * @package  BespokeSupport\PoliceApi
 * @author   Richard Seymour <web@bespoke.support>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  Release: (as documented)
 * @link     https://github.com/BespokeSupport/PoliceApi
 */
class PoliceUK
{
    /**
     * API: Crime Categories
     * @param string $month Year and month (in YYYY-MM format)
     * @return \stdClass[]
     */
    public function crime_categories($month = null)
    {
        $params = [];
        if (preg_match('/^\d{4}-\d{2}$/', $month)) {
            $params['q'] = $month;
        }

        return PoliceJsonApi::fetch('crime-categories', $params);
    }

    /**
     * API: Crime within 1 mile of point
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @return \stdClass[]
     */
    public function crime_locate($latitude, $longitude)
    {
        return PoliceJsonApi::fetch(
            'crimes-street/all-crime',
            [
                'lat' => $latitude,
                'lng' => $longitude
            ]
        );
    }

    /**
     * API: Force
     * @param string $force Police force
     * @return \stdClass
     */
    public function force($force)
    {
        return PoliceJsonApi::fetch('forces/' . $force);
    }

    /**
     * API: Forces
     * @return \stdClass[]
     */
    public function forces()
    {
        return PoliceJsonApi::fetch('forces');
    }

    /**
     * API: Last Updated
     * @return \stdClass
     */
    public function lastupdated()
    {
        return PoliceJsonApi::fetch('crime-last-updated');
    }

    /**
     * API: Neighbourhood for a force
     * @param string $force Force
     * @param string $neighbourhood Neighbourhood
     * @return \stdClass
     */
    public function neighbourhood($force, $neighbourhood)
    {
        return PoliceJsonApi::fetch(sprintf('%s/%s', $force, $neighbourhood));
    }

    /**
     * API: Neighbourhood events
     * @param string $force Force
     * @param string $neighbourhood Neighbourhood
     * @return \stdClass[]
     */
    public function neighbourhood_events($force, $neighbourhood)
    {
        return PoliceJsonApi::fetch(sprintf('%s/%s/events', $force, $neighbourhood));
    }

    /**
     * API: Neighbourhood via GeoLocation
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @return \stdClass
     */
    public function neighbourhood_locate($latitude, $longitude)
    {
        return PoliceJsonApi::fetch(
            'locate-neighbourhood',
            [
                'q' => $latitude . ',' . $longitude
            ]
        );
    }

    /**
     * API: Neighbourhood Team/People
     * @param string $force Force
     * @param string $neighbourhood Neighbourhood
     * @return \stdClass[]
     */
    public function neighbourhood_team($force, $neighbourhood)
    {
        return PoliceJsonApi::fetch(sprintf('%s/%s/people', $force, $neighbourhood));
    }

    /**
     * API: Single Force
     * @param string $force A Police Force
     * @return \stdClass[]
     */
    public function neighbourhoods($force)
    {
        return PoliceJsonApi::fetch(sprintf('%s/neighbourhoods', $force));
    }
}
