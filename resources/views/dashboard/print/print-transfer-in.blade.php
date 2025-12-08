<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"
        href="{{ setting('app_logo') !== null ? asset('storage/' . setting('app_logo')) : asset('assets/images/logos/water.png') }}"
        type="image/x-icon" />
    <title>{{ $transfer_in->letter }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-size: 14px;
            line-height: 1.3;
        }

        main {
            margin: auto;
            max-width: 550px;
            padding: 10px;
        }

        /* Improved header layout and styling to match reference design */
        .header {
            margin-bottom: 10px;
        }

        .header-top {
            display: flex;
            align-items: flex-start;
            gap: 0;
            padding-bottom: 8px;
        }

        .header-logo {
            flex-shrink: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-right: 10px;
        }

        .logo {
            width: 110px;
            height: 110px;
            /* object-fit: cover; */
        }

        .header-text {
            flex: 1;
            text-align: left;
            padding-left: 10px;
            border-left: 3px solid #000;
        }

        .header-text .step-1 {
            margin: 1px 0 0 0;
            line-height: 1;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .header-text .step-2 {
            margin: 1px 0 0 0;
            line-height: 1;
            font-size: 26px;
            font-weight: bolder;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .header-text .step-3 {
            margin: 1px 0 0 0;
            line-height: 1;
            font-size: 16px;
            font-weight: lighter;
        }

        .header-info {
            margin: 1px 0 0 0;
            font-size: 13px;
            line-height: 1.2;
        }

        .header-info p {
            margin: 1px 0;
        }

        /* Styled blue bar for secretary/contact information */
        .address-blue {
            background-color: #003fbc;
            color: white;
            font-size: 11px;
            padding: 6px 12px;
            margin: 0;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-align: center;
            line-height: 1.4;
            width: 100%;
        }

        h1 {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
        }

        h2 {
            font-size: 14px;
            margin: 5px 0;
            font-weight: bold;
        }

        .title {
            text-transform: uppercase;
            font-size: 20px;
            margin: 25px 0 0 0;
            text-align: center;
            text-decoration: underline;
        }

        .content {
            margin-top: 35px;
        }

        table {
            width: 100%;
        }

        td {
            vertical-align: top;
            padding: 2px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        hr {
            border: none;
            border-top: 2px solid black;
            margin: 8px 0;
        }

        .text-capitalize {
            text-transform: capitalize;
        }
    </style>
</head>

<body>
    <main>
        <!-- Restructured header with flex layout for better alignment -->
        <div class="header">
            <div class="header-top">
                <div class="header-logo">
                    <img src="{{ asset('assets/images/logos/logo-app.png') }}" alt="Logo" class="logo">
                </div>
                <div class="header-text">
                    <h1 class="step-1">{{ setting('app_foundation_name') ?? '-' }}</h1>
                    <h2 class="step-2">{{ setting('app_school_name') ?? '-' }}</h2>
                    <h2 class="step-3">TERAKREDITASI "{{ setting('app_accreditation') ?? '-' }}"</h2>
                    <div class="header-info">
                        <p>NSS : {{ setting('app_nss') ?? '-' }} – NPSN : {{ setting('app_npsn') ?? '-' }}</p>
                        <p>Email : {{ setting('app_email') ?? '-' }}</p>
                        <p style="text-transform: uppercase;">{{ setting('app_village') ?? '-' }} -
                            {{ setting('app_district') ?? '-' }} -
                            {{ setting('app_city') ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="address-blue">
                Sekretariat : {{ setting('app_mailing_address') ?? '-' }} {{ setting('app_postal_code') ?? '-' }} –
                Telp : {{ setting('app_phone') ?? '-' }}
            </div>
        </div>

        <h2 class="title">SURAT KETERANGAN MUTASI TERIMA</h2>
        <p style="text-align: center; margin-top: 3px;">Nomor : {{ $transfer_in->number }}</p>
        <div class="content">
            <p>Yang bertandatangan di bawah ini Kepala Sekolah SMP Al Khairiyah Sumberlele Kraksaan Probolinggo dengan
                ini
                menerangkan dengan sebenarnya bahwa :</p>
            <table style="margin-left: 40px;">
                <tr class="text-capitalize">
                    <td width="150">Nama Siswa</td>
                    <td>: {{ $transfer_in->student_name }}</td>
                </tr>
                <tr class="text-capitalize">
                    <td>Tempat/ Tanggal Lahir</td>
                    <td>: {{ $transfer_in->birth_place }}, {{ formatDate($transfer_in->birth_date) }}</td>
                </tr>
                <tr class="text-capitalize">
                    <td>Jenis Kelamin</td>
                    <td>: {{ $transfer_in->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr class="text-capitalize">
                    <td>Agama</td>
                    <td>: {{ $transfer_in->religion }}</td>
                </tr>
                <tr class="text-capitalize">
                    <td>Kelas</td>
                    <td>: {{ $transfer_in->class }} SMP</td>
                </tr>
                <tr class="text-capitalize">
                    <td>Sekolah asal</td>
                    <td>: {{ $transfer_in->previous_school }}</td>
                </tr>
                <tr class="text-capitalize">
                    <td>Alamat siswa</td>
                    <td>: {{ $transfer_in->student_address }}</td>
                </tr>
            </table>
            <p>Dengan ini menyatakan menerima kepindahan siswa tersebut di lembaga kami :</p>
            <table style="margin-left: 40px;">
                <tr class="text-capitalize">
                    <td width="150">Nama</td>
                    <td>: SMP Al Khairiyah</td>
                </tr>
                <tr class="text-capitalize">
                    <td>Alamat</td>
                    <td>: {{ setting('app_address') ?? '-' }}</td>
                </tr>
            </table>
            <p>Kami bersedia menerima pindahan anak tersebut ke SMP Al Khairiyah dengan ketentuan sebagai berikut :</p>
            <ol style="margin-left: 20px;">
                <li>Menunjukkan surat mutasi</li>
                <li>NISN (Nomor Induk Siswa Nasional)</li>
                <li>Raport sesuai tingkat kelas yang diluduki</li>
            </ol>
            <p style="text-indent: 40px; margin-top: 20px;">Demikian surat keterangan ini kamut buat untuk dapat
                dipergunakan sebagaimana mestinya, atas perhatian dan kerja samanya kami sampaikan terimakasih.</p>
        </div>
        <div class="footer">
            <div style="width: max-content; margin-left: auto; text-align: center;">
                <p style="margin: 0; text-transform: capitalize;">{{ setting('app_village') ?? '-' }},
                    {{ formatDate(now()) }}</p>
                <p style="margin: 0 0 10px 0;">{{ setting('app_occupation') ?? '-' }}</p>
                <p style="margin: 0 0 10px 0;">{{ setting('app_school_name') ?? '-' }}</p>
                <img src="{{ setting('app_ttd') !== null ? asset('storage/' . setting('app_ttd')) : asset('assets/images/fake-ttd.png') }}"
                    alt="TTD" style="width: 85px;">
                <p style="text-decoration: underline; margin: 0; text-transform: uppercase;">
                    <strong>{{ setting('app_lead') ?? '-' }}</strong>
                </p>
            </div>
        </div>
    </main>
    <script>
        window.print();
    </script>
</body>

</html>
