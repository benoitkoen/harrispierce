<?php
header( 'content-type: text/html; charset=utf8mb4' );

include("simple_html_dom.php");


function scrapping($journal, $section, $url){
    $titles = array();
    $hrefs = array();
    $teasers = array();
    $images = array();

    echo 'on entre'.$journal."<br>";
    
    if ($journal === 'Wall Street Journal'){
        if ($url === 'https://www.wsj.com/news/world'
            || $url === 'https://www.wsj.com/news/business'
            || $url === 'https://www.wsj.com/news/opinion'
            || $url === 'https://www.wsj.com/news/economy'){

            $html = file_get_html($url);

            foreach($html->find('.hed-summ') as $hed){

                if ($hed->find('div[class=text-wrapper]', 0) !== NULL){
                    
                    //echo $hed->find('.hedgroup', 0)->find('h2, h3', 0)->find('a', 0)->text();
                    
                    array_push($titles, $hed->find('.hedgroup', 0)->find('h2, h3', 0)->find('a', 0)->text());
                }

                if ($hed->find('div[class=text-wrapper]', 0) !== NULL){
                    array_push($teasers, $hed->find('div[class=text-wrapper]', 0)->find('p[class=summary]', 0)->text());
                }

                if ($hed->find('div[class=text-wrapper]', 0) !== NULL){
                    array_push($hrefs, $hed->find('.hedgroup', 0)->find('h2, h3', 0)->find('a', 0)->getAttribute('href')); 

                }
                
                if ($hed->find('div[class=text-wrapper]', 0) !== NULL){
                    
                    //echo $hed->find('div[class=media-wrapper]', 0)->children(0)->getAttribute('class')."<br>";//find('.image-wrapper, .video-wrapper', 0);
                    
                    if ($hed->find('div[class=media-wrapper]', 0) !== NULL){
                        
                        if ($hed->find('div[class=media-wrapper]', 0)->children(0)->getAttribute('class') === 'video-wrapper'){

                            //echo 'video'."<br>";
                            //print_r($hed->find('div[class=media-wrapper]', 0)->children(0)->find('div[class=video-thumbnail]', 0)->childNodes());//->getAttribute('class')."<br>";//->getAttribute('background-image')."<br>";

                            array_push($images, 'void');

                        } else if ($hed->find('div[class=media-wrapper]', 0)->children(0)->getAttribute('class') === 'image-wrapper') {

                            //echo 'image'."<br>";
                            array_push($images, $hed->find('div[class=media-wrapper]', 0)->children(0)->find('a[class=image]', 0)->find('img', 0)->getAttribute('data-src'));
                        }
                        
                    } else {
                        //echo 'pas de media-wrapper'."<br>";
                        array_push($images, 'void');
                    }
                }
            }

            
        } else if ($url === 'https://www.wsj.com/news/politics'
                  || $url === 'https://www.wsj.com/news/technology') {
            
            $html = file_get_html($url);

            foreach($html->find('h3[class=wsj-headline dj-sg wsj-card-feature heading-3 locked], h3[class=wsj-headline dj-sg wsj-card-feature heading-3 unlocked], h3[class=wsj-headline dj-sg wsj-card-feature heading-2 locked]') as $hed){
                
                if ($hed->find('a', 0) !== NULL){
                    array_push($titles,$hed->find('a', 0)->text());
                    //echo $hed->find('a', 0)->text()."<br>";
                }

                if ($hed->nextSibling()->getAttribute('class') === 'wsj-summary dj-sg wsj-card-feature'){  
                    array_push($teasers, $hed->nextSibling()->text());
                } else if ($hed->nextSibling()->getAttribute('class') === 'right wsj-card-feature wsj-card-media Image'){
                    array_push($teasers, $hed->parent()->find('div', 3)->text());
                }


                if ($hed->find('a', 0) !== NULL){
                    array_push($hrefs, $hed->find('a', 0)->getAttribute('href')); 
                }
                
                
                if ($hed->find('a', 0) !== NULL){ 
                    
                    if ($hed->nextSibling()->getAttribute('class') === 'right wsj-card-feature wsj-card-media Image'){
                        
                        //echo $hed->nextSibling()->find('div[class=wsj-image wsj-card-media-item]', 0)->find('img', 0)->getAttribute('src')."<br>";
                        
                        //echo $hed->nextSibling()->find('div[class=wsj-image wsj-card-media-item]', 0)->find('meta', 0)->getAttribute('content')."<br>";
                        
                        array_push($images, $hed->nextSibling()->find('div[class=wsj-image wsj-card-media-item]', 0)->find('meta', 0)->getAttribute('content'));
                        
                    } else if ($hed->nextSibling()->getAttribute('class') === 'wsj-summary dj-sg wsj-card-feature'){
                        array_push($images, 'void');
                    }
                }

            } 
        }
        
        
        
        

    } else if ($journal === 'New York Times'){ //IMAGES#################################
        
            echo 'NYT';
        if ($url === 'https://www.nytimes.com/section/technology'
           || $url === 'https://www.nytimes.com/section/world') {
            
            $html = file_get_html($url);

            foreach($html->find('ol[class=story-menu theme-stream initial-set]', 0)->find('li') as $hed){

                if ($hed->find('article[class=story theme-summary]', 0) !== NULL){
                    //echo $hed->find('article[class=story theme-summary]', 0)->find('div[class=story-body]', 0)->find('a[class=story-link]', 0)->find('div[class=story-meta]', 0)->find('h2[class=headline]', 0)->text()."<br>";
                    
                    array_push($titles,$hed->find('article[class=story theme-summary]', 0)->find('div[class=story-body]', 0)->find('a[class=story-link]', 0)->find('div[class=story-meta]', 0)->find('h2[class=headline]', 0)->text());
                } 

                if ($hed->find('article[class=story theme-summary]', 0) !== NULL){  
                    array_push($teasers, $hed->find('article[class=story theme-summary]', 0)->find('div[class=story-body]', 0)->find('a[class=story-link]', 0)->find('div[class=story-meta]', 0)->find('p[class=summary]',0)->text());
                    
                    //echo $hed->find('article[class=story theme-summary]', 0)->find('div[class=story-body]', 0)->find('a[class=story-link]', 0)->find('div[class=story-meta]', 0)->find('p[class=summary]',0)->text();
                }


                if ($hed->find('article[class=story theme-summary]', 0) !== NULL){
                    array_push($hrefs, $hed->find('article[class=story theme-summary]', 0)->find('div[class=story-body]', 0)->find('a[class=story-link]', 0)->getAttribute('href')); 
                }
                
                if ($hed->find('article[class=story theme-summary]', 0) !== NULL){

                    //echo $hed->find('article[class=story theme-summary]', 0)->find('div[class=story-body]', 0)->find('a[class=story-link]', 0)->find('div[class=wide-thumb]', 0)->find('img', 0)->getAttribute('src');
                        
                    array_push($images, $hed->find('article[class=story theme-summary]', 0)->find('div[class=story-body]', 0)->find('a[class=story-link]', 0)->find('div[class=wide-thumb]', 0)->find('img', 0)->getAttribute('src')); 
                    
                }

            }

            
        } else if ($url === 'http://www.nytimes.com/pages/business/dealbook/index.html?src=busfn'
                   ||
                   $url === 'http://www.nytimes.com/pages/business/economy/index.html?src=busfn'
                   ||
                   $url === 'http://www.nytimes.com/pages/business/energy-environment/index.html?src=busfn'
                   ||
                   $url === 'https://www.nytimes.com/pages/politics/index.html'){
            
            $html = file_get_html($url);
            
            foreach($html->find('div[class=story]') as $hed){

                if ($hed->find('h3', 0) !== NULL){
                    array_push($titles,$hed->find('h3', 0)->find('a', 0)->text());
                    //echo $hed->find('h3', 0)->find('a', 0)->text()."<br>";
                }


                if ($hed->find('h3', 0) !== NULL){  
                    array_push($teasers, $hed->find('p[class=summary]',0)->text());
                }


                if ($hed->find('h3', 0) !== NULL){
                    array_push($hrefs, $hed->find('h3', 0)->find('a', 0)->getAttribute('href')); 
                }
                
                //if ($hed->find('div[class=thumbnail]', 0) !== NULL){
                if ($hed->find('h3', 0) !== NULL){
                    
                    //echo $hed->find('div[class=thumbnail]', 0)->find('a', 0)->find('img', 0)->getAttribute('src');
                    
                    
                    if ($hed->find('div[class=thumbnail]', 0) !== NULL){
                        array_push($images, $hed->find('div[class=thumbnail]', 0)->find('a', 0)->find('img', 0)->getAttribute('src'));   
                    }
                }
            }
        }
        
        

        
    } else if ($journal === 'Financial Times') {

            echo 'FT';
            $html = file_get_html($url);
            
            foreach($html->find('li[class=o-teaser-collection__item o-grid-row]') as $hed){

                if (
                    $hed->find(('div[class=o-teaser__image-container js-teaser-image-container]'), 0) !== NULL 
                    && 
                    $hed->find('p[class=o-teaser__standfirst]', 0) !== NULL){

                        array_push($titles, $hed->find(('a.js-teaser-heading-link'), 0)->text());
                  
                }

                if (
                    $hed->find(('div[class=o-teaser__image-container js-teaser-image-container]'), 0) !== NULL 
                    && 
                    $hed->find('p[class=o-teaser__standfirst]', 0) !== NULL){ 
                    
                        array_push($teasers, $hed->find('p[class=o-teaser__standfirst]', 0)->text());
                }

                if (
                    $hed->find(('div[class=o-teaser__image-container js-teaser-image-container]'), 0) !== NULL 
                    &&
                    $hed->find('p[class=o-teaser__standfirst]', 0) !== NULL){
                    
                        array_push($hrefs, 'https://www.ft.com' . $hed->find(('a.js-teaser-heading-link'), 0)->getAttribute('href')); 
                }
                 
                if (
                    $hed->find(('div[class=o-teaser__image-container js-teaser-image-container]'), 0) !== NULL 
                    &&
                    $hed->find('p[class=o-teaser__standfirst]', 0) !== NULL){
                    
                        //array_push($images, explode(" ", $hed->find(('div[class=o-teaser__image-container js-teaser-image-container]'), 0)->find('a', 0)->find('div[class=n-image-wrapper o-teaser__image-placeholder n-image-wrapper--lazy-loading n-image-wrapper--placeholder]', 0)->find(('img'), 0)->getAttribute('data-srcset'))[0]);
                    
                        array_push($images, $hed->find(('div[class=o-teaser__image-container js-teaser-image-container]'), 0)->find('a', 0)->find('div[class=n-image-wrapper o-teaser__image-placeholder n-image-wrapper--lazy-loading n-image-wrapper--placeholder]', 0)->find(('img'), 0)->getAttribute('data-srcset'));
                    
                }
                  
            }
            

        
        
        
    } else if ($journal === 'Les Echos'){
        
            $html = file_get_html($url);
        
            foreach($html->find('article[class=article-small article-medium]') as $hed){

                
                if ($hed->find('[class=titre]', 0) !== NULL){

                    array_push($titles,$hed->find('[class=titre]', 0)->find('a', 0)->text());
                }


                if ($hed->find('[class=chapo]', 0) !== NULL){
                    
                    array_push($teasers, $hed->find('[class=chapo]', 0)->text());
                }


                if ($hed->find('[class=titre]', 0) !== NULL){
                    array_push($hrefs, $hed->find('[class=titre]', 0)->find('a', 0)->getAttribute('href')); 
                }
                
                if ($hed->find('[class=titre]', 0) !== NULL){
                    array_push($images, 'https://www.lesechos.fr' . $hed->find('figure', 0)->find('a', 0)->find('picture', 0)->find('img', 0)->getAttribute('srcset'));

                }
            }
    }
    
    
   
    
        //$result = array($journal, $section, $titles, $hrefs, $teasers, $images);
        $result = array($titles, $hrefs, $teasers, $images);
        /*
        foreach($result as $re){
            echo (count($re))."<br>"; 
        }*/
        //print_r($result);
        return $result;
}



    


