<?php

namespace App\Http\Controllers;

use Exception;
use App\Jobs\RunCommand;
use App\Events\PublicCommandRun;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CommandController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
    }

    /**
     * Dispatches a command to be run.
     *
     * @param int $id Command ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function run(int $id): JsonResponse
    {
        try {
            broadcast(new PublicCommandRun($id));
            RunCommand::dispatch(Auth::id(), $id);

            return response()->json([]);
        } catch (Exception $e) {
            logger()->error($e);

            return response()->json(
                [
                    'error' => $e->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
