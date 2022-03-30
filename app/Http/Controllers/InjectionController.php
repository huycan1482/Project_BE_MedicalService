<?php

namespace App\Http\Controllers;

use App\Http\Requests\InjectionRequest;
use App\Injection;
use App\Repositories\InjectionRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InjectionController extends InjectionRepository
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InjectionRequest $request)
    {
        $current_user = User::find(Auth::user()->id);
        
        if ($current_user->can('create', Injection::class)) {
            if ($this->createInjection($request->all()) != false) {
                return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
            } else {
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502); 
            }
        } else {
            return response()->json(['mess' => 'Thêm bản ghi lỗi, bạn không đủ thẩm quyền'], 403); 
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
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('update', Injection::class)) {
            $injection = $this->find($id);

            $check_admin = $current_user->can('viewAny', User::class);

            if (empty($injection)) {
                return redirect()->route('admin.errors.4xx');
            }

            return view ('admin.injection.edit', [
                'injection' => $injection,
                'vaccines' => $this->getActiveVaccines(),
                'users' => $check_admin ? $this->getActiveUsers('') : $this->getActiveUsers($current_user->belongsToRole->ward_id),
            ]);
        } else {
            return redirect()->route('admin.errors.4xx');
        }        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
