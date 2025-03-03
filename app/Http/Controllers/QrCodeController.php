<?php

namespace App\Http\Controllers;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{

    public function generate()
    {
        $user = Auth::user(); // Get authenticated user
        $url = route('friend.request', ['id' => $user->id]);

        // Generate the QR Code
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($url)
            ->size(300)
            ->margin(10)
            ->build();

        // Save QR Code
        $path = "qrcodes/user_{$user->id}.png";
        Storage::put("public/$path", $qrCode->getString());

        return response()->json([
            'qr_code_url' => asset("storage/$path")
        ]);
    }

}
