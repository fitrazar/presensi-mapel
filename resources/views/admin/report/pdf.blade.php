<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #34495e;
            font-size: 26px;
            text-align: center;
            margin-bottom: 5px;
        }

        h2 {
            color: #34495e;
            font-size: 18px;
            margin-top: 25px;
            margin-bottom: 10px;
            border-left: 6px solid #3498db;
            padding-left: 8px;
        }

        .subtitle {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .card {
            border-radius: 12px;
            padding: 12px;
            margin: 8px;
            color: white;
            width: 160px;
            display: inline-block;
            text-align: center;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            margin: 0;
            font-size: 14px;
            font-weight: normal;
        }

        .card p {
            margin: 5px 0 0;
            font-size: 22px;
            font-weight: bold;
        }

        .bg-green {
            background: #27ae60;
        }

        .bg-red {
            background: #c0392b;
        }

        .bg-orange {
            background: #d35400;
        }

        .bg-purple {
            background: #8e44ad;
        }

        .bg-blue {
            background: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.08);
        }

        th,
        td {
            border: 1px solid #ecf0f1;
            padding: 8px;
            font-size: 12px;
            text-align: center;
        }

        th {
            background: #ecf0f1;
            font-weight: bold;
            color: #2c3e50;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
            color: #7f8c8d;
        }
    </style>
</head>

<body>

    <h1>📊 Laporan Presensi</h1>
    <p class="subtitle">
        Periode: {{ \Carbon\Carbon::parse($start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($end)->format('d M Y')
        }}
    </p>

    {{-- Ringkasan Status --}}
    <h2>Ringkasan Status</h2>
    <div>
        @foreach($statusSummary as $status => $count)
        <div
            class="card {{ ['Hadir'=>'bg-green','Sakit'=>'bg-red','Izin'=>'bg-orange','Alpa'=>'bg-purple'][$status] ?? 'bg-blue' }}">
            <h3>{{ $status }}</h3>
            <p>{{ $count }}</p>
        </div>
        @endforeach
    </div>

    {{-- Per Kelas --}}
    <h2>Presensi per Kelas</h2>
    <table>
        <thead>
            <tr>
                <th>Kelas</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
                <th>Pulang</th>
                <th>Pulang Sakit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($byClass as $class => $rows)
            <tr>
                <td><strong>{{ $class }}</strong></td>
                <td>{{ $rows['Hadir'] ?? 0 }}</td>
                <td>{{ $rows['Izin'] ?? 0 }}</td>
                <td>{{ $rows['Sakit'] ?? 0 }}</td>
                <td>{{ $rows['Alpa'] ?? 0 }}</td>
                <td>{{ $rows['Pulang'] ?? 0 }}</td>
                <td>{{ $rows['Pulang Sakit'] ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Per Mapel --}}
    <h2>Presensi per Mapel</h2>
    <table>
        <thead>
            <tr>
                <th>Mapel</th>
                <th>Total Presensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bySubject as $mapel => $count)
            <tr>
                <td>{{ $mapel }}</td>
                <td><strong>{{ $count }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Top 5 Siswa --}}
    <h2>Top 5 Siswa Paling Rajin Hadir</h2>
    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama</th>
                <th>Total Hadir</th>
            </tr>
        </thead>
        <tbody>
            @php $rank = 1; @endphp
            @foreach($topHadir as $studentId => $count)
            <tr>
                <td>{{ $rank++ }}</td>
                <td>{{ $students[$studentId] ?? '-' }}</td>
                <td>{{ $count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d M Y H:i') }}
    </div>
</body>

</html>