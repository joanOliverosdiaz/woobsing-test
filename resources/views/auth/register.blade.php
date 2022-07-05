@extends('layout')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="col col-md-6">
            <h3>Nueva Cuenta</h3> <hr>
            <form id="registerForm" >
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Crear cuenta</button>
                <div class="mt-3 d-flex justify-content-md-center">
                    <span class="alert alert-danger mt-3 d-none" id="errorMessage">
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

document.getElementById('registerForm').onsubmit = (e) => {
  e.preventDefault()

  const errorMessage = document.getElementById('errorMessage')
  errorMessage.classList.add('d-none')
  const name = $('#name').val();
  const email = $('#email').val();
  const password = $('#password').val();

  if (!name || !email || !password) {
    errorMessage.innerText = 'Verifique los datos ingresados!'
    return errorMessage.classList.remove('d-none')
  }

  axios
    .post('/api/register', { email: email, name: name, password: password })
    .then((res) => {
        // console.log(res);
      window.location.href = '/two-factor';
    })
    .catch((err) => {
      errorMessage.innerText = err.response.data;
      errorMessage.classList.remove('d-none');
    });
}
</script>
@endsection
