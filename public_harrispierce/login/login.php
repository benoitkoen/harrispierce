<?PHP
require_once("../php/membersite_config.php");

if(isset($_POST['submitted']))
{
   if($fgmembersite->Login())
   {
        //$fgmembersite->RedirectToURL("login-home.php");
       $fgmembersite->RedirectToURL("index_perso.php");
        exit;
   }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Harris & Pierce</title>
    <link rel="stylesheet" href="../styles2.css">
</head>
    <body class=bodybackground> <!--background = '/Users/benoitkoenig/Desktop/Java/news_agg/images/bp.png'-->
        <div id="up">
            <img id = "logo" src="../logo.png" onclick="window.location.href='../../index.html'"/>
 
            <div id="moto" onclick="window.location.href='../../index.html'">Harris <br>&<br> Pierce</div>
            
        </div>
        <h2>Login to your account</h2>
            <div id='fg_membersite'>
                <form id='login' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'> <!--former id: 'registerForm' class="login_newUser_form"-->
                    <fieldset >
                    <legend>Login</legend>
                        <input type='hidden' name='submitted' id='submitted' value='1'/>

                        <div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                        <div class='loginEmail'> <!--former class="loginEmail"   container-->
                            <label for='email' >Email*:</label><br/>
                            <input type='text' name='email' class='emailForm' value='<?php echo $fgmembersite->SafeDisplay('email') ?>' maxlength="50" /><br/>
                            <span id='login_email_errorloc' class='error'></span>
                        </div>
                        <div class='loginPassword'><!--former class="loginPassword"   container-->
                            <label for='password' >Password*:</label><br/>
                            <input type='password' name='password' class='passwordForm' maxlength="50" /><br/>
                            <span id='login_password_errorloc' class='error'></span>
                        </div>
                        <p class='short_explanation'>* required fields</p>

                        <div class='container'>
                            <input type='submit' class='submission' name='Submit' value='Submit' /><!--former class="submit"-->
                        </div>
<!--<div class='short_explanation'><a href='reset-pwd-req.php'>Forgot Password?</a></div>-->
                    </fieldset>
                </form>
          
        
        
        <input id="submitButton" type="button" value="Previous" onclick="window.location.href='../../index.html'" />
        
    <body>
        
        
<footer>

    <em>Harris & Pierce</em><br>
    Your favorite Newspaper is missing?<br>
    E-mail: <a href = 'mailto: contact@harrispierce.com'>contact@harrispierce.com</a><br>
    URL: <a href = 'http://www.harrispierce.com'>http://www.harrispierce.com</a><br>
    All Rights Reserved © 2016 | <a href="">Privacy Policy</a> | <a href="">Terms of Service</a><br>
    2017 Ed Tittel, Benoit Koenig.<br>
    

    
</footer>
    
