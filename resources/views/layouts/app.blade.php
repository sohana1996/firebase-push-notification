<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>


    <!-- firebase js -->
    <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>


<script>
    $(function () {
        var firebaseConfig = {
            apiKey: "AIzaSyCHjUBC1wzeGqPXpuNpsFHa3jJK10EgXlw",
            authDomain: "test-project-220bb.firebaseapp.com",
            databaseURL: "https://test-project-220bb.firebaseio.com",
            projectId: "test-project-220bb",
            storageBucket: "test-project-220bb.appspot.com",
            messagingSenderId: "428037360287",
            appId: "1:428037360287:web:054e8d96ccb28dac5b70aa"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        navigator.serviceWorker.register("{{url('firebase-messaging-sw.js')}}")
            .then(function () {
                const messaging = firebase.messaging();
                console.log(messaging)
                messaging.requestPermission()
                    .then(function () {

                        return messaging.getToken();
                    })
                    .then(function (token) {
                        InsertOrUpdateFcmToken(token);
                        console.log(token)
                    }).catch(function (err) {
                    console.log(err);
                });
                messaging.onMessage(function (payload) {
                    console.log("Message received. ", payload);
                    //https://developer.mozilla.org/en-US/docs/Web/API/notification/Notification
                    navigator.serviceWorker.ready.then(function (registration) {
                        registration.showNotification(payload.notification.title, {
                            tag: payload.notification.tag,
                            body: payload.notification.body,
                            icon: payload.notification.icon,
                            image: payload.notification.image,
                            vibrate: [500, 110, 500, 110, 450, 110, 200, 110, 170, 40, 450, 110, 200, 110, 170, 40, 500],
                            sound: 'https://notificationsounds.com/soundfiles/dd458505749b2941217ddd59394240e8/file-sounds-1111-to-the-point.ogg'
                        });
                    });
                    console.log(payload);
                });
            });
    })

    function InsertOrUpdateFcmToken(token) {
        $.ajax({
            type: 'POST',
            url: '{{route('FcmTokenInsertOrUpdate')}}',
            data:
                {
                    "_token": "{{ csrf_token() }}",
                    user_id: "{{auth()->id()}}",
                    fcm_token: token,

                },
            success: function (data) {
                console.log(data)
            }
        });
    }

</script>


</body>
<script>

</script>
</html>
