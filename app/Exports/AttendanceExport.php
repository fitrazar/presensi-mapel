<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Support\Collection;
use App\Exports\AttendancePerMonthSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AttendanceExport implements WithMultipleSheets
{
    protected $startDate;
    protected $endDate;
    protected $gradeId;
    protected $schoolName = 'SMP 3 AL-MUHAJIRIN'; // sesuaikan jika perlu

    public function __construct($startDate = null, $endDate = null, $gradeId = null)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate) : null;
        $this->endDate = $endDate ? Carbon::parse($endDate) : null;
        $this->gradeId = $gradeId;
    }
    public function sheets(): array
    {
        $sheets = [];

        // Ambil semua kelas yang difilter (atau semua)
        $gradesQuery = Grade::query();
        if ($this->gradeId) {
            $gradesQuery->where('id', $this->gradeId);
        }
        $grades = $gradesQuery->get();

        // Range bulan (dari startDate s/d endDate)
        $start = \Carbon\Carbon::parse($this->startDate)->startOfMonth();
        $end = \Carbon\Carbon::parse($this->endDate)->endOfMonth();

        $period = \Carbon\CarbonPeriod::create($start, '1 month', $end);

        foreach ($grades as $grade) {
            foreach ($period as $month) {
                $sheets[] = new AttendancePerMonthSheet(
                    $grade,
                    $month,
                    $this->startDate,
                    $this->endDate
                );
            }
        }

        return $sheets;
    }

    // public function array(): array
    // {
    //     // Tentukan bulan target: jika ada filter gunakan bulan dari start_date, kalau tidak gunakan bulan sekarang
    //     $refDate = $this->startDate ?? ($this->endDate ?? Carbon::now());
    //     $year = $refDate->year;
    //     $month = $refDate->month;
    //     $monthName = $refDate->locale('id')->isoFormat('MMMM'); // nama bulan bahasa id (jika tidak tersedia fallback)
    //     $daysInMonth = $refDate->daysInMonth;

    //     // Tentukan semester berdasarkan aturanmu: Jan-Jul => Ganjil, Aug-Dec => Genap
    //     $semester = ($month >= 8) ? 'Genap' : 'Ganjil';

    //     // Tentukan tahun pelajaran: jika bulan >= 8 => tahun sekarang / tahun+1, else tahun-1 / tahun
    //     if ($month >= 8) {
    //         $academicYear = "{$year}/" . ($year + 1);
    //     } else {
    //         $academicYear = ($year - 1) . "/{$year}";
    //     }

    //     // Ambil siswa sesuai filter grade (atau semua)
    //     $studentsQuery = Student::query()->with('grade')->orderBy('name');
    //     if ($this->gradeId) {
    //         $studentsQuery->where('grade_id', $this->gradeId);
    //     }
    //     $students = $studentsQuery->get();

    //     // Ambil presensi untuk rentang tanggal yang relevan:
    //     // Jika user memberikan start_date/end_date maka gunakan range itu,
    //     // namun tampilan kolom tetap per bulan dari $refDate (1..daysInMonth).
    //     // Untuk nilai tiap sel, kita lookup attendance berdasarkan tanggal.
    //     $attendanceMap = [];
    //     $dateStart = $this->startDate ? $this->startDate->copy() : Carbon::create($year, $month, 1);
    //     $dateEnd = $this->endDate ? $this->endDate->copy() : Carbon::create($year, $month, $daysInMonth);

    //     // Ambil kehadiran semua siswa dalam rentang (effisien)
    //     $attendances = Attendance::whereBetween('date', [$dateStart->toDateString(), $dateEnd->toDateString()])
    //         ->whereIn('student_id', $students->pluck('id')->toArray())
    //         ->get();

    //     // Buat map [student_id][Y-m-d] => status
    //     foreach ($attendances as $a) {
    //         $attendanceMap[$a->student_id][$a->date] = $this->normalizeStatus($a->status);
    //     }

    //     // Siapkan header baris atas (title etc) nanti di AfterSheet kita merge cells.
    //     $rows = [];
    //     // We'll leave space for title rows (AfterSheet will write those visually)
    //     // Row 1..3 (header) di-handle di styling; di data array kita mulai dari baris data.

    //     // Buat header kolom data (NO, NISN, NAMA, 1,2,...,lastDay, S,I,A,H,PS,P)
    //     $header = ['NO', 'NISN', 'NAMA'];
    //     for ($d = 1; $d <= $daysInMonth; $d++) {
    //         $header[] = $d;
    //     }
    //     // summary columns
    //     $summaryCols = ['S', 'I', 'A', 'H', 'PS', 'P'];
    //     $header = array_merge($header, $summaryCols);

    //     $rows[] = $header;

    //     // Isi tiap baris siswa
    //     $no = 1;
    //     foreach ($students as $student) {
    //         $row = [];
    //         $row[] = $no++;
    //         $row[] = $student->nisn ?? '-';
    //         $row[] = $student->name;

    //         // per-hari status
    //         $counts = array_fill_keys($summaryCols, 0);
    //         for ($d = 1; $d <= $daysInMonth; $d++) {
    //             $dateStr = Carbon::create($year, $month, $d)->toDateString();

    //             $cell = '';
    //             if (isset($attendanceMap[$student->id][$dateStr])) {
    //                 $status = $attendanceMap[$student->id][$dateStr];
    //                 if ($status === 'H') {
    //                     // pakai tanda centang - bisa juga gunakan 'C' sesuai request
    //                     $cell = '✓';
    //                     $counts['H']++;
    //                 } else {
    //                     $cell = $status;
    //                     if (isset($counts[$status]))
    //                         $counts[$status]++;
    //                 }
    //             } else {
    //                 // Tidak ada data: anggap Alpa (A) atau kosong? contoh kamu mau masukkan singkatan status utk tidak hadir:
    //                 $cell = ''; // biarkan kosong kalau tidak ada record; jika mau default A ganti disini
    //             }
    //             $row[] = $cell;
    //         }

    //         // tambahkan ringkasan
    //         foreach ($summaryCols as $sc) {
    //             $row[] = $counts[$sc] ?? 0;
    //         }

    //         $rows[] = $row;
    //     }

    //     // Tambahkan baris keterangan singkatan di bawah (opsional)
    //     $rows[] = []; // empty line
    //     $rows[] = ['Keterangan:', 'S : Sakit', 'I : Izin', 'A : Alpa', 'H : Hadir', 'PS : Pulang Sakit', 'P : Pulang'];

    //     // Tambahkan header metadata di baris paling atas (kita gunakan AfterSheet untuk merge/styling)
    //     // Tapi array() harus dikembalikan sebagai 2D array payload. Kita kembalikan rows, AfterSheet akan menyisipkan header visual.
    //     // Note: Untuk menempatkan title di atas, AfterSheet akan merubah sheet langsung.

    //     // Untuk memudahkan AfterSheet menulis title, kita juga kembalikan meta melalui property.
    //     $this->meta = [
    //         'school' => $this->schoolName,
    //         'class_label' => $this->getClassLabel($students), // e.g. "8 A" or nilai dari Grade
    //         'semester' => $semester,
    //         'academic_year' => $academicYear,
    //         'month_name' => ucfirst($monthName) . " {$year}"
    //     ];

    //     return $rows;
    // }

    // protected function normalizeStatus($raw)
    // {
    //     // Normalisasi berbagai kemungkinan nilai status di DB ke singkatan yang kita gunakan
    //     $s = strtoupper(trim($raw));
    //     return match ($s) {
    //         'S', 'SAKIT' => 'S',
    //         'I', 'IZIN' => 'I',
    //         'A', 'ALPA' => 'A',
    //         'H', 'HADIR', 'C', 'CEKLIS' => 'H',
    //         'PS', 'PULANG SAKIT' => 'PS',
    //         'P', 'PULANG' => 'P',
    //         default => $s,
    //     };
    // }

    // protected function getClassLabel($students)
    // {
    //     // Jika filter grade dipakai dan semua siswa punya grade sama, ambil label grade
    //     if ($this->gradeId) {
    //         $g = Grade::find($this->gradeId);
    //         if ($g)
    //             return trim($g->level . $g->class_number);
    //     }
    //     // fallback: jika tidak ada grade filter, return '-'
    //     return '-';
    // }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             $sheet = $event->sheet->getDelegate();
    //             // $rows = count($event->sheet->toArray());
    //             // Tuliskan header title di atas tabel (merge dan styling)
    //             $meta = $this->meta ?? [];

    //             // Kita anggap header akan kita letakkan pada row 1..3, data mulai row 5 (karena row 4 header kolom)
    //             // Jadi shift semua data ke bawah 4 baris -> namun FromArray menulis mulai dari A1 otomatis.
    //             // Simpler: kita tulis title di baris 1..3 lalu shift data header berada di row 5 dengan memindahkan
    //             // Kita akan insert 3 baris di atas
    //             $sheet->insertNewRowBefore(1, 3);

    //             // Judul utama
    //             $title = "PRESENSI SISWA {$meta['school']}";
    //             $classLabel = "KELAS: " . ($meta['class_label'] ?? '-');
    //             $semesterInfo = "SEMESTER {$meta['semester']}";
    //             $academic = "TAHUN PELAJARAN {$meta['academic_year']}";
    //             $monthInfo = "BULAN: " . ($meta['month_name'] ?? '');

    //             // Merge across columns: kolom akhir = 3 + days + 6 summary. Kita hitung kol terakhir dari sheet content.
    //             $highestColumn = $sheet->getHighestColumn(); // e.g. 'AR'
    //             // tulis baris judul
    //             $sheet->setCellValue('A1', $title);
    //             $sheet->mergeCells("A1:{$highestColumn}1");

    //             $sheet->setCellValue('A2', "{$classLabel}    {$semesterInfo}    {$academic}");
    //             $sheet->mergeCells("A2:{$highestColumn}2");

    //             $sheet->setCellValue('A3', $monthInfo);
    //             $sheet->mergeCells("A3:{$highestColumn}3");

    //             // Styling judul
    //             $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    //             $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(11);
    //             $sheet->getStyle('A3')->getFont()->setItalic(true)->setSize(10);

    //             $sheet->getStyle("A1:{$highestColumn}3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    //             // Border dan style untuk header kolom (baris 5 setelah insert)
    //             $headerRowIndex = 5;
    //             $sheet->getStyle("A{$headerRowIndex}:{$highestColumn}{$headerRowIndex}")
    //                 ->getFont()->setBold(true);

    //             // Set border untuk seluruh area data (dari headerRowIndex sampai last row)
    //             $lastDataRow = $sheet->getHighestRow();
    //             $range = "A{$headerRowIndex}:{$highestColumn}{$lastDataRow}";
    //             $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //             // Center align for small numeric columns (tanggal and summary)
    //             // Kita cari kol indeks untuk tanggal mulai dari C? Header structure: NO(A), NISN(B), NAMA(C) ??? Actually we constructed headers as NO,NISN,NAMA then days...
    //             // That means tanggal dimulai di kol index 4 (D). Kita apply center to D..(D+days-1) and summary columns at the end.
    //             // Simpler: center align for all columns from D to last column
    //             $sheet->getStyle("D{$headerRowIndex}:{$highestColumn}{$lastDataRow}")
    //                 ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    //             // Wrap text for NAMA column (C)
    //             $sheet->getStyle("C{$headerRowIndex}:C{$lastDataRow}")
    //                 ->getAlignment()->setWrapText(true);

    //             // Slight row height increase for readability
    //             for ($r = $headerRowIndex; $r <= $lastDataRow; $r++) {
    //                 $sheet->getRowDimension($r)->setRowHeight(20);
    //             }
    //         },
    //     ];
    // }
}