<?PHP
/*
echo '<link href="public_harrispierce/style2.css" rel="stylesheet">';

$dom = new DOMDocument();
$dom->loadHTMLFile('public_harrispierce/display.html');
echo $dom->saveHTML();

//header('Content-type: image/jpeg');
*/

$dom = new DOMDocument();
//$dom->loadXML("<!DOCTYPE root [<!ATTLIST element id ID #IMPLIED>]><root/>");
$dom->loadHTML('

<head>
    <meta charset="utf-8">
    <title>Harris & Pierce</title>
    <link rel="stylesheet" href="public_harrispierce/styles2.css">
</head>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
    
    <body>
        
        <div id="up">
            <img id = "logo" src="public_harrispierce/logo.png" onclick="window.location.href=\'../../index.html\'"/>
 
            <div id="moto" onclick="window.location.href=\'../../index.html\'">Harris <br>&<br> Pierce</div>
                
            <button id = "login" onclick="window.location.href=\'public_harrispierce/login/login.php\'">Login</button>
            <button id = "newUser" onclick="window.location.href=\'public_harrispierce/newUser/newUser.html\'">New User</button>

            <script>
            function myFunction() {
                var popup = document.getElementById("myPopup");
                popup.classList.toggle("show");
            }
            </script>
            
            <form id="searchForm"> <!--ACTION-->
                    <input id = "searchBar" type="text" onclick="myFunction()" placeholder="Brexit, Trump, Syria..." required>
                    <input id = "searchButton" type="button" value="Search" onclick="myFunction()">
                </form>  
            
        </div>
        <br>
        
        <div class="popup" onclick="myFunction()">
                <span class="popuptext" id="myPopup">Login to use that functionality (and many more).</span>
        </div>    
        </div>
        <br>
        
        </div>
        <br>
        <div class="popup" onclick="myFunction()">
                <span class="popuptext" id="myPopup">Login to use that functionality (and many more).</span>
        </div>
            
    <h1 id = "header1">Login to take advantage of all functionalities: have a look at our presentation video to fully understand what you can do! <em>LINK</em></h1>
     
     <div id=vide>
        <input id="submitButton" type="button" value="Previous" onclick="window.location.href=\'../index.html\'" />
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

require_once('public_harrispierce/php/mysqli_connect.php');


if(isset($_POST['submit'])){//to run PHP script on submit
    if(!empty($_POST['check_list'])){
        $checked_count = count($_POST['check_list']); 

        $counter = 0;
        
        $divup = $dom->getElementById('submitButton');
        
        
        foreach($_POST['check_list'] as $selected){   //'check_list' is a section
            $split = (explode("_",$selected));
            $journal = $split[0];
            $section = $split[1];
            $date = date('Y-m-d H:i:s');
            
            $sql= "SELECT tbl.* FROM (SELECT date, section, title, teaser, href, image FROM scrap WHERE (journal = '$journal' AND section = '$section') ORDER BY date DESC LIMIT 15) as tbl GROUP BY tbl.title;";
            
            $sql .= "INSERT INTO selection_anonyme (date, journal, section) VALUES ('$date', '$journal', '$section')";

            $dbc->multi_query($sql);
            
            $res = $dbc->store_result();
            //echo $dbc->error;

                if ($res->num_rows > 0) {
                    //echo 'OK';
                    while($row = $res->fetch_assoc()) {
                        /*
                        $im_dec = base64_decode($row['image']);
                        echo $im_dec."<br>";
                        */
                        //echo html_entity_decode($row['image']);
                        
                    if ($counter !== 0) { //si y a deja des sections appendee a div
                        
                        if ($dom->getElementById($section) !== NULL){
                            //si la section est deja appendee a divup
                            //$dom->getElementById($section)->nodeValue is 'economy'...
                            
                            if($dom->getElementById($journal.$section) !== NULL){
                                //si le journal est deja appendee a la section, ajoute juste contenu
                                //$dom->getElementById($journal.$section)->nodeValue is 'les echos'...
                                
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
                                
                                $journalContainer = $dom->createElement('h2', $journal);
                                $journalContainer->setAttribute("id", $journal.$section);
                                $journalContainer->setIdAttribute("id", TRUE);
                                $journalContainer->setIdAttribute("id", TRUE);
                                $journalContainer->setAttribute("class", 'journal');

                                /*
                                $sectionTitle = $dom->createElement('h1', $section);
                                $sectionContainer->appendChild($sectionTitle);*/
                                
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
                                        $newImage->setAttribute("srcset", $row['image']); 
                                    } else {
                                        $newImage->setAttribute("src", html_entity_decode($row['image']));
                                    }
                                    $newImage->setAttribute("class", "articleImage");
                                
                                    $newTitle->appendChild($newImage);
                                    
                                }

                            }
                        } else { //cette section existe pas encore: create a container per section et un subcontainer per journal et le contenu qui va avec
                            
                            $counter++;
                            
                            
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
            //echo "no result";
        }
    }
        echo $dom->saveHTML();
}


$dbc->close();

?>