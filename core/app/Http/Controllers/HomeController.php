<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\pasien;
use App\suratkontrol;

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
    public function index()
    {
        $pasien = Pasien::get();
        return view('home', compact('pasien'));
    }

    public function dataPasien()
    {
        $pasien = Pasien::get();
        return datatables()->of($pasien)->toJson();
    }

    public function showSurat()
    {
        $surat = DB::table('surat_kontrol')
            ->orderBy('id','desc')
            ->skip(0)
            ->take(50)
            ->get();
        return view('surat', compact('surat'));
    }

    public function showSuratV(Request $request){
        if($request->input('item_id')==""){
            $surat = DB::table('surat_kontrol')
            ->orderBy('id','desc')
            ->skip(0)
            ->take(50)
            ->get();
        }else{
            $key = ltrim($request->input('item_id'),'0');
            $surat = DB::table('surat_kontrol')
                ->whereRaw("no_rm like '%$key%' or no_surat like '%$key%' ")
                ->get();
        }
        return view('vsurat', compact('surat'));
    }

    public function dataSurat()
    {
        $surat = Suratkontrol::get();
        return datatables()->of($surat)->toJson();
    }

    public function detail($id){
        $info = Pasien::find($id);
        
        //exception null content
        if(is_null($info)){
            abort(404);
        }
        
        $pasien = DB::table('pasien')
        ->join('surat_kontrol', 'pasien.no_rm', '=', 'surat_kontrol.no_rm')
        ->where('pasien.no_rm','=',$id)
        ->get();
        return view('detail', [
            'pasien'=>$pasien,
            'info'=>$info
        ]);
    }

    public function add(){
        $surat = Suratkontrol::orderBy('id', 'DESC')->first();
        $nosurat = explode('/',$surat->no_surat);
        $nosuratNow = $nosurat[2]+1;
        $date = date("my");
        $arrySurat = array("RSOP",$date,sprintf("%06s",$nosuratNow));
        $nosurat = implode('/',$arrySurat);

        return view('add', ['nosurat'=>$nosurat]);
    }

    public function autofill(){
        $id = $_GET['no'];

        $filled = DB::table('surat_kontrol')
        ->join('pasien', 'pasien.no_rm', '=', 'surat_kontrol.no_rm')
        ->where('surat_kontrol.no_rujukan','=',$id)
        ->first();
        
        $json = json_encode($filled);
        return $json;
    }

    public function addStore(Request $request){
        $surat = request()->validate([
            'no_surat' => ['required','min:5'],
            'norujukan' => ['required','min:3'],
            'tgl_rujukan' => ['required'],
            'no_rm' => ['required','min:5'],
            'nama_pasien' => ['required','min:5'],
            'no_kartu' =>['required','min:5']
        ]);
        $no = explode('/',$request->no_surat);
        
        $dbPasien = pasien::where('no_rm','=',$request->no_rm)
        ->get();

        if(is_null($dbPasien)){
            $pasien = new Pasien;
            $pasien->no_rm = $request->no_rm;
            $pasien->nama_pasien = $request->nama_pasien;

            $pasien->save();

            $suratkontrol = new Suratkontrol;
            $suratkontrol->no_surat = $request->no_surat;
            $suratkontrol->no_rujukan = $request->norujukan;
            $suratkontrol->tanggal = $request->tgl_rujukan;
            $suratkontrol->kunjungan = $request->tgl_kunjungan;
            $suratkontrol->no_rm = $request->no_rm;
            $suratkontrol->no_kartu = $request->no_kartu;

            $suratkontrol->save();

            return  redirect('/add')->with('message', 'Sukses menambahkan..');

        }else{
        $db = suratkontrol::where('no_surat','like','%'.$no[2].'%')
        ->first();

        if(is_null($db)){
            $suratkontrol = new Suratkontrol;
            $suratkontrol->no_surat = $request->no_surat;
            $suratkontrol->no_rujukan = $request->norujukan;
            $suratkontrol->tanggal = $request->tgl_rujukan;
            $suratkontrol->kunjungan = $request->tgl_kunjungan;
            $suratkontrol->no_rm = $request->no_rm;
            $suratkontrol->no_kartu = $request->no_kartu;

            $suratkontrol->save();
            return  redirect('/add')->with('message', 'Sukses menambahkan..');
            
        }else{
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'no_surat' => ['Nomor surat medis ganda..']
             ]);
             throw $error;
        }
        }        

    }
    
    public function deleteSurat($id){
        $surat = suratkontrol::find($id);
        if($surat->delete()){
            return redirect('/detail/'.$surat->no_rm)->with('message', 'Sukses menghapus..');
        }else{
            return redirect('/detail/'.$surat->no_rm)->with('messageF', 'Gagal menghapus..');
        }
    }

    public function v_edit_surat($id){
        $surat = suratkontrol::find($id);

        return view('ubah_surat', compact('surat'), ['id'=>$id]);
    }

    public function p_edit_surat(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'norujukan' => 'required|min:3',
            'tgl_rujukan' => 'required',
            'no_rm' => 'required|min:5|numeric',
            'no_kartu' =>'required|min:5|numeric'
        ]);

        if ($validator->fails()) {
            return redirect('edit/surat/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $surat = suratkontrol::find($id)->first();
        $surat->kunjungan = $request->tgl_kunjungan;
        $surat->no_rujukan = $request->norujukan;
        $surat->tanggal = $request->tgl_rujukan;
        $surat->no_rm = $request->no_rm;
        $surat->no_kartu = $request->no_kartu;

        try {
            $surat->save();
            return redirect('/detail/'.$request->no_rm)->with('message', 'Sukses mengubah..');
        } catch (Exception $e) {
            abort(404);
        }
    }
}
