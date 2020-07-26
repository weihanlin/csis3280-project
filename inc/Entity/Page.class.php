<?php
class Page {
    public static $title = "";

    static function header() {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="author" content="Weihan">
            <title><?= self::$title ?></title>
            <link href="css/styles_001.css" rel="stylesheet">
        </head>
        <body>
            <header>
                <h1><?= self::$title ?></h1>
            </header>
            <article>

        <?php
    }

    static function footer() {
        ?>
            </article>
        </body>
        </html>
        <?php
    }

    static function listLocations(Array $data) {
        ?>
        <section class="main">
            <h2>Current Data</h2>
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
                    echo "<td><a href=?action=delete&lid={$datum->getLocationID()}>Delete</a></td>";
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
                    echo "<td><a href=?action=delete&sid={$datum->getSpaceID()}&lid={$datum->getLocationID()}>Delete</a></td>";
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
            <h2>Create Location</h2>
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
            <h2>Create Space</h2>
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
                        <td><input type="number" name="spaceid"></td>
                    </tr>
                    <tr>
                        <td>Unit Price</td>
                        <td><input type="number" step="0.01" name="price"></td>
                    </tr>
                </table>

                <button type="submit" name="action" value="create">Add One</button>
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
                        <td><input type="number" name="spaceid" value="<?= $target->getSpaceID() ?>" readonly></td>
                    </tr>
                    <tr>
                        <td>Unit Price</td>
                        <td><input type="number" step="0.01" name="price" value="<?= $target->getPrice() ?>"></td>
                    </tr>
                </table>
                <button value="edit" type="submit" name="action">Submit</button>
                <button value="cancel" type="reset" name="action">Reset</button>
            </form>
        </section>

        <?php
    }

}