<?php

/**
 *  This file is part of Grublet.
 *
 *  Grublet is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Foobar is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 *
 * This particular file contains the PunchFork request interface.
 * 
 * @author Adam M. Dutko <adam@runbymany.com>
 * @link http://www.runbymany.com
 * @copyright Copyright &copy; 2011 RunByMany, LLC
 * @license GPLv3 or Later
 */

interface PunchForkRequestInt
{
    public function getBase(); // Return the Base of the API URL
    public function setBase($url); // Base of the API URL
    public function getRequestType(); // Return the Request Type
    public function setRequestType($type); // Request Type 
    public function getRequestParameters(); // Get key/val params
    public function setRequestParameters($key,$params); // Set key/val params
    public function getRequest(); // Return the built request
}

?>
