<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="shortcut icon" href="myAssets/image/icon.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/fb15251dc0.js" crossorigin="anonymous"></script>

    <style>
        .body-wrapper {
            height: 100vh;
            width: 100vw;

            /* overflow: hidden; */
            /* background-image: url("Download Virus Pattern on a Dark Background for free.jpg"); */
            /* background-image: url("59d35867-96de-4191-8f17-adf673eb4704.jpg"); */
            background-image: url("/myAssets/image/Download free vector of Clean medical patterned background vector by marinemynt about doctor phone, health illustration, doctor illustration, background, and medical 2292677.jpg");
            /* background-image: url("HD wallpaper_ doctor, doctor's office, health, medical, hospital, medicine.jpg"); */
            /* background-size: cover; */
            background-repeat: repeat;
            background-position: center;
        }

        .glass {
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, .1);
        }

        .box {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 30%;
            /* height: 70%; */
            padding: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 15px;
            background: rgba(255, 255, 255, .95);
            transition: .7s;
            /* box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px; */

        }

        .box:hover {
            box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;

            /* box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px; */
            /* background: rgba(255,255,255,.5); */
        }

        .error-alert {
            color: #EA2027;
            font-size: 17px;
            margin: 10px 5px;
            font-weight: 600;
        }

        .box-header {
            text-align: center;
        }

        .box-header p {
            color: #45aaf2;
            margin-bottom: 0;
        }

        .box-header i {
            font-size: 30px;
            color: #45aaf2;
        }

        .box-title {
            padding: 0;
            text-align: center;
            font-size: 25px;
        }

        form {
            color: #2c3e50;
        }

        .form-group {
            margin: 20px 10px;
            /* width: */
        }

        .form-group input {
            border-color: #e8e9e9;
        }

        form button {
            /* border: 1px solid transparent; */
            border: 0 !important;
            /* border-color: none !important; */
            width: 100%;
            background: linear-gradient(145deg, #45aaf2, #6435c9);
        }

        .box-footer {
            text-align: center;
            margin: 30px 0 10px;
        }

        .box-footer a {
            text-decoration: none;
        }

        .error-text {
            color: #EA2027;
            font-size: 13px;
            margin: 5px;
        }
    </style>
</head>

<body>
    <div class="body-wrapper">
        <div class="glass">
            <div class="box">
                <div class="box-header">
                    <img src="myAssets/image/icon.png" alt="web icon"  width="50px">
                    {{-- <i class="fa-solid fa-house-medical"></i> --}}
                    <p class="box-title">
                        Medical Service
                    </p>
                    <!-- <button>Facebook</button>
                    <button>Google</button> -->
                </div>

                <div class="box-body">
                    <form action="{{ route('postLogin') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <!-- <label for="email" class="form-label">Địa chỉ Email</label> -->
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                            <span class="error-text">{{$errors->first('email')}}</span>
                        </div>
                        <div class="form-group">
                            <!-- <label for="password" class="form-label">Mật khẩu</label> -->
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{ old('password') }}">
                            <span class="error-text">{{$errors->first('password')}}</span>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>

                        <span class="error-alert"> {{ session('msg') ? session('msg') : '' }} </span>    
                        
                        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                    </form>
                </div>

                <div class="box-footer">
                    <a href="">Lấy lại mật khẩu</a>
                </div>
            </div>
        </div>

    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>