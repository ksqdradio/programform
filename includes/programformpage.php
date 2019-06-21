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
  $show_list = $this->get_shows(200);
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
/*  $sql = "SELECT post_title FROM `wp_posts` 
		WHERE post_type = 'pt_view'";
  $result = $this->db->query($sql);
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $temp = $row['post_title'];
    $temp_split = explode(' [ID: ',$temp); // 0 is name, 1 is ID
    $temp_split[1] = substr($temp_split[1], 0, -1); // removes ']' from ID
    $blog_id[$temp_split[0]] = $temp_split[1];
  }*/
  $blog_cats = array();
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
// makeNumberInput($name,$min="",$max="", $value="",$other="")
  echo $this->formL->formatOnError('showid','Please select the show name') . "<br>" ;
  echo $this->formL->makeSelect('showid',$show_list,"") . "<br><br>";
  echo $this->formL->formatOnError('showblog','Please Select the Blog Category Name') . "<br>";
  echo $this->formL->makeSelect('showblog',$blog_cats,"") . "<br><br>";
  echo "Select this box if this is a talk show with an RSS feed: ";
  echo $this->formL->makeCheckBoxes('rss_yes', array("RSS"=>"y")) . "<br>";
  echo $this->formL->formatOnError('rssfeed','Please Select the Show Rss Feed') . "<br>";
  echo $this->formL->makeSelect('rssfeed',$rss_feed,"") . "<br><br>";
  echo "Select this box if this is a music show with a Radio Free America link: ";
  echo $this->formL->makeCheckBoxes('rfa_yes', array("RFA"=>"y")) . "<br>";
  echo $this->formL->formatOnError('rfa_link','Please Select the Show Radio Free America Link') . "<br>";
  echo $this->formL->makeSelect('rfa_link',array("None"=>""),"") . "<br><br>";
?>
<input class="subbutton" type="submit" name="Submit" value="Submit">
</fieldset>
</form><br>
<?php
$this->formL->finish();
$show_id_no      = $uid['show_id'];
$show_info_array = $this->get_playlist($show_id_no);
$personaData     = $this->get_persona($show_info_array['persona']);
$show_logo       = $show_info_array['showlogo'];
$rss_feed_url = $uid['rss_feed'];
$rss_feed_name = array_search($rss_feed_url, $rss_feed); // find name for slug
$show_blog_id = $uid['show_blog']; // ID
$show_descrip = $show_info_array['description'];
$show_descrip = strip_tags(html_entity_decode($show_descrip));
$show_host    = $personaData['name'];
$host_bio     = $personaData['bio'];
$host_bio     = strip_tags(html_entity_decode($host_bio));
$host_logo    = $personaData['image'];
$host_email   = $personaData['email'];
$show_type    = $show_info_array['category'];
$show_title   = $show_info_array['title'];
$show_cat     = 236;
//echo "ID is " . $show_blog_id;
// need host "bio" and "image"
$pagedata = <<<EOT
[et_pb_section bb_built="1" inner_width="auto" inner_max_width="none" _builder_version="3.24.1"]
[et_pb_row _builder_version="3.24.1"]
[et_pb_column type="2_3"]
[et_pb_testimonial _builder_version="3.24.1" quote_icon_background_color="#f5f5f5" ]
$show_descrip
[/et_pb_testimonial]
[et_pb_blog _builder_version="3.24.1" posts_number="4" include_categories=$show_blog_id show_categories="off"  show_thumbnail="off" show_comments="on" fullwidth="off" excerpt_length="200" /]
[et_pb_code admin_label="Recent Playlists Code" _builder_version="3.24.1" z_index_tablet="500"]
[wspin action="playing" count="5" show_id=$show_id_no]
[/et_pb_code]
[et_pb_code admin_label="View All Playlists Code" _builder_version="3.24.1" z_index_tablet="500"]
<a href="https://ksqd.org/category/program/state-of-mind/">More</a>
[/et_pb_code]
[/et_pb_column]
[et_pb_column type="1_3"]
[et_pb_image src="$show_logo" _builder_version="3.22.1"][/et_pb_image]
[et_pb_code _builder_version="3.24.1" z_index_tablet="500"]
<h3>Airs</h3><!-- [et_pb_line_break_holder] -->[wspin action="upnext" count="5" show_id =$show_id_no]
[/et_pb_code]
[et_pb_code admin_label="Air Time Code" _builder_version="3.24.1" z_index_tablet="500"]
<h2>Next Show</h2><!-- [et_pb_line_break_holder] -->[wspin action="upnext" count="5" show_id =$show_id_no]
[/et_pb_code]
[et_pb_text _builder_version="3.19.14"]<h2>Hosted by $show_host</h2>
<a onclick = "cook_email()" href="https://ksqd.org/host-contact-form/" target="_blank">Click here to contact $show_host</a>
[/et_pb_text]
[et_pb_text _builder_version="3.19.14"]<h2>$show_host</h2>$host_bio
[/et_pb_text]
[/et_pb_column][/et_pb_row][/et_pb_section]
<script type="text/javascript">
    function cook_email(){ document.cookie = "host_email=$host_email;path=/"; }
</script>
EOT;
if (!empty($uid['show_id'])) 
	echo $pagedata; // which works?
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
}

?>
