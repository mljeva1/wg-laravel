<?php

namespace App\Http\Controllers;

use App\Services\PlayerService;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    protected $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function index()
    {
        try {
            // Dohvati top 20 igrača prema prosječnom XP-u po bitci
            $players = $this->playerService->getTopPlayersByRating('battle_avg_xp', 20);

            return view('dashboard', [
                'nickname' => Session::get('nickname'),
                'account_id' => Session::get('account_id'),
                'players' => $players,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}