<?php

namespace App\Http\Controllers;

use App\Http\Requests\HuyRequest;
use App\Http\Requests\Session111Request;
use App\Http\Requests\SessionRequest;
use App\Repositories\SessionRepository;
use App\Session;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $check_admin = $current_user->can('viewAny', User::class);

            if (empty(request()->all()))
                $sessions = $this->getPaginate10($check_admin ? 0 : $current_user->belongsToRole->ward_id);
            else 
                $sessions = $this->getFilter10($check_admin ? 0 : $current_user->belongsToRole->ward_id); 

            return view ('admin.session.index', [
                'sessions' => $sessions,
                'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
                'status' => empty(request()->query('status')) ? '' : request()->query('status'),
                'start_at' => empty(request()->query('start_at')) ? '' : request()->query('start_at'),
                'end_at' => empty(request()->query('end_at')) ? '' : request()->query('end_at'),
            ]);
        } else {
            return redirect()->route('admin.errors.4xx');
        }
    }

    public function getDataWithTrashed () {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            $sessions = $this->getSessionWithTrashed();

            return view('admin.session.trash', [
                'sessions' => $sessions,
                'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
                'status' => empty(request()->query('status')) ? '' : request()->query('status'),
                'start_at' => empty(request()->query('start_at')) ? '' : request()->query('start_at'),
                'end_at' => empty(request()->query('end_at')) ? '' : request()->query('end_at'),
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
            return view ('admin.session.create', [
                'diseases' => $this->getActiveDiseases(),
                'vaccines' => $this->getActiveVaccines(0),
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
    public function store(SessionRequest $request)
    {   
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('create', Session::class)) {
            // bắt đầu Rollback
            DB::beginTransaction();

            try {
                $session_id = $this->createSession($request, $current_user->belongsToRole->ward_id);

                if ($session_id == 0) 
                    throw new Exception();

                if (!$this->createSessionVaccine($session_id, $request->input('vaccine_id')))
                    throw new Exception();
                    //Them du lieu vao bang trung gian vaccine_producer

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
            }

            return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
        } else {
            return response()->json(['mess' => 'Thêm bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        } 

        // $current_user = User::find(Auth::user()->id);
        // dd($request->all());
        // if ($current_user->can('create', Session::class)) {
        //     $arr_data = $request->all();
        //     $arr_data['ward_id'] = $current_user->belongsToRole->ward_id;

        //     if ($this->createModel($arr_data) != false) {
        //         return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
        //     } else {
        //         return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502); 
        //     }
        // } else {
        //     return response()->json(['mess' => 'Thêm bản ghi lỗi, bạn không đủ thẩm quyền'], 403); 
        // }   

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
                'diseases' => $this->getActiveDiseases(),
                'vaccines' => $this->getActiveVaccines(0),
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
            // bắt đầu Rollback
            DB::beginTransaction();

            try {
                if (!$this->updateSession($request, $id)) 
                    throw new Exception();
                    //Sua du lieu bang vaccine 
                if (!$this->updateSessionVaccine($request->input('vaccine_id'), $id))
                    throw new Exception();
                    //Sua du lieu vao bang trung gian session_vaccine

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
            }

            return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
        } else {
            return response()->json(['mess' => 'Sửa bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        }
        // $current_user = User::find(Auth::user()->id);

        // if ($current_user->can('update', Session::class)) {
        //     if ($this->updateModel($id, $request->all())) {
        //         return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
        //     } else {
        //         return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
        //     }
        // } else {
        //     return response()->json(['mess' => 'Sửa bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = User::find(Auth::user()->id);

        if ($currentUser->can('viewAny', User::class)) {
            if ($this->deleteModel($id)) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Xóa bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        }
    }

    public function forceDelete($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('viewAny', User::class)) {

            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Xóa bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        }
    }

    public function restore($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('viewAny', User::class)) {

            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Khôi phục bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Khôi phục bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Khôi phục bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        }
    }
}
