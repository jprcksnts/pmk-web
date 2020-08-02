@extends('layouts.master')

@section('body')
    @include('nav.employer.nav')

    <div class="bg-gradient-default">
        <div class="container-fluid">
            <div class="row pt-3 pb-4">
                <div class="col-sm-12 px-0">
                    <div class="mx-4">
                        <h1 class="mb-0 text-white mr-2">Create Job Post</h1>

                        <ol class="breadcrumb breadcrumb-custom px-0">
                            <li class="breadcrumb-item"><a href="/employer/job_posts">Job Posts</a></li>
                            <li class="breadcrumb-item"><a href="#">Create Job Post</a></li>
                        </ol>

                        <a href="/employer/job_posts" class="btn btn-primary mx-0 mt-4">
                            Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12 col-md-8 col-lg-6 mx-2 my-5">

                @include('response_notifiers.response_card')

                <form method="post" action="/job_posts/create">
                    {{ csrf_field() }}

                    <div class="card">
                        <div class="card-header">
                            <h1 class="mb-0">Create Job Post</h1>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="Position">Position</label>
                                        <input id="position" name="position" type="text" class="form-control"
                                               maxlength="128"
                                               placeholder="Enter position" required/>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="max_applicants">
                                            Max Applicants (minimum of 1)
                                        </label>
                                        <input id="max_applicants" name="max_applicants" type="number"
                                               class="form-control"
                                               min="1" minlength="1" maxlength="3"
                                               placeholder="Enter max applicants (e.g. 1)"
                                               required/>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="form-group mb-0">
                                        <label for="description">Description</label>
                                        <textarea id="description" name="description" class="form-control"
                                                  minlength="128"
                                                  maxlength="8096" placeholder="Enter description" rows="6"
                                                  required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                Create Job Post
                            </button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
@endsection
