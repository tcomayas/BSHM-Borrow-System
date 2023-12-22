<?php
class queryHelper {
  public function addUtilityItemQuery() {
    return "CALL sp_addUtilityItem(?,?,?)";
  }

  public function getUtilityItemsQuery() {
    return "CALL sp_getUtilityItems(?)";
  }

  public function updateUtilityItemQuery() {
    return "CALL sp_updateUtilityItem(?,?)";
  }
  public function borrowUtilityItemQuery() {
    return "CALL sp_borrowUtilityItem(?,?,?)";
  }

  public function returnItemQuery() {
    return "CALL sp_returnItem(?)";
  }

  public function getMyItemBorrowedQuery() {
    return "CALL sp_getMyItemBorrowed(?)";
  }
 //------------------------------------------------ not done here
  public function storeAnnouncement() {
    return "CALL sp_store_announcement(?,?,?)";
  }
}
?>
