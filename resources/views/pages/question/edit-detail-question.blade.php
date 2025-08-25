@extends('layouts.app')
@section('content')
    <div class="main-content container-fluid" style="margin-top: -30px !important">
        <section class="section">
            <a href="{{ route('question.index') }}" class="btn icon icon-left btn-primary"><i
                    data-feather="arrow-left"></i>
                Kembali</a>
            <div class="ml-4 mr-4 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Update Detail Ujian</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="form_question" class="form form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label><b>Soal</b></label>
                                            <textarea type="text" class="form-control" id="soal" name="question">{{ $question->question }}</textarea>
                                            <span class="text-danger" id="question-error"></span><br>

                                            <label><b>Gambar</b></label>
                                            <div class="form-group has-icon-left mt-2">
                                                <div class="position-relative">
                                                    <input type="file" name="image" class="form-control" id="image">
                                                    <div class="form-control-icon">
                                                        <i data-feather="upload"></i>
                                                    </div>
                                                </div>
                                                <span class="text-danger" id="image-error"></span><br>
                                            </div>

                                            {{-- Pilihan Ganda --}}
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div class="choice-weight-container" style="display:{{ $display }}">
                                                    <div style="flex: 1;">
                                                        <label><b>Pilihan {{ $i }}</b></label>
                                                        <textarea type="text" class="form-control mt-2 pilihan" name="choice_{{ $i }}">{{ $question->{'choice_' . $i} }}</textarea>
                                                        <span class="text-danger" id="choice_{{ $i }}-error"></span>
                                                    </div>
                                                    <div>
                                                        <label><b>Bobot Pilihan {{ $i }}</b></label>
                                                        <input type="number" step="0.01" class="form-control mt-2 weight-input" name="weight_{{ $i }}" value="{{ $question->{'weight_' . $i} }}">
                                                        <span class="text-danger" id="weight_{{ $i }}-error"></span>
                                                    </div>
                                                </div>
                                            @endfor

                                            <span class="text-danger" id="key-error"></span><br>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1"><i
                                                    data-feather="save"></i>Submit</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script type="application/javascript">
        $(document).ready(function() {
            $('#soal').ckeditor();

            $('#form_question').on('submit', function(e) {
                e.preventDefault();
                formData = new FormData(this);
                formData.set('question', $('#soal').val());

                $('#question-error').text('');
                $('#image-error').text('');
                for (let i = 1; i <= 5; i++) {
                    $(`#choice_${i}-error`).text('');
                    $(`#weight_${i}-error`).text('');
                }
                $('#key-error').text('');

                var url = "{{ route('update-detail-question', $question->id) }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success == true) {
                            window.location.href =
                                "{{ route('list-detail-question', $question->question_id) }}";
                            sessionStorage.setItem('success', response.message);
                        }
                    },
                    error: function(response) {
                        $('#question-error').text(response.responseJSON.errors.question);
                        $('#image-error').text(response.responseJSON.errors.image);
                        for (let i = 1; i <= 5; i++) {
                            $(`#choice_${i}-error`).text(response.responseJSON.errors[`choice_${i}`]);
                            $(`#weight_${i}-error`).text(response.responseJSON.errors[`weight_${i}`]);
                        }
                        $('#key-error').text(response.responseJSON.errors.key);
                        $.notify('<strong>Warning</strong> Isian tidak valid !', {
                            allow_dismiss: false,
                            type: 'danger'
                        });
                    }
                });
            });
        });
    </script>
@endsection