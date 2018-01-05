<?php

namespace App\Http\Controllers\art\obra;

use App\Http\Requests\CreateArtWorks;
use App\Http\Requests\CreatePdfFile;
use App\Http\Requests\EditArtworks;
use App\Models\SysModel\SysArtista;
use App\Models\SysModel\SysObraFile;
use App\Models\SysModel\SysUbicaciones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Models\SysModel\SysObra;
use Illuminate\Support\Facades\Auth;
use App\Models\CoreModel\CoreProfile;
use App\Models\CoreModel\CoreModule;
use App\Helpers\SystemCatchLog\LogSystem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Barryvdh\DomPDF\Facade as PDF;



class ObraController extends Controller
{
    private $idmodulo = 6; /* Defined by the databases table CoreModule */

    public function ObraIndex()
    {
        try{

            /* Menu */
            $modules  = User::find(Auth::id())->profile->module;


            /*echo "Usuario = ".$user."<br>";
            echo "Perfil = ".$profile."<br>";
            echo "Modulos = ".$modules."<br>";*/
            foreach($modules as $a)
            {

                if($a->id == $this->idmodulo) /* Is allowed to see this Module */
                {
                    /*echo "ID = ".$a->id. "<br>";
                    echo "IdC = ". $this->idmodulo. "<br>";*/
                    if($a->pivot->rread > 0 or $a->pivot->eedit > 0 or $a->pivot->wwrite > 0 or $a->pivot->ddelete > 0)
                    {
                        /* Content */

                        /*echo "<br>Read = ".$a->pivot->rread;
                        echo "<br>Write  = ".$a->pivot->wwrite;
                        echo "<br>Edit   = ".$a->pivot->eedit;
                        echo "<br>Delete = ".$a->pivot->ddelete;*/
                        //$logs = CoreLog::orderBy('fecha', 'desc')->paginate(15);
                        $pro = SysObra::orderBy('id', 'desc')->paginate(10);

                        $location = SysUbicaciones::pluck('name','id');
                        //$artists = SysArtista::all()->pluck('full_name', 'id');
                        $artists = SysArtista::orderBy('apellido', 'asc')->get();
                        $artists = $artists->pluck('full_name', 'id');
                        /* Se tiene que hace all()->plunck() y no lunck() directamente, ya que para
                           poder ejecutar la funciuon(full_name) necesita tenern los datos en memoria */


                        //Debugbar::info($object);
                        //Debugbar::error('Error!');
                        //Debugbar::warning('Watch out…');
                        //Debugbar::addMessage('Another message', 'mylabel');

                        return view('art.obra.index')
                            ->with('modulos', $modules) //Modulos
                            ->with('xmod', $a) //Permisos
                            ->with('obras', $pro)
                            ->with('location', $location)
                            ->with('artist', $artists);
                    }
                }
            }
            Session::flash('msg_access', 'Obras');
            return redirect("admin/index"); /* If he dont have access redirect to the Index*/
        }
        catch(\Exception $e)
        {
            LogSystem::writeLog("ExcepcionM : " . $e->getMessage() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionF : " . $e->getFile() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionL : " . $e->getLine() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionT : " . $e->getTraceAsString() . " ", Auth::id());
            Session::flash('msg_access2', $e);
            return redirect("admin/index");
        }

    }


    public function ObraEditIndex($id, $opc, $search, $opc2, $xid)
    {
        try{
            /* OPC = Control de Procedencia siempre */
            /* OPC2 = Control de Procedencia para paa la pagina search */
            /* Menu */
            $modules  = User::find(Auth::id())->profile->module;


            /*echo "Usuario = ".$user."<br>";
            echo "Perfil = ".$profile."<br>";
            echo "Modulos = ".$modules."<br>";*/
            foreach($modules as $a)
            {

                if($a->id == $this->idmodulo) /* Is allowed to see this Module */
                {
                    /*echo "ID = ".$a->id. "<br>";
                    echo "IdC = ". $this->idmodulo. "<br>";*/
                    if($a->pivot->rread > 0 or $a->pivot->eedit > 0 or $a->pivot->wwrite > 0 or $a->pivot->ddelete > 0)
                    {
                        /* Content */

                        /*echo "<br>Read = ".$a->pivot->rread;
                        echo "<br>Write  = ".$a->pivot->wwrite;
                        echo "<br>Edit   = ".$a->pivot->eedit;
                        echo "<br>Delete = ".$a->pivot->ddelete;*/
                        //$logs = CoreLog::orderBy('fecha', 'desc')->paginate(15);
                        $obra = SysObra::find($id);

                        //$pro = SysArtista::orderBy('apellido', 'asc')->paginate(20)->orderBy('full_name', 'asc');

                        $location = SysUbicaciones::pluck('name','id');
                        $artists = SysArtista::orderBy('apellido', 'asc')->get();
                        $artists = $artists->pluck('full_name', 'id');
                        /* Se tiene que hace all()->plunck() y no lunck() directamente, ya que para
                           poder ejecutar la funciuon(full_name) necesita tenern los datos en memoria */


                        //Debugbar::info($object);
                        //Debugbar::error('Error!');
                        //Debugbar::warning('Watch out…');
                        //Debugbar::addMessage('Another message', 'mylabel');

                        return view('art.obra.empty')
                            ->with('modulos', $modules) //Modulos
                            ->with('xmod', $a) //Permisos
                            ->with('obra', $obra)
                            ->with('location', $location)
                            ->with('artist', $artists)
                            ->with('opc', $opc)
                            ->with('xid', $xid)
                            ->with('opc2', $opc2)
                            ->with('search', $search);
                    }
                }
            }
            Session::flash('msg_access', 'Obras');
            return redirect("admin/index"); /* If he dont have access redirect to the Index*/
        }
        catch(\Exception $e)
        {
            LogSystem::writeLog("ExcepcionM : " . $e->getMessage() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionF : " . $e->getFile() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionL : " . $e->getLine() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionT : " . $e->getTraceAsString() . " ", Auth::id());
            Session::flash('msg_access2', $e);
            return redirect("admin/index");
        }

    }

    public function ObraDestroy()
    {
        try{

            $obraFile = SysObraFile::where('id_obra', Input::get('id_obra'))->delete();
            $obra = SysObra::find(Input::get('id_obra'))->delete();


            //$obraFile->destroy();
            //$obra->destroy();


            //SysObraFile::destroy($obra->id);

            //SysObra::destroy(Input::get('id_obra'));
            //SysObra::show();

            //$obra->delete();


            Session::flash('dbDelete', 'ArtWork');

            LogSystem::writeSystemLog("The ArtWork with ID = ". Input::get('id_obra') ." has been deleted","Art.ArtWorks",Auth::id());
            $next = Input::get('next');

            if($next == 0)
            {
                return redirect("art/obra/index");
            }
            else
            {
                return redirect()->back();
            }



        }
        catch(\Exception $e)
        {

            LogSystem::writeLog("ExcepcionM : " . $e->getMessage() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionF : " . $e->getFile() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionL : " . $e->getLine() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionT : " . $e->getTraceAsString() . " ", Auth::id());
            //Session::flash('msg_access2', $e->getMessage());
            Session::flash('dbDeleteError', 'ArtWork');
            return redirect("art/obra/index");
        }

    }

    public function ObraEdit(EditArtworks $request)
    {
        try{
            $file_name  ="";
            $pro = SysObra::find(Input::get('id_obra'));


            if ($request->hasFile('foto1_edit'))
            {
                if (Input::file('foto1_edit')->isValid())
                {

                    $file_name = Input::get('n_inv_edit') . "." . $request->file('foto1_edit')->getClientOriginalExtension();
                    $pathO = "public/Arts_Original/";
                    $pathS = public_path('storage/Arts_Small/' . $file_name);
                    $pathC = public_path('storage/Arts_Square/' . $file_name);
                    //dd(Input::get('n_inv_edit') );
                    $request->file('foto1_edit')->storeAs($pathO, $file_name); //Save Original Photo

                    //dd(Image::make($request->file('foto1_edit')));
                    //$im  = Image::make($request->file('foto1_edit'));

                    $img = Image::make($request->file('foto1_edit'));


                   // dd($img2);




                    if ($img->width() > $img->height())
                    {
                        /**
                        Primera Imagen: Reduccion de tamaño
                         */

                        $img->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });  //Resize and maintain aspect ratio

                        $img->save($pathS, 60); //Save the New Small Photo

                        /*
                         * Segunda Imagen: Primero se reduce de tamaño y luego se corta desde el centro un cuadrado.
                         * */

                        $img2 = Image::make($request->file('foto1_edit'));;
                        $img2->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        }); //Resize and maintain aspect ratio

                        $width  = $img2->width();
                        $height = $img2->height();

                        if($height < 400)
                        {
                            $img2->crop(400, 400); //Crop a square from the center of image
                        }
                        else{
                            $img2->crop($height, $height); //Crop a square from the center of image
                        }
                        $img2->save($pathC, 60); //Save the New Square Photo
                    }
                    else
                    {

                        /**
                        Primera Imagen: Reduccion de tamaño
                         */

                        $img->resize(null, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        });  //Resize and maintain aspect ratio

                        $img->save($pathS, 60); //Save the New Small Photo

                        /*
                         * Segunda Imagen: Primero se reduce de tamaño y luego se corta desde el centro un cuadrado.
                         * */

                        $img2 = Image::make($request->file('foto1_edit'));;
                        $img2->resize(null, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        }); //Resize and maintain aspect ratio

                        $width  = $img2->width();
                        //$height = $img2->height();
                        if($width < 400)
                        {
                            $img2->crop(400, 400); //Crop a square from the center of image
                        }
                        else{
                            $img2->crop($width, $width); //Crop a square from the center of image
                        }




                        $img2->save($pathC, 60); //Save the New Square Photo
                     }


                   // $img->save($pathS, 60); //Save the New Photo
                   // $img2->save($pathC, 60); //Save the New Photo

                    $pro->file1         = $file_name;
                    $pro->file2         = $file_name;

                    //dd($img2);

                }
            }



            //$pro->n_inv         = Input::get('n_inv_edit');
            $pro->id_artista    = Input::get('id_artista');
            $pro->titulo        = Input::get('titulo_edit');
            $pro->tecnica       = Input::get('tecnica_edit');
            $pro->dimension     = Input::get('dimension_edit');
            $pro->ano           = Input::get('ano_edit');
            $pro->edicion       = Input::get('edicion_edit');
            $pro->procedencia   = Input::get('procedencia_edit');
            $pro->catalogo      = Input::get('catalogo_edit');
            $pro->certificacion = Input::get('certificacion_edit');
            $pro->valoracion    = Input::get('valoracion_edit');
            $pro->id_ubica      = Input::get('id_ubica'.Input::get('id_obra'));
            $pro->obs           = Input::get('obs');

            $opc = Input::get('opc');

            $pro->save();
            Session::flash('dbUpdated', '1');
            LogSystem::writeSystemLog("The Artwork with ID = ". $pro->id ." has been created with picture: " . $pro->file1,"Art.ArtWorks",Auth::id());

            if($opc == 0) /* Call from ObraIndex*/
            {
                return redirect("art/obra/index");
            }
            else if($opc == 1) /* Call from AdminIndex*/
            {
                return redirect("admin/index");
            }
            else if($opc == 2) /* Call from Search Level 1*/
            {
                $search = Input::get('search');
                //echo "hola= " .$search;
                //return redirect()->action("art\search\SearchController@SearchIndex", ['test' => $search]);
                return redirect("art/search/".$search );
            }
            else if($opc == 3) /* Call from Search Level 2.1*/
            {
                $search = Input::get('search');
                $opc2 = Input::get('opc2');
                //echo "hola= " .$search;
                //return redirect()->action("art\search\SearchController@SearchIndex", ['test' => $search]);
                return redirect("art/search/details/".$opc2."/".$search."/".$opc );
            }
            else if($opc == 4) /* Call from Search Level 2.2*/
            {
                $search = Input::get('search');
                $opc2 = Input::get('opc2');
                $id = Input::get('xid');
                //echo "hola= " .$search;
                //return redirect()->action("art\search\SearchController@SearchIndex", ['test' => $search]);
                return redirect("art/search/details2/".$opc2."/".$id."/".$search."/".$opc2 );
            }
            else if($opc == 5) /* Call from Summary By Location */
            {
                $search = Input::get('search');
                $opc2 = Input::get('opc2');
                $id = Input::get('xid');
                //echo "hola= " .$search;
                //return redirect()->action("art\search\SearchController@SearchIndex", ['test' => $search]);
                return redirect("admin/log/summary/search/".$opc2."/".$id ."/0" );
            }
            else if($opc == 6) /*  */
            {
                $search = Input::get('search');
                $opc2 = Input::get('opc2');
                $id = Input::get('xid');
                //echo "hola= " .$search;
                //return redirect()->action("art\search\SearchController@SearchIndex", ['test' => $search]);
                return redirect("art/obra/list/".$id );
            }
            else if($opc == 7) /* Call from Summary By Artist */
            {
                $search = Input::get('search');
                $opc2 = Input::get('opc2');
                $id = Input::get('xid');
                //echo "hola= " .$search;
                //return redirect()->action("art\search\SearchController@SearchIndex", ['test' => $search]);
                return redirect("admin/log/summary/search2/".$opc2."/".$id ."/0"  );
            }

        }
        catch(\Exception $e)
        {

            LogSystem::writeLog("ExcepcionM : " . $e->getMessage() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionF : " . $e->getFile() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionL : " . $e->getLine() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionT : " . $e->getTraceAsString() . " ", Auth::id());
        }

    }

    public function ObraCreate(CreateArtWorks $request)
    {
        try {
            $pro = new SysObra();
            $path1 = "";
            $path2 = "";
            $file_name = "";




            if ($request->hasFile('foto1'))
            {
                if (Input::file('foto1')->isValid())
                {

                    $file_name = Input::get('n_inv') . "." . $request->file('foto1')->getClientOriginalExtension();
                    $pathO = "public/Arts_Original/";
                    $pathS = public_path('storage/Arts_Small/' . $file_name);
                    $pathC = public_path('storage/Arts_Square/' . $file_name);
                    // dd($file_name);
                    $request->file('foto1')->storeAs($pathO, $file_name); //Save Original Photo

                    //dd(Image::make($request->file('foto1_edit')));
                    //$im  = Image::make($request->file('foto1_edit'));

                    $img = Image::make($request->file('foto1'));

                    // dd($img2);

                    if ($img->width() > $img->height())
                    {
                        /**
                        Primera Imagen: Reduccion de tamaño
                         */

                        $img->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });  //Resize and maintain aspect ratio

                        $img->save($pathS, 60); //Save the New Small Photo

                        /*
                         * Segunda Imagen: Primero se reduce de tamaño y luego se corta desde el centro un cuadrado.
                         * */

                        $img2 = Image::make($request->file('foto1'));;
                        $img2->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        }); //Resize and maintain aspect ratio

                        $width  = $img2->width();
                        $height = $img2->height();
                        if($height < 400)
                        {
                            $img2->crop(400, 400); //Crop a square from the center of image
                        }
                        else{
                            $img2->crop($height, $height); //Crop a square from the center of image
                        }
                        $img2->save($pathC, 60); //Save the New Square Photo

                    }
                    else
                    {

                        /**
                        Primera Imagen: Reduccion de tamaño
                         */

                        $img->resize(null, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        });  //Resize and maintain aspect ratio

                        $img->save($pathS, 60); //Save the New Small Photo

                        /*
                         * Segunda Imagen: Primero se reduce de tamaño y luego se corta desde el centro un cuadrado.
                         * */

                        $img2 = Image::make($request->file('foto1'));;
                        $img2->resize(null, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        }); //Resize and maintain aspect ratio

                        $width  = $img2->width();
                        //$height = $img2->height();

                        if($width < 400)
                        {
                            $img2->crop(400, 400); //Crop a square from the center of image
                        }
                        else{
                            $img2->crop($width, $width); //Crop a square from the center of image
                        }


                        $img2->save($pathC, 60); //Save the New Square Photo
                    }
                    LogSystem::writeSystemLog("The Artwork with N_Inv = ". Input::get('n_inv') ." has upload a picture: " .$file_name ,"Art.ArtWorks",Auth::id());

                    // $img->save($pathS, 60); //Save the New Photo
                    // $img2->save($pathC, 60); //Save the New Photo

                    $pro->file1         = $file_name;
                    $pro->file2         = $file_name;

                    //dd($img2);

                }
            }



            $pro->n_inv = Input::get('n_inv');
            $pro->id_artista = Input::get('id_artista');
            $pro->titulo = Input::get('titulo');
            $pro->tecnica = Input::get('tecnica');
            $pro->dimension = Input::get('dimension');
            $pro->ano = Input::get('ano');
            $pro->edicion = Input::get('edicion');
            $pro->procedencia = Input::get('procedencia');
            $pro->catalogo = Input::get('catalogo');
            $pro->certificacion = Input::get('certificacion');
            $pro->valoracion = Input::get('valoracion');
            $pro->id_ubica = Input::get('id_ubica');
            $pro->file1 = $file_name;
            $pro->file2 = $file_name;
            $pro->obs = Input::get('obs');
            $pro->save();
            Session::flash('dbCreate', 'Artwork');

            if ($request->hasFile('pdf'))
            {
                //dd($request->pdf);

                foreach ($request->pdf as $pdf)
                {
                    $file_name = $pdf->getClientOriginalName();
                    //dd($file_name);
                    $pathO = "public/pdfs/";
                    //dd($pathC);
                    $filename = $pdf->storeAs($pathO, $file_name);
                    $tmp = new SysObraFile();
                    $tmp->id_obra = $pro->id;
                    $tmp->name = $file_name;

                    //dd($tmp);
                    $tmp->save();

                    //dd($tmp);
                }

            }

            LogSystem::writeSystemLog("The Artwork with ID = ". $pro->id ." has been created with picture: " . $pro->file1,"Art.ArtWorks",Auth::id());
            return redirect("art/obra/index");
        }
        catch(\Exception $e)
        {
            LogSystem::writeLog("ExcepcionM : " . $e->getMessage() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionF : " . $e->getFile() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionL : " . $e->getLine() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionT : " . $e->getTraceAsString() . " ", Auth::id());
        }

    }

    public function ObraCreateArtist(CreateArtWorks $request)
    {
        try {
            $pro = new SysObra();
            $path1 = "";
            $path2 = "";
            $file_name = "";




            if ($request->hasFile('foto1'))
            {
                if (Input::file('foto1')->isValid())
                {

                    $file_name = Input::get('n_inv') . "." . $request->file('foto1')->getClientOriginalExtension();
                    $pathO = "public/Arts_Original/";
                    $pathS = public_path('storage/Arts_Small/' . $file_name);
                    $pathC = public_path('storage/Arts_Square/' . $file_name);
                    // dd($file_name);
                    $request->file('foto1')->storeAs($pathO, $file_name); //Save Original Photo

                    //dd(Image::make($request->file('foto1_edit')));
                    //$im  = Image::make($request->file('foto1_edit'));

                    $img = Image::make($request->file('foto1'));

                    // dd($img2);

                    if ($img->width() > $img->height())
                    {
                        /**
                        Primera Imagen: Reduccion de tamaño
                         */

                        $img->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });  //Resize and maintain aspect ratio

                        $img->save($pathS, 60); //Save the New Small Photo

                        /*
                         * Segunda Imagen: Primero se reduce de tamaño y luego se corta desde el centro un cuadrado.
                         * */

                        $img2 = Image::make($request->file('foto1'));;
                        $img2->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        }); //Resize and maintain aspect ratio

                        $width  = $img2->width();
                        $height = $img2->height();
                        if($height < 400)
                        {
                            $img2->crop(400, 400); //Crop a square from the center of image
                        }
                        else{
                            $img2->crop($height, $height); //Crop a square from the center of image
                        }
                        $img2->save($pathC, 60); //Save the New Square Photo

                    }
                    else
                    {

                        /**
                        Primera Imagen: Reduccion de tamaño
                         */

                        $img->resize(null, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        });  //Resize and maintain aspect ratio

                        $img->save($pathS, 60); //Save the New Small Photo

                        /*
                         * Segunda Imagen: Primero se reduce de tamaño y luego se corta desde el centro un cuadrado.
                         * */

                        $img2 = Image::make($request->file('foto1'));;
                        $img2->resize(null, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        }); //Resize and maintain aspect ratio

                        $width  = $img2->width();
                        //$height = $img2->height();

                        if($width < 400)
                        {
                            $img2->crop(400, 400); //Crop a square from the center of image
                        }
                        else{
                            $img2->crop($width, $width); //Crop a square from the center of image
                        }


                        $img2->save($pathC, 60); //Save the New Square Photo
                    }
                    LogSystem::writeSystemLog("The Artwork with N_Inv = ". Input::get('n_inv') ." has upload a picture: " .$file_name ,"Art.ArtWorks",Auth::id());

                    // $img->save($pathS, 60); //Save the New Photo
                    // $img2->save($pathC, 60); //Save the New Photo

                    $pro->file1         = $file_name;
                    $pro->file2         = $file_name;

                    //dd($img2);

                }
            }



            $pro->n_inv = Input::get('n_inv');
            $pro->id_artista = Input::get('id_artista');
            $pro->titulo = Input::get('titulo');
            $pro->tecnica = Input::get('tecnica');
            $pro->dimension = Input::get('dimension');
            $pro->ano = Input::get('ano');
            $pro->edicion = Input::get('edicion');
            $pro->procedencia = Input::get('procedencia');
            $pro->catalogo = Input::get('catalogo');
            $pro->certificacion = Input::get('certificacion');
            $pro->valoracion = Input::get('valoracion');
            $pro->id_ubica = Input::get('id_ubica');
            $pro->file1 = $file_name;
            $pro->file2 = $file_name;
            $pro->obs = Input::get('obs');
            $pro->save();
            Session::flash('dbCreate', 'Artwork');

            if ($request->hasFile('pdf'))
            {
                //dd($request->pdf);

                foreach ($request->pdf as $pdf)
                {
                    $file_name = $pdf->getClientOriginalName();
                    //dd($file_name);
                    $pathO = "public/pdfs/";
                    //dd($pathC);
                    $filename = $pdf->storeAs($pathO, $file_name);
                    $tmp = new SysObraFile();
                    $tmp->id_obra = $pro->id;
                    $tmp->name = $file_name;

                    //dd($tmp);
                    $tmp->save();

                    //dd($tmp);
                }

            }

            LogSystem::writeSystemLog("The Artwork with ID = ". $pro->id ." has been created with picture: " . $pro->file1,"Art.ArtWorks",Auth::id());
            return redirect("art/obra/list/".$pro->id_artista);
        }
        catch(\Exception $e)
        {
            LogSystem::writeLog("ExcepcionM : " . $e->getMessage() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionF : " . $e->getFile() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionL : " . $e->getLine() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionT : " . $e->getTraceAsString() . " ", Auth::id());
        }

    }

    public function ObraPdfIndex($id)
    {
        try{

            /* Menu */
            $modules  = User::find(Auth::id())->profile->module;


            /*echo "Usuario = ".$user."<br>";
            echo "Perfil = ".$profile."<br>";
            echo "Modulos = ".$modules."<br>";*/
            foreach($modules as $a)
            {

                if($a->id == $this->idmodulo) /* Is allowed to see this Module */
                {
                    /*echo "ID = ".$a->id. "<br>";
                    echo "IdC = ". $this->idmodulo. "<br>";*/
                    if($a->pivot->rread > 0 or $a->pivot->eedit > 0 or $a->pivot->wwrite > 0 or $a->pivot->ddelete > 0)
                    {
                        /* Content */

                        /*echo "<br>Read = ".$a->pivot->rread;
                        echo "<br>Write  = ".$a->pivot->wwrite;
                        echo "<br>Edit   = ".$a->pivot->eedit;
                        echo "<br>Delete = ".$a->pivot->ddelete;*/
                        //$logs = CoreLog::orderBy('fecha', 'desc')->paginate(15);
                        $pro = SysObra::find($id);

                        //$location = SysUbicaciones::pluck('name','id');
                        //$artists = SysArtista::all()->pluck('full_name', 'id');
                        /* Se tiene que hace all()->plunck() y no lunck() directamente, ya que para
                           poder ejecutar la funciuon(full_name) necesita tenern los datos en memoria */


                        //Debugbar::info($object);
                        //Debugbar::error('Error!');
                        //Debugbar::warning('Watch out…');
                        //Debugbar::addMessage('Another message', 'mylabel');

                        return view('art.obra.pdf')
                            ->with('modulos', $modules) //Modulos
                            ->with('xmod', $a) //Permisos
                            ->with('obra', $pro);
                    }
                }
            }
            Session::flash('msg_access', 'Obras');
            return redirect("admin/index"); /* If he dont have access redirect to the Index*/
        }
        catch(\Exception $e)
        {
            LogSystem::writeLog("ExcepcionM : " . $e->getMessage() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionF : " . $e->getFile() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionL : " . $e->getLine() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionT : " . $e->getTraceAsString() . " ", Auth::id());
            Session::flash('msg_access2', $e);
            return redirect("admin/index");
        }

    }

    public function ObraCreatePdf(CreatePdfFile $request)
    {
        try {

            $file_name = "";

            $obraId = Input::get('obraid');



            if ($request->hasFile('pdf'))
            {
                //dd($request->pdf);

                foreach ($request->pdf as $pdf)
                {
                    $file_name = $pdf->getClientOriginalName();
                    $ext = File::extension($file_name);
                    if ($ext == "pdf")
                    {
                        $pathO = "public/pdfs/";
                        //dd($pathC);
                        $filename = $pdf->storeAs($pathO, $file_name);
                        //dd($filename);
                        $tmp = new SysObraFile();
                        $tmp->id_obra = $obraId;
                        $tmp->name = $file_name;
                        //dd($tmp);
                        $tmp->save();
                    }
                    else
                    {
                        Session::flash('dbCreateFile', 'Artwork');
                        return redirect("art/obra/pdf/".$obraId);
                    }

                    //dd($tmp);
                }

            }
            //Session::flash('dbCreateFile', 'Artwork');
            LogSystem::writeSystemLog("The Artwork with ID = ". $obraId." has a new PDF file created, name = ".$file_name."" ,"Art.ArtWorks",Auth::id());
            return redirect("art/obra/pdf/".$obraId);
        }
        catch(\Exception $e)
        {
            LogSystem::writeLog("ExcepcionM : " . $e->getMessage() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionF : " . $e->getFile() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionL : " . $e->getLine() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionT : " . $e->getTraceAsString() . " ", Auth::id());

            Session::flash('dbCreateFile', 'Artwork');
            return redirect("art/obra/pdf/".$obraId);
        }

    }

    public function ObraPdfDestroy()
    {
        try{
            $file = SysObraFile::find(Input::get('id_file'));
            $pathC = public_path('storage/pdfs/' .$file->name);

            \Storage::Delete($pathC);

            SysObraFile::destroy(Input::get('id_file'));


            //echo "Hola";
            //exit;

            Session::flash('dbDelete', 'ArtWork');

            LogSystem::writeSystemLog("The File with ID = ". Input::get('id_file') ." and name = ". $file->name." has been deleted","Art.ArtWorks",Auth::id());
            return redirect("art/obra/pdf/".Input::get('id_obra') );

        }
        catch(\Exception $e)
        {

            LogSystem::writeLog("ExcepcionM : " . $e->getMessage() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionF : " . $e->getFile() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionL : " . $e->getLine() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionT : " . $e->getTraceAsString() . " ", Auth::id());
            Session::flash('msg_access2', $e->getMessage());
            Session::flash('dbDeleteError', 'ArtWorkFile');
            return redirect("art/obra/pdf/".Input::get('id_obra'));
        }

    }

    public function ObraByArtist($id)
    {
        /* Menu */
        $modules  = User::find(Auth::id())->profile->module;
        foreach($modules as $d)
        {
            if($d->id == 6)
            {
                //dd($d);
                $permission_edit_art = $d->pivot->eedit;
                $permission_delete_art = $d->pivot->ddelete;
            }
        }
        foreach($modules as $a)
        {

            if($a->id == $this->idmodulo) /* Is allowed to see this Module */
            {

                if($a->pivot->rread > 0 or $a->pivot->eedit > 0 or $a->pivot->wwrite > 0 or $a->pivot->ddelete > 0)
                {
                    /* Content */

                    $location = SysUbicaciones::pluck('name','id');
                    $artists = SysArtista::all()->pluck('full_name', 'id');
                    /* Se tiene que hace all()->plunck() y no lunck() directamente, ya que para
                       poder ejecutar la funciuon(full_name) necesita tenern los datos en memoria */

                    $artists_name = SysArtista::all()->where('id', $id)->pluck('full_name', 'id');
                    $pro = SysObra::where('id_artista', $id)
                           ->orderBy('id', 'desc')->get();
                    //$pro = SysObra::find($id)->get();
//dd($pro);
                    $allmod = CoreModule::all();
                    return view('art.artist.list')
                            ->with('modulos', $modules)
                            ->with('allmod', $allmod)
                            ->with('obras', $pro)
                            ->with('xmod', $a)
                            ->with('idartist',$id)
                            ->with('editar_obra', $permission_edit_art)
                            ->with('location', $location)
                            ->with('artists_name', $artists_name)
                            ->with('borrar_obra', $permission_delete_art)
                            ->with('artist', $artists);

                }
            }
        }
        Session::flash('msg_access', 'Obras');
        return redirect("admin/index"); /* If he dont have access redirect to the Index*/
    }

    public function ObraPdf($id)
    {
        try{

            //$pdf = PDF::loadView('art.artist.pdf');
            /*            $view = \View::make('art.artist.pdf');
                        $pdf = \App::make('dompdf.wrapper');
                        $pdf->loadHTML($view);
                        return $pdf->stream('test.php'); */// Para desplegar en la misma pantalla
            //return $pdf->download('test.php'); // Para descargar el archivo
            //return view('art.artist.pdf');
            //echo "hola";
            $title = "Buscar";
            //view()->share('title', "Pan con queso");
            //$view =  view('art.artist.pdf');

            //$lista = Input::get('listartworks');

            $obras = SysObra::find($id);
            $title = $obras->artist->nombre ." ". $obras->artist->apellido;
            //dd($obras->artist->nombre);
            //dd($obras);
            //dd(Input::get('listartworks'));
            $pdf =  PDF::loadView('art.obra.exportpdf', compact(['title', 'obras']))
                ->setPaper('a4', 'portrait')
                ->setWarnings(false)
                ->setOptions(['isHtml5ParserEnabled' => true,'isRemoteEnabled' => true]);
//dd($pdf);
            //return $pdf->stream();
            $name = "exp_". $obras->n_inv .".pdf";
                //dd($name);
            return $pdf->download($name);

            /*return view('art.artist.pdf')
                ->with('title', $title)
                ->with('obras', $obras);*/
        }
        catch(\Exception $e)
        {
            //dd($e);
            LogSystem::writeLog("ExcepcionM : " . $e->getMessage() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionF : " . $e->getFile() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionL : " . $e->getLine() . " ", Auth::id());
            LogSystem::writeLog("ExcepcionT : " . $e->getTraceAsString() . " ", Auth::id());
            Session::flash('msg_access2', $e);
            return redirect("admin/index");
        }
    }
}
