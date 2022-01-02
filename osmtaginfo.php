<?php
# OpenStreetMap TagInfo - MediaWiki extension
# 
##################################################################################
#
# Copyright 2010 Grant Slater
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# @addtogroup Extensions
#

if( defined( 'MEDIAWIKI' ) ) {
	$wgExtensionFunctions[] = 'wfosmtaginfo';

	$wgExtensionCredits['parserhook'][] = array(
		'name'           => 'OpenStreetMap OSMTagInfo',
		'author'         => 'Grant Slater',
		'url'            => 'http://wiki.openstreetmap.org/wiki/TagInfo',
		'description'    => 'OSMTagInfo blah blah blah',
		'descriptionmsg' => 'osmtaginfo_desc',
	);

	$wgAutoloadClasses['OSMTagInfo'] = dirname( __FILE__ ) . '/osmtaginfo.class.php';
	$wgExtensionMessagesFiles['OSMTagInfo'] = dirname( __FILE__ ) . '/osmtaginfo.i18n.php';

}
