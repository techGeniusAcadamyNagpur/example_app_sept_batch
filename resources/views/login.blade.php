<html>

<head>
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <style>
        .card {
            margin: auto;
            margin-top: 100px;
        }

    </style>
</head>

<body>
    @if(Session::has('success'))
        <h1 style="color:#0FFF50">{{ Session::get('success') }}</h1>
    @endif

    @if(Session::has('fail'))
        <h1 style="color:#a51700">{{ Session::get('fail') }}</h1>
    @endif



    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h1>Login</h1>
            <p>Login here to move ahead</p>
            <form action="{{ url('login-user') }}" method="POST">
                @csrf
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                    value="{{ old('email') }}" required><br>
                <label for="">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                    required><br>
                <input type="reset" class="btn btn-danger">
                <input type="submit" class="btn btn-success" id="submit" name="submit" value="Login">
            </form>
            <a href="{{ url('signup') }}">if you dont have account click to signup</a>
        </div>

        <!-- login with google button start -->
        <div class="flex items-center justify-end mt-4 align-middle ">
            <a href="{{ route('auth.google') }}">
                <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"
                    style="margin-left: 3em;">
            </a>
        </div>
        <!-- login with google button end -->
        
    </div>


</body>

</html>
