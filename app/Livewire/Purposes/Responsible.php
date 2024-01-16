<?php

namespace App\Livewire\Purposes;

use App\Models\PenanggungJawab;
use App\Models\Purposes;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\On;
use Livewire\Component;

class Responsible extends Component
{

    // Field
    public $nama_penanggung_jawab;
    // initiasi
    public $delete_count = [];
    public $id;
    public $search;

    public function render()
    {
        $responsible = PenanggungJawab::withCount('purposes')->where('nama_penanggung_jawab', 'LIKE', "%" . $this->search . "%")->paginate(10);
        return view('livewire.purposes.responsible', [
            'responsible' => $responsible
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
    public function bulk_delete()
    {
        try {
            for ($i = 0; $i < count($this->delete_count); $i++) {
                $responsible = PenanggungJawab::findOrFail($this->delete_count[$i]);
                $responsible->delete();
            }
            $this->dispatch('success-bulk-delete', message: 'Deleted successfully');
            $this->delete_count = [];
        } catch (ModelNotFoundException) {
            $this->dispatch('notFound-outgoing-data', message: "Error Id tidak ditemukan");
        } catch (Exception $e) {

            $this->dispatch('error-outgoing-data', message: "Serve Error ");
        }
    }
    public function delete($id)
    {
        try {
            $penanggung_jawab = PenanggungJawab::findOrFail($id);
            $penanggung_jawab->delete();

            $this->dispatch('delete-responsible', message: "Delete Data Successfully");
        } catch (Exception $e) {
            $this->dispatch('error', message: 'Gagal, Masalah server');
        }
    }
    public function store()
    {
        try {
            //code...
            PenanggungJawab::create([
                'nama_penanggung_jawab' => $this->nama_penanggung_jawab,
            ]);
            $this->close();
            $this->dispatch('success-create-responsible', message: 'Created Data Successfully');
        } catch (\Throwable $th) {
            throw $th;
            $this->dispatch('error', message: 'Gagal, Masalah server');
        }
    }

    public function edit($id)
    {
        try {
            $responsible = PenanggungJawab::findOrFail($id);
            $this->nama_penanggung_jawab = $responsible->nama_penanggung_jawab;
            $this->id = $responsible->id;
            $this->dispatch('edit_responsible');
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Gagal' . $th->getMessage());
        }
    }

    public function update()
    {
        try {
            PenanggungJawab::findOrFail($this->id)->update([
                'nama_penanggung_jawab' => $this->nama_penanggung_jawab
            ]);
            $this->dispatch('update_responsible', message: "Updated Data Successfully");
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Gagal' . $th->getMessage());
        }
    }

    public function close()
    {
        $this->nama_penanggung_jawab = '';
    }
}
