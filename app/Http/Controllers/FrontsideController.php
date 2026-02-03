<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\TransferIn;
use App\Models\TransferOut;
use App\Models\ActiveTeaching;
use Illuminate\Http\Request;

class FrontsideController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function faqSite()
    {
        return view('pages.faq.index');
    }

    public function letterSite()
    {
        return view('pages.letters.index');
    }

    public function changePasswordSite()
    {
        return view('pages.change-password');
    }

    public function publicView(Asset $asset)
    {
        // dd($asset);
        return view('pages.public-view', compact('asset'));
    }

    /**
     * Verify electronic signature by QR code
     */
    public function verifySignature($id, $type)
    {
        $letter = null;
        $letterType = '';

        switch ($type) {
            case 'transfer-in':
                $letter = TransferIn::findOrFail($id);
                $letterType = 'Surat Keterangan Mutasi Terima';
                break;
            case 'transfer-out':
                $letter = TransferOut::findOrFail($id);
                $letterType = 'Surat Keterangan Mutasi Keluar';
                break;
            case 'active-teaching':
                $letter = ActiveTeaching::findOrFail($id);
                $letterType = 'Surat Keterangan Aktif Mengajar';
                break;
            default:
                abort(404);
        }

        // Check if letter has been signed
        if (!$letter->signed_at || !$letter->signer_name) {
            abort(404, 'Signature not found');
        }

        return view('pages.verify-signature', compact('letter', 'letterType', 'type'));
    }
}
