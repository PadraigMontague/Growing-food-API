<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vegetable Growing Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./main.css">
    <script
  src="https://code.jquery.com/jquery-3.4.0.js"
  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
  crossorigin="anonymous"></script>
  <script src="./main.js"></script>
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-sm register">
                <p>Register</p>
                <form id="myForm">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Your Firstname" id="firstname" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Your Lastname" id="lastname" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Enter Your Email Address" id="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="register">REGISTER</button>
                </form>
                <p class="token_title">JWT Token:</p>
                <div class="token"></div>
            </div>
            <div class="col-sm login">
                <p>Login</p>
                <div class="form-group" method="POST">
                    <input type="text" class="form-control" placeholder="Enter Your Firstname" id="loginFirstname" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Enter Your Email Address" id="loginEmail" required>
                </div>
                <button type="submit" class="btn btn-primary" id="login">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>