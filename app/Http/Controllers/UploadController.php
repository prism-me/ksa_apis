<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\UploadService;
use Illuminate\Support\Collection;
use BunnyCDN\Storage\BunnyCDNStorage;

class UploadController extends Controller
{   
    public $uploadInstance;

    public $bunnyCDNStorage ;
    public $storageZone = 'pigeon';
    public $directory = 'pigeon/images';
    public $base_URL = 'https://pigeon.b-cdn.net';
    public $access_key = '6742bd4b-473d-4585-833bd2dc04aa-bca0-4daf';

    public function __construct()
    {
        $this->uploadInstance = new UploadService();
       $this->bunnyCDNStorage = new BunnyCDNStorage($this->storageZone, $this->access_key, "sg");
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    

        $data = $this->uploadInstance->getImages();
        
        return $data;
       // return response()->json(['images' => $data]);
    }


     public function upload_images_dump(){

            //$data = $this->bunnyCDNStorage->getStorageObjects("/pigeon/downloads/");
            
            //$data = collect($data)->slice(0,300);
            //return $data;

            //$data = $data->toArray();
            
            //$i=0;
            // foreach($data as $index){
                
            //     Upload::create([
            //     'url' =>  $index->ObjectName,
            //     'avatar' => $this->base_URL.'/downloads/'.$index->ObjectName,
            //     'alt_tag'=> $index->ObjectName,
            //     ]);
                
            //     $i++;
            // }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

            //$upload = $this->uploadInstance->save_images($request->all());


            $images = $request->file('images');
            $data = $request['data'];

            $files = [];
    
                 $i =0 ;
                foreach($data as $d)
                {
                  $d = json_decode($d , true);
                    // $type = $d['is360'] === 'false' ?  'image' : '3d';
                    // $folder = $type === 'image' ? 'images' : '360';
                    $without_ext_name= $this->slugify(preg_replace('/\..+$/', '', $images[$i]->getClientOriginalName()));
    
                    $name = $without_ext_name .'-'. time().rand(1,100).'.'.$images[$i]->extension();
                    
                    $files[$i]['avatar'] = $this->base_URL .'/images/'. $name ;
                    $files[$i]['url'] = $name; 
                    $files[$i]['alt_tag'] = $d['alt_tag'];
                    // $files[$i]['type'] = $type;
    
                    if($this->bunnyCDNStorage->uploadFile($images[$i]->getPathName() , $this->storageZone."/images/{$name}")){
    
                        $uploadedImage = Upload::create([
                            'avatar' =>  $this->base_URL.'/images/'. $name,
                            'url' => $name,
                            'alt_tag'=>  $name,
                            'format' => $images[$i]->extension() === 'pdf' ? 1 : 0, 
                        ]);
                        if($images[$i]->extension() == 'pdf'){
                                
                                //return response()->json('Media has been uploaded', 200);     
                            return response()->json(['location' => $files[$i]['avatar'] ], 200);
                                
                        }
                        echo json_encode(['Media Uploaded']);
                        
                    }else{
                        
                        return response()->json('server error',400);
                    }
    
                    $i ++;
                }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        if($upload->deleted_at != null){

            echo json_encode(['message'=>'No record found.' ,'status'=>200]);
          
        } else{
               
            return $upload;
           
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        if($upload->deleted_at != null){

            echo json_encode(['message'=>'No record found.' ,'status'=>200]);
          
        } else{
               
            return $upload;
           
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required',
            'type' => 'required',
            'alt_tag' => 'required',
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = Upload::where('_id',$upload->_id)->update($request->all());

            if($upload){

                echo json_encode(['message'=>'Data has been saved','status'=>200]);
            
            }else{
            
                echo json_encode(['message'=>'Data has not been saved','status'=>404]);
            
            }
        
        }
    }

    public function multipleUpload(Request $request){

        foreach($request->all() as $sigleRequest){

        
            $validator = Validator::make($sigleRequest, [
                'avatar' => 'required',
                'type' => 'required',
                'alt_tag' => 'required',
            ]);
            
            if($validator->fails()){
            
                echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
           
            }else{
            
                $upload = Upload::create($sigleRequest);
    
                if($upload){
    
                    echo json_encode(['message'=>'Data has been saved','status'=>200]);
                
                }else{
                
                    echo json_encode(['message'=>'Data has not been saved','status'=>404]);
                
                }
            
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    {
        if($upload->delete()){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
    
    

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
       // $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            echo 'n-a';
        }

        return $text;
    }
}
