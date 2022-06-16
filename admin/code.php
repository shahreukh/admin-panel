<?php
include('authentication.php');
include('config/dbcon.php');


if(isset($_POST['product_update']))
{
    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $small_description = $_POST['small_description'];
    $long_description = $_POST['long_description'];
    $price = $_POST['price'];
    $offerprice = $_POST['offerprice'];
    $tax = $_POST['tax'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'] == true ? '1':'0';

    $image = $_FILES['image']['name'];
    $old_image = $_FILES['old_image'];

    if($image != '')
    {
        $update_filename = $_FILES['image']['name'];
        
        $allowed_extension = array('png','jpg','jpeg','jfif');
        $file_extension = pathinfo($update_filename, PATHINFO_EXTENSION);
        $filename = time().'.'.$file_extension;

        if(!in_array($file_extension, $allowed_extension))
        {
            $_SESSION ['status'] = "You are allowed to upload only jpg, png or jpeg image.";
            header("Location: product.php");
            exit(0);
        }
        $update_filename = $filename;
    }
    else
    {
        $update_filename = $old_image;
    }

    $query = "UPDATE products SET 
                category_id='$category_id',
                name='$name',
                small_description='$small_description',
                long_description='$long_description',
                price='$price',
                offerprice='$offerprice',
                tax='$tax',
                quantity='$quantity',
                image='$update_filename',
                status='$status'
                WHERE id='$product_id' ";

    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        if($image !='')
        {
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/product/'.$filename);
            if(file_exists('uploads/product/'.$old_image))
            {
                unlink('uploads/product/'.$old_image);
            }
        }
        $_SESSION ['status'] = "Product updated successfully.";
        header('Location: product-edit.php?prod_id='.$product_id);
        exit(0);
    }
    else
    {
        $_SESSION ['status'] = "Product not updated.";
        header('Location: product-edit.php?prod_id='.$product_id);
        exit(0);
    }
}


if(isset($_POST['prod_delete_btn']))
{
    $prod_id = $_POST['prod_delete_id'];

    $query = "DELETE FROM products WHERE id='$prod_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION ['status'] = "Product Deleted Successfully";
        header("Location: product.php");
    }
    else
    {
        $_SESSION ['status'] = "Product Deleting Failed";
        header("Location: product.php");
    }
}


if(isset($_POST['product_save']))
{
    
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $small_description = $_POST['small_description'];
    $long_description = $_POST['long_description'];
    $price = $_POST['price'];
    $offerprice = $_POST['offerprice'];
    $tax = $_POST['tax'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'] == true ? '1':'0';
    $image = $_FILES['image']['name'];

    $allowed_extension = array('png','jpg','jpeg');
    $file_extension = pathinfo($image, PATHINFO_EXTENSION);

    $filename = time().'.'.$file_extension;

    if(!in_array($file_extension, $allowed_extension))
    {
        $_SESSION ['status'] = "You are allowed to upload only jpg, png or jpeg image.";
        header("Location: product-add.php");
        exit(0);
    }
    else
    {
        $query = "INSERT INTO products (category_id,name,small_description,long_description,price,offerprice,tax,quantity,image,status) VALUES ('$category_id','$name','$small_description','$long_description','$price','$offerprice','$tax','$quantity','$filename','$status') ";
        $query_run = mysqli_query ($con, $query);

        if($query_run)
        {
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/product/'.$filename);
            $_SESSION ['status'] = "Product added successfully.";
            header("Location:product-add.php");
        }
        else
        {
            $_SESSION ['status'] = "Something went wrong.";
            header("Location:product-add.php");
        }
    
    }
}


if(isset($_POST['category_save']))
{
    $name = $_POST['name'];
    $description = $_POST['description'];
    $trending = $_POST['trending'] == true ? '1':'0';
    $status = $_POST['status'] == true ? '1':'0';

    $category_query = "INSERT INTO categories (name,description,trending,status) VALUES ('$name','$description','$trending','$status')";
    $cate_query_run = mysqli_query($con, $category_query);
    if($cate_query_run)
    {
        $_SESSION['status'] = "Category inserted successfully.";
        header("Location: category.php");
    }
    else
    {
        $_SESSION['status'] = "Category insertion failed.";
        header("Location: category.php");
    }
}


if(isset($_POST['category_update']))
{
    $cate_id = $_POST['cate_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $trending = $_POST['trending'] == true ? '1': '0' ;
    $status = $_POST['status'] == true ? '1': '0' ;

    $query = "UPDATE categories SET name='$name',description='$description',trending='$trending',status='$status' WHERE id='$cate_id' ";
    $query_run = mysqli_query ($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Category Updated Successfully.";
        header("Location: category.php");
    }
    else
    {
        $_SESSION['status'] = "Category Updating Failed.";
        header("Location: category.php");
    }
}


if(isset($_POST['DeleteUserbtn']))
{
    $userid = $_POST['delete_id'];

    $query = "DELETE FROM users WHERE id='$userid'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION ['status'] = "User Deleted Successfully";
        header("Location: registered.php");
    }
    else
    {
        $_SESSION ['status'] = "User Deleting Failed";
        header("Location: registered.php");
    }
}


if(isset($_POST['cate_delete_btn']))
{
    $cate_id = $_POST['cate_delete_id'];

    $query = "DELETE FROM categories WHERE id='$cate_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION ['status'] = "Category Deleted Successfully";
        header("Location: category.php");
    }
    else
    {
        $_SESSION ['status'] = "Category Deleting Failed";
        header("Location: category.php");
    }
}


if(isset($_POST['logout_btn']))
{
    //session_destroy();
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);

    $_SESSION['status'] = "Logged out successfully.";
    header('Location: login.php');
    exit(0);
}


if(isset($_POST['check_Emailbtn']))
{
    $email = $_POST['email'];

    $checkemail = "SELECT email FROM users WHERE email='$email' ";
    $checkemail_run = mysqli_query($con, $checkemail);

    if(mysqli_num_rows($checkemail_run) > 0)
    {
        echo"Email id already taken.";    
    }
    else
    {
        echo"It is available";
    }
}

if(isset($_POST['addUser']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    if($password == $confirmpassword)
    {
    
    $checkemail = "SELECT email FROM users WHERE email='$email'";
    $checkemail_run = mysqli_query($con, $checkemail);

    if(mysqli_num_rows($checkemail_run) > 0)
    {
        // Token Already Exists
        $_SESSION ['status'] = "Email id is already taken!";
        header("Location: registered.php");
        exit;    
    }
    else
    {
        // Availabale = Record not found.
        $user_query = "INSERT INTO users (name,phone,email,password) VALUES ('$name','$phone','$email','$password')";
        $user_query_run = mysqli_query($con,$user_query);
   
    if($user_query_run)
    {
        $_SESSION ['status'] = "User Added Successfully";
        header("Location: registered.php");
    }
    else
    {
        $_SESSION ['status'] = "User Registration Failed";
        header("Location: registered.php");
    }
  }
}
  else
  {
    $_SESSION ['status'] = "Password and Confirm Password does not match";
    header("Location: registered.php");
  }
}


if(isset($_POST['UpdateUser']))
{
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_as = $_POST['role_as'];

    $query = "UPDATE users SET name='$name', phone='$phone', email='$email', password='$password', role_as='$role_as' WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION ['status'] = "User Updated Successfully";
        header("Location: registered.php");
    }
    else
    {
        $_SESSION ['status'] = "User Updating Failed";
        header("Location: registered.php");
    }
}


?>