<?php
 require 'simple_html_dom.php';
	$key = $_GET['k'];
	$key = str_replace(" " , "+", $key);
	$o = getAmazonResult($key);
	echo json_encode($o);
 
	function getAmazonResult($keyword) {
		
		$response = chGet("http://www.amazon.in/s/&field-keywords=$keyword");
		$dom = str_get_html($response);
		$t = $dom->find("#s-results-list-atf", 0 );
		if(null == $t) {
			echo "NULL s-results-list-atf";
		}else {
			$lis = $t->find("li.s-result-item");
			$li = $lis[0];
			$alist = $li->find("a");
			$listingURL = null;
			foreach($alist as $a) {
				if($a->plaintext )
					if (strpos($a->plaintext,'offers from') !== false) {
						// $response = chGet();
						$listingURL = $a->href;
						break;
					}
			}

			if(null != $listingURL) {
				$response = chGet($listingURL);
				$dom = str_get_html($response);
				$divlist = $dom->find("div.a-row");
				$newDivList = array();
				foreach($divlist as $div) {
					if("a-row a-spacing-mini olpOffer" === $div->class) {
						array_push($newDivList, $div);
					}

				}
				$div = $newDivList[0];
				$price = $div->find("span.a-size-large",0)->plaintext;
				$price = str_replace("&nbsp;", "",  $price);
				$price = str_replace("Rs.", "",  $price);
				$price = trim($price);
				return array("v"=>"amazon.in", "p"=>"$price");

			}
			

		}

	}

	function chGet($url) {
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, "$url");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$response =curl_exec($ch); 
		return $response;
	}
	
	function getCurlObject() {
		$ch = curl_init();
		$user_agent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36';
		curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		return $ch;	
	}

?>