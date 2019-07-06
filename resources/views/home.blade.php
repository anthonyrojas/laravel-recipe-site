@extends('layouts.app')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                        <div class="row">
                            <button class="btn" onclick="getUser()">Get User</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
<script>
    function getUser(){
        axios.get('/api/user').then(res => {
            console.log(res);
        }).catch(err=>{
            console.log(err);
        });
    }
</script>
@endsection