<?php
/**
 * Copyright 2013 Paolo Casarini
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Server-side strategy of geocoding as a wrapper for the http requests to
 * Google Maps API v3 service.
 * 
 * @author Paolo Casarini
 * @see https://developers.google.com/maps/documentation/geocoding/
 */
class Geocoder
{
    const G_API_URL = 'http://maps.googleapis.com/maps/api/geocode/';

    const G_GEO_OK               = "OK";
    const G_GEO_ZERO_RESULTS     = "ZERO_RESULTS";
    const G_GEO_OVER_QUERY_LIMIT = "OVER_QUERY_LIMIT";
    const G_GEO_REQUEST_DENIED   = "REQUEST_DENIED";
    const G_GEO_INVALID_REQUEST  = "INVALID_REQUEST";

    /**
     * Default empty constructor
     */
    public function __construct() {}

    /**
     * Perform the geocoding request
     * 
     * @param string $search the address to search
     * @param string $output (optional) the output type: 'xml' or 'json'
     * @return string the raw response
     */
    public function performRequest($search, $output = 'xml')
    {
        $url = sprintf('%s%s?address=%s&sensor=false',
                self::G_API_URL,
                $output,
                urlencode($search));
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }    

    /**
     * Resolve an address in Placemark through Google Geocoding API
     * 
     * @param string $search the address to search
     * @throws Exception if an error occurs while performing the request
     * @return Placemark|NULL a Placemark object with the resolution of the geocoding request for the given address 
     */
    public function lookup($search)
    {
        $response = $this->performRequest($search, 'xml');
        $xml = new SimpleXMLElement($response);
        $status = $xml->status;
        
        switch ($status) {
        case self::G_GEO_OK:
            require_once('Placemark.php');
            return Placemark::FromSimpleXml($xml->result);
                
        case self::G_GEO_ZERO_RESULTS:
            return null;

        default:
            throw new Exception(sprintf('Google Geo error %s occurred', $status));
        }
    }
}
