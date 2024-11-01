<?php
/*
Plugin Name: Title Capitalization
Plugin URI: http://www.tevine.com/projects/titlecapitalization
Description: Automates the process of capitalization in titles
Author: Nicholas Kwan (multippt)
Author URI: http://www.tevine.com/
Version: 1.0.1
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
*/

$captitleversion = '1.01';

//Default settings. Edit them using WP admin Control
$title_type = 'none';

//Install options
add_option('captitle_type', $title_type, 'Allows guests to vote [Vote It Up]');
if (get_option('captitle_type') == '') {
	update_option('captitle_type', $title_type);
}

//Make variables available
if (get_option('captitle_type') != $title_type) {
	$title_type = get_option('captitle_type');
}

function CapTitle_options() {
	if (function_exists('add_options_page')) {
	add_options_page("Title Capitalization", "Title Capitalization", 8, "captitleconfig", "CapTitle_optionspage");
	}
}

function CapTitle_optionspage() {
	switch ($task) {
	case '':
//Options page
?>
<div class="wrap">
<h2><?php _e('Title options'); ?></h2>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options &raquo;') ?>" />
</p>
<p><?php _e('You can configure some options that affect post titles through this panel.'); ?></p>
<h3>Common settings</h3>
<p>Capitalization of titles<br />
<input type="radio" name="captitle_type" id="captitle_type" value="none" <?php if (get_option('captitle_type') == 'none') { echo ' checked="checked"'; } ?> /><?php _e('None'); ?><br />
<input type="radio" name="captitle_type" id="captitle_type" value="all" <?php if (get_option('captitle_type') == 'all') { echo ' checked="checked"'; } ?> /><?php _e('All-uppercase letters<br />THE VITAMINS ARE IN MY FRESH BRUSSELS SPROUTS'); ?></p>
<input type="radio" name="captitle_type" id="captitle_type" value="lower" <?php if (get_option('captitle_type') == 'lower') { echo ' checked="checked"'; } ?> /><?php _e('All-lowercase letters<br />the vitamins are in my fresh brussels sprouts'); ?></p>
<input type="radio" name="captitle_type" id="captitle_type" value="first" <?php if (get_option('captitle_type') == 'first') { echo ' checked="checked"'; } ?> /><?php _e('Capitalize only first word<br />The vitamins are in my fresh brussels sprouts'); ?></p>
<input type="radio" name="captitle_type" id="captitle_type" value="words" <?php if (get_option('captitle_type') == 'words') { echo ' checked="checked"'; } ?> /><?php _e('Capitalize all words<br />The Vitamins Are In My Fresh Brussels Sprouts'); ?></p>
<input type="radio" name="captitle_type" id="captitle_type" value="wordsexceptarticle" <?php if (get_option('captitle_type') == 'wordsexceptarticle') { echo ' checked="checked"'; } ?> /><?php _e('Capitalize all words, except for internal articles and prepositions<br />The Vitamins Are in My Fresh Brussels Sprouts'); ?></p>
<input type="radio" name="captitle_type" id="captitle_type" value="wordsexceptofbe" <?php if (get_option('captitle_type') == 'wordsexceptofbe') { echo ' checked="checked"'; } ?> /><?php _e('Capitalization of all words, except for internal articles, prepositions and forms of to and be<br />The Vitamins are in My Fresh Brussels Sprouts'); ?></p>
<input type="radio" name="captitle_type" id="captitle_type" value="wordsexceptclosedclass" <?php if (get_option('captitle_type') == 'wordsexceptclosedclass') { echo ' checked="checked"'; } ?> /><?php _e('Capitalization of all words, except for most words in closed-classes<br />The Vitamins are in my Fresh Brussels Sprouts'); ?></p>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="captitle_type" />
<h3>Version</h3>
<?php CapTitle_Updatecheck(); ?>
</form>
</div>
<?php
}
}

