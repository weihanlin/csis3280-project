<?php
class Page {
    public static $title = "";

    static function header() {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title><?= self::$title ?></title>
            <link href="css/styles_001.css" rel="stylesheet">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        </head>
        <body>
            <header>
                <h1><?= self::$title ?></h1>
            </header>


            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Parking System</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="indexReservation.php">Home</a></li>

                        <!--  Hide this option if this session is not admin   -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Manage
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="ManageLocations.php">Locations</a></li>
                                <li><a href="ManageSpaces.php">Spaces</a></li>
                            </ul>
                        </li>
                        <!--   End   -->

                        <li><a href="ShowStats.php">Statistic</a></li>
                        <li><a href="reservationHistory.php">History</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    </ul>
                </div>
            </nav>

        <?php
    }

    static function footer() {
        ?>

        </body>
        </html>
        <?php
    }

    static function confirmDeletion($type) {
        ?>

        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>You are going to delete a <?= $type ?>, and it can not be reversed.</p>
                        <p class="info"></p>
                        <p>Do you want to proceed?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <?php
            if(!strcmp($type,"Location")) {
                ?>
                <script>
                    $('#confirm-delete').on('show.bs.modal', function(e) {
                        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

                        $('.info').html(
                            "Location ID: " + $(e.relatedTarget).data('locid') + " <br>" +
                            "ShortName: " + $(e.relatedTarget).data('name') + " <br>" +
                            "Address: " + $(e.relatedTarget).data('addr') + " <br>"
                        );
                    });
                </script>
                <?php
            } elseif(!strcmp($type,"Space")){
                ?>
                <script>
                    $('#confirm-delete').on('show.bs.modal', function(e) {
                        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

                        $('.info').html(
                            "Location ID: " + $(e.relatedTarget).data('locid') + " <br>" +
                            "ShortName: " + $(e.relatedTarget).data('name') + " <br>" +
                            "Space ID: " + $(e.relatedTarget).data('spid') + " <br>"
                        );
                    });
                </script>
                <?php
            }
        ?>



        <?php
    }


    static function listLocations(Array $data) {
        ?>
        <section class="main">
            <h2>Current Data</h2>
            <?php
            if(count($data) == 0){
                echo "<h3>Can not find related data.</h3>".
                    "<a href='ManageLocations.php'>Back to the whole list</a></section>";
                return;
            }
            ?>

            <script src="script\sort-table.js"></script>

            <table>
                <thead><tr>
                    <th onclick="sortcol(1)">ID</th>
                    <th onclick="sortcol(2)">ShortName</th>
                    <th onclick="sortcol(3)">Address</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr></thead>
                <tbody id="restable">
                <?php
                $i = 1;
                foreach($data as $datum){
                    if(($i%2) == 0)
                        echo "<tr class='evenRow'>";
                    else
                        echo "<tr>";

                    echo "<td>{$datum->getLocationID()}</td>";
                    echo "<td>{$datum->getShortName()}</td>";
                    echo "<td>{$datum->getAddress()}</td>";
                    echo "<td><a href=?action=edit&lid={$datum->getLocationID()}>Edit</a></td>";
                    echo "<td><a href='#' data-locid='{$datum->getLocationID()}'
                                        data-name='{$datum->getShortName()}'
                                        data-addr='{$datum->getAddress()}'
                                        data-href='?action=delete&lid={$datum->getLocationID()}'
                                        data-toggle='modal' data-target='#confirm-delete'>Delete</a></td>";

                    echo "</tr>";
                    $i++;
                }

                ?>
                </tbody>
            </table>
        </section>
        <?php

    }


