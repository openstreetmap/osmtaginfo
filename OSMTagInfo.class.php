<?php
# OpenStreetMap TagInfo - MediaWiki extension
#
# #################################################################################
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

class OSMTagInfo {

	# The callback function for converting the input text to HTML output
	static function parse( $input, $argv ) {
		global $wgScriptPath;

		wfLoadExtensionMessages( 'OSMTagInfo' );

		if ( isset( $argv['key'] ) ) {
			$key = $argv['key'];
		} else {
			$key = '';
		}
		if ( isset( $argv['value'] ) ) {
			$value = $argv['value'];
		} else {
			$value = '';
		}

		$height = '200';
		$width = '200';

		$error = '';

		if ( $error == '' ) {
			
			// Check required parameters values are provided
			if ( $key == ''  ) $error .= wfMsg( 'osmtaginfo_keymissing' ) . '<br>';
			
			// no errors so far. Now check the values
			/*
			if ( !is_numeric( $width ) ) {
				$error = wfMsg( 'osmtaginfo_widthnan', $width ) . '<br>';
			} else if ( !is_numeric( $height ) ) {
				$error = wfMsg( 'osmtaginfo_heightnan', $height ) . '<br>';
			}
			*/
		}

		if ( $error != "" ) {
			// Something was wrong. Spew the error message and input text.
			$output  = '';
			$output .= "<span class=\"error\">" . wfMsg( 'osmtaginfo_maperror' ) . ' ' . $error . "</span><br />";
			$output .= htmlspecialchars( $input );
		} else {
			// HTML output for the slippy map.
			// Note that this must all be output on one line (no linefeeds)
			// otherwise MediaWiki adds <BR> tags, which is bad in the middle of a block of javascript.
			// There are other ways of fixing this, but not for MediaWiki v4
			// (See http://www.mediawiki.org/wiki/Manual:Tag_extensions#How_can_I_avoid_modification_of_my_extension.27s_HTML_output.3F)

			$output  = '<!-- osm taginfo -->';
			if ( !empty($value) ) {
				$output .= '<iframe frameborder="0" width="'.$width.'" height="100" src="http://taginfo.openstreetmap.org/embed/tag?key='.urlencode($key).'&value='.urlencode($value).'">';
			} else {
				$output .= '<iframe frameborder="0" width="'.$width.'" height="100" src="http://taginfo.openstreetmap.org/embed/key?key='.urlencode($key).'">';
			}
			//$output .= '<p>Your browser does not support iframes.</p>';
			$output .= '</iframe>'."\n";
		}
		return $output;
	}
}
