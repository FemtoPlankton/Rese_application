<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Reservation;

class QRCodeController extends Controller
{
    public function generateQRCode($reservationId)
    {
        // 予約情報を取得する処理
        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            // 予約が見つからない場合のエラーハンドリング
            return response()->json(['error' => 'Reservation not found'], 404);
        }

        // QRコードのコンテンツを予約情報から生成する
        $url = route('authentication.reading', ['reservationId' => $reservation->id, 'token' => $reservation->token]);

        // QRコードを生成
        $qrCode = QrCode::size(200)->generate($url);

        // viewにQRコードを渡して表示
        return view('qrcode',['qrCode' => $qrCode]);
    }

    public function readQRCode($reservationId)
    {
        return view('authenticate-reading');
    }
}
