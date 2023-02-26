<?php include('../../../config.php');
$query = $mysqli->query("select * from examination_reg e join provisional p ON e.applicant_id = p.applicant_id
                         where e.createpemex = '1' ORDER BY e.period_registered DESC");

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
                <input type="text" id="user_search" class="form-control"
                       placeholder="Search Full Name or email address" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="table-responsive">
            <table id="prov-table" class="table" style="margin-top: 3% !important">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Index Number</th>
                    <th>Reverse</th>
                </tr>
                </thead>
                <tbody>

                <?php
                while ($result = $query->fetch_assoc()) {
                    //$user_id = $result['user_id'];
                    ?>
                    <tr>
                        <td>
                            <?php echo $result['first_name'].' '.$result['surname'].' '.$result['other_name'] ?>
                        </td>
                        <td>
                            <?php echo $result['indexnumber'] ?>
                        </td>

                        <td>
                           <button type="button"
                                    data-type="confirm"
                                    class="btn btn-danger reverse_userexception"
                                    i_index="<?php echo $result['examination_id']; ?>"
                                    title="Delete">
                                <i class="flaticon2-trash ml-2" style="color:#fff !important;"></i>
                            </button>
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


<script>

    oTable = $('#prov-table').DataTable({
        "bLengthChange": false
    });

    $('#user_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });

    $(document).on('click', '.reverse_userexception', function() {
        var id_index = $(this).attr('i_index');
        //alert(id_index);

        swal({
                title: "Do you want to reverse exception?",
                text: "You will not be able to recover this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, create it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        type: "POST",
                        url: "ajax/queries/reverseexamexception",
                        data: {
                            examination_id: id_index
                        },
                        dataType: "html",
                        success:function(text) {
                            location.reload();
                        },
                        complete: function () {
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + " " + thrownError);
                        }
                    });

                    swal("Created!", "Exception has been reversed for applicant.", "success");

                } else {
                    swal("Cancelled", "Data is safe.", "error");
                }
            });
    })
    
</script>