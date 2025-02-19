<?php
//test
include "database.class.php";
include "connect.php";
header("refresh: 300;");

//new database
$db = new Database();

if (isset($_POST['search_user'])) {
    //get search user
    $get_user = $db->search_user($_POST['search_user']);
} else {

    //call method getUser
    $get_user = $db->get_all_user();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Beer Open Bar</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="script.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="img/favicon.ico">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h4>Beer Open Bar</h4>
                <div class="col-md-6">
                    <button class="btn btn-info" data-toggle="modal" data-target="#add_user">Add</button>
                </div>

                <div class="col-md-6">
                    <div class="pull-right">
                        <!-- form สำหรับค้นหาข้อมูล -->
                        <form class="form-inline" method="POST" action="index.php">
                            <div class="form-group">
                                <input type="text" class="form-control" name="search_user" placeholder="">
                            </div>
                            <input class="btn btn-primary" type="submit" value="Search">
                        </form>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="10%">ลำดับ</th>
                            <th width="20%">Date</th>
                            <th width="10%">Action</th>
                            <th width="20%">Brand</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">Price</th>
                            <th width="10%">Tips</th>
                            <th width="5%">Edit</th>
                            <th width="5%">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $i = 1;
                        if (!empty($get_user)) {
                            foreach ($get_user as $user) {
                        ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $user['date'] ?></td>
                                    <td><?php echo $user['action'] ?></td>
                                    <td><?php
                                        $sql = "SELECT * FROM brand WHERE id =" . $user["branduid"];
                                        $result = $con->query($sql);
                                        $row = $result->fetch_assoc();
                                        echo $row['name'] ?></td>
                                    <td><?php echo $user['qty'] ?></td>
                                    <td><?php echo $user['price'] ?></td>
                                    <td><?php echo $user['tips'] ?></td>
                                    <td><button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_user" onclick="return show_edit_user(<?php echo $user['id'] ?>);">Edit</button></td>
                                    <td><button class="btn btn-danger btn-xs" onclick="return delete_user(<?php echo $user['id'] ?>);">Delete</button></td>
                                </tr>

                        <?php
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='5'>ไม่พบข้อมูล</td></tr>";
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>


    <!-- Modal Add User -->
    <div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add</h4>
                </div>
                <div class="modal-body">
                    <form id="add_user_form">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="datetime-local" class="form-control" name="send_date" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Action</label>
                            <input type="radio" class="form-check-input" name="send_action" value="Buy">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Buy
                            </label>
                            <input type="radio" class="form-check-input" name="send_action" value="Sell" checked="checked">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Sell
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Brand</label>
                            <?php
                            $sql = "SELECT * FROM brand";
                            $result = $con->query($sql);
                            ?>
                            <select name='send_branduid'>
                                <option value="">--Select--</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $name = $row['name'];
                                ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" name="send_qty" placeholder="Quantity">
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" name="send_price" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <label>Tips</label>
                            <input type="number" class="form-control" name="send_tips" placeholder="Tips">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="return add_user_form();">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit</h4>
                </div>
                <div class="modal-body">
                    <div id="edit_form"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="return edit_user_form();">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>