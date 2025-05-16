@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>All Users</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Domain</th><th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->domains->pluck('domain')->join(', ') }}</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
@endsection
