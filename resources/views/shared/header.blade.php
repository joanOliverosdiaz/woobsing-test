<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Pruebas Tecnica - Joan Oliveros</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Inicio</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto my-2 my-lg-0 navbar-nav-scroll"  style="--bs-scroll-height: 100px;">
      @if(isset($_SESSION['isLoggedIn']))
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route( 'two-factor')}}">Token</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page">{{$_SESSION['email']}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('logout')}}">Cerrar sesión</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{!! url('/register'); !!}">Registrarme</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{!! url('/login'); !!}">Iniciar sesión</a>
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
