<?php
  include('simple_html_dom.php');
  $debug = false;
  header('Content-type: application/json');
  header('Access-Control-Allow-Origin: *');

  // get the command
  $show_id = $_REQUEST['show_id'];
  $dj_id = $_REQUEST['dj_number'];
  if (!empty($show_id)) 
	echo scrape($show_id,$dj_id);
  else
	echo "";

function scrape($show_id, $dj_id) {
	$html = file_get_html("https://widgets.spinitron.com/KSQD/show/$show_id/");
	$i = 0;
	$output = array();
	foreach($html->find('ul[class="timeslot show-schedule"]') as $element) {
		foreach($element->find('li') as $li) {
			$ptext = $li->plaintext;
			$output['airs'][$i] = $ptext;
			$i++;
		}
	}
	$j = 0 ;/*
	foreach ($html->find('div[id="playlist-grid"]') as $div) {
		foreach($div->find('td[class="datetime playlist"]') as $tdata) {
			$ptext = $tdata->plaintext ;
			$output['plist']['text'][$j] = $ptext;
			$adata = $tdata->find('a')[0];
			$atext = $adata->href;
			$output['plist']['href'][$j] = "https://widgets.spinitron.com" . $atext;
			$j++;
		}
	}*/
	
	$i = 0; //
	foreach ($html->find('div[class="description"]') as $div) {
//		echo "Found description " . $i . "\n";
		foreach($div->find('p') as $pdat) {
			$ptext = $pdat->plaintext ;
			$output['descrip'][$i++] = $ptext;
		}
	}

	foreach ($html->find('div[class="block"]') as $div) {
		$adata = $div->find('a')[0];
		$atext = $adata->href;
		foreach($div->find('div[class="datetime playlist"]') as $tdata) {
			$ptext = $tdata->plaintext ;
			$output['plist']['text'][$j] = $ptext;
			$output['plist']['href'][$j] = "https://widgets.spinitron.com" . $atext;
			$j++;
		}
	}

	$i = 0; //

	if (!empty($dj_id)) {
		$html = file_get_html("https://widgets.spinitron.com/KSQD/dj/$dj_id/");
		$i = 0;

		foreach ($html->find('h1') as $aref) {
//		echo "Found ref " . $i . "\n";
			if ( $aref->plaintext != "K-Squid" ) {
				$output['djname'][$i++] = $aref->plaintext;
			}
		}

		foreach ($html->find('div[class="image"]') as $div) {
			foreach ($div->find('img') as $img) {
				$output['djimage'][$i] = "https://spinitron.com" . $img->src ;
			}
		}
		
		$i = 0;
		$j = false;
		foreach ($html->find('p') as $pdesc) {
			if ($j == true) {
				$output['djtext'][$i] = $pdesc->plaintext;
				$j = false;
			}
			if ( $pdesc->getAttribute("class") == "persona-bio") {
				$j = true;
			}
		}
	}
$jout = json_encode($output);
echo "\n" . $jout;
}
?>
