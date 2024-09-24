@extends('layouts.app')

@section('content_header')
    <h1>Registered User</h1> 
@stop

@section('content')

@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )

@if (config('adminlte.usermenu_profile_url', false))
    @php( $profile_url = Auth::user()->adminlte_profile_url() )
@endif

@if (config('adminlte.use_route_url', false))
    @php( $profile_url = $profile_url ? route($profile_url) : '' )
    @php( $logout_url = $logout_url ? route($logout_url) : '' )
@else
    @php( $profile_url = $profile_url ? url($profile_url) : '' )
    @php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif


<div class="card">
    <div class="card-body" style="margin: 40px; display: flex; justify-content: center">
        <div style=" display: flex; justify-content: center; flex-direction: column; text-align:center">
            @if ($errors->any())
    <div class="alert alert-danger">
        
            @foreach ($errors->all() as $error)
                <label>{{ $error }}</label>
            @endforeach
        
    </div>
@endif

            <h2 >Profile</h2>

            <img src="{{asset('image/download-removebg-preview (6).png')}}" alt="">
            <br>
            <br>
            <h3><b>{{$profile->name}}</b></h3>
            <h6>{{$profile->email}}</h6>

            {{-- <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name', $profile->name) }}"> --}}



<br>
<form action="">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
</form>
<br>
            <a class="btn btn-default btn-flat float-right @if(!$profile_url) btn-block @endif"
            href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
             <i class="fa fa-fw fa-power-off text-red"></i>
             {{ __('adminlte::adminlte.log_out') }}
            </a>        
        </div>
    </div>
</div>



<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            
            <div class="modal-body">
                <!-- Add your password change form here -->
                <form action="{{ route('profile.change', Auth::id()) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input type="password" class="form-control" id="old_password" name="password_old" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card{
        margin-left: 16vw;
        width: 50vw;
        display: flex;
        justify-content: center;
        
    }
</style>
@endsection