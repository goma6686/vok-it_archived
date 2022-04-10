<nav class="navbar navbar-expand-md navbar-dark bg-dark" style="background-color: #78003e !important; margin-bottom: 30px;">
    <div class="container-fluid">
      <!--<div class="navbar-header">-->
        <a class="navbar-brand" href="/" style="line-height: 60px; font-family: 'Raleway', sans-serif;"><img src="{{asset('img/VU.png')}}" alt="" height="60" style="padding-right: 15px; padding-top: 0rem !important; padding-bottom: 0rem !important;">VOK-IT</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>      
        <div id="navbarSupportedContent" class="collapse navbar-collapse w-100 order-1 order-md-0 dual-collapse2"> <!--   -->
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">{{ __('Namai') }}</a>
              </li>
              <!--<li class="nav-item">
                <a class="nav-link active" href="">{{ __('Apie') }}</a>
              </li>-->
              <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ __('Pamokos') }}
                </a>
                <ul style="border-radius: 0px;" class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="/lessons/k">{{ __('Pagal kategorijas') }}</a></li>
                  <li><a class="dropdown-item" href="/lessons/t">{{ __('Pagal temas') }}</a></li>
                  <li><a class="dropdown-item" href="/lessons/l">{{ __('Pagal lygius') }}</a></li>
                  <!--<li><hr class="dropdown-divider"></li>-->
                </ul>
              </li>
            </ul>
        
        <!--<div class="navbar-collapse collapse w-100 order-3 dual-collapse2">-->
            <ul class="navbar-nav ms-auto">
               @if(count(config('app.languages')) > 1)
                            <!--<li class="nav-item dropdown">
                                <a class="nav-link active dropdown-toggle" href="" id="dropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img title="language flag" alt="language flag" src="/img/{{app()->getLocale()}}.svg" width="30px">
                                </a>-->
                                  <!--<ul style="border-radius: 0px;" class="dropdown-menu" aria-labelledby="dropdown1">-->
                                    @foreach(config('app.languages') as $langLocale => $langName)
                                      @if ($langLocale != App::getLocale())
                                        <li><a href="{{ url()->current() }}?change_language={{ $langLocale }}" style="vertical-align: middle;"><img title="language flag" alt="language flag" src="/img/{{ $langLocale }}.svg" width="30px" style="vertical-align: -10px;"></a></li>
                                      @endif
                                    @endforeach
                                  <!--</ul>-->
                            <!--</li>-->
                        @endif
              @if (Auth::check()) 
                <li class="nav-item">
                  <a class="nav-link active" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Atsijungti') }}</a>

                </li>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                
              @else
                <li class="nav-item">
                  <a class="nav-link active" href="/login"><i class="bi bi-file-lock2"></i>{{ __('Prisijungti') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/register"><i class="bi bi-file-person"></i>{{ __('Registruotis') }}</a>
                </li>
              @endif
            </ul>
        <!--</div>-->
        </div>
    </div>
  </div>
</nav>