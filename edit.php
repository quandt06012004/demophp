<?php
    include 'connect.php';

    $id = $_GET['id'];
    $errors =[];
    $types = ['image/jpg'];
    $provin = "SELECT * from province order by id desc";
    $mypv = mysqli_query($conn, $provin);

    $human = "SELECT * FROM human where id = $id";
    $myhm = mysqli_query($conn, $human);
    $fethm = mysqli_fetch_object($myhm);
    echo '<pre>';
    print_r($fethm);
    echo '</pre>';
   
    $image_name = $fethm->avatar;
    echo $image_name;
    echo '</br>'; 
    echo $fethm->avatar;
    echo '</br>'; 
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
       $name = $_POST['name'];
       $phone = $_POST['phone'];
       $email = $_POST['email'];
       $birthday = $_POST['birthday'];
       $province_id = $_POST['province_id'];
       $description = $_POST['description'];
       $gender = $_POST['gender'];
         

      
       if(empty($name)){
            $errors['name'] = "tên không được để rỗng";
        } else if(strlen($name) > 100){
            $errors['name'] = "tên không được quá 100 ký tự";
        } else if(strlen($name) < 4){
            $errors['name'] = "tên không được dưới 5 ký tự";
        } 

        if(empty($email)){
            $errors['email'] = "email không được để rỗng";
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "email không đúng định dạng";
        }

        if(empty($phone)){
            $errors['phone'] = "số điện thoại không được để trống";
        }else if (!is_numeric($phone)){
            $errors['phone'] ="số điện thoại phải là số";
        }

        if(empty($birthday)){
            $errors['birthday'] = "ngày sinh không được để trống";
        }

        if(!empty($_FILES['image']['name'])){
            $file = $_FILES['image'];
            $tmp_name = $file['tmp_name'];
            $type = $file['type'];
            if(in_array($type,$types)){
                $errors['image'] ="không đúng định dạng ảnh";
            }else if($errors){
                $errors['image'] ="phải nhập đầy đủ thông tin mới upload được ảnh";
            }else{
                $image_name = time().'-'.$file['name'];
                move_uploaded_file($tmp_name,'./uploads/'.$image_name);
            }
        }
        if(!$errors){
            // $sql = "update human (name, email,phone, gender, birthday, avatar, province_id, description) VALUES ('$name','$email','$phone','$gender','$birthday','$image_name ','$province_id','$description')";
            $sql = "update human set name = '$name', email = '$email', gender = '$gender', phone = '$phone',birthday = '$birthday',avatar = '$image_name', province_id = '$province_id', description = '$description' where id = $id";

            if(mysqli_query($conn, $sql)){
                header('location:index.php');
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php if($errors) : ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php foreach ($errors as $er): ?>
                <li><?php echo $er ?></li>
            <?php endforeach;?>
        </div>
    <?php endif; ?>
    <a href="index.php" class="btn btn-primary">trang chủ</a>
    <div class="container">
        <form action="" method="POST" role="form" enctype="multipart/form-data">

            <div class="row">
            <div class="left col-lg-6" >
                <div class="form-group">
                    <label for="">name</label>
                    <input type="text" class="form-control" name="name" id="" value="<?php echo $fethm->name;?>" placeholder="Input name">
                </div>
                <div class="form-group">
                    <label for="">email</label>
                    <input type="text" class="form-control" name="email" value="<?php echo $fethm->email;?>" id="" placeholder="Input email">
                </div>
                <div class="form-group">
                    <label for="">phone</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $fethm->phone;?>" id="" placeholder="Input phone">
                </div>
                <div class="form-group">
                    <label for="">birthday</label>
                    <input type="date" class="form-control" name="birthday" id="" value="<?php echo $fethm->birthday;?>" placeholder="Input birthday">
                </div>
            </div>
            <div class="right col-lg-6">
                <div class="form-group">
                    <label for="">description</label>
                    <textarea  name="description"  id="input" class="form-control" rows="3"><?php echo $fethm->description;?></textarea>
                </div>
                <div class="form-group">
                    <label for="">image</label>
                    <input type="file" name="image" id="" >
                </div>
                <div class="form-group">
                    <label for="">nam</label>
                    <input type="radio" name="gender" id=""  <?php echo $fethm->gender == 0 ? "checked" : ''?> value="0">
                    <label for="">nữ</label>
                    <input type="radio" name="gender" id="" <?php echo $fethm->gender == 1 ? "checked" : ''?> value="1">
                    <label for="">khác</label>
                    <input type="radio" name="gender" id="" <?php echo $fethm->gender == 2 ? "checked" : ''?> value="2">
                <div class="form-group">
                    <label for="">province</label>
                    <select name="province_id" id="" class="form-control" >
                        <option value="">chọn một</option>
                        <?php while ($pv = mysqli_fetch_object($mypv)) : ?>
                            <option value="<?php echo $pv->id;?>"<?php echo $fethm->province_id == $pv->id ? 'selected' : ''; ?>><?= $pv->name;?></option>

                        <?php endwhile; ?>
                    </select>
                </div>
                <?php echo  $fethm->gender?>
                
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>