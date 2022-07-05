@extends('layout')
@section('content')

<div class="container mt-5">
    @if(!$isActiveTwoFactor)
    <div class="row">
        <h5>Activar doble factor de autenticación</h5>
        <p>1. Para activar el segundo factor de autenticación, instale Google Authenticator en su telefono y escanee el codigo QR.</p>
        <div class="visible-print text-left">
            {!! QrCode::size(150)->generate($QR_Image); !!}
        </div>
        <p class="mt-5">2. Escriba el código generado por Google Authenticator y presione activar doble factor.</p>
    </div>
    <div class="row">
        <div class="col-md-4">
            <form action=""  id="activateSecondFactor">
                <div class="form-group">
                    <label for="code">Código</label>
                    <input type="text" class="form-control" name="code" id="code">
                    <input type="hidden" class="form-control" name="secret" id="secret" value="{{$google2fa_secret}}">
                </div>
                <button class="btn btn-primary" >Activar doble factor</button>
                <div class="mt-3 d-flex justify-content-md-center">
                    <span class="alert alert-danger mt-3 d-none" id="errorMessage">
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
@else
    <div class="row">
        <form action="" id="desactivateSecondFactor">
            <h5>Desactivar doble factor de autenticación</h5>
            <button class="btn btn-danger">Desactivar doble factor</button>
        </form>
    </div>
@endif
<script>
    @if(!$isActiveTwoFactor)
        document.getElementById("activateSecondFactor").onsubmit = (e) => {
            e.preventDefault()

            const errorMessage = document.getElementById('errorMessage')
            errorMessage.classList.add('d-none')
            const code = $('#code').val();
            const secret = $('#secret').val();

            if (!code) {
            errorMessage.innerText = 'Ingrese código valido!';
            return errorMessage.classList.remove('d-none');
            }

            axios
            .post('/api/activateSecondFactor', { code: code, secret: secret })
            .then((res) => {
                console.log(res);
                window.location.href = '/two-factor';
            })
            .catch((err) => {
                errorMessage.innerText = err.response.data;
                errorMessage.classList.remove('d-none');

            })
        };
        @else
        document.getElementById("desactivateSecondFactor").onsubmit = (e) => {
            e.preventDefault();

            axios
            .post('/api/desactivateSecondFactor')
            .then((res) => {
                window.location.href = '/two-factor';
            })
            .catch((err) => {
                errorMessage.innerText = err.response.data;
                errorMessage.classList.remove('d-none');

            })
    }
    @endif
</script>
@endsection
