<?php
include "database.class.php";
include "connect.php";
//create object
$process = new Database();

//Add_user
if (isset($_POST['send_branduid'])) {
    //รับข้อมูลจาก FORM ส่งไปที่ Method add_user
    $process->add_user($_POST);
}

//show edit data form
if (isset($_POST['show_user_id'])) {

    $edit_user = $process->get_user($_POST['show_user_id']);

    echo '<form id="edit_user_form">
			  <div class="form-group">
				<label >Date</label>
				<input type="datetime-local" class="form-control" name="edit_date" value="' . $edit_user['date'] . '">
			  </div>
			  <div class="form-group">
				<label >Action : </label><input type="text" class="form-control" readonly value="' . $edit_user['action'] . '"><br/>
				<input type="radio" class="form-check-input" name="edit_action" value="Buy"';
    if ($edit_user['action']=="Buy"){
        echo 'checked="checked"';
    }
    echo '>
                 <label class="form-check-label" for="flexRadioDefault1">
                    Buy
                </label>
                <input type="radio" class="form-check-input" name="edit_action" value="Sell"';
    if ($edit_user['action']=="Sell"){
        echo 'checked="checked"';
    }
    echo '>
                <label class="form-check-label" for="flexRadioDefault1">
                    Sell
                </label>
			  </div>
                        <div class="form-group">
                            <label>Brand</label>
                            ';
    $sql = "SELECT * FROM brand";
    $result = $con->query($sql);
    $sql2 = "SELECT * FROM brand WHERE id =" . $edit_user["branduid"];
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    echo '<select name="edit_branduid">
          <option value="' . $row2['id'] . '">' . $row2['name'] . '</option>';
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
    echo '</select>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" name="edit_qty" value="' . $edit_user['qty'] . '">
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" name="edit_price" value="' . $edit_user['price'] . '">
                        </div>
                        <div class="form-group">
                            <label>Tips</label>
                            <input type="number" class="form-control" name="edit_tips" value="' . $edit_user['tips'] . '">
                        </div>
			  <input type="hidden" name="edit_user_id" value="' . $edit_user['id'] . '" >
			</form>';
}

//edit user 
if (isset($_POST['edit_user_id'])) {

    $process->edit_user($_POST);
}

//delete user
if (isset($_POST['delete_user_id'])) {

    $process->delete_user($_POST['delete_user_id']);
}
