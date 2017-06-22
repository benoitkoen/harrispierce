<?PHP
require_once("../php/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Harris & Pierce</title>
    <link rel="stylesheet" href="../styles2.css">
</head>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
    
    <body> <!--background = '/Users/benoitkoenig/Desktop/Java/news_agg/images/bp.png'-->
        <div id="up">
            <img id = "logo" src="../logo.png"/ onclick="window.location.href='index_perso.php'">
        
            <div id="moto" onclick="window.location.href='index_perso.php'">Harris <br>&<br> Pierce</div>
               
            <div id="logoutText">Logged in as: <?= $fgmembersite->UserEmail() ?></div>
            <button id = "logoutButton" onclick="window.location.href='../../index.html'">Logout</button>
            
            <form id='searchForm'>
                
                <input id = "searchBar" type="text" placeholder="Brexit, Trump, Syria..." required>
                <input id = "searchButton" type="button" value="Search" >
                <!-- 
                cb.setAttribute('name', 'check_list[]');
                cb.setAttribute('value', journal.journalName+'_'+section);-->
                
            </form>     
        </div>
                
        <!--
        <h1 id = 'header1'>Login to take advantage of all functionalities: have a look at our presentation video to fully understand what you can do! <em>LINK</em></h1>-->
        
        <form id='selection' action='display_selection_perso.php' method="post">
            <!--<input id = 'submitButton' type='submit' value = "Let's go!">-->
        </form> 
        
        <script type="text/javascript" src="../objects.js"></script>

        <script type="text/javascript" src="iniNA_perso.js"></script>
        
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
                <input id = "submitSearch" type="submit" name = "submitSearch" value = "Let's go!">
                <button type="button" id="quitSearch">Quit Search</button>
            </form> 
        </div>

    <body>
        
        
<footer>

    <em>Harris & Pierce</em><br>
    Your favorite Newspaper is missing?<br>
    E-mail: <a href = 'mailto: contact@harrispierce.com'>contact@harrispierce.com</a><br>
    URL: <a href = 'http://www.harrispierce.com'>http://www.harrispierce.com</a><br>
    All Rights Reserved © 2016 | <a href="">Privacy Policy</a> | <a href="">Terms of Service</a><br>
    2017 Ed Tittel, Benoit Koenig.<br>
    

    
</footer>