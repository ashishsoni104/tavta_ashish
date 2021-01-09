@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome {{Auth::user()->first_name.' '.Auth::user()->last_name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="search_users" id="search_users" placeholder="Search Users" />
                        </div>
                        <div class="col-md-3">
                            <a href="{{url('pending-request')}}">Pending Request</a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ url('my-connection') }}">My Connection</a>
                        </div>
                    </div>
                </div>

            </div><br/><br/>
            @if(!empty($user))
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Technology</th>
                    </tr>
                </thead>
                <tbody id="search_result">
                    @foreach($user as $key=>$val)
                        <tr>
                            <td>{{ $val->first_name.' '.$val->last_name }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->mobile }}</td>
                            <td>
                                @foreach($val->technology as $k=>$v)
                                    {{ config('app_constant.technology')[$v] }},
                                @endforeach
                            </td>
                            <td><a href="{{ url('/') }}/send-connection-request/{{ $val->id }}">Send Request</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            @if(!empty($pendingUsers))
                <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Technology</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingUsers as $key=>$val)
                        <tr>
                            <td>{{ $val->first_name.' '.$val->last_name }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->mobile }}</td>
                            <td>
                                @foreach($val->technology as $k=>$v)
                                    {{ config('app_constant.technology')[$v] }},
                                @endforeach
                            </td>
                            <td><a href="{{ url('/manage-status') }}/{{$val->id}}/accept">Accept</a>|<a href="{{ url('/manage-status') }}/{{$val->id}}/reject">Reject</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            @if(!empty($myConnection))
                <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Technology</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myConnection as $key=>$val)
                        <tr>
                            <td>{{ $val->first_name.' '.$val->last_name }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->mobile }}</td>
                            <td>
                                @foreach($val->technology as $k=>$v)
                                    {{ config('app_constant.technology')[$v] }},
                                @endforeach
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script> 
$(document).ready(function() { 
    $("#search_users").on("keyup", function() { 
        var value = $(this).val().toLowerCase(); 
        $("#search_result tr").filter(function() { 
            $(this).toggle($(this).text() 
            .toLowerCase().indexOf(value) > -1) 
        }); 
    }); 
}); 
</script> 