<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $rq)
    {
        $query = Document::query();
        $query->when($rq->filled('title'), function ($q) use ($rq) {
            $q->where('title', 'like', $rq->title);
        });
        $query->when($rq->filled('code'), function ($q) use ($rq) {
            $q->where('code', 'like', $rq->code);
        });

        $filterParam = $rq->filled('tags');

        if ($filterParam) {
            $filteredArticles = DocumentTag::whereHas('tags', function($q) use ($filterParam) {
                $q->where('title', '=', $filterParam);
            });
            $query = $filteredArticles;
        }

        $documents = $query->simplePaginate(25);
        $tags = DB::table('tags')->simplePaginate(5);

        return view('documents', ['documents' => $documents, 'tags' => $tags]);
    }

    public function oneDoc($id){

        $documents = DB::table('documents')->where('id', '=', $id)->get();
        $tags = DB::table('tags')->join('document_tags',function($join){
            $join->on('tags.id', '=', 'document_tags.tag_id');
        })->where('document_tags.document_id','=', $id)->orderBy('title')->get();


        return view('oneDoc', ['documents' => $documents, 'tags' => $tags]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
