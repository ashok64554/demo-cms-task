@extends('layouts.master')
@section('content')
@if(Request::segment(2)==='edit-user' || Request::segment(2)==='add-user')
@if(Request::segment(2)==='add-user')
<?php
$id             = '';
$name           = '';
$email          = '';
$address        = '';
$mobile         = '';
$companyName    = '';
$status         = '';
$userRole       = '';
?>
@else
<?php
$id             = $user->id;
$name           = $user->name;
$email          = $user->email;
$address        = $user->address;
$mobile         = $user->mobile;
$address        = $user->address;
$companyName    = $user->companyName;
$status         = $user->status;
$userRole       = $userRole;
?>
@endif

{{ Form::open(array('route' => 'user-save', 'class'=> 'form-horizontal','enctype'=>'multipart/form-data', 'files'=>true)) }}
{!! Form::hidden('id',$id,array('class'=>'form-control')) !!}
@csrf
<div class="row row-deck">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    @if(Request::segment(2)==='add-user')
                    Add
                    @else
                    Edit
                    @endif
                    User
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            {!! Form::text('name',$name,array('id'=>'name','class'=> $errors->has('name') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Name', 'autocomplete'=>'off','required'=>'required')) !!}
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            {!! Form::text('email',$email,array('id'=>'email','class'=> $errors->has('email') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Email Address', 'autocomplete'=>'off','required'=>'required')) !!}
                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    @if(Request::segment(2)==='add-user')
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            {!! Form::password('password',array('id'=>'password','class'=> $errors->has('password') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Password', 'autocomplete'=>'off','required'=>'required')) !!}
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            {!! Form::password('confirm-password',array('id'=>'confirm-password','class'=> $errors->has('confirm-password') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Confirm Password', 'autocomplete'=>'off','required'=>'required')) !!}
                            @if ($errors->has('confirm-password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('confirm-password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile" class="form-label">Mobile</label>
                            {!! Form::text('mobile',$mobile,array('id'=>'mobile','class'=> $errors->has('mobile') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Mobile', 'autocomplete'=>'off','required'=>'required')) !!}
                            @if ($errors->has('mobile'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="form-label">Address</label>
                            {!! Form::text('address',$address,array('id'=>'address','class'=> $errors->has('address') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Address', 'autocomplete'=>'off','required'=>'required')) !!}
                            @if ($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="companyName" class="form-label">Company Name</label>
                            {!! Form::text('companyName',$companyName,array('id'=>'companyName','class'=> $errors->has('companyName') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Company Name', 'autocomplete'=>'off','required'=>'required')) !!}
                            @if ($errors->has('companyName'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('companyName') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="roles" class="form-label">Role</label>
                            {!! Form::select('roles', $roles,$userRole, array('class' => 'form-control')) !!}
                            @if ($errors->has('roles'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('roles') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="form-footer text-center">
               {!! Form::submit('Save', array('class'=>'btn btn-primary btn-fixed')) !!}
            </div>
            </div>
        </div>
    </div>

</div>
{{ Form::close() }}

@elseif(Request::segment(2)==='view-user')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="panel panel-primary">
                    <div class=" tab-menu-heading">
                        <div class="tabs-menu1 ">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                <li class=""><a href="#basicInfo" class="active" data-toggle="tab">Basic Info</a></li>
                              
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body tabs-menu-body">
                        <div class="tab-content">
                            <div class="tab-pane active " id="basicInfo">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item justify-content-between">
                                                Name
                                                <span class="badgetext">{{ $user->name }}</span>
                                            </li>
                                            <li class="list-group-item justify-content-between">
                                                Email
                                                <span class="badgetext">{{ $user->email }}</span>
                                            </li>
                                            <li class="list-group-item justify-content-between">
                                                Mobile
                                                <span class="badgetext">{{ $user->mobile }}</span>
                                            </li>
                                            
                                            <li class="list-group-item justify-content-between">
                                                Company Name
                                                <span class="badgetext">{{ $user->companyName }}</span>
                                            </li>
                                           
                                            <li class="list-group-item justify-content-between">
                                                Auto lock time out
                                                <span class="badgetext">{{ $user->locktimeout }} minute</span>
                                            </li>
                                            <li class="list-group-item justify-content-between">
                                                Status
                                                @if($user->status=='0') 
                                                <span class="badgetext text-danger">
                                                    Inactive
                                                </span>
                                                @else
                                                <span class="badgetext text-success">
                                                    Active
                                                </span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">

                                            <li class="list-group-item justify-content-between">
                                                Address
                                                <span class="badgetext">{{ $user->address }}</span>
                                            </li>
                                            <li class="list-group-item justify-content-between">
                                                City
                                                <span class="badgetext">{{ $user->city }}</span>
                                            </li>
                                            <li class="list-group-item justify-content-between">
                                                Zip Code
                                                <span class="badgetext">{{ $user->zipCode }}</span>
                                            </li>
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

@else
<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-header ">
            <h3 class="card-title ">User Management</h3>
            <div class="card-options">
                @can('user-create')
                <a class="btn btn-sm btn-outline-primary" href="{{ route('user-create') }}"> <i class="fa fa-plus"></i> Create New User</a>
                @endcan
                &nbsp;&nbsp;&nbsp;<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a>
            </div>
        </div>
        {{ Form::open(array('route' => 'user-action', 'class'=> 'form-horizontal', 'autocomplete'=>'off')) }}
        @csrf
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col"width="10%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $i = 0 @endphp
                        @foreach($data as $rows)
                        <tr>
                            <td>
                                <label class="custom-control custom-checkbox">
                                    {{ Form::checkbox('boxchecked[]', $rows->id,'', array('class' => 'colorinput-input custom-control-input', 'id'=>'')) }}
                                    <span class="custom-control-label"></span>
                                </label>
                            </td>
                            <td>{!! ++$i !!}</td>
                            <td>{!! $rows->name !!}</td>
                            <td>{!! $rows->email !!}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs ">
                                    @if($rows->status=='0') 
                                    <span class="text-danger">Inactive</span>
                                    @else 
                                    <span class="text-success">Active</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-xs">
                                    @can('user-view')
                                    <a class="btn btn-sm btn-secondary" href="{{ route('user-view',$rows->app_key) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><i class="fa fa-eye"></i></a>
                                    @endcan
                                    @can('user-edit')
                                    <a class="btn btn-sm btn-primary" href="{{ route('user-edit',$rows->app_key) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('user-delete')
                                    <a class="btn btn-sm btn-danger" href="{{ route('user-delete',$rows->app_key) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @can('user-action')
            <div class="row div-margin">
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="input-group"> 
                        <span class="input-group-addon">
                            <i class="fa fa-hand-o-right"></i> </span> 
                            {{ Form::select('cmbaction', array(
                            ''              => 'Action', 
                            'Active'        => 'Active',
                            'Inactive'  => 'Inactive'), 
                            '', array('class'=>'form-control','id'=>'cmbaction'))}} 
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-6">
                        <div class="input-group">
                            <button type="submit" class="btn btn-danger pull-right" name="Action" onClick="return delrec(document.getElementById('cmbaction').value);">Apply</button>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endif

@endsection