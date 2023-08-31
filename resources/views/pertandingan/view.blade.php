@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-2 text-gray-800">Input Skor Pertandingan</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Input Satu per satu</h6>
            </div>
            <div class="card-body">
                <form id="saveScoreForm" action="{{ route('save-score') }}" method="POST">
                    @csrf <!-- Add CSRF token -->
                    <div class="form-group">
                        <label for="klub1">Klub 1</label>
                        <select name="klub1" class="form-control klub-select" required>
                            <option value="">Pilih Klub</option>
                            @foreach ($klubs as $klub)
                                <option value="{{ $klub->id_klub }}">{{ $klub->nama_klub }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="klub2">Klub 2</label>
                        <select name="klub2" class="form-control klub-select klub2-select" required>
                            <option value="">Pilih Klub</option>
                            @foreach ($klubs as $klub)
                                <option value="{{ $klub->id_klub }}">{{ $klub->nama_klub }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="score1">Score Klub 1</label>
                        <input type="number" name="score1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="score2">Score Klub 2</label>
                        <input type="number" name="score2" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Input Multiple</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('save-multiple-scores') }}" method="POST">
                    @csrf 
                    <div class="form-group">
                        <label for="scores">Input Skor Pertandingan (klub1 - klub2, score1 - score2)</label>
                        <div id="scoresContainer">
                            <div class="score-row">
                                <div class="form-group">
                                    <label for="klub1">Klub 1</label>
                                    <select name="klub1" class="form-control klub-select" required>
                                        <option value="">Pilih Klub</option>
                                        @foreach ($klubs as $klub)
                                            <option value="{{ $klub->id_klub }}">{{ $klub->nama_klub }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="klub2">Klub 2</label>
                                    <select name="klub2" class="form-control klub-select klub2-select" required>
                                        <option value="">Pilih Klub</option>
                                        @foreach ($klubs as $klub)
                                            <option value="{{ $klub->id_klub }}">{{ $klub->nama_klub }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="number" name="score1[]" class="form-control" placeholder="Score 1" required>
                                <input type="number" name="score2[]" class="form-control" placeholder="Score 2" required>
                                <button type="button" class="btn btn-danger remove-score-row">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary add-score-row">Add</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.klub-select[name="klub1"]').change(function() {
            var selectedKlub1 = $(this).val();
            var klub2Select = $('.klub2-select');
            
            klub2Select.find('option').show();
            klub2Select.find(`option[value="${selectedKlub1}"]`).hide();
            klub2Select.val('').trigger('change');
        });

        $('.klub2-select').change(function() {
            var selectedKlub2 = $(this).val();
            var klub1Select = $('.klub-select[name="klub1"]');
            
            klub1Select.find('option').show();
            klub1Select.find(`option[value="${selectedKlub2}"]`).hide();
        });

        $(document).on('click', '.add-score-row', function() {
            const newScoreRow = `
                <div class="score-row">
                    <select name="klub1[]" class="form-control klub-select klub1" required>
                        <option value="">Pilih Klub</option>
                        @foreach ($klubs as $klub)
                            <option value="{{ $klub->id_klub }}">{{ $klub->nama_klub }}</option>
                        @endforeach
                    </select>
                    <select name="klub2[]" class="form-control klub-select klub2" required>
                        <option value="">Pilih Klub</option>
                    </select>
                    <input type="number" name="score1[]" class="form-control" placeholder="Score 1" required>
                    <input type="number" name="score2[]" class="form-control" placeholder="Score 2" required>
                    <button type="button" class="btn btn-danger remove-score-row">Remove</button>
                </div>
            `;
            $('#scoresContainer').append(newScoreRow);
        });

        // Menghapus baris skor
        $(document).on('click', '.remove-score-row', function() {
            $(this).closest('.score-row').remove();
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const saveScoreForm = document.getElementById("saveScoreForm");

        saveScoreForm.addEventListener("submit", async function (event) {
            event.preventDefault();

            const klub1Value = document.querySelector("select[name='klub1']").value;
            const klub2Value = document.querySelector("select[name='klub2']").value;

            if (klub1Value === klub2Value) {
                alert("Klub 1 dan Klub 2 tidak boleh sama. Harap pilih klub yang berbeda.");
                return;
            }

            const response = await fetch(`/check-match/${klub1Value}/${klub2Value}`);
            const data = await response.json();

            if (data.exists) {
                alert("Pertandingan antara Klub 1 dan Klub 2 sudah pernah dimainkan sebelumnya.");
            } else {
                try {
                    saveScoreForm.submit(); // Submit the form
                } catch (error) {
                    alert("Terjadi kesalahan saat menyimpan skor pertandingan.");
                }
            }
        });
    });


</script>
@endsection

