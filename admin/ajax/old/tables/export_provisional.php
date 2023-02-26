<?php include('../../../config.php');

$year_search = $_POST['year_search'];

$query = $mysqli->query("select * from provisional where
SUBSTRING(provisional_period,1,4) = '$year_search' AND provisional_pin is not null
AND provisional_registration = '1'
ORDER BY professionid DESC,provisional_period DESC");
?>
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="kt-separator kt-separator--dashed"></div>

<div class="kt-section">
    <!-- <span class="kt-section__info">
                        <?php
    /*                        if ($year_search == "All") {
                                echo "All Years".'<br/>';
                                echo "Status: ".$provisional_status ;
                            }
                            else {
                                echo "Year: ".$year_search.'<br/>';
                                echo "Status: ".$provisional_status ;
                            }
                            */?>
                    </span>-->
    `
    <div class="kt-section__content responsive">

        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-toolbar-wrapper">
                <div class="dropdown dropdown-inline">
                    <button type="button" class="btn btn-brand btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="la la-plus"></i> Tools
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="kt-nav">
                            <li class="kt-nav__section kt-nav__section--first">
                                <span class="kt-nav__section-text">Export Tools</span>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" id="export_print">
                                    <i class="kt-nav__link-icon la la-print"></i>
                                    <span class="kt-nav__link-text">Print</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" id="export_copy">
                                    <i class="kt-nav__link-icon la la-copy"></i>
                                    <span class="kt-nav__link-text">Copy</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" id="export_excel">
                                    <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                    <span class="kt-nav__link-text">Excel</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" id="export_csv">
                                    <i class="kt-nav__link-icon la la-file-text-o"></i>
                                    <span class="kt-nav__link-text">CSV</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" id="export_pdf">
                                    <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                    <span class="kt-nav__link-text">PDF</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
        <table id="kt_table_2" class="table" style="margin-top: 3% !important;">
            <thead>
            <tr>
                <th>Title</th>
                <th>Surname</th>
                <th>First Name</th>
                <th>Other Name</th>
                <th>Telephone</th>
                <th>Provisional PIN</th>
                <th>Profession</th>
                <th>Institution</th>
                <th>Image</th>
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
                    </td><td>
                        <?php echo $result['first_name'] ?>
                    </td><td>
                        <?php echo $result['other_name'] ?>
                    </td><td>
                        <?php echo $result['telephone'] ?>
                    </td><td>
                        <?php echo $result['provisional_pin'] ?>
                    </td><td>
                        <?php $prpin = $result['professionid'];
                        $getprname = $mysqli->query("select * from professions where professionid = '$prpin'");
                        $resname = $getprname->fetch_assoc();
                        echo $resname['professionname'];?>
                    </td><td>
                        <?php
                        $getin = $mysqli->query("select * from applicant_institutions where applicant_id = '$applicant_id'");
                        while ($resin = $getin->fetch_assoc()){
                            echo $resin['institution_name'].",";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $getimg = $mysqli->query("select * from applicant_images where applicant_id = '$applicant_id'");
                        $resimg = $getimg->fetch_assoc();
                        ?>
                        <a href="<?php echo $reg_root.'/'.$resimg['image_location'] ?>">
                            Click to view
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
            </div>
    </div>
</div>


<script>
    "use strict";
    var KTDatatablesExtensionButtons={init:function(){var t;$("#kt_table_1").DataTable({responsive:!0,dom:"<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",buttons:["print","copyHtml5","excelHtml5","csvHtml5","pdfHtml5"],columnDefs:[{targets:6,render:function(t,e,a,n){var s={1:{title:"Pending",class:"kt-badge--brand"},2:{title:"Delivered",class:" kt-badge--danger"},3:{title:"Canceled",class:" kt-badge--primary"},4:{title:"Success",class:" kt-badge--success"},5:{title:"Info",class:" kt-badge--info"},6:{title:"Danger",class:" kt-badge--danger"},7:{title:"Warning",class:" kt-badge--warning"}};return void 0===s[t]?t:'<span class="kt-badge '+s[t].class+' kt-badge--inline kt-badge--pill">'+s[t].title+"</span>"}},{targets:7,render:function(t,e,a,n){var s={1:{title:"Online",state:"danger"},2:{title:"Retail",state:"primary"},3:{title:"Direct",state:"success"}};return void 0===s[t]?t:'<span class="kt-badge kt-badge--'+s[t].state+' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-'+s[t].state+'">'+s[t].title+"</span>"}}]}),t=$("#kt_table_2").DataTable({responsive:!0,buttons:["print","copyHtml5","excelHtml5","csvHtml5","pdfHtml5"],processing:!0,serverSide:!0,ajax:{url:"https://keenthemes.com/metronic/tools/preview/api/datatables/demos/server.php",type:"POST",data:{columnsDef:["OrderID","Country","ShipCity","ShipAddress","CompanyAgent","CompanyName","Status","Type"]}},columns:[{data:"OrderID"},{data:"Country"},{data:"ShipCity"},{data:"ShipAddress"},{data:"CompanyAgent"},{data:"CompanyName"},{data:"Status"},{data:"Type"}],columnDefs:[{targets:6,render:function(t,e,a,n){var s={1:{title:"Pending",class:"kt-badge--brand"},2:{title:"Delivered",class:" kt-badge--danger"},3:{title:"Canceled",class:" kt-badge--primary"},4:{title:"Success",class:" kt-badge--success"},5:{title:"Info",class:" kt-badge--info"},6:{title:"Danger",class:" kt-badge--danger"},7:{title:"Warning",class:" kt-badge--warning"}};return void 0===s[t]?t:'<span class="kt-badge '+s[t].class+' kt-badge--inline kt-badge--pill">'+s[t].title+"</span>"}},{targets:7,render:function(t,e,a,n){var s={1:{title:"Online",state:"danger"},2:{title:"Retail",state:"primary"},3:{title:"Direct",state:"success"}};return void 0===s[t]?t:'<span class="kt-badge kt-badge--'+s[t].state+' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-'+s[t].state+'">'+s[t].title+"</span>"}}]}),$("#export_print").on("click",function(e){e.preventDefault(),t.button(0).trigger()}),$("#export_copy").on("click",function(e){e.preventDefault(),t.button(1).trigger()}),$("#export_excel").on("click",function(e){e.preventDefault(),t.button(2).trigger()}),$("#export_csv").on("click",function(e){e.preventDefault(),t.button(3).trigger()}),$("#export_pdf").on("click",function(e){e.preventDefault(),t.button(4).trigger()})}};jQuery(document).ready(function(){KTDatatablesExtensionButtons.init()});
</script>
