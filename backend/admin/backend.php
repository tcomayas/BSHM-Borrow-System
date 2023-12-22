<?php
require './backendHelper.php';

class backend {

  public function addUtilityItem($item_name, $item_img, $item_qty) {
    return backendHelper::addUtilityItem($item_name, $item_img, $item_qty);
  }

  public function getUtilityItem($item_id) {
    return backendHelper::getUtilityItem($item_id);
  }

  public function updateUtilityItem($item_id, $item_qty) {
    return backendHelper::updateUtilityItem($item_id, $item_qty);
  }

  public function borrowUtilityItem($user_id,$item_id,$item_qty) {
    return backendHelper::borrowUtilityItem($user_id,$item_id,$item_qty);
  }

  public function returnItem($borrow_id) {
    return backendHelper::returnItem($borrow_id);
  }

  public function getMyItemBorrowed($user_id) {
    return backendHelper::getMyItemBorrowed($user_id);
  }

 //------------------------------------------------ done here
  public function storeAnnouncement($title,$description,$photo) {
    return backendHelper::storeAnnouncement($title,$description,$photo);
  }
}

?>
