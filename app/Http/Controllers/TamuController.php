<?php

namespace App\Http\Controllers;

use App\Imports\TamuImport;
use Excel;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TamuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tamuUpload(Request $request)
    {
        if ($request->isMethod('get')){
            $guests = new Guest();
            $params = [
                'title' => 'Upload Daftar Peserta',
                'guests' => $guests,
            ];

            return view('guests.import')->with($params);
        }else {
            $rules = [
                'lokasi_file' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors()
                ]);
            
            Excel::import(new TamuImport(),request()->file('lokasi_file'));
            
            return response()->json([
                'fail' => false,
                'redirect_url' => url('master/tamu')
            ]);
        }
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $record = Guest::all();

            return DataTables::of($record)
                ->addColumn('gabungan', function ($data) {
                    $uri_tamu = route('master.tamu.create',['sistem_id'=> 1]);
                    return '<div class="media-left">
                                <div class="media-body">
                                    <a href="#modalForm" data-href="'.$uri_tamu.'/'.$data->id.'/update" data-bs-toggle="modal" class="text-semibold">'.$data->name.'</a>
                                </div>
                            </div>';
                })
                ->addColumn('address',function($data){
                    return '<div class="media-left">
                                <div class="media-body">
                                    <span class="text-blue-700 text-semibold">'.$data->alamat1.'</span>
                                </div>
                                <div class="text-muted text-size-small"><span class="text-semibold">'.$data->alamat2.'</span>
                                </div>
                            </div>';
                })
                ->addColumn('phone',function($data){
                    return '<div class="media-left">
                                <div class="media-body">
                                    <span class="text-blue-700 text-semibold">'.$data->no_telp.'</span>
                                </div>
                                <div class="text-muted text-size-small"><span class="text-semibold">'.$data->email.'</span>
                                </div>
                            </div>';
                })
                ->editColumn('status',function($data){
                    if($data->status==0){
                        return '<span class="badge bg-success">Aktif</span>';
                    }else{
                        return '<span class="badge bg-warning">Tidak Aktif</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $uri_tamu = route('master.tamu.create',['sistem_id'=> 1]);
                    //$uri_add = route('kepesertaan.komda.mitra.create',['komda_id'=> $data->komda_id]);
                    return '<a href="#" data-id='.$data->id.' data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="Hapus Tamu">
                                <i class="align-middle" data-feather="trash"></i></a>';
                })
                ->rawColumns(['gabungan','address','phone','status','action'])
                ->make(true);
        }
        $title = 'Daftar Tamu/Peserta';
        $save_state = '';
        return view('guests.index',compact('title','save_state'));
    }

    public function addTamu(Request $request, $sistem_id)
    {
        if ($request->isMethod('get')){
            $tamu  = new Guest;
            $save_state = 'add';
            $title ="Tamu/Peserta Baru";
            return view('guests.form',compact('tamu','save_state','title'));
            
        }else {
            $rules = [
                'name' => 'required',
                'alamat1' => 'required',
                'no_telp' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
                ]);
                
            $peserta = new Guest();
            $peserta->name = $request->name;
            $peserta->alamat1 = $request->alamat1;
            $peserta->alamat2 = $request->alamat2;
            $peserta->alamat3 = $request->alamat3;
            $peserta->no_telp = $request->no_telp;
            $peserta->email = $request->email;
            $peserta->keterangan = $request->keterangan;
            $peserta->user_id = auth()->user()->id;
            $peserta->save();
            
            return response()->json([
                'fail' => false,
                'redirect_url' => route('master.tamu')
            ]);
        }
    }

    public function editTamu(Request $request, $sistem_id, $id)
    {
        if ($request->isMethod('get')){
           
            $tamu  = Guest::find($id);
            $save_state = 'edit';
            $title ="Edit Tamu/Peserta";
            return view('guests.form',compact('tamu','save_state','title'));
            
        }else {
            $rules = [
                'name' => 'required',
                'alamat1' => 'required',
                'no_telp' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
                ]);
                
            $peserta = Guest::find($id);
            $peserta->name = $request->name;
            $peserta->alamat1 = $request->alamat1;
            $peserta->alamat2 = $request->alamat2;
            $peserta->alamat3 = $request->alamat3;
            $peserta->no_telp = $request->no_telp;
            $peserta->email = $request->email;
            $peserta->keterangan = $request->keterangan;
            $peserta->save();
            
            return response()->json([
                'fail' => false,
                'redirect_url' => route('master.tamu')
            ]);
        }
    }
}
