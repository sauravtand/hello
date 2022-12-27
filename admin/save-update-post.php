<?php
include "config.php";

if (empty($_FILES['new-image']['name'])) {
  $new_name = $_POST['old-image'];
} else {
  $errors = array();

  $file_name = $_FILES['new-image']['name'];
  $file_size = $_FILES['new-image']['size'];
  $file_tmp = $_FILES['new-image']['tmp_name'];
  $file_type = $_FILES['new-image']['type'];
  $tmp = explode('.', $file_name);
  $end = end($tmp);
  $file_ext = strtolower($end);
  $extensions = array("jpeg", "jpg", "png");
  //inarray helps to search sth in array 
  if (in_array($file_ext, $extensions) == false) {
    echo    $errors[] = "This extension file is not allowed,Please choose a JPG or PNG image";
  }

  if ($file_size > 2097152) {
    echo  $errors[] = "The file size must be 2mb or lower";
  }
  if ($file_size > 2097152) {
    echo  $errors[] = "The file size must be 2mb or lower";
  }
  $new_name = time() . "-" . basename($file_name);
  $target = "upload/" . $new_name;
  $image_name = $new_name;

  if (empty($errors) == true) {
    move_uploaded_file($file_tmp, "upload/" . $image_name);
  } else {
    print_r($errors);
    die();
  }
}


$sql = "UPDATE post SET title='{$_POST["post_title"]}',description='{$_POST["postdesc"]}',category={$_POST["category"]},post_img='{$image_name}'
WHERE post_id={$_POST["post_id"]};";

if ($_POST['old_category'] != $_POST['category']) {
  $sql .= "UPDATE `category` SET `post`= post - 1 WHERE category_id={$_POST['old_category']};";
  $sql .= "UPDATE `category` SET `post`= post + 1 WHERE category_id={$_POST['category']};";
}

//  
$result = mysqli_multi_query($conn, $sql);

if ($result) {
  header("LOcation:{$hostname}/admin/post.php");
} else {
  echo "Query Failed";
}
