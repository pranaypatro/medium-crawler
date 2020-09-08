<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
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
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="links">
{{--                {{ dd($data) }}--}}
                <div class="element">
                    <label>Detail Paragraphs:- </label>
                    @foreach ($data['data'] as $para)
                        <p>{{ $para }}</p>
                    @endforeach
                </div>
                <div class="element">
                    <label><b>Data fetched Time:- </b></label>
                    <label>{{ $data['curl_time'] }}</label>
                </div>
                <div class="element">
                    <label><b>Data fetched from:- </b></label>
                    <label>{{ $data['fetched_from'] }}</label>
                </div>
                <div class="element">
                    <label><b>Title:- </b></label>
                    <label>{{ $data['title'] }}</label>
                </div>
                <div class="element">
                    <label><b>Creator:- </b></label>
                    <label>{{ $data['creator'] }}</label>
                </div>
                <div class="element">
                    <label><b>Tags:- </b></label>
                    @foreach ($data['tags'] as $tag)
                        <a class="tag-element" href="">{{ $tag }}</a>
                    @endforeach
                </div>
            </div>
        </div>


        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script>
            $(document).ready(function() {

                $('.tag-element').click(function(e) {
                    e.preventDefault();
                    var text = $(this).text();
                    localStorage.setItem('hitter', text.trim());
                    alert(text.trim());
                    window.location.href = "{{ route('home') }}";
                });

                $('#submit_request').click(function(e) {
                    e.preventDefault();
                    /*Ajax Request Header setup*/
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    /* Submit form data using ajax*/
                    $.ajax({
                        url: "{{ route('home') }}",
                        method: 'get',
                        data: $('#submit_request').serialize(),
                        success: function(response) {

                            var jsonData = JSON.parse(response);

                            var element = document.getElementById("blogs-overview");
                            element.innerHTML = "";
                            var i=0;
                            for (i = 0; i < (jsonData.title).length; i++) {
                                // console.log(jsonData.title[i] + " - " +  jsonData.url[i]);
                                element.innerHTML += `<div class="blog_status"><label>${jsonData.title[i]}</label><input type="hidden" id="${i}" value="${jsonData.url[i]}" name="blog_url"></div>`;
                            }
                        }
                    });

                });

                $(document).on("click", ".blog_status" , function() {
                    var id = $(this).children("label").text();
                    var value = $(this).children("input").val();
                    console.log(id);
                    console.log(value);
                });

            });
        </script>
    </body>
</html>
