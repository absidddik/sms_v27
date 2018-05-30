<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <style media="screen">
    body{
        background: black;
        font-family: 'Open Sans', sans-serif;
        background-image: url({{asset('images/gb_back2.jpg')}});
        background-repeat: no-repeat;
        /* background:#3498db; */
        margin: 0 auto 0 auto;
        width:100%;
        height: 100%;
        margin: 70px 0px 20px 0px;

    }


    .box{
        background:white;
        width:500px;
        border-radius:6px;
        margin: 0 auto 0 auto;
        padding:20px 0px 70px 0px;
        border: #2980b9 4px solid;
    }

    .email{
        background:#ecf0f1;
        border: #ccc 1px solid;
        border-bottom: #ccc 2px solid;
        padding: 8px;
        width:250px;
        color:#AAAAAA;
        margin-top:10px;
        font-size:1em;
        border-radius:4px;
    }



    .btn{
        background:#2ecc71;
        width:125px;
        padding-top:5px;
        padding-bottom:5px;
        color:white;
        border-radius:4px;
        border: #27ae60 1px solid;

        margin-top:20px;
        margin-bottom:20px;
        float:left;
        margin-left:16px;
        font-weight:800;
        font-size:0.8em;
    }

    .btn:hover{
        background:#2CC06B;
    }

    #btn2{
        float:left;
        background:#3498db;
        width:125px;  padding-top:5px;
        padding-bottom:5px;
        color:white;
        border-radius:4px;
        border: #2980b9 1px solid;

        margin-top:20px;
        margin-bottom:20px;
        margin-left:10px;
        font-weight:800;
        font-size:0.8em;
    }

    #btn2:hover{
        background:#3594D2;
    }
    </style>
</head>
<body>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>

    <div class="box">
        <h3 style="text-align:center;">Admin Login</h3>
        <hr>
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="" style="padding:20px;">
                @if (count($errors))
                    <div class="" style="background:red;color:white;padding:3px">
                        <ol>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ol>
                    </div>
                @endif
                <input type="hidden" name="admin_login" value="1">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                <br>
                <input id="email" type="email" class="email" name="email" value="{{ old('email') }}" required autofocus>
                <br>
                <label for="password" >Password</label>
                <br>
                <input id="password" type="password" class="email" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

    </div> <!-- End Box -->


</body>
</html>
