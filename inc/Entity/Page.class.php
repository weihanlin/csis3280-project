<?php


class Page  {

    public static $title = "Please set your title!";

    static function header()   { ?>
        <!-- Start the page 'header' -->
        <!DOCTYPE html>
        <html>
            <head>
                <title></title>
                <meta charset="utf-8">
                <meta name="author" content="Bambang">
                <title><?php echo self::$title; ?></title>   
                <link href="css/styles_001?2.css" rel="stylesheet">     
            </head>
            <body>
                <header>
                    <h1 style="text-align:center;"><?php echo self::$title; ?></h1>
                </header>
                <article>
    <?php }

    static function footer()   { ?>
        <!-- Start the page's footer -->            
                </article>
            </body>

        </html>

    <?php }


static function getSelectForm($locations,$selected=''){
    ?>
    <!-- Start the page's filter form -->
    <section class="select">
                    
                        <h2>Select a Location</h2>                        
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" style="display: block; text-align: center;">
                            <div class="row">
                            <select size="4">
                            <?php
                            
                                foreach($locations as $lo)  {
                                echo "<option value=\"".$lo->getLocationID()."\">".$lo->getShortName()."</option>";
                                }                                    
                                echo "<option value=\"4\">All</option>";
                                
                                
                            ?>

                            </select>
                                
                                
                                <br>
                                <input type="submit" value="Filter">    
                                <br>
                        
                            </div>
                        </form>
                        <br>
                        <h4 style="text-align:center;">User: Isaias </h4>                        
                        <div class="menu" style="text-align: center">
                        <a class="but" href=<?php echo "\"".$_SERVER["PHP_SELF"]."?action=perfil&id=5\""; ?> style="background: yellowgreen;">Profile</a><br>
                        <a class="but" href=<?php echo "\"".$_SERVER["PHP_SELF"]."?action=reserve&id=5\""; ?> style="background: blue;">Parking History</a><br>
                        <a class="but" href=<?php echo "\"".$_SERVER["PHP_SELF"]."?action=reserve&id=5\""; ?> style="background: orange;">Space Admin</a><br>
                        <a class="but" href=<?php echo "\"".$_SERVER["PHP_SELF"]."?action=logout&id=5\""; ?> style="background: red;">Log Out</a>                                         
                        </div>
            </section>

    
    <?php
}


static function getOrderData($spaces, $catID=NULL){
    ?>
                <!-- Start the page's data form -->
                <section class="table" style="width:70%">
                    
                    <h2 style="text-align:center;">  
                        <?php
                            echo "All Parking Available :"
                        ?> 
                    </h2>
                    <table>
                        <?php
                                   echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Number</th>";
                                        
                                        echo "<th>Location</th>";
                                        echo "<th>No Space</th>";
                                        echo "<th>Action</th>";                                       
                                echo "</thead>";    
                                
                                $i=1;    
                                                               
                                                       
 
                                foreach($spaces as $space)  {
                                    if($i%2==0){
                                        echo "<tr class=\"oddRow\">";                            
                                    }
                                    else{
                                        echo "<tr class=\"evenRow\">";
                                    }
                                    
                                    echo "<td>".$i."</td>";
                                    echo"<td>".$space->ShortName."</td>";
                                    echo"<td>".$space->getSpaceID()."</td>";
                                    echo "<td><a href=\"".$_SERVER["PHP_SELF"]."?action=reserve&id=".$space->getSpaceID()."\">Reserve</td>";
                                    echo "</tr>";
                                    $i++;
                                }


                        ?>
                    </table>
                    <!--<h3>Tienes una reservacion activa</h3>    -->
                </section>  
                
    <?php   
        
    }











