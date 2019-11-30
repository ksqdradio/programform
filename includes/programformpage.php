<?php
/**
* @file programformpage.php
* Purpose: setup programmer pages
* Extends MainPage Class
*
* @author Keith Gudger
* @copyright  (c) 2019, Keith Gudger, all rights reserved
* @license    http://opensource.org/licenses/BSD-2-Clause
* @version    Release: 1.0
* @package    KSQD
*
* @note Has processData and showContent, 
* main and checkForm in MainPage class not overwritten.
* 
*/
/* /var/www/html/wp-content/plugins/programform/includes */
require_once("/var/www/html/wp-content/plugins/programform/includes/mainpage.php");
include_once "/var/www/html/includes/util.php";

/**
 * Child class of MainPage used for user preferrences page.
 *
 * Implements processData and showContent
 */

class pFormPage extends MainPage {

/**
 * Process the data and insert / modify database.
 *
 * @param $uid is user id passed by reference.
 */
function processData(&$uid) {
  $uid = array();
  $uid['show_id'] = $this->formL->getValue("showid");
  $uid['rss_feed'] = $this->formL->getValue("rssfeed");
  $uid['show_blog'] = $this->formL->getValue("showblog");
    // Process the verified data here.

$show_id_no      = $this->formL->getValue("showid");
$show_info_array = $this->get_show_by_id($show_id_no);
$personaData = array();
foreach ($show_info_array['persona'] as $persnum) {
	array_push($personaData, $this->get_persona($persnum)); // array now
}
$show_logo       = $show_info_array['image'];
$rss_feed_url = $this->formL->getValue("rssfeed");
$rss_feed_name = array_search($rss_feed_url, $rss_feed); // find name for slug
$show_blog_id = $this->formL->getValue("showblog"); // ID
$show_descrip = $show_info_array['descrip'];
$show_descrip = strip_tags(html_entity_decode($show_descrip));
// deal with array of personas
$show_host = array();
$host_bio  = array();
$host_logo = array();
foreach ($personaData as $pdata) {
	array_push($show_host, $pdata['name']);
	$host_b     = strip_tags(html_entity_decode($pdata['bio']));
	array_push($host_bio, $host_b);
	array_push($host_logo, $pdata['image']);
}
$host_email   = $personaData[0]['email'];
$show_type    = $show_info_array['category'];
$show_title      = $show_info_array['title'];
$pagedata = <<<EOT
[et_pb_section bb_built="1" inner_width="auto" inner_max_width="none" _builder_version="3.24.1"]
[et_pb_row][et_pb_column type="4_4" custom_padding__hover="|||" custom_padding="|||"]
[et_pb_text _builder_version="3.24.1" text_text_align="center" text_text_shadow_horizontal_length="text_text_shadow_style,%91object Object%93" text_text_shadow_horizontal_length_tablet="0px" text_text_shadow_vertical_length="text_text_shadow_style,%91object Object%93" text_text_shadow_vertical_length_tablet="0px" text_text_shadow_blur_strength="text_text_shadow_style,%91object Object%93" text_text_shadow_blur_strength_tablet="1px" link_text_shadow_horizontal_length="link_text_shadow_style,%91object Object%93" link_text_shadow_horizontal_length_tablet="0px" link_text_shadow_vertical_length="link_text_shadow_style,%91object Object%93" link_text_shadow_vertical_length_tablet="0px" link_text_shadow_blur_strength="link_text_shadow_style,%91object Object%93" link_text_shadow_blur_strength_tablet="1px" ul_text_shadow_horizontal_length="ul_text_shadow_style,%91object Object%93" ul_text_shadow_horizontal_length_tablet="0px" ul_text_shadow_vertical_length="ul_text_shadow_style,%91object Object%93" ul_text_shadow_vertical_length_tablet="0px" ul_text_shadow_blur_strength="ul_text_shadow_style,%91object Object%93" ul_text_shadow_blur_strength_tablet="1px" ol_text_shadow_horizontal_length="ol_text_shadow_style,%91object Object%93" ol_text_shadow_horizontal_length_tablet="0px" ol_text_shadow_vertical_length="ol_text_shadow_style,%91object Object%93" ol_text_shadow_vertical_length_tablet="0px" ol_text_shadow_blur_strength="ol_text_shadow_style,%91object Object%93" ol_text_shadow_blur_strength_tablet="1px" quote_text_shadow_horizontal_length="quote_text_shadow_style,%91object Object%93" quote_text_shadow_horizontal_length_tablet="0px" quote_text_shadow_vertical_length="quote_text_shadow_style,%91object Object%93" quote_text_shadow_vertical_length_tablet="0px" quote_text_shadow_blur_strength="quote_text_shadow_style,%91object Object%93" quote_text_shadow_blur_strength_tablet="1px" header_text_shadow_horizontal_length="header_text_shadow_style,%91object Object%93" header_text_shadow_horizontal_length_tablet="0px" header_text_shadow_vertical_length="header_text_shadow_style,%91object Object%93" header_text_shadow_vertical_length_tablet="0px" header_text_shadow_blur_strength="header_text_shadow_style,%91object Object%93" header_text_shadow_blur_strength_tablet="1px" header_2_text_shadow_horizontal_length="header_2_text_shadow_style,%91object Object%93" header_2_text_shadow_horizontal_length_tablet="0px" header_2_text_shadow_vertical_length="header_2_text_shadow_style,%91object Object%93" header_2_text_shadow_vertical_length_tablet="0px" header_2_text_shadow_blur_strength="header_2_text_shadow_style,%91object Object%93" header_2_text_shadow_blur_strength_tablet="1px" header_3_text_shadow_horizontal_length="header_3_text_shadow_style,%91object Object%93" header_3_text_shadow_horizontal_length_tablet="0px" header_3_text_shadow_vertical_length="header_3_text_shadow_style,%91object Object%93" header_3_text_shadow_vertical_length_tablet="0px" header_3_text_shadow_blur_strength="header_3_text_shadow_style,%91object Object%93" header_3_text_shadow_blur_strength_tablet="1px" header_4_text_shadow_horizontal_length="header_4_text_shadow_style,%91object Object%93" header_4_text_shadow_horizontal_length_tablet="0px" header_4_text_shadow_vertical_length="header_4_text_shadow_style,%91object Object%93" header_4_text_shadow_vertical_length_tablet="0px" header_4_text_shadow_blur_strength="header_4_text_shadow_style,%91object Object%93" header_4_text_shadow_blur_strength_tablet="1px" header_5_text_shadow_horizontal_length="header_5_text_shadow_style,%91object Object%93" header_5_text_shadow_horizontal_length_tablet="0px" header_5_text_shadow_vertical_length="header_5_text_shadow_style,%91object Object%93" header_5_text_shadow_vertical_length_tablet="0px" header_5_text_shadow_blur_strength="header_5_text_shadow_style,%91object Object%93" header_5_text_shadow_blur_strength_tablet="1px" header_6_text_shadow_horizontal_length="header_6_text_shadow_style,%91object Object%93" header_6_text_shadow_horizontal_length_tablet="0px" header_6_text_shadow_vertical_length="header_6_text_shadow_style,%91object Object%93" header_6_text_shadow_vertical_length_tablet="0px" header_6_text_shadow_blur_strength="header_6_text_shadow_style,%91object Object%93" header_6_text_shadow_blur_strength_tablet="1px" box_shadow_horizontal_tablet="0px" box_shadow_vertical_tablet="0px" box_shadow_blur_tablet="40px" box_shadow_spread_tablet="0px" text_font_size="28px" text_letter_spacing="1px" text_font="|700|on||||||"]
<p>$show_title</p>
[/et_pb_text]
[/et_pb_column]
[/et_pb_row]
[et_pb_row _builder_version="3.24.1"]
[et_pb_column type="2_3" custom_padding__hover="|||" custom_padding="|||"]
[et_pb_blurb admin_label="Description Blurb" _builder_version="3.24.1" box_shadow_vertical_image_tablet="0px" box_shadow_blur_image_tablet="40px" text_shadow_horizontal_length="text_shadow_style,%91object Object%93" text_shadow_horizontal_length_tablet="0px" text_shadow_vertical_length="text_shadow_style,%91object Object%93" text_shadow_vertical_length_tablet="0px" text_shadow_blur_strength="text_shadow_style,%91object Object%93" text_shadow_blur_strength_tablet="1px" header_text_shadow_horizontal_length="header_text_shadow_style,%91object Object%93" header_text_shadow_horizontal_length_tablet="0px" header_text_shadow_vertical_length="header_text_shadow_style,%91object Object%93" header_text_shadow_vertical_length_tablet="0px" header_text_shadow_blur_strength="header_text_shadow_style,%91object Object%93" header_text_shadow_blur_strength_tablet="1px" body_text_shadow_horizontal_length="body_text_shadow_style,%91object Object%93" body_text_shadow_horizontal_length_tablet="0px" body_text_shadow_vertical_length="body_text_shadow_style,%91object Object%93" body_text_shadow_vertical_length_tablet="0px" body_text_shadow_blur_strength="body_text_shadow_style,%91object Object%93" body_text_shadow_blur_strength_tablet="1px" body_link_text_shadow_horizontal_length="body_link_text_shadow_style,%91object Object%93" body_link_text_shadow_horizontal_length_tablet="0px" body_link_text_shadow_vertical_length="body_link_text_shadow_style,%91object Object%93" body_link_text_shadow_vertical_length_tablet="0px" body_link_text_shadow_blur_strength="body_link_text_shadow_style,%91object Object%93" body_link_text_shadow_blur_strength_tablet="1px" body_ul_text_shadow_horizontal_length="body_ul_text_shadow_style,%91object Object%93" body_ul_text_shadow_horizontal_length_tablet="0px" body_ul_text_shadow_vertical_length="body_ul_text_shadow_style,%91object Object%93" body_ul_text_shadow_vertical_length_tablet="0px" body_ul_text_shadow_blur_strength="body_ul_text_shadow_style,%91object Object%93" body_ul_text_shadow_blur_strength_tablet="1px" body_ol_text_shadow_horizontal_length="body_ol_text_shadow_style,%91object Object%93" body_ol_text_shadow_horizontal_length_tablet="0px" body_ol_text_shadow_vertical_length="body_ol_text_shadow_style,%91object Object%93" body_ol_text_shadow_vertical_length_tablet="0px" body_ol_text_shadow_blur_strength="body_ol_text_shadow_style,%91object Object%93" body_ol_text_shadow_blur_strength_tablet="1px" body_quote_text_shadow_horizontal_length="body_quote_text_shadow_style,%91object Object%93" body_quote_text_shadow_horizontal_length_tablet="0px" body_quote_text_shadow_vertical_length="body_quote_text_shadow_style,%91object Object%93" body_quote_text_shadow_vertical_length_tablet="0px" body_quote_text_shadow_blur_strength="body_quote_text_shadow_style,%91object Object%93" body_quote_text_shadow_blur_strength_tablet="1px" box_shadow_vertical_tablet="0px" box_shadow_blur_tablet="40px" z_index_tablet="500" background_color="#00c0b5" border_radii_image="on|0px|0px|0px|0px" box_shadow_color_image="rgba(0,0,0,0.64)" border_radii="on|10px|10px|10px|10px" box_shadow_style="preset1" box_shadow_horizontal_image_tablet="0px" box_shadow_spread_image_tablet="0px" custom_padding="10px||10px|"]
<p style="color:black">$show_descrip</p>
[/et_pb_blurb]
[et_pb_blog _builder_version="3.24.1" posts_number="4" include_categories=$show_blog_id show_categories="off" fullwidth="off" excerpt_length="200" show_excerpt="off" /]
[et_pb_code admin_label="Recent Playlists Code" _builder_version="3.24.1" z_index_tablet="500"]
<div id="spinlist"><h3>PLAYLISTS (BY DATE)</h3></div>
[/et_pb_code]
[/et_pb_column]
[et_pb_column type="1_3"]
[et_pb_code _builder_version="3.24.1" z_index_tablet="500"]
<div id="spinairs"><h3>AIRS</h3></div>
[/et_pb_code]
[et_pb_code admin_label="Air Time Code" _builder_version="3.24.1" z_index_tablet="500"]
<h3>NEXT SHOW</h3><!-- [et_pb_line_break_holder] -->[wspin action="upnext" count="5" show_id =$show_id_no]
[/et_pb_code]
[et_pb_text _builder_version="3.19.14"]<h3>HOSTED BY</h3>
EOT;
foreach ($show_host as $host_name) {
	$pagedata .= $host_name . "<br>";
}
foreach ( $show_host as $index => $hname ) {
	$pagedata .= "<a onclick = 'cook_email(\"" . $host_email[$index] . "\")' href='https://ksqd.org/host-contact-form/' target='_blank'>Click here to contact $hname</a><br>";
}
$pagedata .= "[/et_pb_text]";
if (!empty($rss_feed_url)) {
	$pagedata.= <<<EOT
[et_pb_text _builder_version="3.19.14"]<h3>PODCASTS/SHOW ARCHIVES</h3>
<a href=https://ksqd.org/feed/podcast/$rss_feed_url target="_blank">$show_title - Podcast RSS Feed</a>
[/et_pb_text]
EOT;
}
foreach( $host_logo as $index => $logo ) {
	$pagedata .= "[et_pb_image src='$logo' _builder_version='3.22.1'][/et_pb_image]";
	$pagedata .= "[et_pb_text _builder_version='3.19.14']";
	$pagedata .= "<h4>$show_host[$index]</h4>$host_bio[$index]";
	$pagedata .= "[/et_pb_text]";
}
$pagedata.= <<<EOT
[et_pb_code _builder_version="4.0.6" hover_enabled="0"]
<script src="https://ksqd.org/spinscrape.js"></script>
<script type="text/javascript">
    function cook_email(hemail){ document.cookie = "host_email=" + hemail + ";path=/"; }
//	Ready($show_id_no);
</script>
[/et_pb_code][/et_pb_column][/et_pb_row][/et_pb_section]
EOT;
// end of pagedata, insert into wp_posts
/*comment_status - closed
ping_status - closed
post_name - the-post-title
post_parent - 0
guid - https://ksqd.org/?page_id=5940 (ID)
post_type - page */

// datetime - YYYY-MM-DD HH:MI:SS
$tdate = date('Y-m-d G:i:s');
$postname = strtolower($show_title);
$postname = str_replace(' ', '-', $postname); // replaces space with dash
$sql = 	"INSERT INTO 
				wp_posts(post_author, post_date, post_date_gmt,
				post_modified, post_modified_gmt, post_content, post_title,
				comment_status, ping_status, post_name,
				post_parent, post_type, post_excerpt, to_ping, pinged,
				post_content_filtered) 
				VALUES ( 19, ?, ?, ?, ?, ?, ?, 'closed', 'closed', ?, 0, 'page', 
				'', '', '', '')";
$result = $this->db->prepare($sql);
$result->execute(array($tdate, $tdate, $tdate, $tdate, $pagedata,$show_title,$postname));
$vid = $this->db->lastInsertId(); // should be last inserted VID
$guid = "https://ksqd/?page_id=$vid";
$sql = 	"UPDATE wp_posts 
			SET guid = '$guid'
			WHERE ID = $vid";
$result = $this->db->prepare($sql);
$result->execute(array());

// now enter data into wp_postmeta
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ?, '_wp_page_template default', '')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ?, '_et_pb_use_builder', 'on')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ?, '_et_builder_version', 'BB|Divi|3.24.1')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ?, '_et_pb_ab_stats_refresh_interval', 'hourly')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ?, '_et_pb_old_content', '')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ?, '_et_pb_enable_shortcode_tracking', '')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ?, '_et_pb_custom_css', '')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ? , '_et_pb_gutter_width', '3')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ? , '_extra_sidebar_location', 'none')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ? , '_extra_sidebar', '')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));
$sql = 	"INSERT INTO
			wp_postmeta(post_id, meta_key, meta_value)
			VALUES ( ? , '_post_extra_title_meta_hide_single', '1')";
