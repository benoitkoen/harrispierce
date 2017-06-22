<?PHP
require_once("fg_membersite.php");

$fgmembersite = new FGMembersite();

//Provide your site name here
$fgmembersite->SetWebsiteName('harrispierce.com');

//Provide the email address where you want to get notifications
$fgmembersite->SetAdminEmail('contact@harrispierce.com');

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, fgusers in this case)
//by itself on submitting register.php for the first time
$fgmembersite->InitDB(/*hostname*/'db677888126.db.1and1.com',
                      /*username*/'dbo677888126',
                      /*password*/'Harrispierce94',
                      /*database name*/'db677888126',
                      /*table name*/'user');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgmembersite->SetRandomKey('XpgEgq7az9eX8LP');

?>