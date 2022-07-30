<?php 
    include("config.php");
    use FTP\Connection;
    session_start();

    function image_upload($username,$email,$image){
        $con = Connection();

        //create veriable for image name
        $image_name = $_FILES['images']['name'];
        //veriable for image temp name
        $tmp_name = $_FILES['images']['tmp_name'];
        //error
        $error = $_FILES['images']['error'];

        //check are there any errors
        if($error === 0){
            //get the pathinfo of image
            $jk_image = pathinfo($image_name, PATHINFO_EXTENSION);

            //conver path infor to lowercase
            $jk_image_lower = strtolower($jk_image);

            //images type(I use only 2 types png(PNG) and jpg(jpeg))
            $allowed_img_types = array("png","PNG","jpg","jpeg");

            //error handling 
            //1.check image file type

            if(in_array($jk_image_lower, $allowed_img_types)){
                //make new name for image 
                $new_jk_image = uniqid("image=", true).'.'.$jk_image_lower;

                //make folder and upload images to folder
                $image_file_path = 'upload/'.$new_jk_image;

                //move images to that folder
                move_uploaded_file($tmp_name,$image_file_path);

                //upload files to database
                $insert_image = "INSERT INTO images_tbl(username,email,image_url)VALUES('$username','$email','$new_jk_image')";
                $insert_image_result = mysqli_query($con,$insert_image);
            }
        }
    }

?>