<html>
<head>
<title>Create Account</title>
</head>
<body>
<?php

if(isset($_POST['submit'])){
    
    $data_missing = array();
    
    if(empty($_POST['email'])){

        // Adds name to array
        $data_missing[] = 'Email';

    } else {

        // Trim white space from the name and store the name
        $email = trim($_POST['email']);

    }

    if(empty($_POST['password'])){

        // Adds name to array
        $data_missing[] = 'Password';

    } else {

        // Trim white space from the name and store the name
        //$password = trim($_POST['password']);
        $password = ($_POST['password']);
        $passwordmd5 = md5($_POST['password']);

    }

    if(empty($data_missing)){
        
        require_once('mysqli_connect.php'); ///WARNING
        
        $query = "INSERT INTO user (email, password, creation_date) VALUES (?, ?, ?)";
        
        $stmt = mysqli_prepare($dbc, $query);
        
        /*i Integers;
        d Doubles;
        b Blobs;
        s Everything Else;*/
            
        mysqli_stmt_bind_param($stmt, "sss", $email, $passwordmd5, date('Y-m-d H:i:s'));
        
        mysqli_stmt_execute($stmt);
        
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        
        if($affected_rows == 1){
            
            echo 'Registration Successful. An email with your information and benefits was sent.';
            
            
            
            
            //Send Mail
            $to = $email; // note the comma

            // Subject
            $subject = 'Thank you for joining the Harris & Pierce Community';

            // Message
            $message = '
            <html>
            <head>
              <title>Harris & Pierce</title>
            </head>
            <body>
              <p>With Harris & Pierce, be more productive when consuming information.</p>
              <h1>Your account information</h1>
              <table>
                <tr>
                  <th>Email</th><th>Password</th>
                </tr>
                <tr>
                  <td>'.$email.'</td><td>'.$password.'</td>
                </tr>
              </table>
              <h1>Your benefits</h1>
                <ul>
                  <li>Type a keyword and get articles related to it.</li>
                  <li>Get access to more newspapers and articles.</li>
                  <li>Get access to articles up to one week old.</li>
                  <li>Take advantage of special features (highlight, annotate and send the modified article).</li>
                  <li>Get the sections that interest you at the moment already checked.</li>
                  <li>Benefit from our Machine Learning algorithm that highlight the right articles for you.</li>
                </ul>
              <p>Sincerely,</p>
              <p>The Harris & Pierce team</p>
            </body>
            </html>
            ';

            // To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = 'From: Harris & Pierce <contact@harrispierce.com>';
            $headers[] = 'Bcc: contact@harrispierce.com';
            
            /* Additional headers
            $headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
            $headers[] = 'Cc: birthdayarchive@example.com';
            $headers[] = 'Bcc: birthdaycheck@example.com';*/

            // Mail it
            mail($to, $subject, $message, implode("\r\n", $headers));
            
            
            
            
            
            mysqli_stmt_close($stmt);
            
            mysqli_close($dbc);
            
        } else {
            //echo $affected_rows;
            echo 'We could not create an account. This email is already used!<br />';
            echo mysqli_error();
            
            mysqli_stmt_close($stmt);
            
            mysqli_close($dbc);
            
        }
        
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br />";
            
        }
        
    }
    
}

?>

<!--
<form action="userAdded.php" method="post">

<b>Create an account</b>

<p>Email:
<input type="text" name="email" size="30" value="" />
</p>

<p>Password:
<input type="password" name="street" size="30" value="" />
</p>

<p>
<input type="submit" name="submit" value="Send" />
</p>

</form>
    
</body>
</html>

-->
    
<input id="submitButton" type="button" value="Previous" onclick="window.location.href='../newUser/newUser.html'" />



