<?php
include('../../../config.php');

$funnel_name = mysqli_real_escape_string($mysqli, $_POST['funnel_name']);
$funnel_description = mysqli_real_escape_string($mysqli, $_POST['funnel_description']);

$mysqli->query("INSERT INTO `farm_funnel`
                (
                    `funnel_name`,
                    `funnel_description`
                )
                VALUES (
                    '$funnel_name',
                    '$funnel_description'
                        )") or die(mysqli_error($mysqli));

echo 1;
