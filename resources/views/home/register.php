<?php require(_LAYOUTS.'basicFiles.php');?>

<html>

<?php require(_LAYOUTS.'head.php');?>

<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">Register form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" onSubmit="register(); return false;" autocomplete="off">
                            <h3 class="text-center text-info">Register</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                            <div id="register-link" class="text-right">
                                <a href="/login" class="text-info">Login here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function register()
        {
            user = $('#username').val();
            pass = $('#password').val();
            $.post("/users/register/"+user+"/"+pass, function(data, status){
                if(status){
                    switch(data.status)
                    {
                        case 'true': 
                            location.href='/login';
                            break;
                        case 'false': 
                            alert('User already exists');
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