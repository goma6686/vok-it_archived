@extends('administrator.layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Atsiliepimas') }}
    </h2>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous"/>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous"></script>
    <link href="/css/admin.css "rel="stylesheet">
    <script src="/js/admin.js" type="text/javascript" defer></script>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <b>{{ __('Atsiliepimai') }}</b>
                    <div class="wrapper admin panel-body">
                        <table class="table table-hover table-striped">
                        <thead>
                            <th scope="col" id="text" style="width: 60%;">{{ __('Tekstas') }}</th>
                            <th scope="col" id="location">{{ __('Puslapis') }}</th>
                            <th scope="col" id="date">{{ __('Data') }}</th>
                        </thead>
                        <tbody>
                            @if (isset($feedbacks)) 
                            @foreach($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback -> text }}</td>
                                    <td><a style="color: #78003F;" target="_blank" href="{{ $feedback -> page }}">{{ $feedback -> page }}</a></td>
                                    <td>{{ $feedback -> created_at }}</td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                        </table>
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection