<?php

namespace App\Http\Controllers\ghisonhatky;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Nhatkyphongmay;
use App\Models\TaiKhoan;
use App\Models\Hocky;
use App\Models\PhongKho;
use App\Models\Maymocthietbi;



class NhatKyPhongMayController extends Controller
{
    public function index()
    {
        $nhatkys = Nhatkyphongmay::with([
            'phong_kho',
            'taikhoan',
            'hocky'
        ])->get();
        $phongmays = PhongKho::all();
        $taikhoans = Taikhoan::all();
        $hockys = Hocky::all();
        $hockysCurrent = Hocky::where('current', 1)->first();
        // Logic to display the index view for NhatKyPhongMay
        return view('ghisonhatky.nhatkyphongmay.index', compact('nhatkys', 'phongmays', 'taikhoans', 'hockys', 'hockysCurrent'));
    }
    public function storeNew(Request $request)
    {
        try {
            $request->validate([
                'maphong' => 'exists:phong_khos,id',
                'mahocky' => 'exists:hockies,id',
                'nguoiduyet' => 'string|max:255',
                'ghichu' => 'string|max:255',
            ]);
            $nhatky = Nhatkyphongmay::create($request->all());
            return response()->json([
                'scuccess' => 'Thêm nhật ký thành công',
                'nhatky' => $nhatky
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating NhatKyPhongMay: ' . $e->getMessage());
            return response()->json([
                'error' => 'Đã xảy ra lỗi trong quá trình thêm nhật ký.',
            ], 500);
        }
    }
    public function storeOld(Request $request) {}
    public function edit($id)
    {
        // Logic to handle the editing of NhatKyPhongMay
        // Find the record by ID and return it for editing
        // Redirect or return response
    }
    public function update(Request $request, $id)
    {
        // Logic to handle the update of NhatKyPhongMay
        // Validate and update the data
        // Redirect or return response
    }
    public function destroy($id)
    {
        // Logic to handle the deletion of NhatKyPhongMay
        // Find the record by ID and delete it
        // Redirect or return response
    }
    public function getSoPhongById($idphong)
    {
        $count = Maymocthietbi::whereNotNull('somay')
            ->where('maphongkho', $idphong)
            ->count();
        return $count;
    }
    public function getGVQL($idphong)
    {
        try {
            $phong = PhongKho::with(['taikhoan'])->find($idphong);
            if ($phong) {
                $tengvql = $phong->taikhoan->hoten;
                if (!$tengvql) {
                    return null;
                }
                return $tengvql;
            }
        } catch (\Exception $e) {
            Log::error('Error fetching GVQL: ' . $e->getMessage());
            return null;
        }
    }
    public function searchPhongMay(Request $request)
    {
        $search = $request->input('q');
        // Log::info('Searching for phong: ' . $search);

        $result = PhongKho::where('maphong', 'LIKE', '%' . $search . '%')
            ->select('id', 'tenphong', 'maphong')
            ->limit(10)
            ->get();
        if ($result->isEmpty()) {
            return response()->json([
                "message" => 'Không tìm thấy'
            ]);
        }
        // Log::info('Found ' . count($result) . ' results');
        $response = array();
        foreach ($result as $phong) {
            $id = $phong->id;
            $tenphong = $phong->tenphong;
            $maphong = $phong->maphong;
            $count = $this->getSoPhongById($id);
            $tengvql = $this->getGVQL($id);
            $response[] = array(
                "id" => $id,
                "maphong" => $maphong,
                "tenphong" => $tenphong,
                "somay" => $count,
                "tengvql" => $tengvql,
            );
        }
        // Log::info('Response: ' . json_encode($response));
        return response()->json($response);
    }
    public function loadTable(Request $request)
    {
        $idphong = $request->input('idphong');
        $idhocky = $request->input('idhocky');
        $data = Nhatkyphongmay::with([
            'taikhoan',
        ])->where('maphong', $idphong)
            ->where('mahocky', $idhocky)->get();
        if ($data->isEmpty()) {
            return response()->json([
                "message" => 'Không có dữ liệu'
            ]);
        }
        return response()->json([
            'data' => $data
        ]);
    }
}
