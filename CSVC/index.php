<?php
$rootPath = '/DormitoryManagement';

// Connect to the database
require_once '../db_connection.php';

$sqlShowcosovatchat = "SELECT * FROM cosovatchat";
$cosovatchat = $conn->query($sqlShowcosovatchat);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí kí túc xá</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <!-- Container -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-2 auto text-bg-light  bg-opacity-75 shadow-lg px-0" style="min-height: 100vh;background-color:rgba(0,0,0,0.6)">
                <?php include '../assets/sidebar.html' ;?>
            </div>

            <!-- Content -->
            <div class="col-10 auto text-bg-light  bg-opacity-75" style="min-height: 100vh;background-color:rgba(0,0,0,0.6)">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="text-center display-5 m-4" style="width:fit-content;height:fit-content">Cơ sở vật chất</h2>
                    <p class="my-5 text-center">
                        <a href="create.php" class="btn btn-primary p-3" style="width:fit-content">Thêm cơ sở vật chất</a>
                    </p>
                </div>
                <table class="shadow table caption-top rounded overflow-hidden">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Tên cơ sở vật chất</th>
                            <th scope="col">Giá thuê</th>
                            <th scope="col">Giờ mở cửa</th>
                            <th scope="col">Giờ đóng cửa</th>
                            <th scope="col">Tên cụm nhà</th>
                            <th scope="col">Mã nhân viên</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $cosovatchat->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?= $row['TenCSVC'] ?></td>

                                <td><?= $row['GiaThue'] ?></td>
                                <td><?= $row['GioMoCua'] ?></td>
                                <td><?= $row['GioDongCua'] ?></td>
                                <td><?= $row['TenCN'] ?></td>
                                <td><?= $row['MaNVQL'] ?></td>
                                <td>
                                    <?php
                                    if ($row['TinhTrang'] == 'đang hoạt động') { ?>
                                        <span class="text-success"><?php echo $row['TinhTrang']; ?></span>
                                    <?php } else { ?>
                                        <span class="text-danger"><?php echo $row['TinhTrang']; ?></span>
                                    <?php } ?>
                                </td>
                                <td class="d-flex">
                                    <p>
                                        <a href="./update.php?TenCSVC=<?= $row['TenCSVC'] ?>" class="link-info p-2 link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Chỉnh sửa</a>
                                    </p>
                                    <p>
                                        <a href="./delete.php?TenCSVC=<?= $row['TenCSVC'] ?>" onclick="return confirm('Bạn có muốn xóa cơ sở vật chất này không?')" class="link-danger p-2 link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Xóa</a>
                                    </p>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>