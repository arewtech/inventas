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
