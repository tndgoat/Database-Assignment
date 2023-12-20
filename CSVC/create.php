<?php
require_once '../db_connection.php';
if (isset($_POST['add'])) {
    $TenCSVC = $_POST['TenCSVC'];
    $TinhTrang = $_POST['TinhTrang'];
    $GiaThue = $_POST['GiaThue'];
    $GioMoCua = $_POST['GioMoCua'];
    $GioDongCua = $_POST['GioDongCua'];
    $TenCN = $_POST['TenCN'];
    $MaNVQL = $_POST['MaNVQL'];
    $tb = '';
    $ok = true;
    // if ($TenCSVC == '' || $TinhTrang == '' || $GiaThue == '' || $GioMoCua == '' || $GioDongCua == '' || $TenCN == '' || $MaNVQL == '') {
    //     $tb = 'Bạn chưa nhập đủ các trường' . '<br/>';

    if ($TenCSVC == '') {
        $tb .= 'Bạn chưa nhập tên cơ sở vật chất' . '<br/>';
        $ok = false;
    }
    if ($TinhTrang == '') {
        $tb .= 'Bạn chưa nhập tình trạng' . '<br/>';
        $ok = false;
    }
    if ($GiaThue == '') {
        $tb .= 'Bạn chưa nhập giá thuê' . '<br/>';
        $ok = false;
    }
    if ($GioMoCua == '') {
        $tb .= 'Bạn chưa nhập giờ mở cửa' . '<br/>';
        $ok = false;
    } elseif ($GioMoCua < '16:00:44') {
    }
    if ($GioDongCua == '') {
        $tb .= 'Bạn chưa nhập giờ đóng cửa' . '<br/>';
        $ok = false;
    }
    if ($TenCN == '') {
        $tb .= 'Bạn chưa nhập tên cụm nhà' . '<br/>';
        $ok = false;
    }
    if ($MaNVQL == '') {
        $tb .= 'Bạn chưa nhập mã nhân viên quản lí' . '<br/>';
        $ok = false;
    }
    // Check if valid TinhTrang
    if ($TinhTrang != '') {
        if ($TinhTrang != 'đang hoạt động' && $TinhTrang != 'ngừng hoạt động') {
            $tb .= "Tình trạng 'đang hoạt động' hoặc 'ngừng hoạt động'" . '<br/>';
            $ok = false;
        }
    }
    // Check if valid TenCN
    if ($TenCN != '') {
        $check = false;
        $maNVQLquery = "SELECT TenCN FROM cumnha";
        $maNVQLdata = $conn->query($maNVQLquery);
        if ($maNVQLdata->num_rows > 0
        ) {
            while ($row = $maNVQLdata->fetch_assoc()) {
                if ($row['TenCN'] === $TenCN) {
                    $check = true;
                    break;
                } else {
                    $check = false;
                }
            }
            if ($check === false) {
                $tb .= 'Tên cụm nhà không tồn tại' . '<br/>';
                $ok = false;
            }
        }
    }
    // Check if valid MaNVQL
    if ($MaNVQL != '') {
        $check=false;
        $maNVQLquery = "SELECT MaNV FROM truongcumnha";
        $maNVQLdata = $conn->query($maNVQLquery);
        if ($maNVQLdata->num_rows > 0) {
            while ($row = $maNVQLdata->fetch_assoc()) {
                if ($row['MaNV'] === $MaNVQL) {
                   $check = true; 
                   break;
                } else {
                    $check = false;
                }
                
            }
            if ($check === false) {
                $tb .= 'Mã nhân viên quản lí không tồn tại' . '<br/>';
                $ok = false;
            }
        }
    }
    if ($ok) {
        $sqlInsert = "INSERT INTO cosovatchat (TenCSVC, TinhTrang, GiaThue, GioMoCua, GioDongCua, TenCN, MaNVQL) 
                     VALUES ('$TenCSVC', '$TinhTrang', '$GiaThue', '$GioMoCua', '$GioDongCua', '$TenCN', '$MaNVQL')";
        $conn->query($sqlInsert);
        setcookie('thongBao', 'Đã thêm cơ sở vật chất thành công', time() + 5);
        header("location: index.php");
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí kí túc xá</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-clockpicker@0.0.7/dist/bootstrap-clockpicker.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <div class="shadow p-3 my-5 rounded">
                    <?php
                    if (isset($tb)) {
                        echo '<div class="row"><div class="alert alert-danger">' . $tb . '</div></div>';
                    }
                    ?>
                    <form class="p-3" method="post">
                        <h1 class="text-center display-6 p-2">Thêm cơ sở vật chất</h2>
                            <div class="form-floating">
                                <input class="form-control my-3" placeholder="Nhập tên cơ sở vật chất" id="TenCSVC" name="TenCSVC"></input>
                                <label for="TenCSVC">Tên cơ sở vật chất</label>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="TenCN">Tên cụm nhà</span>
                                <input type="text" class="form-control" placeholder="Tên cụm nhà" name="TenCN" aria-describedby="TenCN">
                            </div>
                            <div class="form-floating">
                                <input class="form-control my-3" placeholder="Nhập Tình Trạng" id="TinhTrang" name="TinhTrang"></input>
                                <label for="TinhTrang">Tình Trạng</label>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Giá thuê</span>
                                <input type="number" class="form-control" placeholder="Eg:20000" name="GiaThue">
                                <span class="input-group-text">VNĐ</span>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Giờ mở cửa</span>
                                <!-- <input type="text" class="form-control" placeholder="Eg: 6:00:00" name="gioMoCua"> -->
                                <input type="time" class="form-control" placeholder="Eg: 6:00" name="GioMoCua">

                                <span class="input-group-text">Giờ đóng cửa</span>
                                <!-- <input type="text" class="form-control" placeholder="Eg: 20:00:00" name="gioDongCua"> -->
                                <input type="time" class="form-control" placeholder="Eg: 22:00" name="GioDongCua">
                            </div>
                            <div class="form-floating">
                                <input class="form-control my-3" placeholder="Nhập Tình Trạng" id="MaNVQL" name="MaNVQL"></input>
                                <label for="MaNVQL">Mã số nhân viên quản lí</label>
                            </div>
                            <div class="d-flex justify-content-evenly mt-3">
                                <a href="index.php" class="btn btn-secondary">Hủy bỏ</a>
                                <!-- <a href="index.php" class="btn btn-primary">Xác nhận</a> -->
                                <input type="submit" class="btn btn-primary" value="Thêm" name="add">
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const pickerInline = document.querySelector('.timepicker-inline-24');
        const timepickerMaxMin = new mdb.Timepicker(pickerInline, {
            format24: true,
            inline: true
        });
    </script>
</body>

</html>