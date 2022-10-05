<?php

namespace App\Services;
use App\Models\Upload;
use BunnyCDN\Storage\BunnyCDNStorage;

class UploadService {

    public $bunnyCDNStorage ;
    public $storageZone = 'pigeon';
    public $directory = 'pigeon/images';
    public $base_URL = 'https://pigeon.b-cdn.net';
    public $access_key = '6742bd4b-473d-4585-833bd2dc04aa-bca0-4daf';

    public function __construct()
    {

       $this->bunnyCDNStorage = new BunnyCDNStorage($this->storageZone, $this->access_key, "sg");
    }


    // public function save_images($data) 
    // {

    //     $images = $data->file('images');

    //     $files = [];

    //          $i =0 ;
    //         foreach($data as $d)
    //         {
    //           $d = json_decode($d , true);
    //             dd($d);
    //             // $type = $d['is360'] === 'false' ?  'image' : '3d';
    //             // $folder = $type === 'image' ? 'images' : '360';
    //             dd($d);
    //             $without_ext_name= slugify(preg_replace('/\..+$/', '', $images[$i]->getClientOriginalName()));

    //             $name = $without_ext_name .'-'. time().rand(1,100).'.'.$d->extension();
    //             $files[$i]['avatar'] = $name;
    //             $files[$i]['url'] = $this->base_URL . $name ;
    //             $files[$i]['alt_tag'] = $d['alt_text'];
    //             // $files[$i]['type'] = $type;

    //             if($this->bunnyCDNStorage->uploadFile($d->getPathName() , $this->storageZone."/images/{$name}")){

    //                 Upload::create([
    //                     'avatar' =>  $name,
    //                     'url' => $this->base_URL . $name,
    //                     'alt_tag'=>  $name,
    //                 ]);
    //             }else{
                    
    //                 return response()->json('server error',400);
    //             }

    //             $i ++;
    //         }
         
    // }

    public function getImages(){

        $files = [];
        try{    
            
            $uploads = Upload::where('format','!=',"1")->latest()->get();
            return collect($uploads)->take(200);
            
            //$data = $this->bunnyCDNStorage->getStorageObjects("/pigeon/album3/");
            // return $data;
            //$data = $data->toArray();
           // $i=0;
           // foreach($data as $index){
                
                // Upload::create([
                // 'avatar' =>  $index->ObjectName,
                // 'url' => $this->base_URL.'/album3/'.$index->ObjectName,
                // 'alt_tag'=> $index->ObjectName,
                // ]);
                //return $index->ObjectName;
                //exit;
              //  $i++;
            //}
            //return $files;
           // return $data;
        
        }catch(\Exception $e){
        
            return $e;
        
        }

    }
    // $files[$i]['avatar'] =  $index->ObjectName;
    // $files[$i]['url'] = $this->base_URL.'/album4/'.$index->ObjectName;
    // $files[$i]['alt_tag'] = $index->ObjectName;
    // https://pigeon.b-cdn.net/album4/10%253A55%253A27%20GMT+0400%20(Gulf%20Standard%20Time).jpeg
    // https://pigeon.b-cdn.net/album4/10%3A55%3A27 GMT+0400 (Gulf Standard Time).jpeg



    // https://pigeon.b-cdn.net/album4/10%3A55%3A27%20GMT+0400%20(Gulf%20Standard%20Time).jpeg
    // https://pigeon.b-cdn.net/album4/10%253A55%253A27%20GMT+0400%20(Gulf%20Standard%20Time).jpeg


    //https://pigeon.b-cdn.net/album4/10%253A55%253A27%20GMT+0400%20(Gulf%20Standard%20Time).jpeg
    //https://pigeon.b-cdn.net/album4/10%3A55%3A27%20GMT+0400%20(Gulf%20Standard%20Time).jpeg


}