@extends('administrator.layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous"></script>
    <link href="/css/admin.css "rel="stylesheet">
    <script src="/js/admin.js" type="text/javascript" defer></script>
@endsection

@section('content')

    <div class="py-12">

        <!-- Upload zone -->        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <center><h4><b>{{ __('Įkelti pamoką') }}</b></h4></center>
                    <section>
                        <form action="/administrator/uploadFile" class="dropzone" id="file-upload">
                            @csrf
                            <div class="dz-message" data-dz-message><span>{{ __('Tempti pamokas čia') }}</span></div>
                            <div class="fallback">
                                <input name="file" type="file"/>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>

        <!-- Draggable lessons containers -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 25px;">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <center><h4><b>{{ __('Pamokų eiliškumas') }}</b></h4></center>

                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link sortBySelectionButton active" id="category" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">{{ __('Pagal kategorijas') }}</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link sortBySelectionButton" id="topic" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">{{ __('Pagal temas') }}</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link sortBySelectionButton" id="level" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">{{ __('Pagal lygius') }}</button>
                      </li>
                    </ul>

                    <div class="draggableContainersBody">
                        <div class="containersContainer category">
                            @foreach($categories as $category)
                                <div class="containerForDraggable category" id="{{ $category -> id }}">
                                    @if(strtoupper(app()->getLocale()) == "DE")
                                        <div class="container_name"><h4><b>{{ $category -> name_de}}</b></h4></div>
                                    @else
                                        <div class="container_name"><h4><b>{{ $category -> name}}</b></h4></div>
                                    @endif
                                    @foreach($lessonsSortedByCategory as $lesson)
                                        @if($lesson -> category_id == $category -> id)
                                            <div class="draggable category containerId_{{ $lesson -> category_id }} containerPos_{{ $lesson -> category_order }}" id="{{ $lesson -> id }}" draggable="true" style="overflow:auto;">
                                                <div class="left" style="float: left; width: 33%"> <!-- Left starts here-->
                                                    <div class="name"><h5><b>{{ $lesson -> name }}</b></h5></div>
                                                    <button class="btn btn-outline-danger category visibilityToggleButton" style="display: inline-block; float:left;">
                                                        @if($lesson -> visible == true)
                                                            <div class="bi bi-eye"></div>
                                                        @else
                                                            <div class="bi bi-eye-slash"></div>
                                                        @endif
                                                    </button>
                                                    <div class="delete_button" style="display: inline-block; float:left; margin-left: 15px; ">
                                                        <form action="/administrator/delete/{{ $lesson -> id }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti pamoką') }}</button>
                                                        </form>
                                                    </div>
                                                </div> <!-- Left ends here-->
                                                <div class="right" style="float: right; width: 66%;"> <!-- Right starts here-->
                                                    @if($lesson -> picture != null)
                                                        <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" style="max-height: 100px; max-width: 200px; float: right;" alt="{{ $lesson -> picture }}">
                                                        <form action="/administrator/changeImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Pakeisti viršelio nuotrauką') }}</button>
                                                            <input type="file" name="imageChange">
                                                        </form>
                                                        <form action="/administrator/removeImage/{{ $lesson -> id }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti viršelio nuotrauką') }}</button>
                                                        </form>
                                                    @else
                                                        <form action="/administrator/uploadImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Įkelti viršelio nuotrauką') }}</button>
                                                            <input type="file" name="imageUpload">
                                                        </form>
                                                    @endif
                                                </div> <!-- Right ends here-->
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="containerForDraggable category" id="noId">
                                <div class="container_name"><h4><b>{{ __('Nesurūšiuotos pamokos') }}</b></h4></div>
                                @foreach($lessonsSortedByCategory as $lesson)
                                    @if($lesson -> category_id == null)
                                        <div class="draggable category containerId_noId containerPos_noPos" id="{{ $lesson -> id }}" draggable="true" style="overflow:auto;">
                                            <div class="left" style="float: left; width: 33%"> <!-- Left starts here-->
                                                <div class="name"><h5><b>{{ $lesson -> name }}</b></h5></div>
                                                <button class="btn btn-outline-danger category visibilityToggleButton" style="display: inline-block; float:left;">
                                                    @if($lesson -> visible == true)
                                                        <div class="bi bi-eye"></div>
                                                    @else
                                                        <div class="bi bi-eye-slash"></div>
                                                    @endif
                                                </button>
                                                <div class="delete_button" style="display: inline-block; float:left; margin-left: 15px; ">
                                                    <form action="/administrator/delete/{{ $lesson -> id }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti pamoką') }}</button>
                                                    </form>
                                                </div>
                                            </div> <!-- Left ends here-->
                                            <div class="right" style="float: right; width: 66%;"> <!-- Right starts here-->
                                                @if($lesson -> picture != null)
                                                    <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" style="max-height: 100px; max-width: 200px; float: right;" alt="{{ $lesson -> picture }}">
                                                    <form action="/administrator/changeImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Pakeisti viršelio nuotrauką') }}</button>
                                                        <input type="file" name="imageChange">
                                                    </form>
                                                    <form action="/administrator/removeImage/{{ $lesson -> id }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti viršelio nuotrauką') }}</button>
                                                    </form>
                                                @else
                                                    <form action="/administrator/uploadImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Įkelti viršelio nuotrauką') }}</button>
                                                        <input type="file" name="imageUpload">
                                                    </form>
                                                @endif
                                            </div> <!-- Right ends here-->
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="containersContainer topic hiddenSort">
                            @foreach($topics as $topic)
                                <div class="containerForDraggable topic" id="{{ $topic -> id }}">
                                    @if(strtoupper(app()->getLocale()) == "DE")
                                        <div class="container_name"><h4><b>{{ $topic -> name_de}}</b></h4></div>
                                    @else
                                        <div class="container_name"><h4><b>{{ $topic -> name}}</b></h4></div>
                                    @endif
                                    @foreach($lessonsSortedByTopic as $lesson)
                                        @if($lesson -> topic_id == $topic -> id)
                                            <div class="draggable topic containerId_{{ $lesson -> topic_id }} containerPos_{{ $lesson -> topic_order }}" id="{{ $lesson -> id }}" draggable="true" style="overflow:auto;">
                                                <div class="left" style="float: left; width: 33%"> <!-- Left starts here-->
                                                    <div class="name"><h5><b>{{ $lesson -> name }}</b></h5></div>
                                                    <button class="btn btn-outline-danger topic visibilityToggleButton" style="display: inline-block; float:left;">
                                                        @if($lesson -> visible == true)
                                                            <div class="bi bi-eye"></div>
                                                        @else
                                                            <div class="bi bi-eye-slash"></div>
                                                        @endif
                                                    </button>
                                                    <div class="delete_button" style="display: inline-block; float:left; margin-left: 15px; ">
                                                        <form action="/administrator/delete/{{ $lesson -> id }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti pamoką') }}</button>
                                                        </form>
                                                    </div>
                                                </div> <!-- Left ends here-->
                                                <div class="right" style="float: right; width: 66%;"> <!-- Right starts here-->
                                                    @if($lesson -> picture != null)
                                                        <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" style="max-height: 100px; max-width: 200px; float: right;" alt="{{ $lesson -> picture }}">
                                                        <form action="/administrator/changeImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Pakeisti viršelio nuotrauką') }}</button>
                                                            <input type="file" name="imageChange">
                                                        </form>
                                                        <form action="/administrator/removeImage/{{ $lesson -> id }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti viršelio nuotrauką') }}</button>
                                                        </form>
                                                    @else
                                                        <form action="/administrator/uploadImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Įkelti viršelio nuotrauką') }}</button>
                                                            <input type="file" name="imageUpload">
                                                        </form>
                                                    @endif
                                                </div> <!-- Right ends here-->
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="containerForDraggable topic" id="noId">
                                <div class="container_name"><h4><b>{{ __('Nesurūšiuotos pamokos') }}</b></h4></div>
                                @foreach($lessonsSortedByTopic as $lesson)
                                    @if($lesson -> topic_id == null)
                                        <div class="draggable topic containerId_noId containerPos_noPos" id="{{ $lesson -> id }}" draggable="true" style="overflow:auto;">
                                            <div class="left" style="float: left; width: 33%"> <!-- Left starts here-->
                                                <div class="name"><h5><b>{{ $lesson -> name }}</b></h5></div>
                                                <button class="btn btn-outline-danger topic visibilityToggleButton" style="display: inline-block; float:left;">
                                                    @if($lesson -> visible == true)
                                                        <div class="bi bi-eye"></div>
                                                    @else
                                                        <div class="bi bi-eye-slash"></div>
                                                    @endif
                                                </button>
                                                <div class="delete_button" style="display: inline-block; float:left; margin-left: 15px; ">
                                                    <form action="/administrator/delete/{{ $lesson -> id }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti pamoką') }}</button>
                                                    </form>
                                                </div>
                                            </div> <!-- Left ends here-->
                                            <div class="right" style="float: right; width: 66%;"> <!-- Right starts here-->
                                                @if($lesson -> picture != null)
                                                    <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" style="max-height: 100px; max-width: 200px; float: right;" alt="{{ $lesson -> picture }}">
                                                    <form action="/administrator/changeImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Pakeisti viršelio nuotrauką') }}</button>
                                                        <input type="file" name="imageChange">
                                                    </form>
                                                    <form action="/administrator/removeImage/{{ $lesson -> id }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti viršelio nuotrauką') }}</button>
                                                    </form>
                                                @else
                                                    <form action="/administrator/uploadImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Įkelti viršelio nuotrauką') }}</button>
                                                        <input type="file" name="imageUpload">
                                                    </form>
                                                @endif
                                            </div> <!-- Right ends here-->
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="containersContainer level hiddenSort">
                            @foreach($levels as $level)
                                <div class="containerForDraggable level" id="{{ $level -> id }}">
                                    @if(strtoupper(app()->getLocale()) == "DE")
                                        <div class="container_name"><h4><b>{{ $level -> name_de}}</b></h4></div>
                                    @else
                                        <div class="container_name"><h4><b>{{ $level -> name}}</b></h4></div>
                                    @endif
                                    @foreach($lessonsSortedByLevel as $lesson)
                                        @if($lesson -> level_id == $level -> id)
                                            <div class="draggable level containerId_{{ $lesson -> level_id }} containerPos_{{ $lesson -> level_order }}" id="{{ $lesson -> id }}" draggable="true" style="overflow:auto;">
                                                <div class="left" style="float: left; width: 33%"> <!-- Left starts here-->
                                                    <div class="name"><h5><b>{{ $lesson -> name }}</b></h5></div>
                                                    <button class="btn btn-outline-danger level visibilityToggleButton" style="display: inline-block; float:left;">
                                                        @if($lesson -> visible == true)
                                                            <div class="bi bi-eye"></div>
                                                        @else
                                                            <div class="bi bi-eye-slash"></div>
                                                        @endif
                                                    </button>
                                                    <div class="delete_button" style="display: inline-block; float:left; margin-left: 15px; ">
                                                        <form action="/administrator/delete/{{ $lesson -> id }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti pamoką') }}</button>
                                                        </form>
                                                    </div>
                                                </div> <!-- Left ends here-->
                                                <div class="right" style="float: right; width: 66%;"> <!-- Right starts here-->
                                                    @if($lesson -> picture != null)
                                                        <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" style="max-height: 100px; max-width: 200px; float: right;" alt="{{ $lesson -> picture }}">
                                                        <form action="/administrator/changeImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Pakeisti viršelio nuotrauką') }}</button>
                                                            <input type="file" name="imageChange">
                                                        </form>
                                                        <form action="/administrator/removeImage/{{ $lesson -> id }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti viršelio nuotrauką') }}</button>
                                                        </form>
                                                    @else
                                                        <form action="/administrator/uploadImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Įkelti viršelio nuotrauką') }}</button>
                                                            <input type="file" name="imageUpload">
                                                        </form>
                                                    @endif
                                                </div> <!-- Right ends here-->
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="containerForDraggable level" id="noId">
                                <div class="container_name"><h4><b>{{ __('Nesurūšiuotos pamokos') }}</b></h4></div>
                                @foreach($lessonsSortedByLevel as $lesson)
                                    @if($lesson -> level_id == null)
                                        <div class="draggable level containerId_noId containerPos_noPos" id="{{ $lesson -> id }}" draggable="true" style="overflow:auto;">
                                            <div class="left" style="float: left; width: 33%"> <!-- Left starts here-->
                                                <div class="name"><h5><b>{{ $lesson -> name }}</b></h5></div>
                                                <button class="btn btn-outline-danger level visibilityToggleButton" style="display: inline-block; float:left;">
                                                    @if($lesson -> visible == true)
                                                        <div class="bi bi-eye"></div>
                                                    @else
                                                        <div class="bi bi-eye-slash"></div>
                                                    @endif
                                                </button>
                                                <div class="delete_button" style="display: inline-block; float:left; margin-left: 15px; ">
                                                    <form action="/administrator/delete/{{ $lesson -> id }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti pamoką') }}</button>
                                                    </form>
                                                </div>
                                            </div> <!-- Left ends here-->
                                            <div class="right" style="float: right; width: 66%;"> <!-- Right starts here-->
                                                @if($lesson -> picture != null)
                                                    <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" style="max-height: 100px; max-width: 200px; float: right;" alt="{{ $lesson -> picture }}">
                                                    <form action="/administrator/changeImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Pakeisti viršelio nuotrauką') }}</button>
                                                        <input type="file" name="imageChange">
                                                    </form>
                                                    <form action="/administrator/removeImage/{{ $lesson -> id }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')" class="btn btn-outline-danger" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Ištrinti viršelio nuotrauką') }}</button>
                                                    </form>
                                                @else
                                                    <form action="/administrator/uploadImage/{{ $lesson -> id }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Įkelti viršelio nuotrauką') }}</button>
                                                        <input type="file" name="imageUpload">
                                                    </form>
                                                @endif
                                            </div> <!-- Right ends here-->
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS that needs to be in this file or it does not work (Dropzone is stupid) -->
    <script type="text/javascript">
        Dropzone.options.fileUpload = {
            paramName: "file",
            acceptedFiles : '.zip, .h5p',
            init: function() {
                this.on("queuecomplete", function (file) {
                    location.reload();
                });
            }
        }
        var csrfToken = "{{ csrf_token() }}";
    </script>
@endsection