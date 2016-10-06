<?php

//$o =  getFlipkartResult("Ray+Ban+Aviator+Sunglasses");
//$o =  getFlipkartResult("samsung+galaxy+s6");
//print_r($o);
require 'simple_html_dom.php';

	$key = $_GET['k'];
	$key = str_replace(" " , "+", $key);
	$o = getFlipkartResult($key);
	echo json_encode($o);

	function getFlipkartResult($keyword) {
		$allvalues = array();
		$o = exec("curl --silent \"http://www.flipkart.com/search?q=$keyword&as=off&as-show=on&otracker=start\"", $response, $aa);
		$response = implode("\n", $response);
	
	//	file_put_contents("out.htm", $response);
		$dom = str_get_html($response);

		$t = $dom->find("#products", 0 );
		
		if(null == $t) {
			echo "NULL products";
		}else {

			$divs = $t->find("div.browse-grid-row");
			if(count($divs) > 3) {
				$divs = array_slice($divs, 0,3);
			}

			
			$firstPrice = 0; 
			foreach($divs as $div) {
				$items = $div->find("div.product-unit");
				
				foreach($items as $item) {
					$item = $item->find("div.pu-price", 0)->find("div.pu-final", 0);
					$price =  $item->plaintext;
					$price = str_replace("Rs.", "",$price);
					$price =trim($price);
					$price = str_replace(",", "", $price);
				
					if(count($allvalues) == 0) {
						$firstPrice = $price;
					}
					
					if( !(($price - $firstPrice  ) < -2000) ) {
						//echo "$firstPrice  - $price " ;
						array_push($allvalues, $price );
					} 

					
					
				}
				
			}
			//print_r($allvalues);
		}

	 
		return array("v"=>"FlipKart", "p"=>min($allvalues));
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