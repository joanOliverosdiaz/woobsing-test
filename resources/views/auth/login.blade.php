@extends('layout')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="col col-md-6">
            <h3>Iniciar sesion</h3> <hr>
            <form id="loginForm">
                {{csrf_field()}}
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Iniciar sesion</button>
                <div class="mt-3 d-flex justify-content-md-center">
                    <span class="alert alert-danger mt-3 d-none" id="errorMessage">
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

document.getElementById('loginForm').onsubmit = (e) => {
  e.preventDefault()

  const errorMessage = document.getElementById('errorMessage')
  errorMessage.classList.add('d-none')
  const email = $('#email').val();
  const password = $('#password').val();

  if ( !email || !password) {
    errorMessage.innerText = 'Verifique los datos ingresados!';
    return errorMessage.classList.remove('d-none');
  }

  axios
    .post('/api/login', { email: email, password: password })
    .then((res) => {
        if(res.data.secondFactor){
             window.location.href = '/login-otp';
        }else {
             window.location.href = '/two-factor';
        }
    })
    .catch((err) => {
      errorMessage.innerText = err.response.data;
      errorMessage.classList.remove('d-none');

    })
}
</script>
@endsection