function CapTitle_Updatecheck() {
global $captitleversion;
//Checks for an update
$fp = fsockopen("www.tevine.com", 80, $errno, $errstr, 30) or die('');
if (!$fp) {
    echo "<p>Sorry, but the plugin cannot be checked if it is the latest revision. </p>\n";
} else {
    $out = "GET /projects/titlecapitalization/latest.txt HTTP/1.1\r\n";
    $out .= "Host: www.tevine.com\r\n";
    $out .= "Connection: Close\r\n\r\n";

    fwrite($fp, $out);
$fitm = '';
    while (!feof($fp)) {
        $fitm .= fread($fp, 128);
    }
    fclose($fp);
}
      // strip the headers
      $pos      = strpos($fitm, "\r\n\r\n");
      $response = substr($fitm, $pos + 4);
	$response = (string) $response;
if ($response != $captitleversion) {
	echo '<p>A newer version is available - '.$response.'. Please <a href="http://www.tevine.com/projects/socialdropdown/" title="Social Dropdown downloa">update</a>.</p>';
} else {
	echo '<p>You are currently using the latest version.</p>';
}
}

//Capitalizes the title
function CapitalizeTitle($content) {
global $title_type;
switch ($title_type) {
	case 'none':
		//No changes
		return $content;
	break;
	case 'all':
		//Capitalization of all letters
		$content = strtoupper($content);
		return $content;
	break;
	case 'lower':
		//No capitalization
		$content = strtolower($content);
		return $content;
	break;
	case 'first':
		//Capitalization of only first word
		$content = ucfirst($content);
		return $content;
	break;
	case 'words':
		//Capitalization of all words
		$content = ucwords($content);
		return $content;
	break;
	case 'wordsexceptarticle':
		//Capitalization of all words, except for internal articles and prepositions
		$contentfrag = explode(" ", $content);
		$exceptions = array('with', 'the', 'a', 'an', 'of', 'to', 'in', 'for', 'on');
		foreach($contentfrag as $key => $value) {
			$ev = (string) array_search($value, $exceptions);
			if ($ev == '') {
				$contentfrag[$key] = ucwords($value);
			} else {
				$contentfrag[$key] = $value;
			}
		}
		$contentfinal = implode(" ", $contentfrag);
		return ucfirst($contentfinal);
	break;
	case 'wordsexceptofbe':
		//Capitalization of all words, except for internal articles, prepositions and forms of to and be
		$contentfrag = explode(" ", $content);
		$exceptions = array('of', 'to', 'in', 'for', 'on', 'is', 'are', 'were', 'be', 'have', 'has', 'been', 'with', 'the', 'a', 'an');
		foreach($contentfrag as $key => $value) {
			$ev = (string) array_search($value, $exceptions);
			if ($ev == '') {
				$contentfrag[$key] = ucwords($value);
			} else {
				$contentfrag[$key] = $value;
			}
		}
		$contentfinal = implode(" ", $contentfrag);
		return ucfirst($contentfinal);
	break;
	case 'wordsexceptclosedclass':
		//Capitalization of all words, except for internal closed-class words
		$contentfrag = explode(" ", $content);
		$exceptions = array('of', 'to', 'in', 'for', 'on', 'is', 'are', 'were', 'be', 'have', 'has', 'been', 'with', 'the', 'a', 'an', 'some', 'all', 'which', 'that', 'my', 'her', 'she', 'you', 'this', 'these', 'those', 'its', 'their', 'your', 'whose');
		foreach($contentfrag as $key => $value) {
			$ev = (string) array_search($value, $exceptions);
			if ($ev == '') {
				$contentfrag[$key] = ucwords($value);
			} else {
				$contentfrag[$key] = $value;
			}
		}
		$contentfinal = implode(" ", $contentfrag);
		return ucfirst($contentfinal);
	break;
}
}

//Runs the plugin
add_action('admin_menu', 'CapTitle_options');

add_filter('the_title', 'CapitalizeTitle');
?>