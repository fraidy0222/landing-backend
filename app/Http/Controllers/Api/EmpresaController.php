<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Http\Resources\EmpresaResource;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function index()
    {
        return response()->json(['empresa' => EmpresaResource::collection(Empresa::all())]);
    }

    public function storeEmpresa(EmpresaRequest $request)
    {
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            if ($logo != null) {
                $logo = $logo->store('empresa', 'public');
            } else {
                $logo = '';
            }
        } else {
            $logo = '';
        }

        $empresa = Empresa::create($request->validated());

        $empresa['logo'] = $logo;

        $empresa->save();

        return response()->json(['message' => 'Empresa creada satisfactoriamente'], 200);
    }

    public function updateEmpresa(EmpresaRequest $request, Empresa $empresa)
    {
        $empresa = Empresa::find($empresa->id);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            Storage::delete('public/' . $empresa->logo);
            if ($logo != null) {
                $logo = $logo->store('empresa', 'public');
            } else {
                $logo = $empresa->logo;
            }
        } else {
            $logo = $empresa->logo;
        }

        $empresa->update($request->validated());

        $empresa->logo = $logo;

        $empresa->save();

        return response()->json(['message' => 'Empresa creada satisfactoriamente'], 200);
    }

    public function storeInfoEmpresa(Request $request, Empresa $empresa)
    {
        $rules = [
            'director' => 'nullable|max:100',
            'slogan' => 'nullable|max:255',
            'resumen' => 'nullable',
            'facebook' => 'nullable|url:https,http',
            'youtube' => 'nullable|url:https,http',
            'twitter' => 'nullable|url:https,http',
            'linkend' => 'nullable|url:https,http',
        ];

        $message = [
            'director.max' => 'El campo director no puede tener más de 100 caracteres',
            'slogan.max' => 'El campo slogan no puede tener más de 255 caracteres',
            'facebook.url' => 'El campo Facebook debe ser una URL válida',
            'youtube.url' => 'El campo Youtube debe ser una URL válida',
            'twitter.url' => 'El campo Twitter debe ser una URL válida',
            'linkedin.url' => 'El campo LinkedIn debe ser una URL válida',
        ];

        $this->validate($request, $rules, $message);

        $empresa->fill($request->only([
            'director',
            'slogan',
            'resumen',
            'facebook',
            'youtube',
            'twitter',
            'linkedin'
        ]));

        $empresa->save();

        return response()->json(['message' => 'Información creada satisfactoriamente'], 200);
    }

    public function updateInfoEmpresa(Request $request, Empresa $empresa)
    {
        $rules = [
            'director' => 'nullable|max:100',
            'slogan' => 'nullable|max:255',
            'resumen' => 'nullable',
            'facebook' => 'nullable|url:https,http',
            'youtube' => 'nullable|url:https,http',
            'twitter' => 'nullable|url:https,http',
            'linkedin' => 'nullable|url:https,http',
        ];

        $message = [
            'director.max' => 'El campo director no puede tener más de 100 caracteres',
            'slogan.max' => 'El campo slogan no puede tener más de 255 caracteres',
            'facebook.url' => 'El campo Facebook debe ser una URL válida',
            'youtube.url' => 'El campo Youtube debe ser una URL válida',
            'twitter.url' => 'El campo Twitter debe ser una URL válida',
            'linkedin.url' => 'El campo LinkedIn debe ser una URL válida',
        ];

        $this->validate($request, $rules, $message);

        $empresa->fill($request->only([
            'director',
            'slogan',
            'resumen',
            'facebook',
            'youtube',
            'twitter',
            'linkedin'
        ]));

        $empresa->save();

        return response()->json(['message' => 'Información editada satisfactoriamente'], 200);
    }

    public function uploadVideo(Request $request, Empresa $empresa)
    {
        // $rules = [
        //     'video_institucional' => 'nullable|max:1024'
        // ];

        // $message = [
        //     'video_institucional.max' => 'El video institucional no puede tener mas 1mb'
        // ];

        // $this->validate($request, $rules, $message);

        if ($request->hasFile('video_institucional')) {
            $video = $request->file('video_institucional');
            Storage::delete('public/' . $empresa->video_institucional);
            $video = $video->store('empresa/video', 'public');

            $empresa->video_institucional = $video;

            $empresa->save();

            // Devuelve una respuesta de éxito
            return response()->json(['message' => 'Video subido correctamente']);
        }

        // Devuelve una respuesta de error si no se recibió ningún blob
        return response()->json(['error' => 'No se recibió ningún video'], 400);
    }

    public function deleteVideo(Empresa $empresa)
    {

        Storage::delete('public/' . $empresa->video_institucional);

        $empresa->video_institucional = null;
        $empresa->save();

        return response()->json(['message' => 'Video eliminado correctamente']);
    }
}
