<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProducerRequest;
use App\Repositories\ProducerRepository;
use Illuminate\Http\Request;

class ProducerController extends ProducerRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (empty(request()->all()))
            $producers = $this->getPaginate10();
        else 
            $producers = $this->getFilter10(); 

        return view ('admin.producer.index', [
            'producers' => $producers,
            'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
            'status' => empty(request()->query('status')) ? '' : request()->query('status'),
            'name' => empty(request()->query('name')) ? '' : request()->query('name'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.producer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProducerRequest $request)
    {
        if ($this->createModel($request->all())) {
            return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
        } else {
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producer = $this->find($id);

        if (empty($producer)) {
            return redirect()->route('admin.errors.404');
        }

        return view('admin.producer.edit', [
            'producer' => $producer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProducerRequest $request, $id)
    {
        if ($this->updateModel($id, $request->all())) {
            return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
        } else {
            return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
