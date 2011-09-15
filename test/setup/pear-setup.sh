#!/bin/bash
pear upgrade pear
pear channel-update pear.php.net
pear config-set auto_discover 1
pear install --alldeps pear.phpunit.de/PHPUnit