$journalList = array();

    
    
class journal
{
  public $journalName; 
  public $sectionUrls; 
    
  public function __construct($journalName, $sectionUrls)
  {
    $this->journalName = $journalName; 
    $this->sectionUrls = $sectionUrls; 
  }
}
    

    
    
$WSJUrls = array("World"=> "https://www.wsj.com/news/world", 
                 "Economy"=> "https://www.wsj.com/news/economy",
                 "Companies"=> "https://www.wsj.com/news/business",  //Business?
                 "Politics"=> "https://www.wsj.com/news/politics",
                 "Tech"=> "https://www.wsj.com/news/technology",
                 "Opinion"=> "https://www.wsj.com/news/opinion");
$WSJ = new journal('Wall Street Journal', $WSJUrls);
array_push($journalList, $WSJ);
  
    
$NYTUrls = array("World"=> "https://www.nytimes.com/section/world", 
                 "Economy"=> "http://www.nytimes.com/pages/business/economy/index.html?src=busfn",
                 "Dealbook"=> "http://www.nytimes.com/pages/business/dealbook/index.html?src=busfn",
                 "Politics"=> "https://www.nytimes.com/pages/politics/index.html",
                 "Tech"=> "https://www.nytimes.com/section/technology",
                 "Energy"=> "http://www.nytimes.com/pages/business/energy-environment/index.html?src=busfn");
