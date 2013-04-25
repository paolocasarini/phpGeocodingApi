#!/usr/bin/php
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
 * A simple example script to show the use of this Geocoding implementation
 */
require_once('Geocoder.php');
$geocoder = new Geocoder();
$address=utf8_encode("via Puccini 6, Parma, PR, Italy");

try {
    $placemark = $geocoder->lookup($address);
    print_r($placemark);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