$result = $this->db->prepare($sql);
$result->execute(array($vid));

}

/**
 * Display the content of the page.
 *
 * @param $title is page title.
 * @param $uid is user id passed by reference.
 */
function showContent($title, &$uid) {

// Put HTML after the closing PHP tag
?>
<div class="preamble" id="KSQD-preamble" role="article">
<?php
  $show_list = array();
  $show_list['None'] = '';
  $show_list = array_merge($show_list, $this->get_shows(200));
  $rss_feed  = array();
  $rss_feed['None'] = '';
  $sql = "SELECT wp_terms.name, wp_terms.slug 
		FROM wp_terms,wp_term_taxonomy 
		WHERE wp_term_taxonomy.taxonomy = 'series' 
		AND wp_term_taxonomy.term_taxonomy_id = wp_terms.term_id";
  $result = $this->db->query($sql);
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $rss_feed[$row["name"]] = $row["slug"];
  }

  $blog_id = array();
  $blog_id['None'] = '';
  $blog_cats = array();
  $blog_cats['None'] = '';
  $sql = "SELECT parent, name, slug, wp_terms.term_id 
			FROM `wp_term_taxonomy`, `wp_terms` 
			WHERE wp_term_taxonomy.taxonomy = 'category'
			AND wp_term_taxonomy.term_id = wp_terms.term_id";
  $result = $this->db->query($sql);
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//    $blog_cats[$row['name']] = $row['slug'];
    $blog_cats[$row['name']] = $row['term_id'];
  }
  
	echo $this->formL->reportErrors();
	echo $this->formL->start('POST', "", 'name="programform"');