    static function listFeedbacks(Array $feedbacks)    {
    ?>
        <!-- Start the page's show data form -->
        <section class="main">
        <h2>Current Data</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th> <!-- Feedback ID -->
                    <!-- ... -->
                    <th>Full Name</th>
                    <th>Date of Birth</th>
                    <th>Terms</th>
                    <th>Department</th>
                    <th>Edit</th>
                    <th>Delete</th>
            </thead>
            <?php
                $i=0;
                //List all the feedbacks
                
                foreach($feedbacks as $feedback)  {

                    // make sure to use the correct tr class
                    // echo "<tr class=
                    if($i%2==0){
                        echo "<tr class=\"oddRow\">";                            
                    }
                    else{
                        echo "<tr class=\"evenRow\">";
                    }  
                    echo"<td>".$feedback->getFeedbackID()."</td>";
                    echo"<td>".$feedback->getFullName()."</td>";
                    echo"<td>".$feedback->getDOB()."</td>";
                    echo"<td>".$feedback->getNumberOfTerms()."</td>";
                    echo"<td>".$feedback->ShortName."</td>";
                    // ... Fill me with your code ...
                    //echo '<td><a href=\"'.$_SERVER['PHP_SELFT'].'?action=delete&id='.$feedback->getFeedbackID().'">Edit</td>';
                    echo "<td><a href=\"".$_SERVER["PHP_SELF"]."?action=edit&id=".$feedback->getFeedbackID()."\">Edit</td>";                    
                    echo "<td><a href=\"".$_SERVER["PHP_SELF"]."?action=delete&id=".$feedback->getFeedbackID()."\">Delete</td>";
                    echo "</tr>";
                    $i++;
                } 
                
                
        echo '</table>';
        echo ' <input type="hidden" form="myform" id="total" name="total" value="'.($i+1).'">';
        
        echo "</section>";
  
    }




    static function createFeedbackForm(Array $departments)   { ?>        
        <!-- Start the page's add entry form -->
        <section class="form1">
                <h2>Create Feedback</h2>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" id="myform">
                    <table>
                        <tr>
                            <td>Full Name</td>
                            <td><input type="text" name="fullName"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><input type="text" name="email"></td>
                        </tr>                        
                        <tr>
                            <td>Date of Birth</td>
                            <td><input type="date" name="dob"></td>
                        </tr>
                        <tr>
                            <td>Terms</td>
                            <td><input type="number" min="1" max="7" step="1" name="terms"></td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td>
                            <select name="deptID">
                            <?php
                                foreach ($departments as $department)   {                                
                                        // list all department short names from the database read                                        
                                        echo '<option value="'.$department->getDeptID().'">'.$department->getShortName().'</option>';                                        
                                }
                            ?>
                            </select>
                            </td>
                        </tr>
                    </table>
                    <!-- Use input type hidden to let us know that this action is to create -->
                    <input type="hidden" name="action" value="create">
                    <input type="submit" value="Add Feedback">
                </form>
            </section>
                
    <?php }

    static function editFeedbackForm(feedback $feedbackToEdit, Array $departments)   {  ?>        
        <!-- Start the page's edit entry form -->
        <section class="form1">
            <h2>Edit Feedback - <?php echo $feedbackToEdit->getFeedbackID(); ?></h2>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <table>
                    <tr>
                        <td>Feedback ID</td>
                        <td><?php echo $feedbackToEdit->getFeedbackID(); ?></td>
                    </tr>
                    <!-- 
                        You know the drill from the create feedback form 
                        Make sure to add all input entries corresponding to the selected 
                        FeedbackID. Don't forget to put the values...
                    -->
                    <tr>
                            <td>Full Name</td>
                            <td><input type="text" name="fullName" value="<?php echo $feedbackToEdit->getFullName(); ?>"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><input type="text" name="email" value="<?php echo $feedbackToEdit->getEmail(); ?>"></td>
                        </tr>                        
                        <tr>
                            <td>Date of Birth</td>
                            <td><input type="date" name="dob" value="<?php echo $feedbackToEdit->getDOB(); ?>"></td>
                        </tr>
                        <tr>
                            <td>Terms</td>
                            <td><input type="number" min="1" max="7" step="1" name="terms" value="<?php echo $feedbackToEdit->getNumberOfTerms(); ?>"></td>
                        </tr>
                    <tr>
                        <td>Department</td>
                        <td>
                        <select name="deptID">
                        <?php
                            foreach ($departments as $department)   {                                                            
                                // list all department short names from the database read
                                
                                // make sure the corresponding department for this feedback is selected
                                if($department->getDeptID() ==$feedbackToEdit->getDeptID()){
                                    echo '<option value="'.$department->getDeptID().'" selected>'.$department->getShortName().'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$department->getDeptID().'">'.$department->getShortName().'</option>';
                                }
                            }
                        ?>
                        </select>
                        </td>
                    </tr>
                </table>
                <!-- We need another hidden input for feedback id here. Why? -->
                <input type="hidden" name="id" value="<?php echo $feedbackToEdit->getFeedbackID(); ?>">
                
                <!-- Use input type hidden to let us know that this action is to edit -->
                <input type="hidden" name="action" value="edit">
                <input type="submit" value="Edit Feedback">                
            </form>
        </section>

<?php }

}