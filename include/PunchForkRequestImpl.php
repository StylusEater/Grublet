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
 * This particular file contains the implementation of the PunchFork request 
 * interface.
 * 
 * @author Adam M. Dutko <adam@runbymany.com>
 * @link http://www.runbymany.com
 * @copyright Copyright &copy; 2011 RunByMany, LLC
 * @license GPLv3 or Later
 */

class PunchForkRequestImpl implements PunchForkRequestInt
{
    private $types = array(
                           "recipes","random_recipe",
                           "publishers","search_index",
                           "rate_limit_status"
                          );
    private $key = "";

    public $base = "";
    public $type = "";
    public $params = array();

    public function __construct() { }
    public function __destruct() { }

    /**
     * @todo write tests
     */
    public function getBase() 
    {
        if (isset($this->base))
        {
            return $this->base;
        }
    } 

    /**
     * @todo validate parameters
     * @todo write tests
     */
    public function setBase($url)
    {
        $this->base = $url;
    }

    /**
     * @todo write tests
     */
    public function getRequestType()
    {
        if (isset($this->type))
        {
            return $this->type;
        }
    } 
   
    /**
     * @todo validate parameters
     * @todo write tests
     */
    public function setRequestType($type)
    {
        // Valid types are: 
        //     recipes
        //     random_recipe
        //     publishers
        //     search_index
        //     rate_limit_status
        if (in_array($type, $this->types))
        { 
            $this->type = $type;
        }
    }

    public function getRequestParameters()
    {
        return $this->params;
    } 

    /**
     * @todo validate parameters
     * @todo write tests
     */
    public function setRequestParameters($key,$params)
    {
        $this->key = $key;

        if (is_array($params))
        {
            $this->params = $params;
        } else {
            die("ERROR: Parameters are not an array.");
        } 
    }

    /**
     * @todo write tests
     */
    public function getRequest()
    {
        $params = "key=" . $this->key;
        foreach ($this->params as $param => $value)
        {
            $params .= "&" . $param . "=" . $value; 
        }
        return $this->getBase() . $this->getRequestType() . "?" . $params; 
    }

}

?>
