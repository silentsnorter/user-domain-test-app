@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1 class="mb-4">Your Domains</h1>

        {{-- Add new domain --}}
        <form method="POST" action="{{ route('domains.store') }}" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="domain" class="form-control" placeholder="Enter domain (e.g., google.com)" required>
                <button class="btn btn-primary" type="submit">Add Domain</button>
            </div>
        </form>

        <div>
        {{-- List of domains --}}
        @if ($domains->isEmpty())
            <p>No domains added yet.</p>
        @else
            <ul class="list-group">
                @foreach ($domains as $domain)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $domain->domain }}
                        <form method="POST" action="{{ route('domains.delete', $domain) }}" onsubmit="return confirm('Delete this domain?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
        </div>
    </div>
</div>
@endsection
