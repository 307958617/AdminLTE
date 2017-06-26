@extends('layouts.app_top-nav')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username">{{ $user->name }}</h3>
                    <h5 class="widget-user-desc">
                        {{ $user->profile->position ? $user->profile->position : '' }}
                    </h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="{{ asset('storage/images/avatars').'/'.$user->avatar }}" style="height: 90px" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row text-center">
                        <br>
                        @if(Auth::user()->id == $user->id)
                            <edit_profile user="{{ Auth::user()->name }}" position="{{ Auth::user()->profile->position }}" about="{{ Auth::user()->profile->about }}"></edit_profile>
                        @endif
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title text-center" style="display: block">About {{ $user->name }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" id="box-body-about">
                    {{ $user->profile->about ? $user->profile->about : '没有内容！' }}
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection