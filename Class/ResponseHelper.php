<?php


class ResponseHelper
{

    public static function select($data = null)
    {
        return response()->json(['status' => 'OK', 'data' => $data], 220);
    }

    public static function insert($data = null)
    {
        return response()->json(['status' => 'OK', 'data' => $data], 230);
    }

    public static function update($data = null)
    {
        return response()->json(['status' => 'OK', 'data' => $data], 240);
    }

    public static function delete($msg = "Deleted Successfully")
    {
        return response()->json(['status' => 'OK', 'msg' => $msg], 250);
    }

    public static function MissingParameter($msg = "Missing Required Param")
    {
        return response()->json(['status' => 'ERROR', 'msg' => $msg], 400);
    }

    public static function DataNotFound($msg = "Data Not Found")
    {
        return response()->json(['status' => 'ERROR', 'msg' => $msg], 410);
    }

    public static function AlreadyExists($msg = "Already Exists")
    {
        return response()->json(['status' => 'ERROR', 'msg' => $msg], 420);
    }

    public static function authenticationFail($msg = "Not Authenticated")
    {
        return response()->json(['status' => 'ERROR', 'msg' => $msg], 430);
    }

    public static function authorizationFail($msg = "Not Authorized")
    {
        return response()->json(['status' => 'ERROR', 'msg' => $msg], 440);
    }

    public static function invalidData($msg = "Invalid Data")
    {
        return response()->json(['status' => 'ERROR', 'msg' => $msg], 460);
    }

    public static function operationFail($msg = "Operation Fail")
    {
        return response()->json(['status' => 'ERROR', 'msg' => $msg], 510);
    }
}
