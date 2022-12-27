<?php



if (isset($_POST['submit'])) {
    include "config.php";
    $category_id = mysqli_real_escape_string($conn, $_POST['cat_id']);
    $category_name = mysqli_real_escape_string($conn, $_POST['cat_name']);

    $sql = "UPDATE `category` set category_name='{$category_name}' where category_id={$category_id}";
    if (mysqli_query($conn, $sql)) {
        header("Location:http://localhost//news-template/admin/category.php");
    }
} else {
    echo "<div>Not Submitted!</div>";
}