$NYT = new journal('New York Times', $NYTUrls);
array_push($journalList, $NYT);
    
    
$FTUrls = array("World"=> "http://ft.com/world", 
                 "Companies"=> "http://ft.com/companies", //Companies
                 "Markets"=> "http://ft.com/markets", 
                 "Opinion"=> "https://www.ft.com/opinion",
                 "Careers"=> "https://www.ft.com/work-careers");
$FT = new journal('Financial Times', $FTUrls);
array_push($journalList, $FT);
    
    
$lesEchosUrls = array("World"=> "http://www.lesechos.fr/monde/index.php", 
                 "Economy"=> "http://www.lesechos.fr/economie-france/index.php",
                 "Markets"=> "http://www.lesechos.fr/finance-marches/index.php", 
                 "Politics"=> "http://www.lesechos.fr/politique-societe/index.php",
                 "Tech"=> "http://www.lesechos.fr/tech-medias/index.php");
$lesEchos = new journal('Les Echos', $lesEchosUrls);
array_push($journalList, $lesEchos);






//require_once('mysqli_connect.php'); ///WARNING
/*
DEFINE ('DB_USER', 'dbo677888126');
DEFINE ('DB_PASSWORD', 'Harrispierce94');
DEFINE ('DB_HOST', 'db677888126.db.1and1.com'); ///tmp/mysql5.sock
DEFINE ('DB_NAME', 'db677888126'); 


// $dbc will contain a resource link to the database
// @ keeps the error from showing in the browser

//$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
$dbc = @mysqli_connect('db677888126.db.1and1.com', 'dbo677888126', 'Harrispierce94', 'db677888126')
OR die('Could not connect to MySQL: ' .
mysqli_connect_error());
 */


    $host_name  = "db677888126.db.1and1.com";
    $database   = "db677888126";
    $user_name  = "dbo677888126";
    $password   = "Harrispierce94";


    $dbc = mysqli_connect($host_name, $user_name, $password, $database);
    
    if(mysqli_connect_errno())
    {
    echo '<p>La connexion au serveur MySQL a ??chou??: '.mysqli_connect_error().'</p>';
    }
    else
    {
    echo '<p>Connexion au serveur MySQL ??tablie avec succ??s.</p>';
    }

