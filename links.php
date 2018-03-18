<?php


//assume I already got the categories from here: https://www.capterra.com/categoriesx
$tvsFile = getCategories("./categories.html");
getLinks($tvsFile);
function getCategories($fvsDomain) {
	$tvsFileHTML = file_get_contents($fvsDomain);
	return $tvsFileHTML;
}
function getLinks($fvsDocument) {
	$tvoDoc = new DOMDocument;
	@$tvoDoc->loadHTML($fvsDocument);

	//need to find this: body > div.site-main > div > div > div > div.cell.two-thirds.portable-one-whole > div.browse.base-margin-bottom
	// Look for all the 'a' elements
	$tvaLinks = $tvoDoc->getElementsByTagName('a');
$count = 0;
	foreach ($tvaLinks as $tvsLink) {
		$tvsHref = "https://www.capterra.com/".$tvsLink->getAttribute('href');
//		$tvsItemPage = file_get_contents($tvsHref);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $tvsHref);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
$tvsItemPage = curl_exec($curl);
curl_close($curl);

//		$tviPos1 = strpos($tvsItemPage, "<span class=\"subheading\">(");
//<span class="subheading">(100)</span>
		$tvsAmount = explode(")", explode("<span class=\"subheading\">(", $tvsItemPage)[1])[0];
		$tvsHTML = $tvsLink->nodeValue;
echo $tvsHTML.": ".$tvsAmount."<br>";
//file_put_contents($tvsHref, $tvsHref);
$count++;
if ($count > 25) die();
	}

}
?>
