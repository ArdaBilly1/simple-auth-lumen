<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\User;

class AssetController extends Controller
{
    public function index($id)
    {
        $user = User::where("id", $id)->first();
        if (!$user) {
            $out = [
                "message" => "failed",
                "code"    => 401
            ];
            return response()->json($out, $out['code']);
        }
        if ($user->role == 1) {
            $asset = Asset::all();
        }
        else{
            $asset = Asset::find($id);
        }


        // $asset = Asset::all();
        return response()->json($asset);

    }
    public function create()
    {
        
    }

    public function update($id, $id1, Request $request)
    {
    //    $id yaitu data id dari aset
    //    $id1 yaitu data id dari user
   
          $asset = Asset::find($id);
          $user = User::find($id1);

          if (!$user) {
            $out = [
                "message" => "failed",
                "code"    => 401
            ];
            return response()->json($out, $out['code']);
        }

        if ($user->role == 1) {
            $asset->update($request->all());
            $msg = [
                'success' => true,
                'message' => 'Data Asset berhasil di ubah1'
            ];
            return response()->json($msg);
        }
        if ($user->id == $asset->id_user) {
            $asset->update($request->all());
            $msg = [
                'success' => true,
                'message' => 'Data Asset berhasil di ubah1'
            ];
            return response()->json($msg);
        }
        else {
            $msg = [
                'success' => false,
                'message' => 'Data Asset tidak dapat diubah'
            ];
            return response()->json($msg);
        }

        
   
   
    }

    public function store(Request $request)
    {
        Asset::create($request->all());
        $msg = [
            'success' => true,
            'message' => 'Asset berhasil dibuat!'
        ];
        return response()->json($msg);
        // return 'Data berhasil Ditambahkan';
    }

    
    public function show($id)
    {
        $asset = Asset::find($id);
        return $asset->toJson();
    }



    public function delete($id, $id1)
    {
        $asset = Asset::find($id);
        $user = User::find($id1);

        if (!$user) {
            $out = [
                "message" => "failed",
                "code"    => 401
            ];
            return response()->json($out, $out['code']);
        }

        if ($user->role == 1) {
            if(!empty($asset)){
                $asset->delete();
                $msg = [
                    'success' => true,
                    'message' => 'Asset Berhasil Dihapus!'
                ];
                return response()->json($msg);
            } else {
                $msg = [
                    'success' => false,
                    'message' => 'Asset gagal dihapus!'
                ];
                return response()->json($msg);
            }
        }
        if ($asset->id_user == $id1) {
            if(!empty($asset)){
                $asset->delete();
                $msg = [
                    'success' => true,
                    'message' => 'Asset Berhasil Dihapus!'
                ];
                return response()->json($msg);
            } else {
                $msg = [
                    'success' => false,
                    'message' => 'Asset gagal dihapus!'
                ];
                return response()->json($msg);
            }
        }
        else {
            $msg = [
                'success' => false,
                'message' => 'Asset gagal dihapus!'
            ];
            return response()->json($msg);
        }

        // return 'data dengan id '.$id.' berhasil dihapus dihapus';
    }
}
