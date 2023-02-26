<?php include('../../../config.php');

$query = $mysqli->query("select * from provisional where provisional_pin is not null
and LENGTH(provisional_pin) != 8 AND provisional_registration = '1'
ORDER BY professionid DESC,provisional_period DESC");
?>


<div class="kt-section">
    `
    <div class="kt-section__content responsive">

        <!--begin: Search Form -->
        <div class="kt-form kt-fork--label-right">
            <div class="row align-items-center ml-2 mr-2 mb-4">
                <div class="col-xl-5 order-2 order-xl-1">
                    <div class="row align-items-center">
                        <div class="col-md-12 kt-margin-b-20-tablet-and-mobile">
                            <div class="kt-input-icon kt-input-icon--left">
                                <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
						<span class="kt-input-icon__icon kt-input-icon__icon--left">
							<span><i class="la la-search"></i></span>
						</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="kt-portlet__body kt-portlet__body--fit">

            <div class="table-responsive">
        <table class="kt-datatable" id="html_table" width="100%">
            <thead>
            <tr>
                <th>Title</th>
                <th>Surname</th>
                <th>First Name</th>
                <th>Telephone</th>
                <th>Provisional PIN</th>
                <th>Profession</th>
                <th>Action</th>
                <th>Other Name</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($result = $query->fetch_assoc()){
                $applicant_id = $result['applicant_id'];
                ?>
                <tr>
                    <td>
                        <?php $title = $result['title'];
                        if ($title == "Other") {
                            echo $result['othertitle'];
                        }
                        else {
                            echo $title;
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo $result['surname'] ?>
                    </td>
                    <td>
                        <?php echo $result['first_name'] ?>
                    </td>
                    <td>
                        <?php echo $result['telephone'] ?>
                    </td>
                    <td>
                        <?php echo $result['provisional_pin'] ?>
                    </td>
                    <td>
                        <?php $prpin = $result['professionid'];
                        $getprname = $mysqli->query("select * from professions where professionid = '$prpin'");
                        $resname = $getprname->fetch_assoc();
                        echo $resname['professionname'];?>
                    </td>
                    <td>
                        <button type="button"
                                class="approvalbtn btn btn-primary btn-rounded btn-sm
                                    btn-floating btn-outline"
                                applicantid = "<?php echo $applicant_id; ?>">
                            Regenerate PIN
                        </button>
                    </td>
                    <td>
                        <?php echo $result['other_name'] ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
                </div>

            </div>

    </div>
</div>

<script>
    "use strict";
    var KTDatatableHtmlTableDemo = {
        init: function () {
            var t;
            t = $(".kt-datatable").KTDatatable({
                data: {saveState: {cookie: !1}},
                search: {input: $("#generalSearch")}
            }), $("#kt_form_status").on("change", function () {
                t.search($(this).val().toLowerCase(), "Status")
            }), $("#kt_form_type").on("change", function () {
                t.search($(this).val().toLowerCase(), "Type")
            }), $("#kt_form_status,#kt_form_type").selectpicker()
        }
    };
    jQuery(document).ready(function () {
        KTDatatableHtmlTableDemo.init()
    });


    $(document).on('click','.approvalbtn',function() {
        var applicant_id = $(this).attr('applicantid');

        //alert(applicant_id);
        $.ajax({
            type: "POST",
            url: "ajax/queries/provisional_regeneratepin.php",
            data: {
                applicant_id: applicant_id
            },
            success: function (text) {
                $.notify('Pin Updated','success');
                $.ajax({
                    url: "ajax/tables/provisional_regeneratepin.php",
                    beforeSend: function () {
                        KTApp.blockPage({
                            overlayColor: "#000000",
                            type: "v2",
                            state: "success",
                            message: "Please wait..."
                        })
                    },
                    success: function (text) {
                        $('#provisional_table_div').html(text);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + " " + thrownError);
                    },
                    complete: function () {
                        KTApp.unblockPage();
                    },

                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
        });
    });
</script>
