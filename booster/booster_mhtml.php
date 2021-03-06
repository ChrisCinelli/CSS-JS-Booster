<?php  
/*------------------------------------------------------------------------
* 
* CSS-JS-BOOSTER
* Copyright (C) 2010 Christian "Schepp" Schaefer
* http://twitter.com/derSchepp
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as published 
* by the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public License
* along with this program. 
* If not, see <http://www.gnu.org/licenses/lgpl-3.0.txt>
* 
------------------------------------------------------------------------*/
include('booster_inc.php');

((isset($_GET['dir'])) ? $source = str_replace('>','..',rtrim(preg_replace('/[^a-z0-9,\-_\.\/>]/i','',preg_replace('/!.+/i','',$_GET['dir'])),'/')) : $source = 'css');
((isset($_GET['cachedir'])) ? $booster_cachedir = str_replace('>','..',rtrim(preg_replace('/[^a-z0-9,\-_\.\/>]/i','',$_GET['cachedir']),'/')) : $booster_cachedir = 'booster_cache');

$booster = new Booster();
$booster->booster_cachedir = $booster_cachedir;
$booster->css_source = $source;

// Force browser to always request the file, and then serve 304 if nothing changed
$etag = md5($source.$booster->mhtmltime());

if(@$_SERVER['HTTP_IF_NONE_MATCH'] === $etag) 
{
	header('HTTP/1.1 304 Not Modified');
	exit();
}

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".gmdate('D, d M Y H:i:s',time() - (24 * 3600))." GMT");
header("Content-type: text/plain"); 
header("ETag: ".$etag);

echo $booster->mhtml();
?>