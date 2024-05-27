<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Http\Resources\EmpresaResource;
use Illuminate\Database\QueryException;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Response;
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
        // Tamaño máximo permitido en bytes (4 GB)
        $maxSize = 1 * 1024 * 1024 * 1024;

        if ($request->hasFile('video_institucional')) {
            $video = $request->file('video_institucional');

            // Validar el tamaño del archivo
            if ($video->getSize() > $maxSize) {
                return response()->json(['error' => 'El video no puede ser mayor a 4 GB'], 400);
            }

            // Validar el tipo MIME del archivo (opcional)
            $allowedMimeTypes = ['video/mp4'];
            if (!in_array($video->getMimeType(), $allowedMimeTypes)) {
                return response()->json(['error' => 'El formato de video no válido. Tiene que ser el formato mp4'], 400);
            }

            // Guardar el nuevo video
            try {
                Storage::delete('public/' . $empresa->video_institucional);
                $videoPath = $video->store('empresa/video', 'public');
                $empresa->video_institucional = $videoPath;
                $empresa->save();

                return response()->json(['message' => 'Video subido correctamente']);
            } catch (QueryException $e) {
                // Manejo de errores de base de datos
                return response()->json(['error' => 'Error al guardar el video'], 500);
            } catch (\Exception $e) {
                // Otros errores (almacenamiento, etc.)
                return response()->json(['error' => 'Error al subir el video'], 500);
            }
        }

        return response()->json(['error' => 'No se recibió ningún video'], 400);
    }


    public function deleteVideo(Empresa $empresa)
    {

        Storage::delete('public/' . $empresa->video_institucional);

        $empresa->video_institucional = null;
        $empresa->save();

        return response()->json(['message' => 'Video eliminado correctamente']);
    }

    public function showVideo(Empresa $empresa)
    {
        $filePath = 'public/' . $empresa->video_institucional;

        if (Storage::exists($filePath)) {
            return response()->file(Storage::path($filePath));
        } else {
            return response()->json(['error' => 'Video no encontrado'], 404);
        }
    }
}
