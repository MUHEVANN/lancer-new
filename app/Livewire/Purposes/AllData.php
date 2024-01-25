<?php

namespace App\Livewire\Purposes;

use App\Exports\PurposeExport;
use App\Imports\PurposeImport;
use App\Models\Document;
use App\Models\PenanggungJawab;
use App\Models\Purposes;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class AllData extends Component
{
    use WithFileUploads;
    use WithPagination;
    // field
    public $penanggung_jawab_id;
    public $nama_pemohon;
    public $proses_permohonan;
    public $no_akta;
    public $bank_name;
    public $jenis_pekerjaan;
    public $proses_sertifikat;
    public $keterangan;
    public $tanggal;
    public $document = [];
    // Filter
    public $filterMonth;
    public $filterYear;
    public $filterResponsible;
    // initiasi
    public $month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    public $year = [];
    public $penanggung_jawab;
    public $purposes_id = 0;
    public $iteration = 0;
    public $page;
    public $search;
    public $delete_count = [];
    public $exel = "";




    public function mount()
    {
        $this->filterYear = (int)date('Y');
        $this->filterMonth = (int)date('m');
        $this->page = 5;
        $this->penanggung_jawab = PenanggungJawab::all();
        $year = Purposes::selectRaw('YEAR(tanggal) as year')->get();
        foreach ($year as $item) {
            if (!in_array($item->year, $this->year)) {
                array_push($this->year, $item->year);
            }
        }
        $this->penanggung_jawab = PenanggungJawab::all();
    }
    public function render()
    {

        $purposes = Purposes::with('document', 'responsible')
            ->where('nama_pemohon', 'LIKE', "%" . $this->search . "%")
            ->when($this->filterMonth, function ($query) {
                return $query->whereMonth('tanggal', $this->filterMonth);
            })
            ->when($this->filterYear, function ($query) {
                return $query->whereYear('tanggal', $this->filterYear);
            })
            ->when($this->filterResponsible, function ($query) {
                return $query->where('penanggung_jawab_id', $this->filterResponsible);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->page);


        return view('livewire.purposes.all-data', [
            'purposes' => $purposes,

        ]);
    }

    #[On('bulk-delete-js')]
    public function updateCount($value)
    {
        $this->delete_count = $value;
    }
    #[On('bulk-delete-cancel')]
    public function cancelDelete()
    {
        $this->delete_count = [];
    }
    public function store()
    {
        $this->validate([
            'penanggung_jawab_id' => 'required',
            'tanggal' => 'required',
            'nama_pemohon' => 'required',
        ], [
            'penanggung_jawab_id.required' => 'Masukkan nama penanggung jawab terlebih dahulu!',
            'tanggal.required' => 'Berapa Tanggal Masuk?',
            'nama_pemohon.required' => 'Nama pemohon?',
        ]);


        $purposes = Purposes::create([
            'penanggung_jawab_id' => $this->penanggung_jawab_id,
            'tanggal' => $this->tanggal,
            'nama_pemohon' => $this->nama_pemohon,
            'bank_name' => $this->bank_name,
            'jenis_pekerjaan' => $this->jenis_pekerjaan,
            'keterangan' => $this->keterangan,
            'no_akta' => $this->no_akta,
        ]);
        if ($this->document) {
            for ($i = 0; $i < count($this->document); $i++) {
                $fileName = Str::uuid(5) . "." . $this->document[$i]->getClientOriginalExtension();
                $this->document[$i]->storeAs('public/document', $fileName);
                Document::create([
                    'document' => $fileName,
                    'purpose_id' => $purposes->id
                ]);
            }
        }
        $this->dispatch('created-data', message: 'Data created successfully');
        $this->close();
    }

    public function close()
    {
        $this->penanggung_jawab_id = "";
        $this->nama_pemohon = "";
        $this->proses_permohonan = "";
        $this->no_akta = "";
        $this->bank_name = "";
        $this->jenis_pekerjaan = "";
        $this->proses_sertifikat = "";
        $this->keterangan = "";
        $this->tanggal = "";
    }

    public function edit($id)
    {
        $purposes = Purposes::find($id);
        $this->purposes_id = $purposes->id;
        $this->penanggung_jawab_id = $purposes->penanggung_jawab_id;
        $this->nama_pemohon = $purposes->nama_pemohon;
        $this->proses_permohonan = $purposes->nama_pemohon;
        $this->no_akta = $purposes->no_akta;
        $this->bank_name = $purposes->bank_name;
        $this->jenis_pekerjaan = $purposes->jenis_pekerjaan;
        $this->proses_sertifikat = $purposes->proses_sertifikat;
        $this->keterangan = $purposes->keterangan;
        $this->tanggal = $purposes->tanggal;
        $this->dispatch('edit-data-mode');
    }

    public function update()
    {
        $this->validate([
            'penanggung_jawab_id' => 'required',
            'tanggal' => 'required',
            'nama_pemohon' => 'required',
        ], [
            'penanggung_jawab_id.required' => 'Masukkan nama penanggung jawab terlebih dahulu!',
            'tanggal.required' => 'Berapa Tanggal Masuk?',
            'nama_pemohon.required' => 'Nama pemohon?',
        ]);
        $purposes = Purposes::find($this->purposes_id);
        $purposes->id = $this->purposes_id;
        $purposes->penanggung_jawab_id = $this->penanggung_jawab_id;
        $purposes->nama_pemohon = $this->nama_pemohon;
        $purposes->nama_pemohon = $this->proses_permohonan;
        $purposes->no_akta = $this->no_akta;
        $purposes->bank_name = $this->bank_name;
        $purposes->jenis_pekerjaan = $this->jenis_pekerjaan;
        $purposes->proses_sertifikat = $this->proses_sertifikat;
        $purposes->keterangan = $this->keterangan;
        $purposes->tanggal = $this->tanggal;
        if (count($this->document) > 0) {
            $docs = Document::where('purpose_id', $purposes->id)->get();
            foreach ($docs as $doc) {
                Storage::delete('public/document/' . $doc->document);
                $doc->delete();
            }
            for ($i = 0; $i < count($this->document); $i++) {
                $fileName = Str::uuid() . "." . $this->document[$i]->getClientOriginalExtension();
                $this->document[$i]->storeAs('public/document', $fileName);
                Document::create([
                    'document' => $fileName,
                    'purpose_id' => $purposes->id
                ]);
            }
        }
        $purposes->save();
        $this->dispatch('updated-data', message: "Updated created successfully ");
    }
    public function delete($id)
    {
        Purposes::findOrFail($id)->delete();
        $this->dispatch('deleted-data', message: "Deleted successfully ");
    }

    public function outgoing_data($id)
    {
        try {
            $purposes = Purposes::findOrFail(1);
            $purposes->update([
                'proses_sertifikat' => 'keluar'
            ]);
            $this->dispatch('success-outgoing-data', message: "Data Outgoing Successfully");
        } catch (ModelNotFoundException $e) {
            $this->dispatch('notFound-outgoing-data', message: "Error Id tidak ditemukan");
        } catch (Exception $e) {

            $this->dispatch('error-outgoing-data', message: "Serve Error ");
        }
    }

    public function bulk_delete()
    {
        try {
            for ($i = 0; $i < count($this->delete_count); $i++) {
                $purposes = Purposes::findOrFail($this->delete_count[$i]);
                $purposes->delete();
            }
            $this->dispatch('success-bulk-delete', message: 'Deleted successfully');
            $this->delete_count = [];
        } catch (ModelNotFoundException) {
            $this->dispatch('notFound-outgoing-data', message: "Error Id tidak ditemukan");
        } catch (Exception $e) {

            $this->dispatch('error-outgoing-data', message: "Serve Error ");
        }
    }

    public function export()
    {
        return Excel::download(new PurposeExport, Str::random(10) . ".xlsx");
        $this->dispatch('success-export');
    }
    public function import()
    {
        $this->validate([
            'exel' => 'required|mimes:xlsx'
        ], [
            'excel.required' => 'masukkan File terlebih dahulu',
            'excel.mimes' => 'Format File harus xlsx'
        ]);
        Excel::import(new PurposeImport, $this->exel);
        $this->dispatch('success-import', message: "Excel Import Successfully");
        $this->exel = null;
        $this->iteration++;
    }

    public function resetFilter()
    {
        $this->filterMonth = "";
        $this->filterYear = "";
        $this->filterResponsible = "";
    }
}