@extends('layouts.admin.master')
@section('title', 'Manage Users')
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header d-flex ">
                        <h3 class="box-title">List Users</h3>
                        <form class="form-inline col-xs-7 text-center" method="GET" action="{{ route('users.search') }}" id="formSearchUser">
                            <input class="form-control" type="text" placeholder="Search" name="user_name" value="{{ request('user_name') }}">
                            <button class="fa fa-search btn-primary btn" role="button" title="search" id="searchUser"></button>
                        </form>
                        <div class="col-xs-4 text-right">
                            <a href="{{ route('users.create') }}" class="btn btn-info" role="button">Create</a>
                        </div>
                    </div>
                    <div class="box-body">
                        @if (Session::has('message'))
                        <h3 class="text-danger alert-success">{{ Session::get('message') }}</h3>
                        @endif
                        <table id="example2" class="table table-bordered table-hover users-table">
                            <thead>
                            <tr>
                                <th class="fix-witdh-name">Name</th>
                                <th class="fix-witdh-mail">Email</th>
                                <th class="fix-witdh-birth-day">Birth day</th>
                                <th class="fix-witdh-addess">Address</th>
                                <th class="fix-witdh-phone">Phone</th>
                                <th class="fix-witdh-choice">Choice</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ date('d-m-Y', strtotime($user->birth_day)) }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->phone }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('users.show', $user->id) }}" class="fa fa-search btn btn-info" role="button" title="Show"></a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="fa fa-edit btn-warning btn" role="button" title="Edit"></a>
                                    <form  method="POST" action="{{ route('users.destroy', [$user->id]) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" class="fa fa-remove btn-danger btn btn-delete" title="Delete" data-name="{{ $user->name }}"></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Birth day</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Choice</th>
                            </tr>
                            </tfoot>
                        </table>
                        <div class="col-12 text-center">
                            {{ $users->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection