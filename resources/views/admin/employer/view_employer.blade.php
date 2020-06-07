@extends('layouts.master')

@section('body')
    @include('nav.nav')

    <div class="container">
        <form method="post" action="/employer/update" enctype="multipart/form-data">
            {{ csrf_field() }}

            <input id="employer_id" name="employer_id" type="hidden" value="{{ $employer->id }}">

            <div class="col-sm-12 col-md-8 col-lg-6 mx-auto my-6">

                @include('response_notifiers.response_card')

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                <a href="/admin/management/employers"
                                   class="btn btn-secondary icon icon-shape rounded-circle">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>

                            <div class="col-auto my-auto">
                                <h1 class="mb-auto">
                                    <i class="fas fa-user-tie" style="margin-right: 8px;"></i>
                                    Employer Details
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h3>User Credentials</h3>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="text" class="form-control" maxlength="255"
                                   placeholder="Enter email" value="{{ $employer->user->email }}" disabled>
                        </div>

                        <h3>User Details</h3>
                        <div class="row">
                            <div class="col-sm-12 col-md">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input id="first_name" name="first_name" type="text" class="form-control"
                                           maxlength="64" placeholder="Enter first name"
                                           value="{{ $employer->user->userDetail->first_name }}" disabled>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input id="last_name" name="last_name" type="text" class="form-control"
                                           maxlength="32" placeholder="Enter last name"
                                           value="{{ $employer->user->userDetail->last_name }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sex">Sex</label>
                            <select id="sex" name="sex" class="form-control" disabled>
                                <option @if($employer->user->userDetail->sex == 'Male') selected @endif>Male</option>
                                <option @if($employer->user->userDetail->sex == 'Female') selected @endif>Female
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="company_id">Company</label>
                            <select id="company_id" name="company_id" class="form-control" disabled>
                                <option
                                    value="{{ $employer->company->id }}">{{ ucfirst($employer->company->name) }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="/admin/management/employer/{{ $employer->id }}/update"
                           class="btn bg-orange text-white">
                            Update Employer
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
