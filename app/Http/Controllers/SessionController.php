<?php

namespace App\Http\Controllers;

use App\Http\Requests\HuyRequest;
use App\Http\Requests\Session111Request;
use App\Http\Requests\SessionRequest;
use App\Repositories\SessionRepository;
use App\Session;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends SessionRepository 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', Session::class)) {
            if (empty(request()->all()))
                $sessions = $this->getPaginate10();
            else 
                $sessions = $this->getFilter10(); 

            return view ('admin.session.index', [
                'sessions' => $sessions,
                'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
                'status' => empty(request()->query('status')) ? '' : request()->query('status'),
                'name' => empty(request()->query('name')) ? '' : request()->query('name'),
            ]);
        } else {
            return redirect()->route('admin.errors.4xx');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', Session::class)) {
            return view ('admin.session.create');
        } else {
            return redirect()->route('admin.errors.4xx');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SessionRequest $request)
    {   
        $current_user = User::find(Auth::user()->id);
        
        if ($current_user->can('create', Session::class)) {
            $arr_data = $request->all();
            $arr_data['ward_id'] = $current_user->belongsToRole->ward_id;

            if ($this->createModel($arr_data) != false) {
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
        
        if ($current_user->can('create', Session::class)) {
            $session = $this->find($id);

            if (empty($session)) {
                return redirect()->route('admin.errors.4xx');
            }

            return view ('admin.session.edit', [
                'session' => $session,
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
    public function update(SessionRequest $request, $id)
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('update', Session::class)) {
            if ($this->updateModel($id, $request->all())) {
                return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
            } else {
                return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
            }
        } else {
            return response()->json(['mess' => 'Sửa bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
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
