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
  $sql = "SELECT post_title FROM `wp_posts` 
		WHERE post_type = 'pt_view'";
  $result = $this->db->query($sql);
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $temp = $row['post_title'];
    $temp_split = explode(' [ID: ',$temp); // 0 is name, 1 is ID
    $temp_split[1] = substr($temp_split[1], 0, -1); // removes ']' from ID
    $blog_id[$temp_split[0]] = $temp_split[1];
  }
	echo $this->formL->reportErrors();
	echo $this->formL->start('POST', "", 'name="programform"');
?>
<fieldset>
<legend>Please the show name and RSS feed name (if exists).</legend
<br>
<?php
// makeNumberInput($name,$min="",$max="", $value="",$other="")
  echo $this->formL->makeSelect('showid',$show_list,"");
  echo $this->formL->formatOnError('showid','Show Name: ') . "<br>" ;
  echo $this->formL->makeSelect('rssfeed',$rss_feed,"");
  echo $this->formL->formatOnError('rssfeed','Show Rss Feed: ') . "<br>";
  echo $this->formL->makeSelect('showblog',$blog_id,"");
  echo $this->formL->formatOnError('showblog','Show Blog: ') . "<br>";?>
<input class="subbutton" type="submit" name="Submit" value="Submit">
</fieldset>
</form>
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
$show_type    = $show_info_array['category'];
$show_title   = $show_info_array['title'];
//echo "ID is " . $show_blog_id;
// need host "bio" and "image"
$pagedata = <<<EOT
[et_pb_row _builder_version="3.22.3" background_size="initial" background_position="top_left" background_repeat="repeat"]
[et_pb_column type="2_5" _builder_version="3.0.47"][et_pb_image src="$show_logo" _builder_version="3.22.1"][/et_pb_image]
[et_pb_text _builder_version="3.22.1"]<h3>Podcasts/Show Archives</h3>
<a href="https://ksqd.org/feed/podcast/$rss_feed_url">$show_title - Podcast RSS Feed</a>[/et_pb_text]
[/et_pb_column]
[et_pb_column type="3_5" _builder_version="3.0.47"][et_pb_testimonial _builder_version="3.15"]$show_descrip [/et_pb_testimonial]
[et_pb_text _builder_version="3.22.1"]<p>Hosted by <strong>$show_host</strong></p>
<p>Show Type: $show_type</p>[/et_pb_text][/et_pb_column][/et_pb_row]
<hr />
[et_pb_row _builder_version="3.22.4"][et_pb_column type="4_4" _builder_version="3.22.4"][et_pb_code _builder_version="3.22.4"]<iframe width="800" height="800" src="https://widgets.spinitron.com/KSQD/show/$show_id_no"></iframe>[/et_pb_code][/et_pb_column][/et_pb_row]
[et_pb_row _builder_version="3.22.4"][et_pb_column type="4_4" _builder_version="3.22.4"]
[et_pb_text _builder_version="3.19.14"]<h2>Blog Posts/Show Updates</h2>
[/et_pb_text][et_pb_code _builder_version="3.19.14"][pt_view id="$show_blog_id"][/et_pb_code][/et_pb_column][/et_pb_row]
[et_pb_row _builder_version="3.22.4"][et_pb_column type="4_4" _builder_version="3.22.4"]
[et_pb_image src="$host_logo" _builder_version="3.22.1"][/et_pb_image]
[et_pb_text _builder_version="3.19.14"]<h2>$show_host</h2>$host_bio
[/et_pb_text]
[/et_pb_column][/et_pb_row]
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
