<?php

namespace App\Http\Controllers;

use App\Rules\YoutubeUrlCheckRule;
use Illuminate\Http\Request;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Validator;


class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getVideoStats(Request $request)
    {
        foreach ($request->url_video as $key => $url_video) {

            $validator = Validator::make(
                ['url_video' => $url_video],
                [
                    'url_video' => ['bail', 'required', new YoutubeUrlCheckRule]
                ]
            );

            if ($validator->fails()) {
                $infos[$key]['title'] = 'Informe manualmente';
                $infos[$key]['views'] = 0;
            } else {
                $videoId = Youtube::parseVidFromURL($url_video);
                $videoInfo = Youtube::getVideoInfo($videoId);

                if ($videoInfo !== false) {
                    $infos[$key]['title'] = $videoInfo->snippet->title;
                    $infos[$key]['views'] = $videoInfo->statistics->viewCount;
                } else {
                    $infos[$key]['title'] = 'Vídeo privado. Informe manualmente';
                    $infos[$key]['views'] = 0;
                }
            }
        }

        return $infos;

    }
}
