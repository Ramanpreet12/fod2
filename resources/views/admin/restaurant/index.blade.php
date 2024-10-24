@extends('admin.layout.layout')
@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Hoverable Table rows -->
        <div class="card">
            {{-- <div class="card-header d-flex justify-content-between">
                <h5>Restaurants</h5>
                <a class="card-title end" href="{{ route('admin.restaurants.create') }}">
                    <button class="btn btn-primary"> Add Restaurant</button>
                </a>
                </div> --}}
            @include('alert_messages')
            @if (session('email') && session('password'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Restaurant Owner Credentials</h4>
                <p>Please share these credentials with the restaurant owner:</p>
                <p><strong>Email:</strong> {{ session('email') }}</p>
                <p><strong>Password:</strong> {{ session('password') }}</p>
                <p class="mb-0">Note: This password will only be shown once.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Restaurants</h3>
                {{-- <small class="text-body float-end">Default label</small> --}}
                <a class="text-body float-end" href="{{ route('admin.restaurants.create') }}">
                    <button class="btn btn-primary"> Add Restaurant</button>
                </a>
            </div>

            <div class="table-responsive text-wrap">
                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th>S.No. </th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Speciality</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Owner Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if ($restaurants->isNotEmpty())
                            @foreach ($restaurants as $restaurant)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td> <img
                                            src="{{ asset('storage/restaurants/featured/' . $restaurant->featured_image) }}"
                                            alt="" srcset="" width="75px" height="60px"></td>
                                    <td>{{ $restaurant->name }}</td>
                                    <td>{{ Str::limit($restaurant->speciality, 40, '...') }}</td>
                                    <td>{{ $restaurant->address }},{{ Str::ucfirst($restaurant->city) }},
                                        {{ Str::ucfirst($restaurant->state) }}, {{ $restaurant->country }},
                                        {{ $restaurant->postal_code }}
                                    </td>
                                    <td>{{ $restaurant->email }}</td>
                                    <td>{{ Str::ucfirst($restaurant->owner_name) }}</td>
                                    @if ($restaurant->status == 'active')
                                        <td><span
                                                class="badge bg-label-primary me-1">{{ Str::ucfirst($restaurant->status) }}</span>
                                        </td>
                                    @else
                                        <td><span
                                                class="badge bg-label-danger me-1">{{ Str::ucfirst($restaurant->status) }}</span>
                                        </td>
                                    @endif


                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.restaurants.edit', $restaurant->id) }}"><i
                                                        class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-trash me-1"></i>
                                                    Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif


                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Hoverable Table rows -->
    </div>
    <!-- / Content -->
@endsection
