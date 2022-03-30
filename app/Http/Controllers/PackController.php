<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackRequest;
use App\Pack;
use App\Repositories\PackRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackController extends PackRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            if (empty(request()->all()))
                $packs = $this->getPaginate10();
            else 
                $packs = $this->getFilter10();

            return view ('admin.pack.index', [
                'packs' => $packs,
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

        if ($current_user->can('viewAny', User::class)) {
            return view ('admin.pack.create', [
                'vaccines' => $this->getActiveVaccines(),
                // 'producers' => $this->getActiveProducers(),
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
    public function store(PackRequest $request)
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            if ($this->createModel($request->all()) != false) {
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

        if ($current_user->can('viewAny', User::class)) {
            $pack = $this->find($id);

            if (empty($pack)) {
                return redirect()->route('admin.errors.404');
            }

            return view('admin.pack.edit', [
                'pack' => $pack,
                'vaccines' => $this->getActiveVaccines(),
                'producers' => $this->getActiveProducers(),
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
    public function update(PackRequest $request, $id)
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
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

    public function forceDelete($id)
    {
        // $currentUser = User::findOrFail(Auth()->user()->id);

        // if ($currentUser->can('forceDelete', ClassRoom::class)) {

            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        // } else {
        //     return response()->json(['mess' => 'Xóa bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        // }
    }

    public function restore($id)
    {
        // $currentUser = User::findOrFail(Auth()->user()->id);

        // if ($currentUser->can('restore', ClassRoom::class)) {

            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Khôi phục bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Khôi phục bản không thành công'], 400);
            }
        // } else {
        //     return response()->json(['mess' => 'Khôi phục bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        // }
    }

    public function getActivePacksByVaccineId($vaccine_id) {
        return response()->json([
            'status' => true,
            'data' => $this->getActivePacks($vaccine_id),
        ]);
    }
}