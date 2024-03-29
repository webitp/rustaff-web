<?php

namespace App\Http\Controllers;

use xPaw\SourceQuery\SourceQuery;
use Illuminate\Http\Request;

class ServersController extends Controller
{
    public function get(Request $request)
    {
        $sq_ip = $request->ip;
        $sq_port = $request->port;
        $sq_timeout = 1;
        $sq_engine = SourceQuery::SOURCE;

        $query = new SourceQuery();

        try
        {
            $query->Connect($sq_ip, $sq_port, $sq_timeout, $sq_engine);

            return response()->json([
                'server' => $query->GetInfo(),
            ], 200);
        }
        catch (Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ], 200);
        }

        $query->Disconnect();
    }

    public function rcon(Request $request)
    {
        $sq_ip = '37.46.129.24';
        $sq_port = 28015;
        $sq_timeout = 1;
        $sq_engine = SourceQuery::SOURCE;

        $query = new SourceQuery();

        try
        {
            $query->Connect($sq_ip, $sq_port, $sq_timeout, $sq_engine);

            $query->SetRconPassword('daAs2Sf91F');
            $data = $query->GetInfo();
            $query->Disconnect();

            return response()->json($data, 200);
        }
        catch (Exception $e)
        {
            $query->Disconnect();
            return response()->json([
                'error' => $e->getMessage()
            ], 200);
        }
    }
}