    static function listSpaces(Array $data) {
        ?>
        <section class="main">
            <h2>Current Data</h2>
            <?php
            if(count($data) == 0){
                echo "<h3>Can not find related data.</h3>".
                    "<a href='ManageSpaces.php'>Back to the whole list</a></section>";
                return;
            }
            ?>
            <script src="script\sort-table.js"></script>

            <table>
                <thead><tr>
                    <th onclick="sortcol(1)">Location</th>
                    <th onclick="sortcol(2)">ID</th>
                    <th onclick="sortcol(3)">Unit Price</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr></thead>
                <tbody id="restable">
                <?php
                $i = 1;
                foreach($data as $datum){
                    if(($i%2) == 0)
                        echo "<tr class='evenRow'>";
                    else
                        echo "<tr>";

                    echo "<td>{$datum->getShortName()}</td>";
                    echo "<td>{$datum->getSpaceID()}</td>";
                    echo "<td>\$ {$datum->getPrice()}</td>";
                    echo "<td><a href=?action=edit&sid={$datum->getSpaceID()}&lid={$datum->getLocationID()}>Edit</a></td>";
                    echo "<td><a href='#' data-locid='{$datum->getLocationID()}'
                                        data-name='{$datum->getShortName()}'
                                        data-spid='{$datum->getSpaceID()}'
                                        data-href='?action=delete&sid={$datum->getSpaceID()}&lid={$datum->getLocationID()}'
                                        data-toggle='modal' data-target='#confirm-delete'>Delete</a></td>";

                    echo "</tr>";
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </section>
        <?php

    }

    static function createLocationForm() {
        ?>
        <section class="form1">
            <h2>Location</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <table>
                    <tr>
                        <td>Short Name</td>
                        <td><input type="text" name="shortname"></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><input type="text" name="addr"></td>
                    </tr>
                </table>
                <button type="submit" name="action" value="create">Add One</button>
                <button type="submit" name="action" value="search">Search</button>
            </form>
        </section>

        <?php
    }

    static function editLocationForm(Location $target) {
        ?>
        <section class="form1">
            <h2>Edit Location</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <table>
                    <tr>
                        <td>Location ID</td>
                        <td>
                            <input name="locationid" value="<?= $target->getLocationID() ?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>Short Name</td>
                        <td><input type="text" name="shortname" value="<?= $target->getShortName() ?>" </td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><input type="text" name="addr" value="<?= $target->getAddress() ?>"></td>
                    </tr>
                </table>
                <button value="edit" type="submit" name="action">Submit</button>
                <button value="cancel" type="reset" name="action">Reset</button>
            </form>
        </section>

        <?php
    }


    static function createSpaceForm(Array $target) {
        ?>
        <section class="form1">
            <h2>Space</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <table>
                    <tr>
                        <td>Location</td>
                        <td>
                            <select name="locationid">
                                <?php
                                    foreach ($target as $item) {
                                        echo "<option value={$item->getLocationID()}>{$item->getShortName()}</option>>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Space ID</td>
                        <td><input type="number" min="1" name="spaceid"></td>
                    </tr>
                    <tr>
                        <td>Unit Price</td>
                        <td><input type="number" min="0" step="0.01" name="price"></td>
                    </tr>
                </table>
                <button type="submit" name="action" value="create">Add One</button>
                <button type="submit" name="action" value="search">Search</button>
            </form>
        </section>

        <?php
    }

    static function editSpaceForm(space $target, Array $parameter) {
        ?>
        <section class="form1">
            <h2>Edit Space</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <table>
                    <tr>
                        <td>Location</td>
                        <td>
                            <input name="locationid" value="<?= $target->getLocationID() ?>" hidden>
                            <input type="text" name="shortname" value="<?php
                            foreach ($parameter as $item) {
                                if($target->getLocationID() == $item->getLocationID())
                                    echo $item->getShortName();
                            }
                            ?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>Space ID</td>
                        <td><input type="number" name="spaceid" min="1" value="<?= $target->getSpaceID() ?>" readonly></td>
                    </tr>
                    <tr>
                        <td>Unit Price</td>
                        <td><input type="number" step="0.01" min="0" name="price" value="<?= $target->getPrice() ?>"></td>
                    </tr>
                </table>
                <button value="edit" type="submit" name="action">Submit</button>
                <button value="cancel" type="reset" name="action">Reset</button>
            </form>
        </section>

        <?php
    }
    
    static function displayUserDetails(User $user) { ?>
        <h1>User Details</h1>
        <div>
        Email Address:<?php echo $user->getEmail() ?><br>
        Full Name: <?php echo ($user->getFullName()) ?><br>
        Phone Number: <?php echo($user->getPhoneNumber()) ?><br>

        <a href="<?php echo 'ManageLocations.php'?>">Manage your Locations</a><br>
        <a href="<?php echo 'ManageSpaces.php'?>">Manage your Spaces</a><br>
        <a href="<?php echo 'parkingLogout.php'?>">Logout</a>
        </div>
        <?php }

    static function displayLogin() { ?>
    <form action="" method="POST">
    <h2>Please sign in</h2>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required autofocus>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
    <input type="submit" value="Login">
    </form>
    <br>

        Don't have an account? <a href="<?php echo 'parkingRegistration.php'?>">Click here</a> to register.

    <?php }
    static function displayRegistrationForm() { ?>
    
        Have an account?<a href="<?php echo "parkingLogin.php"?>"> Please login</a>.
        <section class="form">
        <h1> Please Fill in the Form</h1>
        <form action="" method="post">
        <table>
        <tr>
            <td align="right"><label for="email">E-mail address</label></td>
            <td align="left"><input type="email" name="email" required></td>
        </tr>
        <tr>
            <td align="right"><label for="password">Password</label></td>
            <td align="left"><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td align="right"><label for="password_confirm">Confirm Password</label></td>
            <td align="left"><input type="password" name="password_confirm" required></td>
        </tr>
        <tr>
            <td align="right"><label for="fullname">Full Name</label></td>
            <td align="left"><input type="text" name="fullname" required></td>
        </tr>
        <tr>
            <td align="right"><label for="phone">Phone Number (no hyphens)</label></td>
            <td align="left"><input type="tel" name="phonenumber" pattern="[0-9]{3}[0-9]{3}[0-9]{4}"></td>
        </tr>
        <tr>
        </tr>
        <tr>
        <td></td>
            <td align="right"><input type="submit" value="Register"></td>
        </tr>
        </table>
    </form>
        <?php }
    static function displayUsers(Array $user) {
                ?>

                    <section>
                    <h2>All users</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Is Manager?</th>
                                <th>Remove Manager</th>
                                <th>Make manager</th>

                        </thead>
                        <?php
            
                            
                            foreach($user as $u)  {
                                echo "<tr>";
                                echo "<td>" .$u->getID(). "</td>";
                                echo "<td>" .$u->getFullName(). "</td>";
                                echo "<td>" .$u->getEmail(). "</td>";
                                echo "<td>" .$u->getPhoneNumber(). "</td>";
                                if($u->getManager()==true){
                                    echo "<td>Yes</td>";
                                }
                                else{
                                    echo"<td>No</td";
                                }
            

                                echo "<td><a href=\"".$_SERVER['PHP_SELF']."?action=remove&id=".$u->getEmail()."\">Remove</td>";

                                echo "<td><a href=\"".$_SERVER['PHP_SELF']."?action=add&id=".$u->getEmail()."\">Add</td>";
                                echo "</tr>";
                            } 
                    
                    echo '</table>
                        </section>';
              
                }
/*Reservation pages*/
static function getSelectForm($locations,$selected=''){
    ?>
       <section class="form1">              
                        <h2 style="text-align: center;">Select a Location</h2>                        
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" style="display: block; text-align: center;">
                            <div class="form-group">
                            <select name="loc" id="loc" size="4">
                                <?php
                                    foreach($locations as $lo)  {
                                    echo "<option value=\"".$lo->getLocationID()."\">".$lo->getShortName()."</option>";
                                    }                                    
                                    echo "<option value=\"all\" selected>All</option>";                                                                    
                                ?>
                            </select>
                            </div>
                            <div class="form-group">                                                    
                            <button type="submit" name="action" value="Filter">Filter</button>                                                    
                            </div>
                        </form>                                    
    
    <?php
}


static function currentReservation(){
    //Colocar aqui codigo para mostrar situacion actual del usuario
}


static function getOrderData($locations, $spaces){
    ?>
                <!-- Start the page's data form -->
    <section class="main" style="width:70%">

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" style="display: block; text-align: center;">
        <h2>Reserve your parking space</h2>
        <tr>
        <td><label for="lo">Choose your Location:</label>
        <select name="lo" id="lo">
        <?php
            foreach($locations as $lo)  {
            echo "<option value=\"".$lo->getLocationID()."\">".$lo->getShortName()."</option>";
            }                                                                    
            ?>
        </select></td>
        <td>  <label for="id"> Type your parking space:</label>
        <input type="text" id="id" name="id" maxlength="7" size="7" required>
        </td>
        <td>
        <button type="submit" name="action" value="reserve">Reserve</button>        
        </tr>
        <table>
        </table>
        </form>

                    <h3 style="text-align:center;">  
                        <?php
                            echo "All Parking Available :"
                        ?> 
                    </h3>
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
                                    echo "<td><a href=\"".$_SERVER["PHP_SELF"]."?action=reserve&id=".$space->getSpaceID()."&lo=".$space->getLocationID()."\">Reserve</td>";
                                    echo "</tr>";
                                    $i++;
                                }


                        ?>
                    </table>
                    <!--<h3>Tienes una reservacion activa</h3>    -->
                    
            </section>  
                
    <?php   
        
}

//Record module 
static function getHistoryData($spaces, $catID=NULL){
?>
            <!-- Start the page's data form -->
            <section class="table" style="width:80%">
                
                <h3>  
                    <?php
                        echo "This is your reservation history"
                    ?> 
                </h3>
                <table>
                    <?php
                               echo "<thead>";
                                echo "<tr>";
                                    echo "<th width=4%> # </th>";                                        
                                    echo "<th>ID reserv.</th>";
                                    echo "<th>Location</th>";
                                    echo "<th>Space</th>";                                       
                                    echo "<th>Started At</th>";                                       
                                    echo "<th>Ended At</th>";
                                    echo "<th>Status</th>";
                                    echo "<th>Amount</th>";
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
                                echo"<td>".$space->getRecordID()."</td>";
                                echo"<td>".$space->ShortName."</td>";
                                echo"<td>".$space->getSpaceID()."</td>";
                                echo"<td style='color:red;'>".$space->getStartedAt()."</td>";
                                echo"<td style='color:green;'>".$space->getEndedAt()."</td>";
                                
                                echo"<td>".$space->getPaid()."</td>";

                                if ($space->getPaid()=="Reservated"){
                                    echo"<td>".$space->temp_paid."</td>";
                                }else{
                                    echo"<td>".$space->getAmount()."</td>";    
                                }                                                                                            

                                if($space->getPaid()=="Reservated"){
                                    echo "<td><a href=\"".$_SERVER["PHP_SELF"]."?action=paid&id=".$space->getRecordID()."\" style=\"color:green; font-weight: bold;\">PAID</td>";
                                }else{
                                    echo "<td><a href=\"".$_SERVER["PHP_SELF"]."?action=delete&id=".$space->getRecordID()."\" style=\"color:red; font-weight: bold;\">DELETE</td>";
                                }
                                
                                echo "</tr>";
                                $i++;
                                
                            }


                    ?>
                </table>
                <!--<h3>Tienes una reservacion activa</h3>    -->
            </section>  
            
<?php   
    
}

//Last reservation of User
static function statusUser(Record $data, User $user){

    
    echo "</br><p style='text-align:center'>Welcome back ".$user->getFullName()."</p>";
    if($data->pending==0){
        echo "<p style='color:green; text-align:center;'>No tienes pendientes</p>";
    }else{
        if($data->pending==1){
        echo "<p style='color:red ; text-align:center;'>you have ".$data->pending." pending reservation.</p>";
        }else
        {
        echo "<p style='color:red ; text-align:center;'>you have ".$data->pending." pending reservations.</p>";
        }
    }
    if($data->lastdate==NULL){
    echo "</br><p style='text-align:center'>This will be your first reservation</p>";
    }else{
        echo "</br><p style='text-align:center'>Your last reservation was:<br> ".$data->lastdate."</p>";
    }
    echo "</section>";

}


}

?>

