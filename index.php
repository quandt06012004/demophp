<?php
    include 'connect.php';


    $sql ="SELECT 
        h.id,h.name, h.email,h.phone,h.description,h.avatar,h.province_id,h.birthday,p.name AS pname,
        CASE
            WHEN h.gender = 0 THEN 'nam'
            WHEN h.gender = 1 THEN 'nữ'
            ELSE 'bê đê'
        END as Status
            FROM human h
            JOIN province p ON h.province_id = p.id";
    
    if(!empty($_GET['key'])){
        
        $key = $_GET['key'];
        $sql .= " WHERE h.name LIKE '%$key%'";
    }
    // $sql .= "order by id desc";
    $query = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Title Page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        
        
        <form action="" method="get" class="form-inline" role="form">
        
            <div class="form-group">
                <input type="text" class="form-control" name="key" id="" placeholder="Input field">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        <div class="container" >
            <a class="btn btn-primary" href="add.php"><i class="fa fa-plus">thêm mới </i></a>
        <h1>chi tiết</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>stt</th>
                    <th>name</th>
                    <th>email</th>
                    <th>phone</th>
                    <th>gender</th>
                    <th>birthday</th>
                    <th>avatar</th>
                    <th>province_id</th>
                    <th>description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 1; foreach($query as $hm) :?>
                    <tr>
                    <th><?= $n;?></th>
                    <th><?= $hm['name'];?></th>
                    <th><?= $hm['email'];?></th>
                    <th><?= $hm['phone'];?></th>
                    <th><?= $hm['Status'];?></th>
                    <th><?= $hm['birthday'];?></th>
                    <th>
                        <img src="./uploads/<?= $hm['avatar'];?>" alt="" width="60px">
                    </th>
                    <th><?= $hm['pname'];?></th>
                    <th><?= $hm['description'];?></th>
                    <th>
                        <a class="btn btn-danger" href="delete.php?id=<?= $hm['id'];?>">xóa</a>
                        <a class="btn btn-primary" href="edit.php?id=<?= $hm['id'];?>">sửa</a>
                    </th>
                    </tr>
                <?php $n++; endforeach; ?>
            </tbody>
        </div>
        
        </table>
        
        

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