?>
<fieldset>
<legend>Please select the program name from the lists below.</legend>
<?php
$RFA_list = array("None" => "",
"Kitchen Sisters Present/PRX Remix Select" => "http://www.kitchensisters.org/present/",
"Laura Flanders" => "http://www.lauraflanders.com/",
"Counterspin" => "https://fair.org/counterspin/",
"New Dimensions" => "https://newdimensions.org/",
"On Being" => "https://onbeing.org/series/podcast/",
"Ralph Nader" => "https://ralphnaderradiohour.com/",
"Alternative Radio" => "https://www.alternativeradio.org/",
"Democracy Now" => "https://www.democracynow.org/",
"California Report" => "https://www.kqed.org/news/program/the-california-report",
"Cephalotron" => "https://www.radiofreeamerica.com/show/cephalotron-1-k-squid",
"The Cutting Edge" => "https://www.radiofreeamerica.com/show/the-cutting-edge-k-squid",
"The Hive" => "https://www.radiofreeamerica.com/show/the-hive-k-squid",
"Up Like 7!" => "https://www.radiofreeamerica.com/show/up-like-7-1-k-squid",
"Making Contact" => "https://www.radioproject.org/",
"Economic Update" => "https://www.rdwolff.com/",
"Reveal Weekly" => "https://www.revealnews.org");

