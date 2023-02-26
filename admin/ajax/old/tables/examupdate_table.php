<?php include('../../../config.php');
$pinq = $mysqli->query("select * from indexnumber_error ORDER BY id DESC");
?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>


<div class="kt-section">

    `
    <div class="kt-section__content responsive">
        <div class="kt-searchbar">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">
                                <i class="la la-search"></i>
                            </span></div>
                <input type="text" id="it_search" class="form-control"
                       placeholder="Search..." aria-describedby="basic-addon1">
            </div>
        </div>


        <div class="table-responsive">
        <table id="prov-table" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th>Name of Applicant</th>
                <th>Email Address</th>
                <th>Index Number</th>
                <th>School Number</th>
                <th>User</th>
                <th>Period Updated</th>
            </tr>
            </thead>

            <tbody>

            <?php
            while ($fetch = $pinq->fetch_assoc()) {
                $proid = $fetch['provisionalid'];
                ?>

                <tr>

                    <td><?php $getname = $mysqli->query("select * from provisional where provisionalid = '$proid'");
                        $resname = $getname->fetch_assoc();
                        echo $fullname = $resname['surname'].' '.$resname['first_name'].' '.$resname['other_name']; ?></td>
                    <td><?php echo $fetch['emailaddress']; ?></td>
                    <td><?php echo $fetch['indexnumber']; ?></td>
                    <td><?php echo $fetch['applicantid']; ?></td>
                    <td><?php $user = $fetch['user'];
                        $getname = $mysqli->query("select * from mis_users where user_id = '$user'");
                        $resname = $getname->fetch_assoc();
                        echo $resname['full_name'];

                        ?>
                    </td>
                    <td>
                        <?php echo $fetch['period'] ?>
                    </td>

                </tr>

            <?php } ?>
            </tbody>
        </table>
            </div>
    </div>
</div>

<script>

    oTable = $('#prov-table').DataTable({
        "bLengthChange": false
    });

    $('#it_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

</script>