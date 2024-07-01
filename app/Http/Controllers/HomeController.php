<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Guest;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $activeYearId = Year::where('year_current', 'selected')->value('id');
        $years = Year::orderBy("updated_at", "DESC")->get();

        // Statistik jumlah tamu berdasarkan waktu
        $totalGuests = Guest::count();
        $totalGuestsToday = Guest::whereDate("tgl_kunjungan", Carbon::today())
                                    ->where('year_id', $activeYearId)
                                    ->count();
        $totalGuestsMonth = Guest::whereMonth('tgl_kunjungan', Carbon::now()->month)
                                    ->where('year_id', $activeYearId)
                                    ->count();
        $totalGuestsPeriod = Guest::where('year_id', $activeYearId)->count();

        // Daftar tamu terbaru
        $recentGuest = Guest::where('year_id', $activeYearId)
                                ->latest('tgl_kunjungan')->take(5)->get();

        return view('adminpage.home', [
            'years' => $years,
            'totalGuests' => $totalGuests,
            'totalGuestsToday' => $totalGuestsToday,
            'totalGuestsMonth' => $totalGuestsMonth,
            'totalGuestsPeriod' => $totalGuestsPeriod,
            'recentGuest' => $recentGuest,
        ]);
    }
}
