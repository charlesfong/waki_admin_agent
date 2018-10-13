<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WAKi DATA') }}</title>

    <!-- Styles, Font, Bootstrap, Icon -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/material-icons.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="{{ asset('css/Contact-Form-Clean.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Navigation-with-Button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Sidebar-Menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Sidebar-Menu1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Pretty-Search-Form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">

    @yield('css')

    <!-- JavaScript -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/chart-data.js') }}"></script>
    
</head>
<body style="background-image:url(&quot;{{ asset('img/BG-01.png') }}&quot;);">
    <div id="app">
        <div id="wrapper">
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li id="MainMenu-toggle" class="sidebar-brand" style="text-align:center;margin-left:-28px;"> <a href="#">Main Menu<i class="fa fa-bars"></i></a></li>

                    <!-- gambar atau logo org yang login -->
                    <li style="margin-left:-28px;text-align:center;height:160px;"> <img id="img-member" src="{{ asset('img/default-avatar.jpg') }}"></li>

                    <!-- buat nampilin nama dan tipe aksesnya -->
                    <li id="Nama-TipeAkses" class="DataLogin">{{ Auth::user()->name }} - {{Auth::user()->roles->first()->name}}</li>

                    <!-- buat nampulin negara dan branch nya -->
                    <li id="Negara-Branch" class="DataLogin">{{ Auth::user()->branch['country'] }} - {{ Auth::user()->branch['name'] }}</li>

                    <!-- buat ganti password modal -->
                    <li id="Change-Password" class="DataLogin" style="margin-bottom:35px;">
                        <a href="#" id="change-password" class="btn btn-link" style="background-color:black;font-size:12px;height:inherit;" role="button" value="idnya-userLogin">Change Password</a>
                    </li>
                    
                    @yield('navmenu')

                    <!-- untuk logout -->
                    <li id="logout-nav">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                            <i class="fa fa-sign-out" style="margin-left:5px;display:inline;"></i>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <div class="page-content-wrapper">
                <div class="container-fluid" style="color:rgb(49,55,58);background-color:#000000;height:50px;text-align:center;">
                    <a class="btn btn-link d-inline float-left" role="button" href="#menu-toggle" id="menu-toggle" style="height:50px;padding-top:2px;font-size:25px;color:rgb(153,153,153);">
                        <i class="fa fa-bars"></i>
                    </a>
                    <img id="logo-waki" src="{{ asset('img/waki.png') }}">

                    <!-- tombol untuk logout -->
                    <a class="btn btn-link d-inline float-right" role="button" id="logout" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                        <i class="fa fa-sign-out" style="margin-left:5px;display:inline;"></i>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>

                <!-- For Change Password -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->has('new-password'))
                    @foreach($errors->get('new-password') as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                <!-- For Saved/Changed Data -->
                @if (session()->has('message'))
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $("#modal-Notification").modal("show");
                            $("#txt-notification").html("<div class=\"alert alert-success\">{{ session()->get('message')}}</div>");
                        });
                    </script>
                @endif

                @yield('content')
            </div>
        </div>
        <!-- modal notification (data saved) -->
        <div class="modal fade" role="dialog" tabindex="-1" id="modal-Notification">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Notice</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="txt-notification"></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal notification (data update) -->
        <div class="modal fade" role="dialog" tabindex="-1" id="modal-NotificationUpdate">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Notice</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="txt-notification"><div class="alert alert-success">Data has been CHANGED successfully</div></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal ganti password -->
        <div class="modal fade" role="dialog" tabindex="-1" id="modal-ChangePassword">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Change Password</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <!-- form untuk ganti password -->
                    <form method="post" action="{{ route('changePassword') }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                                <div class="form-group">
                                    <span style="display:block;">Current Password</span>
                                    <input class="form-control form-control" id="current-password" type="password" name="current-password" placeholder="Current Password" required>
                                    <span class="invalid-feedback">
                                        <strong>Your current password does not matches with the password you provided.</strong>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <span style="display:block;">New Password</span>
                                    <input class="form-control form-control" id="new-password" type="password" name="new-password" required placeholder="Min length: 6">
                                    <span class="invalid-feedback">
                                        <strong>New Password cannot be same as your current password.</strong>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <span style="display:block;">Confirm New Password</span>
                                    <input class="form-control form-control" id="new-password-confirm" type="password" name="new-password_confirmation" placeholder="Confirm New Password" required>
                                    <span class="invalid-feedback">
                                        <strong>This field must same with your New Password.</strong>
                                    </span>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @yield('modal')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="{{ asset('js/ListMethod.js') }}"></script>
    <script src="{{ asset('js/Sidebar-Menu.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/easypiechart.js') }}"></script>
    <script src="{{ asset('js/easypiechart-data.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#current-password").on("keyup", function(){
                CheckChangePassword();
            });

            $("#new-password").on("keyup", function(){
                CheckChangePassword();
            });

            $("#new-password-confirm").on("keyup", function(){
                CheckChangePassword();
            });
        } );

        function CheckChangePassword()
        {
            var currentPass = $("#current-password").val();
            var newPass = $("#new-password").val();
            var confirmPass = $("#new-password-confirm").val();

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: "{{route('check-change-password')}}",
                data: {
                    'currentPass': currentPass,
                    'newPass': newPass,
                    'confirmPass': confirmPass,
                },
                success: function(data){
                    $.each(data, function(key, val)
                    {
                        if(val != '')
                        {
                            $("#" + key).addClass("is-invalid");
                        }
                        else
                        {
                            $("#" + key).removeClass("is-invalid");
                        }
                    });
                },
            });
        }
    </script>
    @yield('script')
</body>
</html>