// makeNumberInput($name,$min="",$max="", $value="",$other="")
  echo $this->formL->formatOnError('showid','Please select the show name') . "<br>" ;
  echo $this->formL->makeSelect('showid',$show_list,"") . "<br><br>";
  echo $this->formL->formatOnError('showblog','Please Select the Blog Category Name') . "<br>";
  echo $this->formL->makeSelect('showblog',$blog_cats,"") . "<br><br>";
  echo "Select this box if this is a talk show with an RSS feed: ";
  echo $this->formL->makeCheckBoxes('rss_yes', array("RSS"=>"y")) . "<br>";
  echo $this->formL->formatOnError('rssfeed','Please Select the Show Rss Feed') . "<br>";
  echo $this->formL->makeSelect('rssfeed',$rss_feed,"") . "<br><br>";
/*  echo "Select this box if this is a music show with a Radio Free America link: ";
  echo $this->formL->makeCheckBoxes('rfa_yes', array("RFA"=>"y")) . "<br>";
  echo $this->formL->formatOnError('rfa_link','Please Select the Show Radio Free America Link') . "<br>";
  echo $this->formL->makeSelect('rfa_link',$RFA_list,"") . "<br><br>"; */
?>
<input class="subbutton" type="submit" name="Submit" value="Submit">
</fieldset>
</form><br>
<?php
$this->formL->finish();
$show_id_no      = $uid['show_id'];
$show_info_array = $this->get_show_by_id($show_id_no);
$show_title   = $show_info_array['title'];
/*
$personaData     = $this->get_persona($show_info_array['persona']);
$show_logo       = $show_info_array['image'];
$rss_feed_url = $uid['rss_feed'];
$rss_feed_name = array_search($rss_feed_url, $rss_feed); // find name for slug
$show_blog_id = $uid['show_blog']; // ID
$show_descrip = $show_info_array['descrip'];
$show_descrip = strip_tags(html_entity_decode($show_descrip));
$show_host    = $personaData['name'];
$host_bio     = $personaData['bio'];
$host_bio     = strip_tags(html_entity_decode($host_bio));
$host_logo    = $personaData['image'];
$host_email   = $personaData['email'];
$show_type    = $show_info_array['category'];
$show_cat     = 236;

print_r($show_info_array);
echo "<br>Show ID is " . $show_id_no . "<br>";
echo "Blog ID is " . $show_blog_id . "<br>";
*/
// need host "bio" and "image"
$postname = strtolower($show_title);
$postname = str_replace(' ', '-', $postname); // replaces space with dash
if (!empty($postname)) {
	$pagedata = "The new page is here:<br>";
	$pagedata .= "<a href = 'https://ksqd.org/" . $postname . "'>https://ksqd.org/$postname</a>";
} else $pagedata = "";

