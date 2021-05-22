<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./main.css">
    <script
  src="https://code.jquery.com/jquery-3.4.0.js"
  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
  crossorigin="anonymous"></script>
  <script src="./main.js"></script>
    <title>Home Page</title>
</head>
<body>
<div class="container">
<div class="row">
<p class="welcomeTitle">Welcome To GrowMore</p>
</div>
<div class="row">
<form class="searchBar">
    <select class="form-control form-control-lg" id="vegName">
        <option default>What do you want to grow</option>
        <option value="Vegetables">Vegetables</option>
        <option value="Fruit">Fruit</option>
    </select>
    <br>
    <div class="form-group">
    <input type="text" class="form-control form-control-lg" placeholder="Vegetable Name">
    </div>

    <button class="searchBtn" type="submit" class="btn btn-primary" id="search">Search</button>
</form>
</div>
<div class="row">
    <div id="data"></div>
</div>
</div>
</body>
</html>