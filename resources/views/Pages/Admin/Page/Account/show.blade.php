@extends('Pages.Admin.Layout.index')
@section('content')
    <div class="card">
        <form action="" class="d-inline p-3">
        <div class="px-3 d-flex row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Email" class="form-control" value="{{ $user->email }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" placeholder="Username" class="form-control" value="{{ $user->username }}">
                </div>
            </div>
            <div class="col-lg-12 d-flex justify-content-center py-3">
                <button class="btn btn-primary w-50" type="submit" onclick="changeToEdit(event)" id="submitButton">Edit</button>
            </div>
        </div>
    </form>
    </div>
    </div>

    @include('Components.changeToEdit')
@endsection
