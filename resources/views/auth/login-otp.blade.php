@extends('layout')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="col col-md-6">
            <h3>Segundo factor de autenticación</h3> <hr>
            <form id="loginOtpForm">
                {{csrf_field()}}
                <div class="mb-3">
                    <label for="code" class="form-label">Código</label>
                    <input type="text" class="form-control" id="code" name="code">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Ingresar</button>
                <div class="mt-3 d-flex justify-content-md-center">
                    <span class="alert alert-danger mt-3 d-none" id="errorMessage">
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

document.getElementById('loginOtpForm').onsubmit = (e) => {
  e.preventDefault()

  const errorMessage = document.getElementById('errorMessage')
  errorMessage.classList.add('d-none')
  const code = $('#code').val();

  if ( !code) {
    errorMessage.innerText = 'Verifique el código ingresados!';
    return errorMessage.classList.remove('d-none');
  }

  axios
    .post('/api/validateCode', { code: code })
    .then((res) => {
        console.log(res);
        window.location.href = '/two-factor';
    })
    .catch((err) => {
      errorMessage.innerText = err.response.data;
      errorMessage.classList.remove('d-none');

    })
}
</script>
@endsection
