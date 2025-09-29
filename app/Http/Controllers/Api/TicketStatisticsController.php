<?php

namespace App\Http\Controllers\Api;

use App\Actions\GetTicketStatistics;
use App\Http\Controllers\Controller;

class TicketStatisticsController extends Controller
{
	public function index(GetTicketStatistics $stats)
	{
		return response()->json($stats->handle());
	}
}
