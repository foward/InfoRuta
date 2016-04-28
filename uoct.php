<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es-ES"> 
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" /> 
		<link rel='stylesheet' href='style.css' type='text/css' media='screen' /> 
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/> 
		<title>InfoRuta Mobile</title> 		
	</head> 
	<body> 
<div id="container">
	<div id="header"> <h1> <a href="/" > <img src="btnback.png" />InfoRuta </a></h1> </div>
	<div id="content">
<?php
include_once('simple_html_dom.php');
function scraping_digg() {
	$sector=$_GET['sector'];
	if(!empty($sector)){ 
		$url = "http://www.uoct.cl/uoct/sectores/ver_sector.jsp?sector=".$sector;
		}else{
		$url = "http://www.uoct.cl/uoct/sectores/ver_sector.jsp?sector=centro";
		}
	$html = file_get_html($url);
	$br = "<br>";
	$counter = 0;
foreach($html->find('table[width=410]') as $tables) {
    foreach($tables->find('tr[bgcolor=#FFFBD6]') as $news) {	
		 $test['title'] = trim($news->find('td[class=link1]', 0)->plaintext);
		if(!empty($test['title'])){
        $item['title'] = trim($news->find('td[class=link1]', 0)->plaintext);		
        $test['details'] = trim($news->find('td[class=link3] a', 0)->plaintext);
		if(!empty($test['details'])){
			$item['details'] = $test['details'];}
		$test['date'] = trim($news->find('td[class=link3] span', 0)->plaintext);
		if(!empty($test['date'])){ 	$item['date'] = $test['date'];}
			if(!empty($item)){ $ret[] = $item;	}
		}			
    }
 } 
	foreach($tables->find('td[colspan="2"]') as $descriptions){
		$te['descriptions'] = $descriptions->plaintext. '<br>';
		if(!empty($te) && strcmp($te['descriptions'],$br)!=0){
			$ret[$counter]['descriptions'] = $te['descriptions'];
			$counter++;
		}
	} 
    $html->clear(); unset($html); return $ret;
}
// -----------------------------------------------------------------------------
ini_set('user_agent', 'My-Application/2.5');
$ret = scraping_digg();
foreach($ret as $v) {
    echo '<h2>'.$v['title'].'</h2>';
    echo '<h3>'.$v['date'].'</h3>';
	echo '<p>'.$v['details'].'</p>';
	echo '<p>		'.$v['descriptions'].'</p>';
	echo '<hr>';
}
?>
</div> <div id="footer"> InfoRuta Beta Mobile 2010 / Info extraída de UOCT.cl </div> </div> </body> </html>