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
                        <li><a href="UserProfile.php">Profile</a></li>

                        <!--  Hide this option if this session is not admin   -->
                        <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']==true) { ?>
                        
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Manage
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="AdminProfile.php">Manage Admins</a></li>
                                <li><a href="ManageLocations.php">Locations</a></li>
                                <li><a href="ManageSpaces.php">Spaces</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <!--   End   -->

                        <li><a href="ShowStats.php">Statistic</a></li>
                        <li><a href="reservationHistory.php">History</a></li>
                    </ul>
                    <!-- Hide if not logged in -->
                    <?php if(isset($_SESSION['email'])) {?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="parkingLogout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    </ul>
                    <?php } ?>
                     <!--   End   -->
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

            <table class="table table-hover table-striped">
                <thead><tr>
                    <th onclick="sortcol(1)">ID   <span class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
                    <th onclick="sortcol(2)">ShortName   <span class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
                    <th onclick="sortcol(3)">Address   <span class="glyphicon glyphicon-sort" aria-hidden="true"></span></th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr></thead>
                <tbody id="restable">
                <?php
                foreach($data as $datum){
                    $ucaddr = ucwords($datum->getAddress());
                    echo "<tr>";
                    echo "<td>{$datum->getLocationID()}</td>";
                    echo "<td>{$datum->getShortName()}</td>";
                    echo "<td>{$ucaddr}</td>";
                    echo "<td><a href=?action=edit&lid={$datum->getLocationID()}>Edit</a></td>";
                    echo "<td><a href='#' data-locid='{$datum->getLocationID()}'
                                        data-name='{$datum->getShortName()}'
                                        data-addr='{$ucaddr}'
                                        data-href='?action=delete&lid={$datum->getLocationID()}'
                                        data-toggle='modal' data-target='#confirm-delete'>Delete</a></td>";

                    echo "</tr>";
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

            <table class="table table-hover table-striped">
                <thead><tr>
                    <th onclick="sortcol(1)">Location   <span class="glyphicon glyphicon-sort" aria-hidden="true"></th>
                    <th onclick="sortcol(2)">Space ID   <span class="glyphicon glyphicon-sort" aria-hidden="true"></th>
                    <th onclick="sortcol(3)">Unit Price   <span class="glyphicon glyphicon-sort" aria-hidden="true"></th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr></thead>
                <tbody id="restable">
                <?php

                foreach($data as $datum){
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
                <div class="form-group">
                        <label>Short Name</label>
                        <input class="form-control" type="text" name="shortname">
                </div>
                <div class="form-group">
                        <label>Address</label>
                        <input class="form-control" type="text" name="addr">
                </div>
                <div class="btn-group btn-group-justified" role="group">
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" type="submit" name="action" value="create">Add One</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" type="submit" name="action" value="search">Search</button>
                    </div>
                </div>
            </form>
        </section>

        <?php
    }

    static function editLocationForm(Location $target) {
        ?>
        <section class="form1">
            <h2>Edit Location</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                    <label>Location ID</label>
                    <input class="form-control" name="locationid" value="<?= $target->getLocationID() ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Short Name</label>
                    <input class="form-control" type="text" name="shortname" value="<?= $target->getShortName() ?>">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input class="form-control" type="text" name="addr" value="<?= ucwords($target->getAddress()) ?>">
                </div>
                <div class="btn-group btn-group-justified" role="group">
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" value="edit" type="submit" name="action">Submit</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" value="cancel" type="reset" name="action">Reset</button>
                    </div>
                </div>
            </form>
        </section>

        <?php
    }


    static function createSpaceForm(Array $target) {
        ?>

        <section class="form1">
            <h2>Space</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                    <label>Location</label>

                            <select class="form-control" name="locationid">
                                <?php
                                    foreach ($target as $item) {
                                        echo "<option value={$item->getLocationID()}>{$item->getShortName()}</option>>";
                                    }
                                ?>
                            </select>
                </div>
                <div class="form-group">
                    <label>Space ID</label>
                    <input class="form-control" type="number" min="1" name="spaceid">
                </div>
                <div class="form-group">
                    <label>Unit Price</label>
                    <input class="form-control" type="number" min="0" step="0.01" name="price">
                </div>
                <div class="btn-group btn-group-justified" role="group">
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" type="submit" name="action" value="create">Add One</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" type="submit" name="action" value="search">Search</button>
                    </div>
                </div>
            </form>
        </section>

        <?php
    }

    static function editSpaceForm(space $target, Array $parameter) {
        ?>
        <section class="form1">
            <h2>Edit Space</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                        <label>Location</label>
                            <input name="locationid" value="<?= $target->getLocationID() ?>" hidden>
                            <input class="form-control"  type="text" name="shortname" value="<?php
                            foreach ($parameter as $item) {
                                if($target->getLocationID() == $item->getLocationID())
                                    echo $item->getShortName();
                            }
                            ?>" readonly>

                </div>
                <div class="form-group">
                        <label>Space ID</label>
                        <input class="form-control"  type="number" name="spaceid" min="1" value="<?= $target->getSpaceID() ?>" readonly>
                </div>
                <div class="form-group">
                        <label>Unit Price</label>
                        <input class="form-control"  type="number" step="0.01" min="0" name="price" value="<?= $target->getPrice() ?>">
                </div>
                <div class="btn-group btn-group-justified" role="group">
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" value="edit" type="submit" name="action">Submit</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-default" value="cancel" type="reset" name="action">Reset</button>
                    </div>
                </div>
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
 <!--   For Admins Only   -->
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
                                    echo"<td>No</td>";
                                }
                                if($_SESSION['email'] == $u->getEmail()||$u->getID()==1){
                                    echo"<td></td><td></td>";
                                }
                                else{
                                echo "<td><a href=\"".$_SERVER['PHP_SELF']."?action=remove&id=".$u->getEmail()."\">Remove</td>";

                                echo "<td><a href=\"".$_SERVER['PHP_SELF']."?action=add&id=".$u->getEmail()."\">Add</td>";
                                }
                                echo "</tr>";
                            } 
                    
                    echo '</table>
                        </section>';
              
                }
                   static function editUser(User $user)
                {  ?>

                    <section>
                        <h2>Edit Profile - <?php echo $user->getFullName(); ?></h2>
                        <form action="" method="post">
                            <table>
                            <tr>
                                <td>Email</td>
                                <td><?php echo $user->getEmail();?></td>
                            <tr>
                                <td align="right"><label for="fullname">Full Name</label></td>
                                <td align="left"><input type="text" name="fullname" value="<?php echo $user->getFullName();?>" required></td>
                            </tr>
                            <tr>
                                <td align="right"><label for="phone">Phone Number (no hyphens)</label></td>
                                <td align="left"><input type="tel" name="phonenumber" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" value="<?php echo $user->getPhoneNumber(); ?>" required></td>
                            </tr>
                            <tr>
                                <td align="right"><label for="password">Enter your password to confirm changes</label></td>
                                <td align="left"><input type="password" name="password" required></td>
                            </tr>
                            </table>

                            <input type="submit" value="Update Profile">
                        </form>
                    </section>

            <?php }
            static function changePassword(){?>
                <form action="" method="post">
                <table>
                    <tr>
                        <td align="right"><label for="password_old">Current Password</label></td>
                        <td align="left"><input type="password" name="password_old" required></td>
                    </tr>
                    <tr>
                        <td align="right"><label for="password">New Password</label></td>
                        <td align="left"><input type="password" name="password" required></td>
                    </tr>
                    <tr>
                        <td align="right"><label for="password_confirm">Confirm Password</label></td>
                        <td align="left"><input type="password" name="password_confirm" required></td>
                    </tr>
                    <tr>
                        <td align="right"><input type="submit" value="Change Password"></td>
                    </tr>
                </table>
            </form>
            <?php
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
                                        if($selected == $lo->getLocationID()){
                                            echo "<option value=\"".$lo->getLocationID()."\" selected>".$lo->getShortName()."</option>";
                                        }
                                        else{
                                            echo "<option value=\"".$lo->getLocationID()."\">".$lo->getShortName()."</option>";
                                        }

                                    }
                                    if($selected=='all'||$selected==null){
                                        echo "<option value=\"all\" selected>All</option>";
                                    }else{
                                        echo "<option value=\"all\">ALL</option>";
                                    }

                                ?>
                            </select>
                            </div>
                            <div class="form-group">
                            <button type="submit" name="action" value="Filter">Filter</button>
                            </div>
                        </form>

    <?php
}


