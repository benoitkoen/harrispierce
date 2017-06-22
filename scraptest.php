<?PHP
require_once('public_harrispierce/php/mysqli_connect.php');


if(isset($_POST['submit'])){//to run PHP script on submit
    if(!empty($_POST['check_list'])){
        $checked_count = count($_POST['check_list']); 
        //echo "You have selected following ".$checked_count." option(s): <br/>";
        // Loop to store and display values of individual checked checkbox.
        
        $counter = 0;
        $journalList = array();
        $sectionList = array();
        
        
        foreach($_POST['check_list'] as $selected){   //'check_list' is a section
            $res = (explode("_",$selected));
            $journal = $res[0];
            $section = $res[1];
            //$searchDate = 
            $limit = 100;
            
            //$sql = "SELECT DATE(date) AS descdate, title, teaser, href, image FROM scrap WHERE (journal = '$journal' AND section = '$section') ORDER BY descdate DESC";
            
            
            $sql = "SELECT date, title, teaser, href, image FROM scrap WHERE (journal = '$journal' AND section = '$section') ORDER BY date DESC limit 15";
            
            
            //$sql = "SELECT date, section, title, teaser, href, image FROM scrap WHERE (date < '$searchDate' AND journal = '$journal' AND (teaser LIKE '%{$topic}%' OR title LIKE '%{$topic}%')) ORDER BY date DESC limit '$searchLimit'"; //limit is $limit

            
            $result = $dbc->query($sql);
            
            if ($result->num_rows > 0) { //si result pas vide
 
                        echo "<table><tr><th>JOURNAL</th><th>SECTION</th><th>TITLES</th><th>TEASERS</th></tr>";
                        // output data of each row
                
                        while($row = $result->fetch_assoc()) {
                            //echo "<tr><td>".$row["descdate"]."</td><td>$journal</td><td>$section</td><td>".$row["title"]."</td><td>".$row["teaser"]."</td><td><img src=".$row["image"]."></td></tr>";
                            echo "<tr><td>".$row["date"]."</td><td>$journal</td><td>$section</td><td>".$row["title"]."</td><td>".$row["teaser"]."</td><td><img src=".$row["image"]."></td></tr>";
                        
                        }
                        echo "</table></br>";
                        /*
                        $path_to_img = $row['image'];
                        echo "<img src=\"$path_to_img\" alt=\"my image\" />";
                        echo "img";
                        //echo "<img src=\"".$row["image"]."\">";  */
                        
                
                } else {
                        echo "0 results";
                }
        }
        //echo $dom->saveHTML();
    }
}
$dbc->close();

?>
 