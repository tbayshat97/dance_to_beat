{{-- extend layout --}}
@extends('layouts-artist.contentLayoutMaster')

{{-- page title --}}
@section('title','Dashboard')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/css/fullcalendar.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/daygrid/daygrid.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/timegrid/timegrid.min.css')}}">
@endsection

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-calendar.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section">
    <!--card stats start-->
    <div id="card-stats" class="pt-0">
        <div class="row">
            <div class="col s12 m6 l6 xl3">
                <div
                    class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">star</i>
                                <p>Rate</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{ $myReview['total'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6 xl3">
                <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">group</i>
                                <p>Clients</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{ $students }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6 xl3">
                <div
                    class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text animate fadeRight">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">event_available</i>
                                <p>Appointment</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{ $appointments }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6 xl3">
                <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">personal_video</i>
                                <p>Courses</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{ $courses }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h4 class="card-title">
                        Calender
                    </h4>
                    <div id="basic-calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal3" class="modal bottom-sheet">
        <div class="modal-content">
          <h4>Modal Header</h4>
          <ul class="collection">
            <li class="collection-item avatar">
              <img src="{{asset('images/avatar/avatar-7.png')}}" alt="" class="circle">
              <span class="title">Title</span>
              <p>First Line
                <br> Second Line
              </p>
              <a href="#!" class="secondary-content">
                <i class="material-icons">grade</i>
              </a>
            </li>
            <li class="collection-item avatar">
              <i class="material-icons circle">folder</i>
              <span class="title">Title</span>
              <p>First Line
                <br> Second Line
              </p>
              <a href="#!" class="secondary-content">
                <i class="material-icons">grade</i>
              </a>
            </li>
            <li class="collection-item avatar">
              <i class="material-icons circle green">assessment</i>
              <span class="title">Title</span>
              <p>First Line
                <br> Second Line
              </p>
              <a href="#!" class="secondary-content">
                <i class="material-icons">grade</i>
              </a>
            </li>
            <li class="collection-item avatar">
              <i class="material-icons circle red">play_arrow</i>
              <span class="title">Title</span>
              <p>First Line
                <br> Second Line
              </p>
              <a href="#!" class="secondary-content">
                <i class="material-icons">grade</i>
              </a>
            </li>
          </ul>
        </div>
      </div>

    <!--card stats end-->
</div>
@endsection

@section('vendor-script')
<script src="{{asset('vendors/chartjs/chart.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/lib/moment.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/js/fullcalendar.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/daygrid/daygrid.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/timegrid/timegrid.min.js')}}"></script>
<script src="{{asset('vendors/fullcalendar/interaction/interaction.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
<script>
    $(document).ready(function () {
        //  Basic Calendar Initialize
        availableTimes()
    });

    function availableTimes()
    {
        var basicCal = document.getElementById('basic-calendar');
        var fcCalendar = new FullCalendar.Calendar(basicCal, {
            editable: false,
            plugins: ["dayGrid", "interaction"],
            eventLimit: true, // allow "more" link when too many events
            events: "{{ route('artist.artistAvailableTime.index') }}",
            dateClick: function (info) {
                showSingleDateAvailableTimes(info.dateStr);
            }
        });
        fcCalendar.render();
    }

    function showSingleDateAvailableTimes(date) {
        var url = "{{ route('artist.artistAvailableTime.showSingleDateAvailableTimes', ':date') }}";
        url = url.replace(':date', date);

        window.location.href = url;
    }
</script>
@endsection
