# PoliceApi
API and Data for data.police.uk
Replacement for old cURL library (https://github.com/RickSeymour/Police.uk-API-PHP-Curl-Class)

## Usage
Add to your composer.json

```
{
    "require": {
        "bespoke-support/police-api": "~0.1.0"
    }
}
```

```
<?php

require_once 'vendor/autoload.php';

$police = new Police;

$obj = $police->lastupdated();
```

```
<?php

$neighbourhoods = PoliceJsonApi::fetch(sprintf('%s/neighbourhoods', $force));
```

## Endpoints available

- crime-last-updated
- crimes-street-dates
- forces
- forces/leicestershire
- forces/leicestershire/people
- leicestershire/neighbourhoods
- leicestershire/C01
- leicestershire/C01/boundary
- leicestershire/C01/people
- leicestershire/C01/priorities
- leicestershire/C01/events
- outcomes-for-crime/55cf6589528767582bf0c96af1a4f99308aa66daad285c3f8317df357628bee0
- locate-neighbourhood?q=51.500617,-0.124629
- crime-categories?date=2011-08
- crimes-street/all-crime?lat=52.629729&lng=-1.131592&date=2013-01
- crimes-street/all-crime?poly=52.268,0.543:52.794,0.238:52.130,0.478&date=2013-01
- outcomes-at-location?date=2013-01&location_id=12345
- outcomes-at-location?date=2013-01&lat=52.629729&lng=-1.131592
- outcomes-at-location?date=2013-01&poly=52.268,0.543:52.794,0.238:52.130,0.478
- crimes-at-location?date=2012-02&location_id=12345
- crimes-at-location?date=2012-02&lat=52.629729&lng=-1.131592
- crimes-no-location?category=all-crime&force=warwickshire&date=2013-09
- stops-street?lat=52.629729&lng=-1.131592&date=2015-05
- stops-street?poly=52.268,0.543:52.794,0.238:52.130,0.478&date=2015-01
- stops-at-location?location_id=885142&date=2015-06
- stops-no-location?force=cleveland&date=2015-06
- stops-force?force=avon-and-somerset&date=2015-04
