<!-- resources/views/klasemen.blade.php -->

@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="h3 mb-2 text-gray-800">Klasemen</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Klasemen Sementara</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Posisi</th>
                                <th>Klub</th>
                                <th>Ma</th>
                                <th>Me</th>
                                <th>S</th>
                                <th>K</th>
                                <th>GM</th>
                                <th>GK</th>
                                <th>Point</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($klubs as $index => $klub)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $klub->nama_klub }}</td>
                                <td>{{ $klub->main }}</td>
                                <td>{{ $klub->menang }}</td>
                                <td>{{ $klub->seri }}</td>
                                <td>{{ $klub->kalah }}</td>
                                <td>{{ $klub->goal_menang }}</td>
                                <td>{{ $klub->goal_kalah }}</td>
                                <td>{{ $klub->point }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
