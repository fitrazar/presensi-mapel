<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Attendance;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;

class AttendancePerMonthSheet implements FromArray, WithTitle, WithEvents
{
    protected $grade;
    protected $month;
    protected $startDate;
    protected $endDate;
    protected $meta;

    public function __construct($grade, $month, $startDate, $endDate)
    {
        $this->grade = $grade;
        $this->month = $month;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function title(): string
    {
        // contoh: "8A (Januari)"
        return "{$this->grade->level}{$this->grade->class_number} ({$this->month->isoFormat('MMMM')})";
    }

    public function array(): array
    {
        $year = $this->month->year;
        $month = $this->month->month;
        $daysInMonth = $this->month->daysInMonth;

        // Semester & tahun ajaran
        $semester = ($month >= 8) ? 'GENAP' : 'GANJIL';
        $academicYear = ($month >= 8)
            ? "{$year}/" . ($year + 1)
            : ($year - 1) . "/{$year}";

        $students = Student::where('grade_id', $this->grade->id)
            ->orderBy('name')
            ->get();

        $dateStart = $this->month->copy()->startOfMonth();
        $dateEnd = $this->month->copy()->endOfMonth();

        $attendances = Attendance::whereBetween('date', [$dateStart, $dateEnd])
            ->whereIn('student_id', $students->pluck('id'))
            ->orderBy('date')
            ->get()
            ->groupBy(function ($item) {
                return $item->student_id . '-' . $item->date;
            });

        // Map hasilnya
        $attendanceMap = [];
        foreach ($attendances as $group) {
            // ambil satu saja (misalnya yang pertama)
            $a = $group->first();
            $attendanceMap[$a->student_id][$a->date] = $this->normalizeStatus($a->status);
        }


        // Header
        $header = ['NO', 'NISN', 'NAMA'];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $header[] = $d;
        }
        $summaryCols = ['S', 'I', 'A', 'H', 'PS', 'P'];
        $header = array_merge($header, $summaryCols);

        $rows = [];
        $rows[] = $header;

        // Data siswa
        $no = 1;
        foreach ($students as $s) {
            $row = [$no++, $s->nisn, $s->name];
            $counts = array_fill_keys($summaryCols, 0);

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $date = \Carbon\Carbon::create($year, $month, $d)->toDateString();
                $cell = '';
                if (isset($attendanceMap[$s->id][$date])) {
                    $st = $attendanceMap[$s->id][$date];
                    if ($st === 'H') {
                        $cell = '✓';
                        $counts['H']++;
                    } else {
                        $cell = $st;
                        if (isset($counts[$st]))
                            $counts[$st]++;
                    }
                }
                $row[] = $cell;
            }

            foreach ($summaryCols as $sc) {
                $row[] = $counts[$sc];
            }

            $rows[] = $row;
        }

        $rows[] = [];
        // $rows[] = ['Keterangan:', 'S:Sakit', 'I:Izin', 'A:Alpa', 'H:Hadir', 'PS:Pulang Sakit', 'P:Pulang'];

        $this->meta = [
            'school' => 'SMP 3 AL-MUHAJIRIN',
            'class_label' => "{$this->grade->level}{$this->grade->class_number}",
            'semester' => $semester,
            'academic_year' => $academicYear,
            'month_name' => $this->month->isoFormat('MMMM Y')
        ];

