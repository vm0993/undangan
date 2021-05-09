<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $record = Invitation::select(\DB::raw('invitations.id,guests.name,guests.no_telp,weddings.wedding_theme,weddings.wedding_time,weddings.wedding_date,invitations.status,invitations.realiaze_status'))
                        ->join('guests','guests.id','=','invitations.guest_id')
                        ->join('weddings','weddings.id','=','invitations.wedding_id')
                        ->where('realiaze_status',0)
                        ->get();

            return DataTables::of($record)
                ->addColumn('gabungan', function ($data) {
                    $uri_tamu = route('invitation.create',['sistem_id'=> 1]);
                    return '<div class="media-left">
                                <div class="media-body">
                                    <a href="#modalForm" data-href="'.$uri_tamu.'/'.$data->id.'/update" data-bs-toggle="modal" class="text-semibold">'.$data->name.'</a>
                                </div>
                                <div class="text-muted text-size-small"><span class="text-semibold">'.Carbon::parse($data->wedding_date)->format('d M Y').'</span>
                                </div>
                            </div>';
                })
                ->addColumn('judulundangan',function($data){
                    return '<div class="media-left">
                                <div class="media-body">
                                    <span class="text-blue-700 text-semibold">'.$data->wedding_theme.'</span>
                                </div>
                                <div class="text-muted text-size-small"><span class="text-semibold">'.Carbon::parse($data->wedding_time)->format('h:m:ss').'</span>
                                </div>
                            </div>';
                })
                ->addColumn('konfirmasi',function($data){
                    if($data->status==1){
                        return '<span class="badge bg-success">Konfirm Hadir</span>';
                    }elseif($data->status==2){
                        return '<span class="badge bg-info">Mungkin Hadir</span>';
                    }elseif($data->status==3){
                        return '<span class="badge bg-warning">Tidak Hadir</span>';
                    }else{
                        return '<span class="badge bg-primary">Belum Konfirm</span>';
                    }
                })
                ->editColumn('status',function($data){
                    if($data->realiaze_status==0){
                        return '<span class="badge bg-success">Belum Hadir</span>';
                    }else{
                        return '<span class="badge bg-warning">Sudah Hadir</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $uri_tamu = route('master.tamu.create',['sistem_id'=> 1]);
                    //$uri_add = route('kepesertaan.komda.mitra.create',['komda_id'=> $data->komda_id]);
                    return '<a href="javascript:void(0);" onclick="tamuHadir('.$data->id.');" data-id='.$data->id.' data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="Hapus Tamu">
                                <i class="align-middle" data-feather="trash"></i>Hadir</a>';
                })
                ->rawColumns(['gabungan','judulundangan','konfirmasi','status','action'])
                ->make(true);
        }

        return view('dashboard');
    }

    public function getHadir(Request $request, $id)
    {
        if($request->ajax()){
            $results = Invitation::find($id);
            $results->realiaze_status=1;
            $results->save();
        }
    }
}
