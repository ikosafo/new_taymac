<?php include('../../../config.php');

$search_year = $_POST['search_year'];
$search_region = $_POST['search_region'];
$search_approval = $_POST['search_approval'];

$que1 = $mysqli->query("select * from examconfig LIMIT 1");
$res1 = $que1->fetch_assoc();
$pass_mark = $res1['passmark'];

$fullname = $_SESSION['full_name'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];
$user_type = $_SESSION['user_type'];


?>

<style>
    ul {
        list-style-type: none;
    }
</style>



<script>

    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
        location.reload();
    }
</script>

<div id="print_this">

    <h5 class="card-header">Examination Registration Search <strong>

        </strong></h5>

    <table class="table">
        <tr>
            <td>YEAR:</td>
            <td><b><?php echo $search_year ?></b></td>

            <td>REGION:</td>
            <td><b><?php echo $search_region ?></b></td>
        </tr>
        <tr>
            <td>APPROVAL:</td>
            <td><b><?php echo $search_approval ?></b></td>


        </tr>
    </table>


    <?php


    if ($search_approval == "Any" && $search_year == "Any" && $search_region == "Any") {
        $query = $mysqli->query("select * from examination_reg");
    }
    else {

        //ALL
        if ($search_region == "Any" && $search_approval == "Any") {

            $query = $mysqli->query("select * from examination_reg where
SUBSTRING(period_registered,1,4) = '$search_year'");

        } //ONE'S

        else if ($search_region == "Any") {

            if ($search_approval == "Passed") {

                $query = $mysqli->query("SELECT * FROM examination e JOIN
examination_reg p ON  p.`provisional_number` = e.`pin` WHERE
SUBSTRING(e.examdate,1,4) = '$search_year' AND e.results >= $pass_mark");

            }

            else {
                $query = $mysqli->query("SELECT * FROM examination e JOIN
examination_reg p ON  p.`provisional_number` = e.`pin` WHERE
SUBSTRING(e.examdate,1,4) = '$search_year' AND e.results < $pass_mark");
            }
        }


        else if ($search_approval == "Any") {

            $query = $mysqli->query("SELECT * FROM examination e JOIN
examination_reg p ON  p.`provisional_number` = e.`pin` JOIN provisional l
ON l.`provisional_pin` = e.`pin` WHERE
SUBSTRING(e.examdate,1,4) = '$search_year' AND l.`res_region` = '$search_region'");

        }


        else if ($search_region != "Any" && $search_approval != "Any"){

            if ($search_approval == "Passed") {

                $query = $mysqli->query("SELECT * FROM examination e JOIN
examination_reg p ON  p.`provisional_number` = e.`pin` JOIN provisional l
ON l.`provisional_pin` = e.`pin` WHERE
SUBSTRING(e.examdate,1,4) = '$search_year' AND l.`res_region` = '$search_region'
AND e.results >= $pass_mark");

            }

            else {
                $query = $mysqli->query("SELECT * FROM examination e JOIN
examination_reg p ON  p.`provisional_number` = e.`pin` JOIN provisional l
ON l.`provisional_pin` = e.`pin` WHERE
SUBSTRING(e.examdate,1,4) = '$search_year' AND l.`res_region` = '$search_region'
AND e.results < $pass_mark");
            }


        }
    }



    ?>



    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-responsive"
               style="width:100% !important;">
            <thead>
            <tr>
                <th>Full Name</th>
                <th>Profession</th>
                <th>PIN</th>
                <th>Examination Details</th>

            </tr>
            </thead>
            <tbody>

            <?php
            while ($res = $query->fetch_assoc()) {

                $applicant_id = $res['applicant_id'];


                ?>
                <tr>
                    <td><?php

                        $an_q = $mysqli->query("select * from provisional where applicant_id = '$applicant_id'");
                        $result = $an_q->fetch_assoc();

                        $title = $result['title'];

                        if ($title == "Other") {
                            $title = $result['othertitle'];
                            echo $title . " " . $result["surname"] . " " . $result["first_name"] . " " . $result["other_name"];
                        } else {
                            echo $title . " " . $result["surname"] . " " . $result["first_name"] . " " . $result["other_name"];
                        }

                        ?>
                    </td>
                    <td>
                        <?php echo $result['profession'] ?>
                    </td>
                    <td>
                        <?php echo $result['provisional_pin'] ?>
                    </td>

                    <td>
                        Internship Period: <b><?php echo $res['internship_period'] ?></b> <br/>
                        Facility: <b><?php echo $res['facility'] ?></b> <br/>
                        Previous Exam: <b><?php echo $res['previous_exam'] ?></b> <br/>
                        Exam Attempts: <b><?php echo $res['exam_attempts'] ?></b> <br/>
                        Exam Center: <b><?php echo $res['exam_center'] ?></b> <br/>
                    </td>


                </tr>

                <?php
            }
            ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
            </div>


    </div>


</div>



<div>
    <button class="btn btn-primary pull-right m-t-20 m-b-20"
            onclick="printContent('print_this')"><i class="icon-printer"></i> Print Form
    </button>
</div>



<script>
    $('#bs4-table').DataTable({
        aaSorting: [],
        dom: 'Bfrtip'
    });
</script>


<?php
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

?>