        return $rows;
    }

    protected function normalizeStatus($s)
    {
        $s = strtoupper(trim($s));
        return match ($s) {
            'S', 'SAKIT' => 'S',
            'I', 'IZIN' => 'I',
            'A', 'ALPA' => 'A',
            'H', 'HADIR', 'C', 'CEKLIS' => 'H',
            'PS', 'PULANG SAKIT' => 'PS',
            'P', 'PULANG' => 'P',
            default => $s,
        };
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $meta = $this->meta;

                // ----------------------------
                // Struktur baris yang kita buat:
                // Row 1 : Title
                // Row 2 : Kelas / Semester / Tahun ajaran
                // Row 3 : (kosong atau tambahan)
                // Row 4 : BARIS KHUSUS => Bulan (di-merge di atas kolom tanggal) & "Keterangan" (di-merge di atas kolom S,I,A,H,PS,P)
                // Row 5 : BARIS TANGGAL => 1,2,3,... (ini berasal dari array() header yang sudah ditulis)
                // Row 6.. : Data siswa
                // ----------------------------
    
                // Sisipkan 4 baris kosong di atas -> baris header array() akan turun ke row 5
                $sheet->insertNewRowBefore(1, 4);

                // Re-evaluate highest column/row setelah insert (kolom tidak berubah, tapi aman)
                $highestCol = $sheet->getHighestColumn();
                $lastRow = $sheet->getHighestRow();

                // baris header tanggal setelah insert
                $dateHeaderRow = 5;
                $monthRow = $dateHeaderRow - 1;   // = 4
                $dataStartRow = $dateHeaderRow + 1; // = 6
    
                // ambil jumlah hari dari month object
                $daysInMonth = $this->month->daysInMonth;

                // kolom index: 1=A, 2=B, 3=C, tanggal mulai di kolom 4 (D)
                $firstDayColIndex = 4;
                $lastDayColIndex = $firstDayColIndex + $daysInMonth - 1;

                // nama kolom huruf
                $firstDayColLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($firstDayColIndex);
                $lastDayColLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($lastDayColIndex);

                // summary columns (S,I,A,H,PS,P)
                $summaryCount = 6;
                $firstSummaryColIndex = $lastDayColIndex + 1;
                $lastSummaryColIndex = $firstSummaryColIndex + $summaryCount - 1;
                $firstSummaryColLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($firstSummaryColIndex);
                $lastSummaryColLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($lastSummaryColIndex);

                // ----------------------------
                // Tulis Judul (row 1..3)
                // ----------------------------
                $sheet->setCellValue('A1', "PRESENSI SISWA " . ($meta['school'] ?? ''));
                $sheet->mergeCells("A1:{$highestCol}1");

                $sheet->setCellValue('A2', "KELAS: " . ($meta['class_label'] ?? '-') . "   SEMESTER " . ($meta['semester'] ?? '') . "   TAHUN PELAJARAN " . ($meta['academic_year'] ?? ''));
                $sheet->mergeCells("A2:{$highestCol}2");

                // baris 3 bisa kosong atau info lain (kita kosongkan)
                $sheet->setCellValue("A3", "");

                $sheet->getStyle("A1:{$highestCol}3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A1:{$highestCol}2")->getFont()->setBold(true)->setSize(12);

                // ----------------------------
                // Tulis BARIS BULAN (monthRow) - di atas baris tanggal
                // ----------------------------
                $sheet->setCellValueByColumnAndRow($firstDayColIndex, $monthRow, ($meta['month_name'] ?? ''));
                // merge sepanjang kolom tanggal
                $sheet->mergeCellsByColumnAndRow($firstDayColIndex, $monthRow, $lastDayColIndex, $monthRow);

                // Tulis "Keterangan" di atas kolom summary
                $sheet->setCellValueByColumnAndRow($firstSummaryColIndex, $monthRow, 'Keterangan');
                $sheet->mergeCellsByColumnAndRow($firstSummaryColIndex, $monthRow, $lastSummaryColIndex, $monthRow);

                // Merge NO, NISN, NAMA vertical (cover monthRow dan dateHeaderRow)
                foreach (['A', 'B', 'C'] as $colLetter) {
                    $sheet->mergeCells("{$colLetter}{$monthRow}:{$colLetter}{$dateHeaderRow}");
                }

                $sheet->setCellValue("A{$monthRow}", "NO");
                $sheet->setCellValue("B{$monthRow}", "NIS");
                $sheet->setCellValue("C{$monthRow}", "NAMA");

                // Styling baris monthRow + dateHeaderRow
                $sheet->getStyle("A{$monthRow}:{$highestCol}{$dateHeaderRow}")
                    ->getFont()->setBold(true);
                $sheet->getStyle("A{$monthRow}:{$highestCol}{$dateHeaderRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Border untuk seluruh area tabel (dari monthRow sampai akhir)
                $lastRow = $sheet->getHighestRow();
                $tableRange = "A{$monthRow}:{$highestCol}{$lastRow}";
                $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Lebar kolom sesuai permintaan
                $sheet->getColumnDimension('A')->setWidth(5);   // NO kecil
                $sheet->getColumnDimension('B')->setWidth(16);  // NISN lebih lebar
                $sheet->getColumnDimension('C')->setWidth(30);  // Nama lebih panjang
    
                // (Opsional) set wrap text untuk Nama
                $sheet->getStyle("C{$dateHeaderRow}:C{$lastRow}")->getAlignment()->setWrapText(true);

                // Center align untuk kolom tanggal + summary (agar ceklis/angka rata tengah)
                $sheet->getStyle("{$firstDayColLetter}{$monthRow}:{$lastSummaryColLetter}{$lastRow}")
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // ----------------------------
                // Warnai weekend (Sabtu & Minggu) -- apply dari baris tanggal (dateHeaderRow) sampai akhir data
                // ----------------------------
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    $date = \Carbon\Carbon::create($this->month->year, $this->month->month, $d);
                    if ($date->isSaturday() || $date->isSunday()) {
                        $colIndex = $firstDayColIndex + $d - 1;
                        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);

                        // Terapkan fill dari header tanggal sampai akhir data
                        $sheet->getStyle("{$colLetter}{$dateHeaderRow}:{$colLetter}{$lastRow}")
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFCCCC'); // merah muda
                    }
                }

                // Freeze pane agar header selalu terlihat (baris data mulai di dataStartRow)
                $sheet->freezePane('A' . $dataStartRow);

                // ----------------------------
                // Tambah keterangan di bawah tabel (sebelah kiri tanda tangan)
                // ----------------------------
                $noteRow = $lastRow + 3;
                $noteCol = 'B'; // mulai kolom agak ke kiri biar tidak mentok A
    
                $sheet->setCellValue("{$noteCol}{$noteRow}", "Keterangan:");
                $sheet->setCellValue("{$noteCol}" . ($noteRow + 1), "S : Sakit");
                $sheet->setCellValue("{$noteCol}" . ($noteRow + 2), "I : Izin");
                $sheet->setCellValue("{$noteCol}" . ($noteRow + 3), "A : Alpa");
                $sheet->setCellValue("{$noteCol}" . ($noteRow + 4), "PS : Pulang Sakit");
                $sheet->setCellValue("{$noteCol}" . ($noteRow + 5), "✓ : Hadir");
                $sheet->setCellValue("{$noteCol}" . ($noteRow + 6), "P : Pulang");

                // ----------------------------
                // Tambah tanda tangan di bawah tabel (posisi: di kolom summary agar di kanan)
                // ----------------------------
                $signRow = $lastRow + 3;
                $sigStartColLetter = $firstSummaryColLetter; // mulai dari kolom summary (kanan)
                $sheet->setCellValue("{$sigStartColLetter}{$signRow}", "Mengetahui,");
                $sheet->setCellValue("{$sigStartColLetter}" . ($signRow + 1), "Kepala SMP 3 Al-Muhajirin");
                // beri jarak 3 baris untuk tanda tangan
                $sheet->setCellValue("{$sigStartColLetter}" . ($signRow + 6), "Hj. Kiki Zakiah Nuraisyah, S.S.I., M.H.");
                $sheet->setCellValue("{$sigStartColLetter}" . ($signRow + 7), "NIY: 04699066");

                // (Opsional) beri style italic / bold pada nama
                $sheet->getStyle("{$sigStartColLetter}" . ($signRow + 6))->getFont()->setBold(true);
            }
        ];
    }


}