<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Field :attribute harus disetujui.',
    'accepted_if' => 'Field :attribute harus disetujui ketika :other bernilai :value.',
    'active_url' => 'Field :attribute harus berupa URL yang valid.',
    'after' => 'Field :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Field :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Field :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Field :attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num' => 'Field :attribute hanya boleh berisi huruf dan angka.',
    'any_of' => 'Field :attribute tidak valid.',
    'array' => 'Field :attribute harus berupa array.',
    'ascii' => 'Field :attribute hanya boleh berisi karakter alfanumerik satu byte dan simbol.',
    'before' => 'Field :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Field :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => 'Field :attribute harus memiliki antara :min dan :max item.',
        'file' => 'Field :attribute harus antara :min dan :max kilobyte.',
        'numeric' => 'Field :attribute harus antara :min dan :max.',
        'string' => 'Field :attribute harus antara :min dan :max karakter.',
    ],
    'boolean' => 'Field :attribute harus bernilai true atau false.',
    'can' => 'Field :attribute mengandung nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi field :attribute tidak cocok.',
    'contains' => 'Field :attribute tidak mengandung nilai yang diperlukan.',
    'current_password' => 'Kata sandi saat ini salah.',
    'date' => 'Field :attribute harus berupa tanggal yang valid.',
    'date_equals' => 'Field :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => 'Field :attribute harus sesuai dengan format :format.',
    'decimal' => 'Field :attribute harus memiliki :decimal angka di belakang koma.',
    'declined' => 'Field :attribute harus ditolak.',
    'declined_if' => 'Field :attribute harus ditolak ketika :other bernilai :value.',
    'different' => 'Field :attribute dan :other harus berbeda.',
    'digits' => 'Field :attribute harus terdiri dari :digits angka.',
    'digits_between' => 'Field :attribute harus terdiri dari :min sampai :max angka.',
    'dimensions' => 'Field :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Field :attribute memiliki nilai duplikat.',
    'doesnt_end_with' => 'Field :attribute tidak boleh diakhiri dengan salah satu dari: :values.',
    'doesnt_start_with' => 'Field :attribute tidak boleh diawali dengan salah satu dari: :values.',
    'email' => 'Field :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Field :attribute harus diakhiri dengan salah satu dari: :values.',
    'enum' => 'Field :attribute yang dipilih tidak valid.',
    'exists' => 'Field :attribute yang dipilih tidak valid.',
    'extensions' => 'Field :attribute harus memiliki ekstensi: :values.',
    'file' => 'Field :attribute harus berupa file.',
    'filled' => 'Field :attribute wajib diisi.',
    'gt' => [
        'array' => 'Field :attribute harus memiliki lebih dari :value item.',
        'file' => 'Field :attribute harus lebih besar dari :value kilobyte.',
        'numeric' => 'Field :attribute harus lebih besar dari :value.',
        'string' => 'Field :attribute harus lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => 'Field :attribute harus memiliki :value item atau lebih.',
        'file' => 'Field :attribute harus lebih besar atau sama dengan :value kilobyte.',
        'numeric' => 'Field :attribute harus lebih besar atau sama dengan :value.',
        'string' => 'Field :attribute harus lebih besar atau sama dengan :value karakter.',
    ],
    'hex_color' => 'Field :attribute harus berupa warna heksadesimal yang valid.',
    'image' => 'Field :attribute harus berupa gambar.',
    'in' => 'Field :attribute yang dipilih tidak valid.',
    'in_array' => 'Field :attribute harus ada di dalam :other.',
    'integer' => 'Field :attribute harus berupa bilangan bulat.',
    'ip' => 'Field :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Field :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Field :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Field :attribute harus berupa string JSON yang valid.',
    'list' => 'Field :attribute harus berupa daftar.',
    'lowercase' => 'Field :attribute harus menggunakan huruf kecil semua.',
    'lt' => [
        'array' => 'Field :attribute harus memiliki kurang dari :value item.',
        'file' => 'Field :attribute harus kurang dari :value kilobyte.',
        'numeric' => 'Field :attribute harus kurang dari :value.',
        'string' => 'Field :attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => 'Field :attribute tidak boleh memiliki lebih dari :value item.',
        'file' => 'Field :attribute harus kurang dari atau sama dengan :value kilobyte.',
        'numeric' => 'Field :attribute harus kurang dari atau sama dengan :value.',
        'string' => 'Field :attribute harus kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => 'Field :attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => 'Field :attribute tidak boleh memiliki lebih dari :max item.',
        'file' => 'Field :attribute tidak boleh lebih dari :max kilobyte.',
        'numeric' => 'Field :attribute tidak boleh lebih dari :max.',
        'string' => 'Field :attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits' => 'Field :attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => 'Field :attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => 'Field :attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'array' => 'Field :attribute harus memiliki minimal :min item.',
        'file' => 'Field :attribute harus minimal :min kilobyte.',
        'numeric' => 'Field :attribute harus minimal :min.',
        'string' => 'Field :attribute harus minimal :min karakter.',
    ],
    'min_digits' => 'Field :attribute harus memiliki minimal :min digit.',
    'missing' => 'Field :attribute harus tidak ada.',
    'missing_if' => 'Field :attribute harus tidak ada ketika :other adalah :value.',
    'missing_unless' => 'Field :attribute harus tidak ada kecuali :other adalah :value.',
    'missing_with' => 'Field :attribute harus tidak ada ketika :values ada.',
    'missing_with_all' => 'Field :attribute harus tidak ada ketika semua :values ada.',
    'multiple_of' => 'Field :attribute harus kelipatan dari :value.',
    'not_in' => 'Field :attribute yang dipilih tidak valid.',
    'not_regex' => 'Format field :attribute tidak valid.',
    'numeric' => 'Field :attribute harus berupa angka.',
    'password' => [
        'letters' => 'Field :attribute harus mengandung setidaknya satu huruf.',
        'mixed' => 'Field :attribute harus mengandung setidaknya satu huruf kapital dan satu huruf kecil.',
        'numbers' => 'Field :attribute harus mengandung setidaknya satu angka.',
        'symbols' => 'Field :attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => 'Field :attribute yang diberikan ditemukan dalam kebocoran data. Harap gunakan :attribute yang berbeda.',
    ],
    'present' => 'Field :attribute harus ada.',
    'present_if' => 'Field :attribute harus ada ketika :other adalah :value.',
    'present_unless' => 'Field :attribute harus ada kecuali :other adalah :value.',
    'present_with' => 'Field :attribute harus ada ketika :values ada.',
    'present_with_all' => 'Field :attribute harus ada ketika semua :values ada.',
    'prohibited' => 'Field :attribute tidak diperbolehkan.',
    'prohibited_if' => 'Field :attribute tidak diperbolehkan ketika :other adalah :value.',
    'prohibited_if_accepted' => 'Field :attribute tidak diperbolehkan ketika :other diterima.',
    'prohibited_if_declined' => 'Field :attribute tidak diperbolehkan ketika :other ditolak.',
    'prohibited_unless' => 'Field :attribute tidak diperbolehkan kecuali :other ada dalam :values.',
    'prohibits' => 'Field :attribute melarang :other untuk ada.',
    'regex' => 'Format field :attribute tidak valid.',
    'required' => 'Field :attribute wajib diisi.',
    'required_array_keys' => 'Field :attribute harus memiliki entri untuk: :values.',
    'required_if' => 'Field :attribute wajib diisi ketika :other adalah :value.',
    'required_if_accepted' => 'Field :attribute wajib diisi ketika :other diterima.',
    'required_if_declined' => 'Field :attribute wajib diisi ketika :other ditolak.',
    'required_unless' => 'Field :attribute wajib diisi kecuali :other ada dalam :values.',
    'required_with' => 'Field :attribute wajib diisi ketika :values ada.',
    'required_with_all' => 'Field :attribute wajib diisi ketika semua :values ada.',
    'required_without' => 'Field :attribute wajib diisi ketika :values tidak ada.',
    'required_without_all' => 'Field :attribute wajib diisi ketika tidak ada satu pun dari :values yang ada.',
    'same' => 'Field :attribute harus sama dengan :other.',
    'size' => [
        'array' => 'Field :attribute harus berisi :size item.',
        'file' => 'Field :attribute harus berukuran :size kilobyte.',
        'numeric' => 'Field :attribute harus bernilai :size.',
        'string' => 'Field :attribute harus berisi :size karakter.',
    ],
    'starts_with' => 'Field :attribute harus dimulai dengan salah satu dari: :values.',
    'string' => 'Field :attribute harus berupa teks.',
    'timezone' => 'Field :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Field :attribute sudah digunakan.',
    'uploaded' => 'Gagal mengunggah field :attribute.',
    'uppercase' => 'Field :attribute harus berupa huruf kapital semua.',
    'url' => 'Field :attribute harus berupa URL yang valid.',
    'ulid' => 'Field :attribute harus berupa ULID yang valid.',
    'uuid' => 'Field :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