static function getOrderData($locations, $spaces){
    ?>

<!-- Start Reservation confirmation modal -->
<div class="modal fade" id="confirm-reserve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Paid</h4>
                    </div>

                    <div class="modal-body">
                        <p>You will make a reservation.</p>
                        <p>Do you want to proceed?</p>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-success btn-ok">Reserve</a>
                    </div>
                </div>
            </div>
        </div>

    <!-- End of Modal -->



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
        <button type="submit" name="action" value="reserve" onclick="return confirm('Are you sure you want to reserve this space?');">Reserve</button>
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
                                    echo "<td><a data-href=\"".$_SERVER["PHP_SELF"]."?action=reserve&id=".$space->getSpaceID()."&lo=".$space->getLocationID()."\" data-toggle=\"modal\" data-target=\"#confirm-reserve\">Reserve</td>";
                                    echo "</tr>";
                                    $i++;
                                }


                        ?>
                    </table>

            </section>

            <!-- script for modal of creating a new reservation -->
            <script>
        $('#confirm-reserve').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

            $('.debug-url').html('Reserve URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
        });
    </script>



    <?php

}

//Record module
static function getHistoryData($spaces, $catID=NULL){
?>
    <!-- Start Delete confirmation modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    </div>

                    <div class="modal-body">
                        <p>You are about to delete the record, this procedure is irreversible.</p>
                        <p>Do you want to proceed?</p>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>

    <!-- End of Modal -->


    <!-- Start Paid confirmation modal -->
    <div class="modal fade" id="confirm-paid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirm Paid</h4>
                    </div>

                    <div class="modal-body">
                        <p>You will pay the reservation, this procedure is irreversible.</p>
                        <p>Do you want to proceed?</p>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary btn-ok">Pay</a>
                    </div>
                </div>
            </div>
        </div>

    <!-- End of Modal -->


            <!-- Start the page's data form -->
            <section class="table" style="width:100%;">

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

                                if ($space->getPaid()=="Reserved"){
                                    echo"<td> $ ".sprintf('%.2f', $space->temp_paid)."</td>";
                                }else{
                                    echo"<td> $ ".sprintf('%.2f', $space->getAmount())."</td>";
                                }

                                if($space->getPaid()=="Reserved"){
                                    echo "<td><a data-href=\"".$_SERVER["PHP_SELF"]."?action=paid&id=".$space->getRecordID()."\" style=\"color:green; font-weight: bold;\" data-toggle=\"modal\" data-target=\"#confirm-paid\">PAID</td>";
                                }else{
                                    echo "<td><a data-href=\"".$_SERVER["PHP_SELF"]."?action=delete&id=".$space->getRecordID()."\" style=\"color:red; font-weight: bold;\" data-toggle=\"modal\" data-target=\"#confirm-delete\">DELETE</td>";
                                }

                                echo "</tr>";
                                $i++;

                            }


                    ?>
                </table>

            </section>

            <!-- script for modal of update and elimination of reservation -->
    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

            $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
        });

        $('#confirm-paid').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

            $('.debug-url').html('Paid URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
        });
    </script>

<?php

}

//Last reservation of User
static function statusUser(Record $data, User $user){


    echo "</br><p style='text-align:center'>Welcome back ".$user->getFullName()."</p>";
    if($data->pending==0){
        echo "<p style='color:green; text-align:center;'>You don't have pending reservations</p>";
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
