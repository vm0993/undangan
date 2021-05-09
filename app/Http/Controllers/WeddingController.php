<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class WeddingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $record = Wedding::all();

            return DataTables::of($record)
                ->addColumn('gabungan', function ($data) {
                    $uri_tamu = route('weddings.create',['sistem_id'=> 1]);
                    return '<div class="media-left">
                                <div class="media-body">
                                    <a href="#modalForm" data-href="'.$uri_tamu.'/'.$data->id.'/update" data-bs-toggle="modal" class="text-semibold">'.$data->pengantin_pria.'</a>
                                </div>
                                <div class="text-muted text-size-small"><span class="text-semibold">'.$data->pengantin_wanita.'</span>
                                </div>
                            </div>';
                })
                ->addColumn('tanggal',function($data){
                    return '<div class="media-left">
                                <div class="media-body">
                                    <span class="text-blue-700 text-semibold">'.$data->wedding_theme.'</span>
                                </div>
                                <div class="text-muted text-size-small"><span class="text-semibold">'.Carbon::parse($data->wedding_date)->format('d M Y').' - '.Carbon::parse($data->wedding_time)->format('H:i A').'</span>
                                </div>
                            </div>';
                })
                ->editColumn('status',function($data){
                    if($data->status==0){
                        return '<span class="badge bg-success">Aktif</span>';
                    }else{
                        return '<span class="badge bg-warning">Sudah Terlaksana</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $uri_tamu = route('master.tamu.create',['sistem_id'=> 1]);
                    return '<a href="#"><i class="align-middle" data-feather="printer"></i>Cetak Undangan</a>';
                })
                ->rawColumns(['gabungan','tanggal','status','action'])
                ->make(true);
        }
        $title = 'Daftar Acara';
        $save_state = '';
        return view('weddings.index',compact('title','save_state'));
    }

    public function addAcara(Request $request, $sistem_id)
    {
        if ($request->isMethod('get')){
            $invite  = new Wedding;
            $save_state = 'add';
            $title ="Pernikahan Baru";
            return view('weddings.wedding',compact('invite','save_state','title'));
            
        }else {
            $rules = [
                'pengantin_pria' => 'required',
                'pengantin_wanita' => 'required',
                'wedding_date' => 'required',
                'wedding_time' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
                ]);
                
            $peserta = new Wedding();
            $peserta->pengantin_pria = $request->pengantin_pria;
            $peserta->pengantin_wanita = $request->pengantin_wanita;
            $peserta->wedding_date = $request->wedding_date;
            $peserta->wedding_time = $request->wedding_time;
            $peserta->wedding_theme = $request->wedding_theme;
            $peserta->save();
            
            return response()->json([
                'fail' => false,
                'redirect_url' => route('weddings')
            ]);
        }
    }

    public function editAcara(Request $request, $sistem_id, $id)
    {
        if ($request->isMethod('get')){
           
            $invite  = Wedding::find($id);
            $save_state = 'edit';
            $title ="Edit Acara";
            return view('weddings.wedding',compact('invite','save_state','title'));
            
        }else {
            $rules = [
                'pengantin_pria' => 'required',
                'pengantin_wanita' => 'required',
                'wedding_date' => 'required',
                'wedding_time' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
                ]);
                
            $peserta = Wedding::find($id);
            $peserta->pengantin_pria = $request->pengantin_pria;
            $peserta->pengantin_wanita = $request->pengantin_wanita;
            $peserta->wedding_date = $request->wedding_date;
            $peserta->wedding_time = $request->wedding_time;
            $peserta->wedding_theme = $request->wedding_theme;
            $peserta->save();
            
            return response()->json([
                'fail' => false,
                'redirect_url' => route('invitation')
            ]);
        }
    }
}