return $pagedata;
}
// functions to return needed info from Spinitron

    /**
     * Request resources from an endpoint using search parameters.
     *
     * @see https://spinitron.github.io/v2api for search parameters
     *
     * @param string $endpoint e.g. 'spins', 'shows' ...
     * @param array $params e.g. ['playlist_id' => 1234, 'page' => 2]
     * @return array Response with an array of resources of the endpoint's type plus metadata
     * @throws \Exception
     */
function spin_search($endpoint, $params)
{
   $url = '/' . $endpoint;
   if (!empty($params)) {
       $url .= '?' . http_build_query($params);
   }
   return json_decode($this->spin_query($endpoint, $url), true);
}

    /**
     * Query the API with the given URL, returning the response JSON document
     * from the API.
     *
     * @param string $endpoint e.g. 'spins', 'shows' ...
     * @param string $url
     * @return string JSON document
     * @throws \Exception
     */
function spin_query($endpoint, $url)
{
// Request resource from the API.
    $context = stream_context_create([
        'http' => [
            'user_agent' => 'Mozilla/5.0 Spinitron v2 API demo client',
            'header' => 'Authorization: Bearer ' . $this->spin_api_key,
        ],
    ]);
    
    $fullUrl = $this->apiBaseUrl . $url;

    $stream = fopen($fullUrl, 'rb', false, $context);
    if ($stream === false) {
        throw new Exception('Error opening stream for ' . $fullUrl);
    }

    $response = stream_get_contents($stream);
    if ($response === false) {
        throw new Exception('Error requesting ' . $fullUrl . ': ' . var_export(stream_get_meta_data($stream), true));
    }

    return $response;
}

