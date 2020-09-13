<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script> -->
    <!-- Fonts -->
    <!-- <link href="{{ asset('css/argon.css') }}" rel="stylesheet"> -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">{{ auth()->user()->unreadNotifications->count() }} Notifications</span>
          <div class="dropdown-divider"></div>
          @forelse(auth()->user()->unreadNotifications as $notification)
            <a href="{{route('specificcustomer',['id'=>$notification->data['id']])}}" class="dropdown-item">
            <i class="fas fa-bell mr-2"></i>
                 {{ $notification->data['username'] }}&nbsp;{{ $notification->data['message'] }}
            <span class="float-right text-muted text-sm">{{$notification->created_at->diffForHumans()}}</span>
          </a> 
          @empty
          <a href="#" class="dropdown-item"><i class="fas fa-bell-slash"></i>&nbsp;No notifications</a>
          <br>
              <div class="dropdown-divider"></div>   
            @endforelse
            <br>
          <div class="dropdown-divider"></div>
          @if(auth()->user()->unreadNotifications->count() >0)
          <a href="{{route('mark')}}" class="dropdown-item dropdown-footer">Mark All Notifications Read</a>
          @endif
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" role="button" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" data-toggle="tooltip" data-placement="top" title="Logout">
         <i class="fas fa-sign-out-alt"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DestroTechs ltd</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('home')}}" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('allcustomers')}}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('editcustomer')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Edit Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('newcustomer')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Customer</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{route('listnas')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Nas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('newnas')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Nas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('userlimits')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Limits</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('newlimitattr')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Limit Attribute</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('userlimitgroups')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Limit Groups</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money">&dollar;</i>
              <p>
                Payments
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('allpayments')}}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Payments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('initiatepayment')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Initiate payment</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-hammer"></i>
              <p>
               Maintenance
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('get.cleanstale')}}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Clean Stale Conns</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('customerconnectivity')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Test Connectivity</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('deleteacctrec')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delete Accounting Rec</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('onlineusers')}}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Online Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('lastconnatt')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Last Conection Attempts</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User registration reports</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top User</p>
                </a>
              </li>
            </ul>
          </li>
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Accounting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('useraccounting')}}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Accounting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('ipaccounting')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>IP Accounting</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="{{route('nasaccounting')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nas Accounting</p>
                </a>
              </li>
               
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('plans')}}" class="nav-link">
              <i class="fas fa-chart-pie nav-icon"></i>
              <p>Plans</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('operators')}}" class="nav-link">
              <i class="fas fa-user nav-icon"></i>
              <p>OPerators</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('plans')}}" class="nav-link">
              <i class="fas fa-atlas nav-icon"></i>
              <p>Invoices</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('servicestatus')}}" class="nav-link">
              <i class="fas fa-check-circle nav-icon"></i>
              <p>Services Status</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0 text-dark">@yield('pagetitle')</h3>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
       @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?php echo date('Y');?> <a href="#">DestroTecths</a>.</strong> All rights reserved.
  </footer>
</div>
    <!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard2.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

@yield('scripts')
 @include('sweetalert::alert')

</body>
</html>
