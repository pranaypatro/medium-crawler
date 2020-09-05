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

            <div class="content">
                <div class="content">
                    <form id="submit_request" method="post" action="#">
                        <label>Enter Keyword</label>
                        <input type="text" id="keyword" name="keyword">
                        <button type="submit">Search</button>
                    </form>

                    <div id="blogs-overview">
{{--                        @for ($i = 0; $i < sizeof($data['title']); $i++)--}}
{{--                            <h1>Title = {{ $data['title'][$i] }}</h1>--}}
{{--                        @endfor--}}


                    </div>
                </div>

            </div>
        </div>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script>
            //-----------------
            $(document).ready(function(){
                $('#submit_request').click(function(e){
                    e.preventDefault();
                    /*Ajax Request Header setup*/
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#send_form').html('Sending..');

                    /* Submit form data using ajax*/
                    $.ajax({
                        url: "{{ route('overview.parse') }}",
                        method: 'post',
                        data: $('#submit_request').serialize(),
                        success: function(response){

                            var jsonData = JSON.parse(response);

                            var element = document.getElementById("blogs-overview");
                            element.innerHTML = "";
                            var i=0;
                            for (i = 0; i < (jsonData.title).length; i++) {
                                // console.log(jsonData.title[i] + " - " +  jsonData.url[i]);
                                element.innerHTML += `<a href="${jsonData.url[i]}">${jsonData.title[i]}</a><label> - Parsing</label><br/>`;
                            }
                            
                            //------------------------
                            // $('#send_form').html('Submit');
                            // $('#res_message').show();
                            // $('#res_message').html(response.msg);
                            // $('#msg_div').removeClass('d-none');
                            // document.getElementById("contact_us").reset();
                            setTimeout(function(){
                                $('#res_message').hide();
                                $('#msg_div').hide();
                            },10000);
                            //--------------------------
                        }});
                });
            });
            //-----------------
        </script>
    </body>
</html>
