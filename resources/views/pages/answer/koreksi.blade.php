@extends('layouts.app')
@section('style')
    <style type="text/css">
        .scroll {
            max-height: 850px;
            overflow-y: auto;
        }

        #style-5::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F5F5F5;
        }

        #style-5::-webkit-scrollbar {
            width: 10px;
            background-color: #F5F5F5;
        }

        #style-5::-webkit-scrollbar-thumb {
            background-color: #0ae;
            background-image: -webkit-gradient(linear, 0 0, 0 100%,
                    color-stop(.5, rgba(255, 255, 255, .2)),
                    color-stop(.5, transparent), to(transparent));
        }
    </style>
@endsection
@section('content')
    <div class="main-content container-fluid" style="margin-top: -30px !important">
        <section class="section">
            <div class="row">
                <div class="col-8">
                    <div class="card mt-2">
                        <div class="card-header">
                            <h4><b>Koreksi Test</b></h4>
                            <hr>
                        </div>
                        <div class="card-body scroll" id="style-5">
                            @foreach ($soal as $item)
                                <div class="card-body">
                                    <b>Soal {{ $loop->iteration }}</b>
                                    <h5>
                                        <p>{!! $item->question !!}</p>
                                    </h5>
                                    @if ($item->image)
                                        <img src="{{ Storage::url('public/images/' . $item->question_id . '/' . $item->image) }}"
                                            class="rounded" style="width: 70px; height: 70px;">
                                    @endif
                                    
                                    {{-- Tentukan jenis soal --}}
                                    @php
                                        $isMultipleChoice = !is_null($item->choice_1) || 
                                                          !is_null($item->choice_2) || 
                                                          !is_null($item->choice_3) || 
                                                          !is_null($item->choice_4) || 
                                                          !is_null($item->choice_5);
                                    @endphp

                                    @if ($isMultipleChoice)
                                        {{-- Tampilkan pilihan ganda --}}
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="radio"
                                                value="a" {{ $item->answer == 'a' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="Primary">
                                                A. {{ $item->choice_1 }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="radio" value="b"
                                                {{ $item->answer == 'b' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="Primary">
                                                B. {{ $item->choice_2 }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="radio" value="c"
                                                {{ $item->answer == 'c' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="Primary">
                                                C. {{ $item->choice_3 }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="radio" value="d"
                                                {{ $item->answer == 'd' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="Primary">
                                                D. {{ $item->choice_4 }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="radio" value="e"
                                                {{ $item->answer == 'e' ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="Primary">
                                                E. {{ $item->choice_5 }}
                                            </label>
                                        </div>
                                        <p>
                                            {{-- <b>Jawaban: {{ strtoupper($item->answer ?? 'Tidak dijawab') }}</b> --}}
                                            (Bobot: 
                                            @switch($item->answer)
                                                @case('a')
                                                    {{ $item->weight_1 }}
                                                    @break
                                                @case('b')
                                                    {{ $item->weight_2 }}
                                                    @break
                                                @case('c')
                                                    {{ $item->weight_3 }}
                                                    @break
                                                @case('d')
                                                    {{ $item->weight_4 }}
                                                    @break
                                                @case('e')
                                                    {{ $item->weight_5 }}
                                                    @break
                                                @default
                                                    0
                                            @endswitch
                                            )
                                        </p>
                                    @else
                                        {{-- Tampilkan esai --}}
                                        <div class="form-group with-title mb-3">
                                            <label>Jawaban Siswa</label>
                                            <textarea class="form-control" rows="3" disabled>{{ $item->answer ?? 'Tidak dijawab' }}</textarea>
                                        </div>
                                        <p>
                                            <b>Bobot: 
                                                @if($item->status == 'correct')
                                                    {{ $item->weight_1 }} {{-- Adjust according to your weight field for essay --}}
                                                @else
                                                    0
                                                @endif
                                            </b>
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h4><b>Detail Ujian</b></h4>
                            <hr>
                            <div class="row">
                                <div class="col-4">1
                                    <p>Nama</p>
                                </div>
                                <div class="col-8">: <b>{{ $participant->fullname }}</b></div>
                                <div class="col-4">
                                    <p>Kelas</p>
                                </div>
                                <div class="col-8">: <b>{{ $participant->kelas->name }}</b></div>
                                <div class="col-4">
                                    <p>Jurusan</p>
                                </div>
                                <div class="col-8">: <b>{{ $participant->major->major }}</b></div>
                                <div class="col-4">
                                    <p>Jumlah soal</p>
                                </div>
                                <div class="col-8">: {{ $banyak_soal }}</div>
                                <div class="col-4">
                                    <p>Total Score</p>
                                </div>
                                <div class="col-8">: {{ number_format($total_bobot, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection