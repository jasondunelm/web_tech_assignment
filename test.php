<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<input type="text" id="searchGame" name="searchGame" placeholder="search a game"
       class="form-control" onkeyup="searchGame();" autocomplete="off">

<input type="submit" name="submit" class="btn btn-primary" value="Search Game">

<div style="border-style: none; border-width: 1px; margin: auto; min-width: 30px; visibility: hidden"
     id="d1"></div>

<script type="text/javascript">
    function searchGame() {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "searchList.php?gameNM=" + document.getElementById("searchGame").value, false);
        xmlhttp.send(null);
        document.getElementById("d1").innerHTML = xmlhttp.responseText;
        document.getElementById("d1").style.visibility = 'visible';
    }
</script>

</body>
</html>




