<?php
require './database.php';
require './queryHelper.php';

class backendHelper {
  public static function addUtilityItem ($item_name, $item_img, $item_qty) {
    try {
      $query = new queryHelper();
      $db = new Database();
      if ($db->getStatus()) {
        $stmt = $db->getConn()->prepare($query->addUtilityItemQuery());
        $stmt->execute(array($item_name,$item_img,$item_qty));
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res) {
          $db->closeConn();
          return json_encode(['status' => '201', 'message' => 'Item has been successfully added to the inventory']);
        } else {
          $db->closeConn();
          return json_encode(['status' => '403']);
        }
      } else {
        return json_encode(['status' => '403']);
      }
    } catch (PDOException $th) {
      return json_encode(['status' => '501', 'message' => $th->getMessage()]);
    }
  }

  public static function getUtilityItem($item_id) {
    try {
      $query = new queryHelper();
      $db = new Database();
      if ($db->getStatus()) {
        $stmt = $db->getConn()->prepare($query->getUtilityItemsQuery());
        $stmt->execute(array($item_id));
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->closeConn();
        return json_encode($res);
      } else {
        return json_encode(['status' => '403']);
      }
    } catch (PDOException $th) {
      return json_encode(['status' => '501']);
    }
  }

  public static function updateUtilityItem($item_id, $item_qty) {
    try {
      $query = new queryHelper();
      $db = new Database();
      if ($db->getStatus()) {
        $stmt = $db->getConn()->prepare($query->updateUtilityItemQuery());
        $stmt->execute(array($item_id, $item_qty));
        $res = $stmt->fetch();
        if ($res) {
          $db->closeConn();
          return json_encode(['status' => '201', 'message' => 'item updated successfully']);
        } else {
          $db->closeConn();
          return json_encode(['status' => '403', 'message' => 'empty res']);
        }
        
      } else {
        return json_encode(['status' => '403', 'message' => 'no connection']);
      }
      
    } catch (PDOException $th) {
      return json_encode(['status' => '501']);
    }
  }

  public static function borrowUtilityItem($user_id,$item_id,$item_qty) {
    try {
      $query = new queryHelper();
      $db = new Database();
      if ($db->getStatus()) {
        $stmt = $db->getConn()->prepare($query->borrowUtilityItemQuery());
        $stmt->execute(array($user_id,$item_id,$item_qty));
        $res = $stmt->fetch();
        if ($res) {
          $db->closeConn();
          return json_encode(['status' => '201', 'message' => 'Successful borrowing this item']);
        } else {
          $db->closeConn();
          return json_encode(['status' => '403']);
        }
      } else {
        return json_encode(['status' => '403']);
      }
      
    } catch (PDOException $th) {
      return json_encode(['status' => '501']);
    }
  }

  public static function returnItem($borrow_id) {
    try {
      $query = new queryHelper();
      $db = new Database();
      if ($db->getStatus()) {
        $stmt = $db->getConn()->prepare($query->returnItemQuery());
        $stmt->execute(array($borrow_id));
        $res = $stmt->fetch();
        if ($res) {
          $db->closeConn();
          return json_encode(['status' => '201', 'message' => 'item returned successfully']);
        } else {
          $db->closeConn();
          return json_encode(['status' => '403']);
        }
      } else {
        return json_encode(['status' => '403']);
      }
    } catch (PDOException $th) {
      return json_encode(['status' => '501']);
    }
  }

  public static function getMyItemBorrowed($user_id) {
    try {
      $query = new queryHelper();
      $db = new Database();
      if ($db->getStatus()) {
        $stmt = $db->getConn()->prepare($query->getMyItemBorrowedQuery());
        $stmt->execute(array($user_id));
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
          $db->closeConn();
          return json_encode($res);
        } else {
          $db->closeConn();
          return json_encode(['status' => '403']);
        }
      } else {
        return json_encode(['status' => '403']);
      }
    } catch (PDOException $th) {
      return json_encode(['status' => '501']);
    }
  }

 //------------------------------------------------ not done here
  public static function storeAnnouncement($title,$description,$photo) {
    try {
      $query = new queryHelper();
      $db = new Database();
      if ($db->getStatus()) {
        $stmt = $db->getConn()->prepare($query->storeAnnouncement());
        $stmt->execute(array($title,$description,$photo));
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res) {
          $db->closeConn();
          return json_encode(['status' => '201', 'message' => 'Announcement added successfully']);
        } else {
          $db->closeConn();
          return json_encode(['status' => '403']);
        }
      } else {
        return json_encode(['status' => '403']);
      }
    } catch (PDOException $th) {
      return json_encode(['status' => '501']);
    }
  }
}

?>
