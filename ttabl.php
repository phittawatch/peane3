<?php
    // Start session and include the database connection file
    session_start();
    include 'connect.php';

    // Define the SQL query to fetch data from the 'contract' table
    $sql = "SELECT contract_number, contract_name, start_date, end_date, file_attach, ngoed_num FROM contract";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Execute the prepared statement
    $stmt->execute();

    // Fetch all rows from the result set
    $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">สัญญาอุปกรณ์</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>เลขที่สัญญา</th>
                        <th>ชื่อสัญญา</th>
                        <th>วันที่เริ่มสัญญา</th>
                        <th>วันที่หมดสัญญา</th>
                        <th>ไฟล์</th>
                        <th>งวดที่</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>เลขที่สัญญา</th>
                        <th>ชื่อสัญญา</th>
                        <th>วันที่เริ่มสัญญา</th>
                        <th>วันที่หมดสัญญา</th>
                        <th>ไฟล์</th>
                        <th>งวดที่</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($contracts as $contract): ?>
                        <tr>
                            <td><?php echo $contract['contract_number']; ?></td>
                            <td><?php echo $contract['contract_name']; ?></td>
                            <td><?php echo $contract['start_date']; ?></td>
                            <td><?php echo $contract['end_date']; ?></td>
                            <td><?php echo $contract['file_attach']; ?></td>
                            <td><?php echo $contract['ngoed_num']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
