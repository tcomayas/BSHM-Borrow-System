<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once(__DIR__ . '/Student.php');
    require_once(__DIR__ . '/Announcement.php');
    global $parsed;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $method = isset($_POST['method']) ? $_POST['method'] : '';
        // $method = "getAllStudents";
        if(function_exists($method)) {
            call_user_func($method);
        }
        else {
          $json = file_get_contents('php://input');
          $parsed = json_decode($json, true);

          if (function_exists($parsed['method'])) {
            call_user_func($parsed['method']);
          } else {
            echo "Not set metho";
          }
        }
    }

    function signup(){

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $department = $_POST['department'];
        $password = $_POST['password'];
        $role = "Student";

        $studArr = array(
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "department" => $department,
            "password" => $password,
            "role" => $role
        );
        $student = new Student();
        $ret = $student->insert_student($studArr);
        echo json_encode($student->getStudentByEmailFromModel($studArr));
    }

    function signin() {
        // $email = 
        // $password = $_POST['password'];

        // $email = "young@chae.boang";
        // $password = "asdasd";
        global $parsed;
        $email = $parsed['email'];
        $password = $parsed['password'];

        $studArr = array(
            "email" => $email,
            "password" => $password,
        );
        $student = new Student();
        echo json_encode($student->signin_student($email,$password));
    }

    function getAllStudents() {
        $student = new Student();
        echo json_encode($student->getAllStudentsFromModel());
        // echo "bruh";
        // print_r($student->getAllStudentsFromModel());
    }

    function updateUser() {
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $department = $_POST['department'];
        $role = $_POST['role'];
        $password = $_POST['password'];

        $studArr = array(
            "id" => $id,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "department" => $department,
            "role" => $role,
            "password" => $password
        );

        $student = new Student();
        $student->update_student($studArr);
        echo json_encode($student->getStudentFromModel($studArr));

    }

    function deleteUser() {
        $id = $_POST['id'];

        $studArr = array(
            "id" => $id
        );

        $student = new Student();
        $student->delete_student($studArr);
    }

    function storeAnnouncement() {
        $title = $_POST['title'];
        $description = $_POST['description'];
    
        // Check if a file was uploaded successfully
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photo = $_FILES['photo']['name'];
    
            // Specify the destination path within the "src/assets" directory
            $destination = 'src/assets/' . $photo;
    
            // Move the uploaded file to the specified location
            move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
        } else {
            $photo = null;  // Set to null or handle the absence of a file based on your requirements
        }

        return dd($photo);
    
        $date = new DateTime('now');
        $formatted_date = date_format($date, "Y-m-d H-i-s");
    
        $announcementArr = array(
            "title" => $title,
            "description" => $description,
            "photo" => $photo,
            "created_at" => $formatted_date,
        );
    
        $announcement = new Announcement();
        $ret = $announcement->store_announcement($announcementArr);
    
        echo json_encode($announcementArr);


    }
    

    function getAllAnnouncements() {
        $announcement = new Announcement();
        echo json_encode($announcement->getAllAnnouncementsFromModel());
        // echo "bruh";
        // print_r($student->getAllStudentsFromModel());
    }

    function updateAnnouncement() {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $photo = $_POST['photo'];
        
        $announcementArr = array(
            "id" => $id,
            "title" => $title,
            "description" => $description,
            "photo" => $photo
        );

        $announcement = new Announcement();
        $ret = $announcement->update_announcement($announcementArr);
        echo json_encode($announcement->getAllAnnouncementsFromModel());
    }

    function deleteAnnouncement() {
        $id = $_POST['id'];

        $announcementArr = array(
            "id" => $id
        );

        $announcement = new Announcement();
        $ret = $announcement->delete_announcement($announcementArr);
        echo json_encode($announcement->getAllAnnouncementsFromModel());

    }

    function get_student() {
        $id = "1";

        $studentArr = array(
            "id" => $id
        );

        $student = new Student();
        echo json_encode($student->getStudentFromModel($studentArr));
    }

    // get_student();
