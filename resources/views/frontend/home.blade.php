@extends('layouts.frontend')
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard">
                

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-list"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Assets </span>
                        <span class="info-box-number">{{App\Models\Allocation::count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-line"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Today Assets</span>
                        <span class="info-box-number">{{App\Models\Allocation::whereDate('created_at', today())->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1" ><i class="fas fa-signal" style="color: #fff"></i></span>
                
                        <div class="info-box-content">
                            <span class="info-box-text">Last Month Assets</span>
                            <span class="info-box-number">
                                {{ App\Models\Allocation::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count() }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Employees</span>
                            <span class="info-box-number">{{App\Models\Employee::count()}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                
                <!-- /.col -->
                
              
                
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>



                </div>
                <!-- /.row -->
            <!-- /.col -->
        </div>
    </div>
    <div class="card-header">
        {{ trans('cruds.tasksCalendar.title') }}
    </div>
    <div class="card">
    <div class="card-body">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css" />
        <div id="calendar"></div>

    </div>
</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
@parent
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                events : [
@foreach($events as $event)
@if($event->due_date)
                            {
                                title : '{{ $event->name }}',
                                start : '{{ \Carbon\Carbon::createFromFormat(config('panel.date_format'),$event->due_date)->format('Y-m-d') }}',
                                // url : '{{ url('tasks').'/'.$event->id.'/edit' }}'
                            },
@endif
@endforeach
                ]
            })
        });
</script>

@endsection