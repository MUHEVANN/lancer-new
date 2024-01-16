<div class="card p-3 mb-3">

    <div class="col-lg-12 col-12">
        <small class="text-light fw-semibold">Data Masuk</small>
        <div class="mt-3">
            <div class="d-flex justify-content-between align-items-center ">
                <div class="d-flex gap-2">
                    <button wire:ignore.self wire:click="$dispatch('bulk-deleting')" type="button"
                        class="btn btn-danger button__delete" id="bulk-delete" disabled>Delete
                        {{ count($delete_count) === 0 ? '' : count($delete_count) }}</button>
                </div>
                <button class="btn rounded-pill btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                    <span class="tf-icons bx bx-plus"></span>&nbsp;
                </button>
            </div>

            <div class="input-group input-group-merge my-3">
                <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                <input type="text" class="form-control" wire:model.live="search" placeholder="Cari Nama Pemohon"
                    aria-label="Cari Nama Pemohon" aria-describedby="basic-addon-search31" />
            </div>


        </div>
        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form class="modal-content" wire:submit="store">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Data</h5>

                        <button type="button" wire:click="close" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="">Nama Penanggung Jawab</label>
                            <input type="text" wire:model.live="nama_penanggung_jawab" id=""
                                class="form-control text-capitalize">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="close">
                            Close
                        </button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form class="modal-content" wire:submit="update">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Edit Data</h5>

                        <button type="button" wire:click="close" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <div class="mb-3">
                            <label for="" class="">Nama Penanggung Jawab</label>
                            <input type="text" wire:model.live="nama_penanggung_jawab" id=""
                                class="form-control text-capitalize">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="close">
                            Close
                        </button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- /modal --}}
    </div>
    {{-- Datatables --}}
    {{-- Table --}}
    <div class="table-responsive text-nowrap">
        <table class="table table-hover" id="myTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="head-cb"></th>
                    <th>No</th>
                    <th>Nama Penanggung Jawab</th>
                    <th>Jumlah Yang ditanggung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @if ($responsible->isEmpty())
                    <tr>
                        <td colspan="5" class=" text-center">Tidak ada data</td>
                    </tr>
                @else
                    @foreach ($responsible as $item)
                        <tr>
                            <td><input type="checkbox" class="child-cb" wire:model.live="delete_count"
                                    value="{{ $item->id }}" id=""></td>
                            <td>{{ $loop->index + $responsible->firstItem() }}</td>
                            <td class="text-capitalize">{{ $item->nama_penanggung_jawab }}</td>
                            <td>{{ $item->purposes_count }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            wire:click="edit({{ $item->id }})"><i class="bx bx-edit-alt me-1"></i>
                                            Edit</a>
                                        <a class="dropdown-item"
                                            wire:click="$dispatch('deleting',{id : {{ $item->id }}})"
                                            href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
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
    {{-- /Table --}}
    {{-- <div class="d-flex justify-content-between mt-3 align-items-center px-3">
        <div>
            Show {{ $purposes->firstItem() }} to {{ $purposes->lastItem() }} of {{ $purposes->total() }}
        </div>
        {{ $purposes->links() }}
    </div> --}}
    {{-- /Datatables --}}

</div>
@push('script')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('success-create-responsible', function(data) {
                $('#modalCenter').modal('hide');
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    padding: "12px",
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: data.message
                });
            })
            Livewire.on('edit_responsible', (data) => {
                $('#modalEdit').modal('show');
            })
            Livewire.on('update_responsible', (data) => {
                $('#modalEdit').modal('hide');
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    padding: "12px",
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: data.message
                });
            })

            Livewire.on('deleting', (data) => {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "Are you sure?",
                    text: "Semua data yang berkaitan seperti purpose akan hilang!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('delete', data.id);
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your imaginary file is safe :)",
                            icon: "error"
                        });
                    }
                });
            })
            Livewire.on('bulk-deleting', (data) => {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('bulk_delete');
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your imaginary file is safe :)",
                            icon: "error"
                        });
                    }
                });
            })
            Livewire.on('delete-responsible', (data) => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    padding: "12px",
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: data.message
                });
            })
            Livewire.on('success-bulk-delete', (data) => {
                $('#bulk-delete').prop('disabled', true);
                $('#head-cb').prop('checked', false);
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    padding: "12px",
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: data.message
                });
            })

            Livewire.on('error', (data) => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    padding: "12px",
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: data.message
                });

            })
            Livewire.on('notFound-outgoing-data', (data) => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    padding: "12px",
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: data.message
                });
            })

            $('#head-cb').on('click', function() {
                if ($(this).prop('checked')) {
                    $('#myTable tbody .child-cb').prop('checked', true);
                    var cbCheck = $('#myTable tbody .child-cb:checked');
                    var all = [];
                    $.each(cbCheck, function(index, val) {
                        all.push(val.value);
                    })
                    Livewire.dispatch('bulk-delete-js', {
                        value: all
                    })
                    $('#bulk-delete').prop('disabled', false);
                } else {
                    Livewire.dispatch('bulk-delete-cancel')
                    $('#bulk-delete').prop('disabled', true);
                    $('#myTable tbody .child-cb').prop('checked', false);
                }
            })

            // Livewire.
        })

        $('#myTable tbody').on('click', '.child-cb', function() {
            var cbCheck = $('#myTable tbody .child-cb:checked');
            var allCb = cbCheck.length > 0;
            $('#head-db').prop('checked', allCb);
            $('#bulk-delete').prop('disabled', !allCb);
            if ($(this).prop('checked') === false) {
                $('#head-cb').prop('checked', false);
            }
        })
    </script>
@endpush
