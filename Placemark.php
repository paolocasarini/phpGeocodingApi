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
 * A class to represent the place of a geoconding result.
 * 
 * @author Paolo Casarini
 */
class Placemark {

    /**
     * The gps location of the place
     * 
     * @var Point
     */
    protected $_point;
    
    /**
     * The address of the place searched
     * 
     * @var string
     */
    protected $_address;
    
    /**
     * The type of the place searched
     * 
     * @var string
     */
    protected $_accuracy;

    public function setAddress($address)
    {
        $this->_address = $address;
    }

    public function getAddress()
    {
        return $this->_address;
    }

    public function setPoint(Point $point)
    {
        $this->_point = $point;
    }

    public function getPoint()
    {
        return $this->_point;
    }

    public function setAccuracy($accuracy)
    {
        $this->_accuracy = $accuracy;
    }

    public function getAccuracy()
    {
        return $this->_accuracy;
    }    

    public function __toString()
    {
        return $this->getAddress();
    }
    
    /**
     * Factory method to build a Placemark from the Google Maps Api xml response
     * 
     * @param string $xml the xml result of the response of a Google Geocoding API v3 request
     * @return Placemark the Placemark instance the represent the place found
     */
    public static function FromSimpleXml($xml)
    {
        require_once('Point.php');
        $point = new Point((float)$xml->geometry->location->lat, (float)$xml->geometry->location->lng);

        $placemark = new self;
        $placemark->setPoint($point);
        $placemark->setAddress((string)$xml->formatted_address);
        $placemark->setAccuracy((string)$xml->type);

        return $placemark;
    }
}