//mysqli_set_charset('utf8', $dbc);
mysqli_query("SET NAMES 'utf8mb4'");

$error = array();


foreach($journalList as $journal){
    $name = $journal->journalName;
    $urls = $journal->sectionUrls;
    foreach ($urls as $section => $url) {
        /*echo $name."<br>";
        echo $section;*/
        echo 'current url'.$url."<br>";
        echo 'current name'.$name."<br>";
        $res = scrapping($name, $section, $url); //array($titles, $hrefs, $teasers, $images);
        
        for ($i = 0; $i < count($res[0]); $i++){
            $title = strip_tags($res[0][$i]); //mb_convert_encoding($str, "UTF-7"
            $href = $res[1][$i];
            $teaser = strip_tags($res[2][$i]);
            $image = ($res[3][$i]);
            $md5_of_title = md5($title);
            
            //$query = "INSERT IGNORE INTO scrap (date, journal, section, title, href, teaser, image, md5_of_title) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $query = "INSERT INTO scrap (date, journal, section, title, href, teaser, image, md5_of_title) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
            $stmt = mysqli_prepare($dbc, $query);
        
        /*i Integers;
        d Doubles;
        b Blobs;
        s Everything Else;*/
            
            mysqli_stmt_bind_param($stmt, "ssssssss", date('Y-m-d H:i:s'), $name, $section, $title, $href, $teaser, $image, $md5_of_title);

            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);

            if($affected_rows == 1){
                echo 'Insertion successful'."<br>";
                mysqli_stmt_close($stmt);
                //mysqli_close($dbc);
                
            } else {
                //echo $affected_rows;
                echo 'Insertion Failed.<br />';
                echo $url."<br>";
                array_push($error, $url);
                echo mysqli_error($dbc);

                mysqli_stmt_close($stmt);

                //mysqli_close($dbc);
            
            }
        }
    }
}
             
mysqli_close($dbc);


if (!empty($error)){
    //mail('technical@harrispierce.com', 'Error scrapping', $error);
}

    
/*
$name = $journalList[3]->journalName;
  
$urls = $journalList[3]->sectionUrls;

foreach ($urls as $section => $url) {
    scrapping($name, $section, $url);
        //echo $section;
        //echo $urls[$section]."<br>";
    }
*/
/*
echo $name;
print_r($urls);*/
//echo $name;
//scrapping($name, 'World', "http://ft.com/world");
    
    


?>