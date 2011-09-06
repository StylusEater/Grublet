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
 * This particular file provides an example of how to get the remaining API 
 * calls you have for your API key for the day. 
 * 
 * @author Adam M. Dutko <adam@runbymany.com>
 * @link http://www.runbymany.com
 * @copyright Copyright &copy; 2011 RunByMany, LLC
 * @license GPLv3 or Later
 */

require_once '../include/PunchFork.php';

$test = new PunchForkImpl('../conf/grublet.ini');
$response = $test->getRateLimitStatus();
print_r($response);

?>
