<?php
/*
Plugin Name: Program Form
Plugin URI:  http://www.github.com/kgudger/
Description: Program form for producers to create WP pages for shows
Version:     1.0
Author:      Keith Gudger
Author URI:  http://www.github.com/kgudger
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) or die( 'Ah ah ah, you didn\'t say the magic word' );

add_shortcode('programform', 'program_form');

function program_form() {
/**
 * dbstart.php opens the database and gets the user variables
 */
require_once("/var/www/html/includes/dbstart.php");

include_once("includes/programformpage.php");

/**
 * The checkArray defines what checkForm does so you don't
 * have to overwrite it in the derived class. */

$checkArray = array();
//	array("isEmpty","showid", "Please enter a valid show id."));
/// a new instance of the derived class (from MainPage)
$pform = new pFormPage($db,$sessvar,$checkArray) ;
/// and ... start it up!  
return $pform->main("Please enter data for Programmers Page.", $uid, "", "");
/**
 * There are 2 choices for redirection dependent on the sessvar
 * above which one gets taken.
 * For this page ... */
}
