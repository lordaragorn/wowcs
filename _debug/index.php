<?php

/**
 * @package World of Warcraft Community Site
 * @version Dev-0.1
 * @revision 0
 * @copyright (c) 2010 Shadez
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **/

if(isset($_GET['clearLog'])) {
    @file_put_contents('tmp.dbg', null);
    header('Location: .');
}
echo '<html><head><title>World of Warcraft Debug Log</title></head><body><a href="?clearLog">Clear log</a><br /><hr />';
/*
@include('../includes/configuration.php');
if(isset($WowConfig) && is_array($WowConfig) && $WowConfig['settings']['useDebug'] === true) {
    @include('../includes/revision_nr.php');
    echo '<html><head><title>World of Warcraft Debug Log</title></head><body><a href="?clearLog">Clear log</a><br /><hr />';
    echo sprintf("<strong>Armory revision:</strong> %d<br />
    <strong>DB Version:</strong> %s<br />
    Configuration values are:<br />
    <strong>WoWConfig['settings']['configVersion']</strong> = %d<br />
    <strong>WoWConfig['settings']['useCache']</strong> = %s<br />
    <strong>WoWConfig['settings']['cache_lifetime']</strong> = %d<br />
    <strong>WoWConfig['settings']['minlevel']</strong> = %d<br />
    <strong>WoWConfig['settings']['defaultLocale']</strong> = %s<br />
    <strong>WoWConfig['settings']['useDebug']</strong> = %s<br />
    <strong>WoWConfig['settings']['db_prefix']</strong> = %s</br>
    <strong>WoWConfig['settings']['logLevel']</strong> = %d<br /><br /><strong>Mulitrealm info:</strong> <br />
    ",
    WOW_REVISION,
    DB_VERSION,
    $WowConfig['settings']['configVersion'],
    ($WowConfig['settings']['useCache'] == true) ? 'true' : 'false',
    $WowConfig['settings']['cache_lifetime'],
    $WowConfig['settings']['minlevel'],
    $WowConfig['settings']['defaultLocale'],
    ($WowConfig['settings']['useDebug'] == true) ? 'true' : 'false',
    $WowConfig['settings']['db_prefix'],
    $WowConfig['settings']['logLevel']    
    );
    if(is_array($WowConfig['multiRealm'])) {
        foreach($WowConfig['multiRealm'] as $realm_info) {
            echo sprintf('Realm <strong>ID</strong>: %d, <strong>name</strong>: %s, <strong>type</strong>: %s<br />', $realm_info['id'], $realm_info['name'], $realm_info['type']);
        }
    }
    echo '<br /><strong>Log</strong>:<br /><br />';
}
elseif($WowConfig['settings']['useDebug'] === false) {
    header('Location: ../../');
    exit;
}
*/
@include('tmp.dbg');
echo '</body></html>';
?>