<?php
  include('simple_html_dom.php');
  $debug = false;
  header('Content-type: application/json');
  header('Access-Control-Allow-Origin: *');

  // get the command
  $show_id = $_REQUEST['show_id'];
  if (!empty($show_id)) 
	echo scrape($show_id);
  else
	echo "";

function scrape($show_id) {
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
	$tarr = array();
	foreach ($html->find('a') as $aref) {
//		echo "Found ref " . $i . "\n";
		if ( strpos($aref->href, "https://spinitron.com") !== false) {
			$tarr[$i] = $aref->href;
			$output['djname'][$i++] = $aref->plaintext;
		}
	}
	$i = 0;
	foreach ($tarr as $dref) {
		$html2 = file_get_html($dref);
		foreach ($html2->find('div[class="image"]') as $div) {
			foreach ($div->find('img') as $img) {
				$output['djimage'][$i] = "https://spinitron.com" . $img->src ;
			}
		}
		$j = false;
		foreach ($html2->find('p') as $pdesc) {
			if ($j == true) {
				$output['djtext'][$i] = $pdesc->plaintext;
				$j = false;
			}
			if ( $pdesc->getAttribute("class") == "persona-bio") {
				$j = true;
			}
		}
		$i++;
	}
$jout = json_encode($output);
echo "\n" . $jout;
}
?>
