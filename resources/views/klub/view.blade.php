@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-2 text-gray-800">Klub</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Klub</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Klub</th>
                                <th>Kota Klub</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($klubs as $klub)
                            <tr>
                                <td>{{ $klub->nama_klub }}</td>
                                <td>{{ $klub->kota_klub }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 pt-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
            </div>
            <div class="card-body">
                <!-- Tampilkan pesan error jika ada -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
    
                <!-- Tampilkan pesan success jika ada -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
    
                <!-- Tampilkan pesan error jika ada -->
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
    
                <form action="{{ url('/add-klub') }}" method="POST">
                    @csrf <!-- Add CSRF token -->
                    <div class="form-group">
                        <label for="nama_klub">Nama Klub</label>
                        <input type="text" name="nama_klub" class="form-control" id="nama_klub" placeholder="Nama Klub" oninput="checkKlubName()" required>
                        <small id="nama_klub_warning" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="kota_klub">Kota Klub</label>
                        <input type="text" name="kota_klub" class="form-control" id="kota_klub" placeholder="Kota Klub" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript">
	function checkKlubName() {
        const namaKlub = document.getElementById('nama_klub').value;
        
        if (namaKlub.trim() === '') {
            document.getElementById('nama_klub_warning').textContent = '';
            return;
        }

        fetch(`/check-klub/${encodeURIComponent(namaKlub)}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    document.getElementById('nama_klub_warning').textContent = '';
                } else {
                    document.getElementById('nama_klub_warning').textContent = '';
                }
            });
    }
</script>
