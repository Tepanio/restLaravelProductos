<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
</head>
<body>
<h1>Ingrese su nuevo password {{$username}}</h1>
<div class="flex-center position-ref full-height">
    
    
    <form id=passForm >
        <label for="password">New Password:</label>
        <input type="hidden" id="user" name="user" value="{{$username}}">
        <input type="hidden" id="token" name="token" value="{{$token}}">
        <input type="password" id="pass" name="pass">
        <input type="submit" value="Submit" >
    </form>
    
    <script>
        async function fetchPass(username,password,token) {
            console.log(username,password,token)
        //  let json = await fetch(`http://localhost:8000/api/productos`, {
        //    method: "get",
        //    headers: {
        //        "Content-Type": "application/json",
        //        'Authorization': `Bearer ${token}`,
        //        "Accept": "application/json"
        //    },
        //}).then(res => res.json());
        //this.setState({todosProductos: json});
    }
        
        
        var form =  document.getElementById('passForm');
        form.onsubmit = function (e){
            e.preventDefault();
           // console.log("pass" + form.pass.value);
            //console.log("token" + form.token.value);
            //console.log("user" + form.user.value);
            fetchPass(form.user.value,form.pass.value,form.token.value);
        }

    </script>

</div>
     
</body>
</html>