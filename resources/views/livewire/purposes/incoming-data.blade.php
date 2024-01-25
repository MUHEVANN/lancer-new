<div class="card p-3 mb-3">

    <div class="col-lg-12 col-12">
        <small class="text-light fw-semibold">Data Masuk</small>
        <div class="mt-3">
            <div class="d-flex justify-content-between align-items-center ">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <i class='bx bx-filter-alt'></i>
                    </button>
                    <select wire:model.live="page" class="form-control" id="">
                        <option value="5">Page</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                    <button wire:ignore.self wire:click="$dispatch('bulk-deleting')" type="button"
                        class="btn btn-danger button__delete" id="bulk-delete" disabled>Delete
                        {{ count($delete_count) === 0 ? '' : count($delete_count) }}</button>
                </div>

                <button class="btn rounded-pill btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                    <span class="tf-icons bx bx-plus"></span>&nbsp;
                </button>
            </div>

            <div class="collapse  my-3" id="collapseExample" wire:ignore>
                <div class=" gap-2 d-flex flex-column flex-md-row  ">
                    <div class="col-lg-3">
                        <select wire:model.live="filterMonth" id="" class="form-control">
                            <option value="">Pilih Bulan</option>
                            @for ($i = 0; $i < count($month); $i++)
                                <option value="{{ $i }}">{{ $month[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select wire:model.live="filterYear" id="" class="form-control">
                            <option value="">Pilih Tahun</option>
                            @for ($i = 0; $i < count($year); $i++)
                                <option value="{{ $year[$i] }}">{{ $year[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select wire:model.live="filterResponsible" id="" class="form-control">
                            <option value="">Pilih Responsible</option>
                            @foreach ($penanggung_jawab as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_penanggung_jawab }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <button wire:click="resetFilter" class="btn btn-outline-primary ">Reset</button>
                    </div>
                </div>
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
                            <label for="" class="">Tanggal Masuk</label>
                            <input type="date" wire:model.live="tanggal" id="tanggal" class="form-control">
                            @error('tanggal')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Jenis Pekerjaan</label>
                            <select wire:model.live="jenis_pekerjaan" id="jenis_pekerjaan" class="form-control">
                                <option value="">Pilih salah satu</option>
                                <option value="PPAT">PPAT</option>
                                <option value="NOTARIS">NOTARIS</option>
                            </select>
                            <div id="error-jenis_pekerjaan" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Nama Pemohon</label>
                            <input type="text" wire:model.live="nama_pemohon" id="nama_pemohon"
                                class="form-control text-capitalize">
                        </div>
                        <div class="mb-3">
                            <label for="" class="">No. Akta</label>
                            <input type="text" wire:model.live="no_akta" id="no_akta" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Proses Permohonan</label>
                            <input type="text" wire:model.live="proses_permohonan" id="proses_permohonan"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Nama Bank</label>
                            <input type="text" wire:model.live="bank_name" id="bank_name" class="form-control">
                        </div>
                        <div class="mb-3" x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                            x-on:livewire-upload-finish="uploading = false"
                            x-on:livewire-upload-error="uploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress" wire:ignore.self>

                            <label for="" class="">Document</label>
                            <input type="file" wire:model.live="document" id="document" class="form-control"
                                multiple>
                            <div x-show="uploading" class="progres">
                                <progress max="100" x-bind:value="progress"></progress>
                            </div>
                            <div id="error-document" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Nama Penanggung Jawab</label>
                            <select wire:model.live="penanggung_jawab_id" class="form-control text-capitalize">
                                <option value="">Pilih Salah Satu</option>
                                @foreach ($penanggung_jawab as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama_penanggung_jawab }}</option>
                                @endforeach
                            </select>
                            @error('penanggung_jawab_id')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Keterangan</label>
                            <textarea wire:model.live="keterangan" id="keterangan" cols="30" rows="10" class="form-control"></textarea>
                            <div id="error-keterangan" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="close">
                            Close
                        </button>
                        <div>
                            <button class="btn btn-primary" id="button_import" wire:target="document"
                                wire:loading.class="d-none">
                                Save
                            </button>
                            <button wire:loading wire:target="document" class="btn btn-primary " disabled>
                                <div class="spinner-border text-light spin" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </button>
                        </div>
                        {{-- <button class="btn btn-primary">Save</button> --}}
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
                            <label for="" class="">Tanggal Masuk</label>
                            <input type="date" wire:model.live="tanggal" id="tanggal" class="form-control">
                            @error('tanggal')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Jenis Pekerjaan</label>
                            <select wire:model.live="jenis_pekerjaan" id="jenis_pekerjaan" class="form-control">
                                <option value="">Pilih salah satu</option>
                                <option value="PPAT">PPAT</option>
                                <option value="NOTARIS">NOTARIS</option>
                            </select>
                            <div id="error-jenis_pekerjaan" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Nama Pemohon</label>
                            <input type="text" wire:model.live="nama_pemohon" id="nama_pemohon"
                                class="form-control text-capitalize">
                        </div>
                        <div class="mb-3">
                            <label for="" class="">No. Akta</label>
                            <input type="text" wire:model.live="no_akta" id="no_akta" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Proses Permohonan</label>
                            <input type="text" wire:model.live="proses_permohonan" id="proses_permohonan"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Nama Bank</label>
                            <input type="text" wire:model.live="bank_name" id="bank_name" class="form-control">
                        </div>
                        <div class="mb-3" x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                            x-on:livewire-upload-finish="uploading = false"
                            x-on:livewire-upload-error="uploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress" wire:ignore.self>

                            <label for="" class="">Document</label>
                            <input type="file" wire:model.live="document" id="document" class="form-control"
                                multiple>
                            <div x-show="uploading">
                                <progress max="100" x-bind:value="progress"></progress>
                            </div>
                            <div id="error-document" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Nama Penanggung Jawab</label>
                            <select wire:model.live="penanggung_jawab_id" class="form-control text-capitalize">
                                <option value="">Pilih Salah Satu</option>
                                @foreach ($penanggung_jawab as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama_penanggung_jawab }}</option>
                                @endforeach
                            </select>
                            @error('penanggung_jawab_id')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="">Keterangan</label>
                            <textarea wire:model.live="keterangan" id="keterangan" cols="30" rows="10" class="form-control"></textarea>
                            <div id="error-keterangan" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="close">
                            Close
                        </button>
                        <div>
                            <button class="btn btn-primary" id="button_import" wire:target="document"
                                wire:loading.class="d-none">
                                Save
                            </button>
                            <button wire:loading wire:target="document" class="btn btn-primary " disabled>
                                <div class="spinner-border text-light spin" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </button>
                        </div>
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
                    <th>Tanggal</th>
                    <th>Pihak</th>
                    <th>Jenis Pekerjaan</th>
                    <th>No Akta</th>
                    <th>Proses Permohonan </th>
                    <th>Nama Bank</th>
                    <th>Keterangan</th>
                    <th>Document</th>
                    <th>Penanggung Jawab</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @if ($purposes->isEmpty())
                    <tr>
                        <td colspan="13" class=" text-center">Tidak ada data</td>
                    </tr>
                @else
                    @foreach ($purposes as $item)
                        <tr>
                            <td><input type="checkbox" class="child-cb" value="{{ $item->id }}"
                                    wire:key="{{ $item->id }}" wire:model.live="delete_count"></td>
                            <td>{{ $loop->index + $purposes->firstItem() }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</td>
                            <td class="{{ $item->name_pemohon === '' ? 'kosong' : '' }}">
                                {{ $item->nama_pemohon ? $item->nama_pemohon : '-' }}</td>
                            <td>{{ $item->jenis_pekerjaan }}</td>
                            <td class="{{ $item->no_akta === null ? 'kosong' : '' }}">
                                {{ $item->no_akta ? $item->no_akta : '-' }}</td>
                            <td class="{{ $item->proses_permohonan === null ? 'kosong' : '' }}">
                                {{ $item->proses_permohonan ? $item->proses_permohonan : '-' }}</td>
                            <td class="{{ $item->bank_name === null ? 'kosong' : '' }}">
                                {{ $item->bank_name ? $item->bank_name : '-' }}</td>
                            <td class="{{ $item->keterangan === null ? 'kosong' : '' }}">
                                {{ $item->keterangan ? $item->keterangan : '-' }}</td>
                            @if (count($item->document) > 0)
                                <td>
                                    <ul>
                                        @foreach ($item->document as $doc)
                                            <li class="document__list">
                                                <a href="{{ asset('storage/document/' . $doc->document) }}"
                                                    target="_blank">{{ $doc->document }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            @else
                                <td class="kosong">-</td>
                            @endif
                            <td>{{ $item->responsible->nama_penanggung_jawab }}</td>

                            @if ($item->proses_sertifikat === 'masuk')
                                <td><span class="badge bg-label-success">{{ $item->proses_sertifikat }}</span></td>
                            @else
                                <td><span class="badge bg-label-danger">{{ $item->proses_sertifikat }}</span></td>
                            @endif
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            wire:click="outgoing_data({{ $item->id }})"><i
                                                class='bx bx-log-out-circle me-1'></i>
                                            Keluar</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            wire:click="edit({{ $item->id }})"><i
                                                class="bx bx-edit-alt me-1"></i>
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
    <div class="d-flex justify-content-between mt-3 align-items-center px-3">
        <div>
            Show {{ $purposes->firstItem() }} to {{ $purposes->lastItem() }} of {{ $purposes->total() }}
        </div>
        {{ $purposes->links() }}
    </div>
    {{-- /Datatables --}}

</div>
@push('script')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('created-data', function(data) {
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
            Livewire.on('edit-data-mode', (data) => {
                $('#modalEdit').modal('show');
            })
            Livewire.on('updated-data', (data) => {
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
                    text: "You won't be able to revert this!",
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
            Livewire.on('deleted-data', (data) => {
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
            Livewire.on('success-outgoing-data', (data) => {
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
            Livewire.on('error-outgoing-data', (data) => {
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
