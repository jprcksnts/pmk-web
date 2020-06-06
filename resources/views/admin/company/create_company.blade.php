@extends('layouts.master')

@section('body')
    @include('nav.nav')

    <div class="container">
        <form method="post" action="/companies/create">
            {{ csrf_field() }}

            <div class="col-sm-12 col-lg-6 mx-auto my-6">

                @include('response_notifiers.response_card')

                <div class="card">
                    <div class="card-header">
                        <h1>
                            <i class="fas fa-building" style="margin-right: 8px;"></i>
                            Create Company
                        </h1>
                    </div>

                    <div class="card-body">
                        <h3>Company Details</h3>
                        <div class="form-group">
                            <label for="name">Company Name</label>
                            <input id="name" name="name" type="text" class="form-control" maxlength="128"
                                   placeholder="Enter company name" required>
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact Number</label>
                            <input id="contact" name="contact" type="text" class="form-control"
                                   maxlength="16"
                                   placeholder="Enter contact number (landline/mobile)" required>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary form-control">
                            Create Company
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection
