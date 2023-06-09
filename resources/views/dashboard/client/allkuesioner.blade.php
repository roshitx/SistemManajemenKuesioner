@extends('dashboard.layouts.main')
@section('content.dashboard')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h1 class="fw-bold text-uppercase mb-3">Manage Questionnaire</h1>
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    <script>
                                        Swal.fire({
                                            title: 'Success',
                                            text: '{{ session('success') }}',
                                            icon: 'success'
                                        });
                                    </script>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    <script>
                                        Swal.fire({
                                            title: 'Error',
                                            text: '{{ session('error') }}',
                                            icon: 'error'
                                        });
                                    </script>
                                @endif
                                <a class="btn btn-success mb-3" href="{{ route('kuesioner.create') }}" role="button"><i
                                        class="fa-solid fa-plus"></i>
                                    Create Questionnaire</a>
                                @unless ($kuesioners->isEmpty())
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <small>
                                            To create a question, click the <span class="badge bg-info"><i
                                                    class="fa-solid fa-eye"></i></span> button.
                                        </small>
                                    </div>
                                @endunless
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table-hover table" id="allKuesioner">
                                        <thead>
                                            <tr class="bg-dark">
                                                <th scope="col">No</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Link</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($kuesioners->isEmpty())
                                                <tr>
                                                    <td colspan="5" class="text-center">You don't have a questionnaire
                                                        yet. Create one now!</td>
                                                </tr>
                                            @else
                                                @foreach ($kuesioners as $kuesioner)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $kuesioner->title }}</td>
                                                        <td>{{ Str::limit($kuesioner->description, 50) }}</td>
                                                        <td>
                                                            {{-- Copy to Clipboard --}}
                                                            <div class="d-flex btn-group align-items-center">
                                                                <input id="link{{ $kuesioner->id }}" class="form-control"
                                                                    value="{{ url('/kuesioner/' . $kuesioner->link) }}"
                                                                    readonly>
                                                                <button class="btn bg-secondary btn-clipboard"
                                                                    data-clipboard-target="#link{{ $kuesioner->id }}"
                                                                    data-bs-toggle="tooltip"
                                                                    data-kuesioner-id="{{ $kuesioner->id }}"
                                                                    title="Copy to Clipboard">
                                                                    <i class="bi bi-clipboard" id="iconClipboard"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ route('kuesioner.show', $kuesioner->id) }}"
                                                                    class="btn btn-info text-white mb-2"
                                                                    data-bs-toggle="tooltip" title="Detail Questionnaire">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('kuesioner.edit', $kuesioner->id) }}"
                                                                    class="btn btn-warning text-white mb-2"
                                                                    data-bs-toggle="tooltip" title="Edit Questionnaire">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <button type="button" data-bs-toggle="modal"
                                                                    data-bs-target="#deleteKuesioner{{ $kuesioner->id }}"
                                                                    class="btn btn-danger mb-2">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </div>
                                                            <a href="{{ route('generate.link', $kuesioner->id) }}"
                                                                class="btn btn-sm btn-primary text-white mb-2"
                                                                data-bs-toggle="tooltip" title="Generate new link">
                                                                <i class="fa-solid fa-link"></i> Generate link
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal Delete Survey -->
                                                    <div class="modal fade" id="deleteKuesioner{{ $kuesioner->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteKuesionerModal{{ $kuesioner->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5"
                                                                        id="deleteKuesionerModal{{ $kuesioner->id }}">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                        Delete Questionnaire
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure want to delete this questionnaire?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Back</button>
                                                                    <form
                                                                        action="{{ route('kuesioner.destroy', ['kuesioner' => $kuesioner->id]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-success">Sure</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        // Datatable
        $.fn.dataTable.ext.errMode = 'none';
        $(document).ready(function() {
            $('#allKuesioner').DataTable();
        });
        // Clipboard JS
        new ClipboardJS('.btn');
        // Change Icon Clipboard
        $(document).ready(function() {
            $('.btn-clipboard').on('click', function() {
                var button = $(this);
                var kuesionerId = button.data('kuesioner-id');

                // Ganti ikon menjadi check
                button.find('.bi.bi-clipboard').removeClass('bi bi-clipboard');
                button.find('i').addClass('bi bi-check2');

                // Setelah beberapa detik, kembalikan ikon ke clipboard
                setTimeout(function() {
                    button.find('.bi.bi-check2').removeClass('bi bi-check2');
                    button.find('i').addClass('bi bi-clipboard');
                }, 800); // Waktu dalam milidetik (misalnya 3000 untuk 3 detik)
            });
        });
    </script>
@endsection
