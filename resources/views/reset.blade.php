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


            .card {
            
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                transition: 0.3s;
            }

            
            .card:hover {
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            }

            
            .container {
            padding: 2px 16px;
            
            }
            .center{
                text-align:center;
                padding:1em;
            }
            .fright{
                float:right;
            }
            .alignRight{
                align:right;
            }

            #passForm > * {
                padding: 0.2em;
            }

        </style>
</head>
<body>

<div class="flex-center position-ref full-height">
    
    <div class="card">
        <h1 class="center">Password Reset</h1>
        <form id=passForm style="float:center;">
            
            <input type="hidden" id="user" name="user" value="{{$username}}">
            <input type="hidden" id="token" name="token" value="{{$token}}">
            <div>
            <label for="password">Password:</label>
            </div>
            <div>
            <input type="password" id="pass" name="pass">
            </div>
            <div>
            <label for="password">Confirm Pass:</label>
            </div>
            <div>
            <input type="password" id="passcon" name="passcon">
            </div>
            <div>
            <input style="float:right;" type="submit" value="Confirmar" >
            
            </div>
        </form>
    
    </div>
    
    <script>

        function reDirect(){
            
        }
        async function fetchPass(username,password,token) {

            console.log(username,password,token)
          let response = await fetch(`http://localhost:8000/api/usuarios/password/reset`, {
            method: "post",
            headers: {
                "Content-Type": "application/json",
                //'Authorization': `Bearer ${token}`,
                "Accept": "application/json"
            },
            body: JSON.stringify({
                "username": username,
                "password": password,
                "token": token
            })

        });

        console.log(response.status);      
        if (response.status == 200 || response.status == 204) {
            window.location.href = "http://localhost:3000";
           
        }  
        else{
            alert('Hubo un error al cambiar la Contraseña');
        }

        
        //console.log(res);
        //this.setState({todosProductos: json});
    }
        
         function Validate(pass,passcon) {
             
        if (pass != passcon) {
            alert("Las contraseñas no coinciden.");
            return false;
        }
        return true;
        }
        var form =  document.getElementById('passForm');
        form.onsubmit = function (e){
            e.preventDefault();
            
            if(Validate(form.pass.value,form.passcon.value)){
                fetchPass(form.user.value,form.pass.value,form.token.value);
            }
        }

    </script>

</div>
     
</body>
</html>