/**
 * get playlist for show
 * @param $show_id is show id
 */
function get_playlist($show_id) {
	$params = array('show_id'=>$show_id); // array for show id
	$play_array = $this->spin_search('playlist', $params);
	$play_items = $play_array['items'][0]; // most recent 1 items
	
	$play_data = array();
	$play_data['showlogo']  = htmlspecialchars($play_items['image'], ENT_NOQUOTES);
	$play_data['title']     = htmlspecialchars($play_items['title'], ENT_NOQUOTES);
	$play_data['persona']   = htmlspecialchars($play_items['persona_id'], ENT_NOQUOTES);
	$play_data['category']  = htmlspecialchars($play_items['category'], ENT_NOQUOTES);

	$playlist = htmlspecialchars($play_items['_links']['spins']['href'], ENT_NOQUOTES);
//	echo "Playlist is . $playlist";
	if (!empty($playlist)) { // playlist_id=8860074&
		$playlist_pos = strpos($playlist,'playlist_id');
		$play_2       = strpos($playlist,'=') + 1; // start of number
		$playlist     = substr($playlist, $play_2);
		$play_data['playlist']  = $playlist;
	} else {
		$play_data['playlist'] = "" ;
	}
	$play_data['description']  = htmlspecialchars($play_items['description'], ENT_NOQUOTES);

	return $play_data;
}

