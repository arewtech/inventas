<?php
function formatDate($date)
{
    $value = Carbon\Carbon::parse($date);
    $parse = $value->locale('id');
    return $parse->translatedFormat('d F Y');
}
function formatDateSlash($date)
{
    $value = Carbon\Carbon::parse($date);
    $parse = $value->locale('id');
    return $parse->translatedFormat('d/m/y');
}

// Thursday, 18 July 2024
function formatDateFull($date)
{
    $value = Carbon\Carbon::parse($date);
    $parse = $value->locale('id');
    return $parse->translatedFormat('l, d F Y | H:i');
}

function getBorrowingColors($status)
    {
        switch ($status) {
            case "borrowed":
                return "bg-warning-subtle text-warning";
            case "returned":
                return "bg-success-subtle text-success";
            default:
                return "bg-danger-subtle text-danger";
        }
    }
function getBorrowingStatuses($status)
    {
        switch ($status) {
            case "borrowed":
                return "Dipinjam";
            case "returned":
                return "Dikembalikan";
            default:
                return "Hilang";
        }
    }

function listSchoolLocations()
{
    return [
        'Ruang Kelas 1',
        'Ruang Kelas 2',
        'Ruang Kelas 3',
        'Ruang Kantor Kepala Sekolah',
        'Ruang Guru',
        'Ruang Laboratorium',
        'Ruang Komputer',
        'Ruang Perpustakaan',
        'Ruang UKS',
        'Ruang Olahraga',
        'Ruang Asrama',
        'Ruang Aset',
    ];
}
// namespace App\Helpers;
function letterName($letterName = null) {
    $letters = [
        'transfer_in' => 'Surat Keterangan Mutasi Terima',
        'transfer_out' => 'Surat Keterangan Mutasi Keluar',
        'active_teaching' => 'Surat Keterangan Aktif Mengajar',
    ];

    if ($letterName === null) {
        return $letters;
    }

    return $letters[$letterName] ?? 'Surat Keterangan';
}
function formatIcon($icon)
{
    switch ($icon) {
        case 'transfer_in':
            return '📥';
        case 'transfer_out':
            return '📤';
        case 'active_teaching':
            return '📚';

        default:
            return '❓';
    }
}
function getDestroyRoute($type, $id)
    {
        $routes = [
            'transfer_in' => 'transfer-in-sites.destroy',
            'transfer_out' => 'transfer-out-sites.destroy',
            'active_teaching' => 'active-teaching-sites.destroy',
            // Tambahkan jenis surat lainnya di sini
        ];

    return route($routes[$type] ?? 'home', $id);
}

function getPrintRoute($type, $id)
{
    $routes = [
        'transfer_in' => 'letters.transfer-ins.print',
        'transfer_out' => 'letters.transfer-outs.print',
        'active_teaching' => 'letters.active-teachings.print',
        // Tambahkan jenis surat lainnya di sini
    ];

    return route($routes[$type] ?? 'home', $id);
}
