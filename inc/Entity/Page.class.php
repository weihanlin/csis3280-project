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
                        <li class="active"><a href="#">Home</a></li>

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

                        <li><a href="#">Page 1</a></li>
                        <li><a href="#">Page 2</a></li>
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
            <table>
                <thead><tr>
                    <th>ID</th>
                    <th>ShortName</th>
                    <th>Address</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr></thead>
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
            <table>
                <thead><tr>
                    <th>Location</th>
                    <th>ID</th>
                    <th>Unit Price</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr></thead>
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
}
