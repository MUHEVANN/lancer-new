<?php

namespace App\Imports;

use App\Models\PenanggungJawab;
use App\Models\Purposes;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PurposeImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $responsible = PenanggungJawab::where('nama_penanggung_jawab', $row['penanggung_jawab'])->first();
            // dd();
            Purposes::create([
                'tanggal' => Carbon::createFromDate('1900', '01', '01')->addDays($row['tanggal_dibuat'] - 2)->format('Y-m-d'),
                'jenis_pekerjaan' => $row['jenis_pekerjaan'],
                'no_akta' => $row['nomor_akta'],
                'proses_permohonan' => $row['proses_permohonan'],
                'bank_name' => $row['nama_bank'],
                'nama_pemohon' => $row['nama_pemohon'],
                'keterangan' => $row['keterangan'],
                'penanggung_jawab_id' => $responsible->id,
                'proses_sertifikat' => $row['status'] ?? 'masuk',
            ]);
        }
    }
}
