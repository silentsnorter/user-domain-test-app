@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card h-100 mb-4">
        <div class="card-body">
            <h5 class="card-title">Your Current Plan</h5>
            @if(auth()->user()->plan)
                <p class="mb-0">
                    <strong>{{ auth()->user()->plan->plan_name }}</strong>
                    — ${{ auth()->user()->plan->price }}
                </p>
            @else
                <p class="mb-0 text-muted">You don’t have a plan selected yet.</p>
            @endif
        </div>
    </div>

    <h1 class="mb-4">Choose Your Plan</h1>

    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-md-4 mb-4">
                <div class="card h-100 card-hover">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $plan->plan_name }}</h5>
                        <h6 class="card-subtitle mb-3 text-muted">${{ $plan->price }}</h6>

                        <ul class="mb-4">
                            @foreach ($plan->features as $key => $value)
                                <li>
                                    @if (is_string($key))
                                        <strong>{{ $key }}:</strong> {{ $value }}
                                    @else
                                        {{ $value }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <form action="{{ route('plans.buy', $plan) }}" method="POST" class="mt-auto">
                            @csrf
                            <button class="btn btn-primary w-100">Buy</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
    <style>
        .card-hover {
            transition: transform 0.2s ease;
            will-change: transform;
        }

        .card-hover:hover {
            transform: scale(1.03);
            z-index: 2;
        }
    </style>
@endpush
