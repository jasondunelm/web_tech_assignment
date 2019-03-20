<?php
session_start();
include("functions.php");

//if ($_POST['submit'] == "Request") {
//    $post_selectedMonth = $_POST["selectedMonth"];
//    if (!$_POST['selectedMonth']) {
//        $error = "Please select a month!";
//    } else {
$query = "SELECT Results.matchID, Results.matchDate FROM Results WHERE matchResult ='win' AND MONTH(Results.matchDate)='3'";
$result = mysqli_query($link, $query);

$chart_data = '';
while ($row = mysqli_fetch_array($result)) {
    $chart_data .= "{day:'" . $row["matchDate"] ."', matchID:".$row["matchID"]. "},";
}
$chart_data = substr($chart_data, 0, -2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title></title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

</head>
<body>
<div class="container" style="width: 900px;">
    <h2>Morris.js chart with php & mysql</h2>
    <div id="chart"></div>

</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script>
    Morris.Bar({
        element: 'chart',
        data: [<?php echo $chart_data;?>],
        xkey: 'matchDate',
        ykeys: ['matchID'],
        labels: ['matchID'],
        hideHover: 'auto',
    });
</script>
</body>
</html>

