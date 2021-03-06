<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $record = Invitation::select(\DB::raw('invitations.id,guests.name,guests.no_telp,weddings.wedding_theme,weddings.wedding_time,weddings.wedding_date,invitations.status,invitations.realiaze_status'))
                        ->join('guests','guests.id','=','invitations.guest_id')
                        ->join('weddings','weddings.id','=','invitations.wedding_id')
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
                                <div class="text-muted text-size-small"><span class="text-semibold">'.Carbon::parse($data->wedding_time)->format('h:i A').'</span>
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
                    $uri_undangan = route('invitation.pdf',['id'=> $data->id]);
                    return '<a href="'.$uri_undangan.'" target="_blank"><i class="align-middle" data-feather="printer"></i>Cetak</a>';
                })
                ->rawColumns(['gabungan','judulundangan','konfirmasi','status','action'])
                ->make(true);
        }
        $title = 'Daftar Undangan Tamu/Peserta';
        $save_state = '';
        return view('undangan.index',compact('title','save_state'));
    }

    public function addUndangan(Request $request, $sistem_id)
    {
        if ($request->isMethod('get')){
            $invite  = new Invitation;
            $save_state = 'add';
            $title ="Undangan Baru";
            return view('undangan.form',compact('invite','save_state','title'));
            
        }else {
            $rules = [
                'wedding_id' => 'required',
                'guest_id' => 'required',
                'time_start' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
                ]);
                
            $peserta = new Invitation();
            $peserta->guest_id = $request->guest_id;
            $peserta->wedding_id = $request->wedding_id;
            $peserta->user_id = auth()->user()->id;
            $peserta->save();
            
            return response()->json([
                'fail' => false,
                'redirect_url' => route('invitation')
            ]);
        }
    }

    public function editUndangan(Request $request, $sistem_id, $id)
    {
        if ($request->isMethod('get')){
            $invite  = Invitation::find($id);
            $save_state = 'edit';
            $title ="Edit Undangan";
            return view('undangan.form',compact('invite','save_state','title'));
            
        }else {
            $rules = [
                'wedding_id' => 'required',
                'guest_id' => 'required',
                'time_start' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
                ]);
                
            $peserta = Invitation::find($id);
            $peserta->guest_id = $request->guest_id;
            $peserta->wedding_id = $request->wedding_id;
            $peserta->save();
            
            return response()->json([
                'fail' => false,
                'redirect_url' => route('invitation')
            ]);
        }
    }

    public function cetakUndangan(Request $request, $id)
    {
        $title = 'Cetak Undangan';
        $invitation = Invitation::with(['tamu','wedding'])->find($id);
        $undangan = nl2br("Nama : ".$invitation->tamu->name."\r\nAlamat : ".$invitation->tamu->alamat1."\r\nNo Telp : ".$invitation->tamu->no_telp);
        
        $params = [
            'title'  => $title,
            'invitation' => $invitation,
            'undangan' => $undangan,
        ];

        //return view('undangan.pdfs.undangan', $params);
        $pdf = PDF::loadView('undangan.pdfs.undangan', $params);
        return $pdf->inline('test.pdf');
    }
}
