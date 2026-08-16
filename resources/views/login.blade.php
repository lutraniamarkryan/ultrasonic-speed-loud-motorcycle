<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:url('/img/front.jpg') center center/cover no-repeat;
            min-height:100vh;
            font-family:Arial, Helvetica, sans-serif;
        }

        .page-wrapper{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:flex-end;
            padding:40px 60px;
        }

        .login-card{
            width:100%;
            max-width:500px;
            background:rgba(255,255,255,.55);
            backdrop-filter:blur(8px);
            border-radius:22px;
            padding:40px;
            box-shadow:0 18px 50px rgba(0,0,0,.2);
        }

        .login-card h2{
            text-align:center;
            margin-bottom:30px;
            color:#222;
        }

        .form-control{
            height:50px;
            border-radius:12px;
        }

        .input-group .form-control{
            border-radius:12px 0 0 12px;
        }

        .input-group .btn{
            border-radius:0 12px 12px 0;
            border:1px solid #ced4da;
            background:#fff;
        }

        .btn-login{
            width:100%;
            height:50px;
            border:none;
            border-radius:12px;
            background:#4bb3c1;
            color:#fff;
            font-size:16px;
        }

        .btn-login:hover{
            background:#3898a7;
        }

        .verse{
            margin-top:25px;
            text-align:center;
            font-size:13px;
            color:#000;
            line-height:1.6;
            font-style:italic;
        }
    </style>
</head>

<body>

<div class="page-wrapper">

    <div class="login-card">

        <h2>Login</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3">
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Email"
                    required>
            </div>

            <div class="input-group mb-3">

                <input
                    type="password"
                    id="loginPassword"
                    name="password"
                    class="form-control"
                    placeholder="Password"
                    required>

                <button
                    class="btn btn-outline-secondary"
                    type="button"
                    onclick="togglePassword()">

                    <i class="bi bi-eye" id="toggleIcon"></i>

                </button>

            </div>

            <button class="btn-login" type="submit">
                Login
            </button>

        </form>

        <p class="verse">
            Isaiah 1:17 — Learn to do right; seek justice.
            Defend the oppressed. Take up the cause of the fatherless;
            plead the case of the widow.
        </p>

    </div>

</div>

<script>

function togglePassword(){

    const password = document.getElementById("loginPassword");
    const icon = document.getElementById("toggleIcon");

    if(password.type === "password"){

        password.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");

    }else{

        password.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");

    }

}

</script>

</body>
</html>