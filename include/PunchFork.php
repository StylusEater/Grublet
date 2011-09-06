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
 * This particular file contains the autoloader for Grublet. 
 * 
 * @author Adam M. Dutko <adam@runbymany.com>
 * @link http://www.runbymany.com
 * @copyright Copyright &copy; 2011 RunByMany, LLC
 * @license GPLv3 or Later
 */

namespace PunchFork;

// SOURCE:
// http://www.ibm.com/developerworks/opensource/library/os-php-5.3namespaces
//
function autoload($classname) 
{
    $classname = ltrim($classname, '\\');
    $filename  = '';
    $namespace = '';
    if ($lastnspos = strripos($classname, '\\')) 
    {
        $namespace = substr($classname, 0, $lastnspos);
        $classname = substr($classname, $lastnspos + 1);
        $filename  = str_replace('\\', '/', $namespace) . '/';
    }
    $filename .= str_replace('_', '/', $classname) . '.php';
    require $filename;  
}

spl_autoload_register(__NAMESPACE__ . '\autoload');

?>