/**
 * get shows
 * @param $count is minimum to return
 */
function get_shows($count=100) {
	$params = array('count'=>$count); // array for show id
	$shows_array = $this->spin_search('shows', $params);
	$shows_data = array();
	
	foreach ($shows_array['items'] as $item) {
		$shows_data[$item['title']] = $item['id'];
	}
	return $shows_data;
}

/**
 * get persona info
 * @param $persona_id is persona id
 */
function get_persona($persona_id) {
	$params = array(); // array not needed
	$persona_array = $this->spin_search('personas/'.$persona_id, $params);
	
	$persona_data = array();
	$persona_data['name']    = htmlspecialchars($persona_array['name'], ENT_NOQUOTES);
	$persona_data['email']   = htmlspecialchars($persona_array['email'], ENT_NOQUOTES);
	$persona_data['website'] = htmlspecialchars($persona_array['website'], ENT_NOQUOTES);
	$persona_data['image']   = htmlspecialchars($persona_array['image'], ENT_NOQUOTES);
	$persona_data['bio']     = htmlspecialchars($persona_array['bio'], ENT_NOQUOTES);

	return $persona_data;
}

/**
 * get show info
 * @param $persona_id is persona id
 */
function get_show_by_id($show_id) {
	$params = array(); // array for show id
	$shows_array = $this->spin_search("shows/$show_id", $params); // get data for 1 show

	$shows_data = array();
	$shows_data['start']    = htmlspecialchars($shows_array['start'], ENT_NOQUOTES);
	$shows_data['end']      = htmlspecialchars($shows_array['end'], ENT_NOQUOTES);
	$shows_data['category'] = htmlspecialchars($shows_array['category'], ENT_NOQUOTES);
	$shows_data['title']    = htmlspecialchars($shows_array['title'], ENT_NOQUOTES);
	$shows_data['descrip']  = htmlspecialchars($shows_array['description'], ENT_NOQUOTES);
	$shows_data['image']    = htmlspecialchars($shows_array['image'], ENT_NOQUOTES);
	$shows_data['url']      = htmlspecialchars($shows_array['url'], ENT_NOQUOTES);
	$pers_data = array();
	foreach ($shows_array['_links']['personas'] as $pers) {
		$tpers = htmlspecialchars($pers['href'],ENT_NOQUOTES);
		$show_parse = parse_url($tpers, PHP_URL_PATH);
		$tpers  = explode("/",$show_parse);
		$tpers  = end($tpers);
		array_push($pers_data,$tpers);
	}
	$shows_data['persona'] = $pers_data;
/*	$shows_data['persona']  = htmlspecialchars($shows_array['_links']['personas'][0]['href'], ENT_NOQUOTES);
	$show_parse = parse_url($shows_data['persona'], PHP_URL_PATH);
	$shows_data['persona']  = explode("/",$show_parse);
	$shows_data['persona']  = end($shows_data['persona']);
*/
	return $shows_data;
}
}

?>
