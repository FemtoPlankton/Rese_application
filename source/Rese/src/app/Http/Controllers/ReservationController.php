<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Jobs\DeleteReservation;
use App\Http\Requests\ReservationRequest;
use App\Jobs\GenerateReservationToken;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|integer|min:1',
        ]);

        if ($data['date'] <= now()->toDateString()) {
            return redirect()->route('errors')->with('message', '過去や今日の日付の予約はできません');
        }

        $user = auth()->user();

        $reservation = $user->reservations()->create([
            'restaurant_id' => $request->restaurant_id,
            'date' => $data['date'],
            'time' => $data['time'],
            'number' => $data['number'],
        ]);

        // 予約日が今日の場合
        $reservationDate = Carbon::createFromFormat('Y-m-d', $data['date']);
        if ($reservationDate->isToday()) {
            // 予約が当日であればトークンを発行
            GenerateReservationToken::dispatch($reservation);
        }

        return redirect()->route('success')->with('message', 'ご予約ありがとうございます');
    }

    public function getReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        return response()->json($reservation);
    }

    public function update(ReservationRequest $request, $id)
    {
        // フォームリクエストから入力データを取得
        $requestData = $request->only(['date', 'time', 'number']);

        // データベースから対象の予約を取得
        $reservation = Reservation::findOrFail($id);

        // 予約データを更新
        $reservation->update($requestData);

        // メッセージをセッションに保存
        Session::flash('success', '予約を更新しました');

        // セッションからメッセージを取得
        $sessionMessage = Session::get('success') ?? Session::get('error') ?? null;

        // 成功した場合のリダイレクト先を指定
        return redirect()->route('mypage.index')->with('success', $sessionMessage);
    }

    public function cancel($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        logger('DeleteReservation job dispatched for reservation ID: ' . $reservation->id);

        $reservation->delete();

        DeleteReservation::dispatch($reservation)->delay(now()->addMinute(5));

        return response()->json(['message' => '予約は5分後にキャンセルされます']);
    }

    public function restore($reservationId)
    {
        $reservation = Reservation::withTrashed()->findOrFail($reservationId);
        $reservation->restore();
        $reservation->save();
    }
}
