<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function scheduleAdd(Request $request)
    {
        // バリデーション設定。
        $request->validate([
            'start_date' => 'required|integer', // 必須。integer型。
            'end_date' => 'required|integer', // 必須。integer型。
            'event_name' => 'required|max:32', // 必須。最大32文字
        ]);

                // 登録処理
        $schedule = new Schedule;
        // 日付に変換。JavaScriptのタイムスタンプはミリ秒なので秒に変換
        $schedule->start_date = date('Y-m-d H:i:s', $request->input('start_date') / 1000);
        $schedule->end_date = date('Y-m-d H:i:s', $request->input('end_date') / 1000);
        $schedule->event_name = $request->input('event_name');
        $schedule->user_id = Auth::id(); // ログインユーザーのIDを設定
        $schedule->save();

        return;
    }


    public function scheduleGet(Request $request)
    {
        // バリデーション
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer'
        ]);

        // カレンダー表示期間
        // JSから送られてきた形式を下記で利用できる用に変形している
        $start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $end_date = date('Y-m-d', $request->input('end_date') / 1000);

        // 取得処理
        $schedules = Schedule::select(
            // FullCalendarの形式に合わせる
                'start_date as start',
                'end_date as end',
                'event_name as title'
            )
            // FullCalendarの表示範囲のみ表示
            ->where('end_date', '>', $start_date)
            ->where('start_date', '<', $end_date)
            ->where('user_id', Auth::id()) // ログインユーザーのスケジュールのみ取得
            ->get();

        // 終日の予定を判別して変換
        $schedules = $schedules->map(function ($event) {
            $startDate = new \DateTime($event->start);
            $endDate = new \DateTime($event->end);

            if ($startDate->format('H:i:s') === '00:00:00' && $endDate->format('H:i:s') === '00:00:00') {
                $event->start = $startDate->format('Y-m-d');
                $event->end = $endDate->format('Y-m-d');
            }

            return $event;
        });

        return $schedules;
    }

    /**
     * 予定一覧画面
     */
    public function scheduleList()
    {
        $schedules = Schedule::where('user_id', Auth::id())->orderBy('start_date', 'asc')->get();
        return view('schedule-list', ['schedules' => $schedules]);
    }

    public function show($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('schedule-show', ['schedule' => $schedule]);
    }

    public function destroy($id)
    {
        // showメソッドと同じ。Scheduleからひとつ抜き出す。
        $schedule = Schedule::findOrFail($id);

        // delete()で文字通り削除。
        $schedule->delete();

        // 'schedule-list'にリダイレクト。'schedule-list'はrouteでつけた「あだ名」の部分です。
        return redirect()->route('schedule-list');
    }

    // ⭐️ 修正画面表示 追加。
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('schedule-edit', ['schedule' => $schedule]);
    }

    // ⭐️追加
    public function update(Request $request, $id)
    {
        // ブラウザから送られる内容 = formのinputの内容に対してバリデーションの処理
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'event_name' => 'required|max:32',
            'details' => 'nullable|string|max:1024',
        ]);

        // URLで与えられたIDでスケジュールを検索
        $schedule = Schedule::findOrFail($id);

        //
        $schedule->start_date = $request->input('start_date');
        $schedule->end_date = $request->input('end_date');
        $schedule->event_name = $request->input('event_name');
        $schedule->details = $request->input('details');
        $schedule->save();

        return redirect()->route('schedules.show', $schedule->id);
    }
}
