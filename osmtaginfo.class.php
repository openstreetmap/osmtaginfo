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

	# register the extension with the WikiText parser
	# the first parameter is the name of the new tag.
	# In this case it defines the tag <osmtaginfo>
	# the second parameter is the callback function for
	# processing the text between the tags
	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'osmtaginfo', [ self::class, 'parse' ] );
	}

	# The callback function for converting the input text to HTML output
	static function parse( $input, $argv ) {
		global $wgScriptPath;

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
		if ( isset( $argv['rtype'] ) ) {
			$rtype = $argv['rtype'];
		} else {
			$rtype = '';
		}

		$height = '250';
		$width = '220';

		$error = '';

		if ( $error == '' ) {
			
			// Check required parameters values are provided
			if ( $key == '' AND $rtype == '' ) $error .= wfMessage( 'osmtaginfo_keymissing' )->escaped() . '<br>';
			
			// no errors so far. Now check the values
			/*
			if ( !is_numeric( $width ) ) {
				$error = wfMessage( 'osmtaginfo_widthnan', $width )->escaped() . '<br>';
			} else if ( !is_numeric( $height ) ) {
				$error = wfMessage( 'osmtaginfo_heightnan', $height )->escaped() . '<br>';
			}
			*/
		}

		if ( $error != "" ) {
			// Something was wrong. Spew the error message and input text.
			$output  = '';
			$output .= "<span class=\"error\">" . wfMessage( 'osmtaginfo_maperror' )->escaped() . ' ' . $error . "</span><br />";
			$output .= htmlspecialchars( $input );
		} else {
			// HTML output for the slippy map.
			// Note that this must all be output on one line (no linefeeds)
			// otherwise MediaWiki adds <BR> tags, which is bad in the middle of a block of javascript.
			// There are other ways of fixing this, but not for MediaWiki v4
			// (See http://www.mediawiki.org/wiki/Manual:Tag_extensions#How_can_I_avoid_modification_of_my_extension.27s_HTML_output.3F)

			$output  = '<!-- osm taginfo -->';
			if ( !empty($rtype) ) {
				$output .= '<iframe frameborder="0" width="'.$width.'" height="160" src="//taginfo.openstreetmap.org/embed/relation?rtype='.urlencode($rtype).'">';
			} elseif ( !empty($value) ) {
				$output .= '<iframe frameborder="0" width="'.$width.'" height="100" src="//taginfo.openstreetmap.org/embed/tag?key='.urlencode($key).'&value='.urlencode($value).'">';
			} else {
				$output .= '<iframe frameborder="0" width="'.$width.'" height="100" src="//taginfo.openstreetmap.org/embed/key?key='.urlencode($key).'">';
			}
			//$output .= '<p>Your browser does not support iframes.</p>';
			$output .= '</iframe>'."\n";
		}
		return $output;
	}
}
