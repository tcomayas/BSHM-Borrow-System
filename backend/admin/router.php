<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require './backend.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['choice'])) {
    $choice = $_POST['choice'];
    $back = new backend();
    if ($choice === 'get') {
        echo $back->getUtilityItem($_POST['item_id']);
    } elseif ($choice === 'update') {
        echo $back->updateUtilityItem($_POST['item_id'], $_POST['item_qty']);
    } elseif ($choice === 'borrow') {
        echo $back->borrowUtilityItem($_POST['user_id'], $_POST['item_id'], $_POST['item_qty']);
    } elseif ($choice === 'return') {
        echo $back->returnItem($_POST['borrow_id']);
    } elseif ($choice === 'my_item') {
        echo $back->getMyItemBorrowed($_POST['user_id']);
    } elseif ($choice === 'announcement') {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
          $uploadDir = 'images/';

          $fileImg = explode('.',$_FILES['image']['name']);
          $ext = end($fileImg);
          $name = time() . '.' . $ext;

          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $name)) {
              $title = isset($_POST['title']) ? $_POST['title'] : 'No title provided';
              $description = isset($_POST['description']) ? $_POST['description'] : 'No description provided';

              echo $back->storeAnnouncement($title,$description,$name);
          } else {
              echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
          }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload error']);
        }
    } elseif ($choice === 'add_item') {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
          $uploadDir = 'images/';

          $fileImg = explode('.',$_FILES['image']['name']);
          $ext = end($fileImg);
          $name = time() . '.' . $ext;

          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $name)) {
              $item_name = isset($_POST['item_name']) ? $_POST['item_name'] : 'No item name provided';
              $item_qty = isset($_POST['item_qty']) ? $_POST['item_qty'] : 'No item quantity provided';

              echo $back->addUtilityItem($item_name, $name,$item_qty);
          } else {
              echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
          }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload error']);
        }
    } else {
        echo "Wrong choice";
    }
  } else {
    echo "Empty choice";
  }
}
?>

