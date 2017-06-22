<?PHP
require_once("../php/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}


$email = $fgmembersite->UserEmail();


$dom = new DOMDocument();
//$dom->loadXML("<!DOCTYPE root [<!ATTLIST element id ID #IMPLIED>]><root/>");
$dom->loadHTML('

<head>
    <meta charset="utf-8">
    <title>Harris & Pierce</title>
    <link rel="stylesheet" href="../styles2.css">
</head>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
    
    <body>
        
        <div id="up">
            <img id = "logo" src="../logo.png" onclick="window.location.href=\'index_perso.php\'"/>

            <div id="moto" onclick="window.location.href=\'index_perso.php\'">Harris <br>&<br> Pierce</div>
                
            <div id="logoutText">Logged in as: '.$email.' </div>
            <button id = "logoutButton" onclick="window.location.href=\'../../index.html\'">Logout</button>

            
            
            <form id=searchForm> <!--ACTION-->
                <input id = "searchBar" type="text" placeholder="Brexit, Trump, Syria..." required>
                <input id = "searchButton" type="button" value="Search" >
            </form>     
        </div>
        <br>
            
    <h1 id = "header1">Login to take advantage of all functionalities: have a look at our presentation video to fully understand what you can do! <em>LINK</em></h1>
     
        <script type="text/javascript" src="../objects.js"></script>
        <script type="text/javascript" src="searchForm.js"></script>
        
        <!-- SEARCH FORM TO SHOW ONLICK-->
        <div id="show_onclick_form">
            <h1>Advanced Search</h1>
            <br>
            <form action="display_search.php" method="post">
                <label for="keyword" id= "keywordSearch" class="keywordSearch" name="keywordSearch">Which keyword? </label>
                <br>
                <input type="text" class="topic" id="topicSearch" name="topicSearch" placeholder="Brexit, Trump, Syria...">
                <br>
                <hr>
                <div id="journalCB">
                    In which newspapers?
                    <br>
                    <script>insertCB();</script>
                </div>
                <br>
                <hr>
                <div id="dateSerch">
                    After which date and time? (Format: 2017-04-21 13:00:00)
                    <br>
                    <input type="datetime-local" class="dateSerch" id="dateInput" name="dateSearch">
                    <script>setDate();</script>
                    </div>
                <br>
                <hr>
                <div id="qtySearch">
                    How many articles per newspaper?
                    <br>
                    <input type="number" min="1" max="500" name= "limitSearch" id="limitSearch">
                </div>
                <br>
                <hr>
                <input id = "submitSearch" type="submit" name = "submitSearch" value = "Let\'s go!">
                <button type="button" id="quitSearch">Quit Search</button>
            </form> 
        </div>
     
     
     <div id=vide>
        <input id="submitButton" type="button" value="Previous" onclick="window.location.href=\'index_perso.php\'" />
     </div>
     
    </body>
    
    <footer>
    <em>Harris & Pierce</em><br>
    Your favorite Newspaper is missing?<br>
    E-mail: <a href = "mailto: contact@harrispierce.com">contact@harrispierce.com</a><br>
    URL: <a href = "http://www.harrispierce.com">http://www.harrispierce.com</a><br>
    All Rights Reserved © 2016 | <a href="">Privacy Policy</a> | <a href="">Terms of Service</a><br>
    2017 Ed Tittel, Benoit Koenig.<br>
    </footer>


');
/*
$dom = new DOMDocument();
$dom->loadHTML('<html><body>Test<br></body></html>');
*/
//echo $dom->saveHTML();

require_once('../php/mysqli_connect.php');


if(isset($_POST['submit'])){//to run PHP script on submit
    if(!empty($_POST['check_list'])){
        $checked_count = count($_POST['check_list']); 
        //echo "You have selected following ".$checked_count." option(s): <br/>";
        // Loop to store and display values of individual checked checkbox.
        
        $counter = 0;
        
        $divup = $dom->getElementById('submitButton');
        
        
        foreach($_POST['check_list'] as $selected){   //'check_list' is a section
            $res = (explode("_",$selected));
            $journal = $res[0];
            $section = $res[1];
            $date = date('Y-m-d H:i:s');
         
            $sql = "SELECT tbl.* FROM (SELECT date, section, title, teaser, href, image FROM scrap WHERE (journal = '$journal' AND section = '$section') ORDER BY date DESC LIMIT 15) as tbl GROUP BY tbl.title;";
            
            $sql .= "INSERT INTO selection_loggedin (date, email, journal, section) VALUES ('$date', '$email', '$journal', '$section')";

            $dbc->multi_query($sql);
            
            $res = $dbc->store_result();
            echo $dbc->error;

            if ($res->num_rows > 0) {
 
                while($row = $res->fetch_assoc()) {

                    if ($counter !== 0) { //si y a deja des sections appendee a div
                        
                        if ($dom->getElementById($section) !== NULL){
                            //si la section est deja appendee a divup
                            //$dom->getElementById($section)->nodeValue is 'economy'...
                            
                            if($dom->getElementById($journal.$section) !== NULL){
                                //si le journal est deja appendee a la section, ajoute juste contenu
                                //$dom->getElementById($journal.$section)->nodeValue is 'les echos'...
                                
                                $sectionContainer = $dom->getElementById($section); //AJOUT
                                
                                $journalContainer = $dom->getElementById($journal.$section);
                                
                                $sectionContainer->appendChild($journalContainer);    
                                
                                
                                $newTitle = $dom->createElement('h3');
                                $newTitle->setAttribute("class", 'title');
                                
                                $journalContainer->appendChild($newTitle);
                                
                                $anchHref = $dom->createElement('a', $row["title"]);
                                $anchHref->setAttribute('href', $row['href']);
                                $anchHref->setAttribute('target', '_blank');
                                $newTitle->appendChild($anchHref);
                                 
                                $newTitle->appendChild($dom->createElement('p', $row["teaser"]));
                    
                                if ($row['image'] !== 'void'){
                                    $newImage = $dom->createElement('img');
                                    if ($journal === 'Financial Times'){
                                        $newImage->setAttribute("srcset", html_entity_decode($row['image'])); 
                                    } else {
                                        $newImage->setAttribute("src", $row['image']);
                                    }
                                    $newImage->setAttribute("class", "articleImage");
                                
                                    $newTitle->appendChild($newImage);
                                    
                                }
                                
                            } else { //ce journal est pas encore dans cette section: create un subcontainer par journal et le contenu
                                
                                array_push($journalList, $journal);
                                
                                $sectionContainer = $dom->getElementById($section); //AJOUT
                                
                                $journalContainer = $dom->createElement('h2', $journal);
                                $journalContainer->setAttribute("id", $journal.$section);
                                $journalContainer->setIdAttribute("id", TRUE);
                                $journalContainer->setIdAttribute("id", TRUE);
                                $journalContainer->setAttribute("class", 'journal');
                                
                                $sectionContainer->appendChild($journalContainer);
                                
                                $newTitle = $dom->createElement('h3');
                                $newTitle->setAttribute("class", 'title');
                                
                                $journalContainer->appendChild($newTitle);
                                
                                $anchHref = $dom->createElement('a', $row["title"]);
                                $anchHref->setAttribute('href', $row['href']);
                                $anchHref->setAttribute('target', '_blank');
                                $newTitle->appendChild($anchHref);
                                
                                $newTitle->appendChild($dom->createElement('p', $row["teaser"]));
                                
                                if ($row['image'] !== 'void'){
                                    $newImage = $dom->createElement('img');
                                    if ($journal === 'Financial Times'){
                                        $newImage->setAttribute("srcset", html_entity_decode($row['image'])); 
                                    } else {
                                        $newImage->setAttribute("src", $row['image']);
                                    }
                                    $newImage->setAttribute("class", "articleImage");
                                
                                    $newTitle->appendChild($newImage);
                                    
                                }

                            }
                        } else { //cette section existe pas encore: create a container per section et un subcontainer per journal et le contenu qui va avec
                            
                            $counter++;
                            
                            array_push($sectionList, $section);
                            array_push($journalList, $journal);
                            
                            //$sectionContainer = $dom->createElement('div', $section);
                            $sectionContainer = $dom->createElement('div');
                            $sectionContainer->setAttribute("id", $section);
                            $sectionContainer->setIdAttribute("id", true);
                            $sectionContainer->setIdAttribute("id", true);
                            $sectionContainer->setAttribute("class", 'section');
                            
                            $sectionTitle = $dom->createElement('h1', $section);
                            $sectionContainer->appendChild($sectionTitle);
                            
                            $divup->parentNode->insertBefore($sectionContainer, $divup);
                            
                            $journalContainer = $dom->createElement('h2', $journal);
                            $journalContainer->setAttribute("id", $journal.$section);
                            $journalContainer->setIdAttribute("id", TRUE);
                            $journalContainer->setIdAttribute("id", TRUE);
                            $journalContainer->setAttribute("class", 'journal');

                            $sectionContainer->appendChild($journalContainer);
                            
                            $newTitle = $dom->createElement('h3');
                            $newTitle->setAttribute("class", 'title');

                            $journalContainer->appendChild($newTitle);
                            
                            $anchHref = $dom->createElement('a', $row["title"]);
                            $anchHref->setAttribute('href', $row['href']);
                            $anchHref->setAttribute('target', '_blank');
                            $newTitle->appendChild($anchHref);
                                
                            $newTitle->appendChild($dom->createElement('p', $row["teaser"]));
                                
                            if ($row['image'] !== 'void'){
                                    $newImage = $dom->createElement('img');
                                    if ($journal === 'Financial Times'){
                                        $newImage->setAttribute("srcset", html_entity_decode($row['image'])); 
                                    } else {
                                        $newImage->setAttribute("src", $row['image']);
                                    }
                                    $newImage->setAttribute("class", "articleImage");
                                
                                    $newTitle->appendChild($newImage);
                                    
                                }
                        }

                    } else { //Si y a aucune section en dessous de divup encore
                            $counter++;
                        
                            array_push($sectionList, $section);
                            array_push($journalList, $journal);
                        
                            //$sectionContainer = $dom->createElement('div', $section);
                            $sectionContainer = $dom->createElement('div');
                            $sectionContainer->setAttribute("id", $section);
                            $sectionContainer->setIdAttribute("id", TRUE);
                            $sectionContainer->setIdAttribute("id", TRUE);
                            $sectionContainer->setAttribute("class", 'section');
                        
                            $sectionTitle = $dom->createElement('h1', $section);
                            $sectionContainer->appendChild($sectionTitle);

                            $divup->parentNode->insertBefore($sectionContainer, $divup);
                            
                            
                            $journalContainer = $dom->createElement('h2', $journal);
                            $journalContainer->setAttribute("id", $journal.$section);
                            $journalContainer->setIdAttribute("id", TRUE);
                            $journalContainer->setIdAttribute("id", TRUE);
                            $journalContainer->setAttribute("class", 'journal');

                            $sectionContainer->appendChild($journalContainer);

                            $newTitle = $dom->createElement('h3');
                            $newTitle->setAttribute("class", 'title');

                            $journalContainer->appendChild($newTitle);
                            
                            $anchHref = $dom->createElement('a', $row["title"]);
                            $anchHref->setAttribute('href', $row['href']);
                            $anchHref->setAttribute('target', '_blank');
                            $newTitle->appendChild($anchHref);
                                
                            $newTitle->appendChild($dom->createElement('p', $row["teaser"]));
                                
                            if ($row['image'] !== 'void'){
                                    $newImage = $dom->createElement('img');
                                    if ($journal === 'Financial Times'){
                                        $newImage->setAttribute("srcset", html_entity_decode($row['image'])); 
                                    } else {
                                        $newImage->setAttribute("src", $row['image']);
                                    }
                                    $newImage->setAttribute("class", "articleImage");
                                
                                    $newTitle->appendChild($newImage);
                                    
                            }
                        }
                    }
                    $res->free(); 
                    while($dbc->more_results() && $dbc->next_result())
                    {
                        $extraResult = $dbc->use_result();
                        if($extraResult instanceof mysqli_result){
                        $extraResult->free();
                        }
                    }
                }
                    //echo "0 results";
        }
        echo $dom->saveHTML();
    }
}
$dbc->close();

?>
 