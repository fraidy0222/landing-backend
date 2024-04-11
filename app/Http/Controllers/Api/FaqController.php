<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Resources\FaqResource;
use App\Http\Requests\FaqRequest;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return response()->json(['faqs' => FaqResource::collection(Faq::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        Faq::create($request->validated());

        return response()->json(['message' => 'Pregunta Precuente creado correctamente']);    
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        return $faq;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated());
        
        return response()->json(['message' => 'Pregunta Precuente actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json(['message' => 'Pregunta Precuente eliminiado correctamente']);
    }
}
