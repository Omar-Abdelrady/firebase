@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        @auth
                            @if(auth()->user()->email == 'omar@admin.com')
                            <form action="{{ route('notification') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                                <div class="form-group">
                                    <label>Body</label>
                                    <textarea class="form-control" name="body"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>icone</label>
                                    <input type="text" class="form-control" name="icon">
                                </div>
                                <div class="form-group">
                                    <label>image</label>
                                    <input type="text" class="form-control" name="image">
                                </div>
                                <button type="submit" class="btn btn-primary my-2">Send Notification</button>
                            </form>
                            @endif
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyBlIaGPWGr03yw2YuplgOpqzu3rgEtWDMc",
            authDomain: "notification-d6445.firebaseapp.com",
            projectId: "notification-d6445",
            storageBucket: "notification-d6445.appspot.com",
            messagingSenderId: "720935794921",
            appId: "1:720935794921:web:a80992da1e12de7eca5878",
            measurementId: "G-NCLTHYQKJW"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        function initFirebaseMessagingRegistration() {
            messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function(token) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route("fcmToken") }}',
                        type: 'POST',
                        data: {
                            token: token
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            // alert('Token saved successfully.');
                        },
                        error: function (err) {
                            console.log('User Chat Token Error'+ err);
                        },
                    });

                }).catch(function (err) {
                console.log('User Chat Token Error'+ err);
            });
        }
        initFirebaseMessagingRegistration();

        messaging.onMessage(function(payload) {
            console.log(payload.notification.link)
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            console.log(noteTitle, noteOptions)
            new Notification(noteTitle, noteOptions);
        });
    </script>
@endsection
