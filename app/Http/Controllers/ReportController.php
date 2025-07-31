<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
     public function index()
    {
        $matches = Matches::with(relations: ['homeTeam', 'awayTeam','result','goals.player'])
            ->has('result')
            ->get();

        $reports = [];

        foreach ($matches as $match) {
            $homeGoals = $match->result->home_score;
            $awayGoals = $match->result->away_score;

            $status = 'Draw';
            if ($homeGoals > $awayGoals) {
                $status = 'Tim Home Menang';
            } elseif ($homeGoals < $awayGoals) {
                $status = 'Tim Away Menang';
            }

            // Hitung top scorer di match ini
            $topScorers = [];
            foreach ($match->goals as $goal) {
                $name = $goal->player->name ?? 'Unknown';
                $topScorers[$name] = ($topScorers[$name] ?? 0) + 1;
            }

            arsort($topScorers);
            $topScorerName = array_key_first($topScorers);
            $topScorerCount = $topScorers[$topScorerName] ?? 0;
            $topScorerDisplay = $topScorerCount > 0 ? "$topScorerName ($topScorerCount gol)" : null;

            // Akumulasi kemenangan tim
            $homeWins = Matches::where('home_team_id', $match->home_team_id)
                ->whereHas('result', fn ($q) => $q->whereColumn('home_score', '>', 'away_score'))
                ->count();

            $awayWins = Matches::where('away_team_id', $match->away_team_id)
                ->whereHas('result', fn ($q) => $q->whereColumn('away_score', '>', 'home_score'))
                ->count();

            $reports[] = [
                'match_id' => $match->id,
                'match_date' => $match->match_date,
                'home_team' => $match->homeTeam->name,
                'away_team' => $match->awayTeam->name,
                'final_score' => "{$homeGoals} - {$awayGoals}",
                'status' => $status,
                'top_scorer' => $topScorerDisplay,
                'total_home_wins' => $homeWins,
                'total_away_wins' => $awayWins
            ];
        }

        return response()->json($reports);
    }
}
