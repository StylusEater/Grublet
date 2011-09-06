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
 * This particular file contains the implementation of the PunchFork interface. 
 * 
 * @author Adam M. Dutko <adam@runbymany.com>
 * @link http://www.runbymany.com
 * @copyright Copyright &copy; 2011 RunByMany, LLC
 * @license GPLv3 or Later
 */

class PunchForkImpl implements PunchForkInt
{
    private $_GRUBLET_CONFIG = "";
    private $_PF_API_KEY = "";
    private $_PF_API_TYPE = 4; 
    private $_BASE = "http://api.punchfork.com/";
    private $CURL_HANDLE = '';

    public function __construct($config='conf/grublet.ini') 
    { 
        $this->_GRUBLET_CONFIG = $config;

        if (is_file($this->_GRUBLET_CONFIG))
        {
            $grublet = parse_ini_file($this->_GRUBLET_CONFIG, true);    
            if (count($grublet) == 0)
            {
                die("ERROR: NO OPTIONS SET IN YD CONFIG!\n");
            } else {
                $this->_PF_API_KEY = $grublet["PF"]["API_KEY"];
                $this->_PF_API_TYPE = $grublet["PF"]["API_TYPE"];
            }

            if ($this->_PF_API_KEY == "")
            {
                die("ERROR: MISSING PUNCHFORK API KEY!\n");
            } 

            if ($this->_PF_API_TYPE == 4)
            {
                die("ERROR: IS YOUR KEY FREE (0), PAID (1) OR ULTRA (2)?\n");
            }

            // Setup Curl
            $this->CURL_HANDLE = curl_init();
            curl_setopt($this->CURL_HANDLE, CURLOPT_HEADER, 0);
            curl_setopt($this->CURL_HANDLE, CURLOPT_HTTPGET, 1);
            curl_setopt($this->CURL_HANDLE, CURLOPT_RETURNTRANSFER, 1); 

        } else {
            die("ERROR: GRUBLET CONFIG NOT FOUND!\n");
        }

    }

    public function __destruct() { }

    private function getKey()
    {
       return $this->_PF_API_KEY;
    }

    private function errorPresent($response)
    {
        if (array_key_exists("error", $response))
        {
            die("ERROR: " . $response["error"] . "\n"); 
        } else {
            return 0; 
        }
    }

    /**
     * @todo validate all parameters
     * @todo write tests
     */
    public function getRecipeByQuery(
                                     $query="",$count=1,$sort="r",
                                     $ingred=0,$publisher="",$cursor="",
                                     $startdate="",$enddate=""
                                    )
    {
        $params = array();
        $validSorts = array("r","d","t");

        if ($query == "")
        {
            die("ERROR: A SEARCH QUERY IS REQUIRED!"); 
        } else {
            $params["q"] = $query;
        }
        
        if (($this->_PF_API_TYPE != (1 || 2) && ($ingred == 1)))
        {
            die("ERROR: YOU NEED A PAID OR ULTRA API SUBSCRIPTION!\n");
        } else {
            if ($ingred === 1)
            {
                $params["ingred"] = $ingred;
            }
        } 
       
        if ($publisher != "")
        {
            $params["from"] = $publisher;
        }

        $params["count"] = $count;
        
        if ($cursor != "")
        {   
            $params["cursor"] = $cursor;
        }
        
        if (in_array($sort, $validSorts))
        { 
            if ($sort != "r")
            {
                $params["sort"] = $sort;
            }
        } else {
            die("ERROR: YOU NEED TO SORT BY A VALID OPTION!\n");
        }
        
        if ($startdate != "")
        {
            $params["startdate"] = $startdate;
        }

        if ($enddate != "")
        {
            $params["enddate"] = $enddate;
        }

        $queried = new PunchForkRequestImpl();
        $queried->setBase($this->_BASE);
        $queried->setRequestType("recipes");
        $queried->setRequestParameters($this->getKey(),$params);
        $request = $queried->getRequest();
        curl_setopt($this->CURL_HANDLE, CURLOPT_URL, $request);
        $response = curl_exec($this->CURL_HANDLE); 

        $decodedResponse = json_decode(utf8_encode($response),1);
        if ($this->errorPresent($decodedResponse) === 0)
        {
            return $decodedResponse; 
        }
    }

    /**
     * @todo write tests
     */
    public function getRandomRecipe()
    {
        $random = new PunchForkRequestImpl();
        $random->setBase($this->_BASE);
        $random->setRequestType("random_recipe");
        $random->setRequestParameters($this->getKey(),array());
        $request = $random->getRequest();
        curl_setopt($this->CURL_HANDLE, CURLOPT_URL, $request);
        $response = curl_exec($this->CURL_HANDLE); 

        $decodedResponse = json_decode(utf8_encode($response),1);
        if ($this->errorPresent($decodedResponse) === 0)
        {
            return $decodedResponse; 
        }
    }

    /**
     * @todo write tests
     */
    public function getPublisherList()
    {
        $publishers = new PunchForkRequestImpl();
        $publishers->setBase($this->_BASE);
        $publishers->setRequestType("publishers");
        $publishers->setRequestParameters($this->getKey(),array());
        $request = $publishers->getRequest();
        curl_setopt($this->CURL_HANDLE, CURLOPT_URL, $request);
        $response = curl_exec($this->CURL_HANDLE); 

        $decodedResponse = json_decode(utf8_encode($response),1);
        if ($this->errorPresent($decodedResponse) === 0)
        {
            return $decodedResponse; 
        }
    }

    /**
     * @todo validate parameters
     * @todo write tests
     */
    public function getSearchIndex($title,$ingred)
    {
        if ($this->_PF_API_TYPE != (1 || 2))
        {
            die("ERROR: THIS FEATURE IS FOR PAID AND ULTRA API USERS ONLY!\n");
        }

        if ($title != "")
        {
            $params["title"] = $title;
        }

        if ($ingred != "")
        {
            $params["ingred"] = $ingred;
        }

        $search = new PunchForkRequestImpl();
        $search->setBase($this->_BASE);
        $search->setRequestType("search_index");
        $search->setRequestParameters($this->getKey(),$params);
        $request = $search->getRequest();
        curl_setopt($this->CURL_HANDLE, CURLOPT_URL, $request);
        $response = curl_exec($this->CURL_HANDLE); 

        $decodedResponse = json_decode(utf8_encode($response),1);
        if ($this->errorPresent($decodedResponse) === 0)
        {
            return $decodedResponse; 
        }
    }

    /**
     * @todo write tests
     */
    public function getRateLimitStatus()
    {
        $limit = new PunchForkRequestImpl();
        $limit->setBase($this->_BASE);
        $limit->setRequestType("rate_limit_status");
        $limit->setRequestParameters($this->getKey(),array());
        $request = $limit->getRequest();
        curl_setopt($this->CURL_HANDLE, CURLOPT_URL, $request);
        $response = curl_exec($this->CURL_HANDLE); 

        $decodedResponse = json_decode(utf8_encode($response),1);
        if ($this->errorPresent($decodedResponse) === 0)
        {
            return $decodedResponse; 
        }
    }

}
