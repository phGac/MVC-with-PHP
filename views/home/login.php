<?php require(_LAYOUTS.'basicFiles.php');?>

<html>

<?php require(_LAYOUTS.'head.php');?>

<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" onSubmit="login(); return false;" autocomplete="off">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                            <div id="register-link" class="text-right">
                                <a href="#" class="text-info">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function login()
        {
            user = $('#username').val();
            pass = $('#password').val();
            $.get("/user/login/"+user+"/"+pass, function(data, status){
                if(status){
                    switch(data.status)
                    {
                        case 'true': 
                            location.href='/';
                            break;
                        case 'false': 
                            alert('Usuario y/o contraseña incorrecto(s).');
                            break;
                        default: 
                            alert('Error.');
                            break;
                    }
                }
            });
        }
    </script>

</body>
</html>