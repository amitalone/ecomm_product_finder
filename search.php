<?php
require 'simple_html_dom.php';
 
 //getAmazonResult($keyword);

//getFlipkartResult($keyword);


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 
<table>
<tr>
	<td><input type="text" style="width:200px;" id="keyword"/> </td>
	<td><button onclick="search();">Search</button></td>
	<td><div id= "pr" style="display:none;"><img src= "5-0.gif" /> </div></td>
</tr>
</table>

<br>
<div id="div1" style="border:1px solid #0f0;" ></div><br>


<script>
var flag1 = false;
var flag2 = false;
	function search() {
		flag1 = false;
		flag2 = false;
		$("#pr").show();
		var key = $("#keyword").val();
	 
		 findOnAmazon(key);
		 findOnFlip(key);
}

function findOnAmazon(key) {
	$.ajax({url: "amazon.php?k="+key, success: function(result){
        $("#div1").append(key + " " +result+"<br>");
		flag1 = true;
		if(flag1 & flag2) {
			$("#pr").hide();
		}
    }});

}

function findOnFlip(key) {
	$.ajax({url: "flipkart.php?k="+key, success: function(result){
        $("#div1").append(key + " " +result+"<br>");
		flag2 = true;
		if(flag1 & flag2) {
			$("#pr").hide();
		}
    }});

}


	
</script>

<br><br>

<b>EG.</b><br>
samsung galaxy s6<br>
ray ban aviator<br>
sony xperia m2<br>
jawbone up2 (listed only on amazon)<br>
Lenovo 59-442262<br>