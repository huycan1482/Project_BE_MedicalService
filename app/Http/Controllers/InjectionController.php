<?php

namespace App\Http\Controllers;

use App\Http\Requests\InjectionRequest;
use App\Injection;
use App\Repositories\InjectionRepository;
use App\Resident;
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
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('create', Injection::class)) {
            $check_admin = $current_user->can('viewAny', User::class);
            $resident = Resident::find(request()->resident_id);

            if (empty($resident))
                return redirect()->route('admin.errors.4xx');

            return view ('admin.injection.create', [
                'resident' => $resident,
                'diseases' => $this->getActiveDiseases(),
                'vaccines' => $this->getActiveVaccines(),
                'packs' => $this->getActivePacks(),
                'priorities' => $this->getActivePriorities(),
                'users' => $this->getActiveUsers($check_admin ? 0 : $current_user->belongsToRole->ward_id),
                'users' => $check_admin ? $this->getActiveUsers('') : $this->getActiveUsers($current_user->belongsToRole->ward_id),
            ]);
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
    public function store(InjectionRequest $request)
    {
        $current_user = User::find(Auth::user()->id);
        // dd($request->all());
        if ($current_user->can('create', Injection::class)) {
            // dd($this->createInjection($request->all())['status']);
            if ($this->createInjection($request->all())['status'] != false) {
                return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
            } else {
                return response()->json(['mess' => $this->createInjection($request->all())['mess']], 502); 
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
                'packs' => $this->getActivePacks(),
                'priorities' => $this->getActivePriorities(),
                'users' => $this->getActiveUsers($check_admin ? 0 : $current_user->belongsToRole->ward_id),
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
    public function update(InjectionRequest $request, $id)
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('update', Injection::class)) {
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
