<?php

namespace App\Http\Controllers;

use App\Http\Requests\vaccineRequest;
use App\Repositories\VaccineRepository;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VaccineController extends VaccineRepository
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
                $vaccines = $this->getPaginate10();
            else 
                $vaccines = $this->getFilter10(); 

            return view ('admin.vaccine.index', [
                'vaccines' => $vaccines,
                'sort' => empty(request()->query('sort')) ? '' : request()->query('sort'),
                'status' => empty(request()->query('status')) ? '' : request()->query('status'),
                'name' => empty(request()->query('name')) ? '' : request()->query('name'),
            ]);
        } else {
            return redirect()->route('admin.errors.4xx');
        }
        
    }

    public function getDataWithTrashed () {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            $vaccines = $this->getVaccinesWithTrashed();

            return view('admin.vaccine.trash', [
                'vaccines' => $vaccines,
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
            return view ('admin.vaccine.create', [
                'producers' => $this->getActiveProducers(),
                'diseases' => $this->getActiveDiseases(),
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
    public function store(VaccineRequest $request)
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            // b???t ?????u Rollback
            DB::beginTransaction();

            try {
                $vaccine_id = $this->createVaccine($request);
                //Tao ban ghi moi cho bang vaccine tra ve id ban ghi moi

                if ($vaccine_id == 0) 
                    throw new Exception();

                if (!$this->createVaccineProducer($request->input('producer_id'), $vaccine_id))
                    throw new Exception();
                    //Them du lieu vao bang trung gian vaccine_producer

                if (!$this->createVaccineDisease($request->input('disease_id'), $vaccine_id))
                    throw new Exception();    
                    //Them du lieu vao bang trung gian vaccine_disease

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['mess' => 'Th??m b???n ghi l???i'], 502);
            }

            return response()->json(['mess' => 'Th??m b???n ghi th??nh c??ng', 200]);
        } else {
            return response()->json(['mess' => 'Th??m b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
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
            $vaccine = $this->find($id);

            if (empty($vaccine)) {
                return redirect()->route('admin.errors.404');
            }

            return view('admin.vaccine.edit', [
                'vaccine' => $vaccine,
                'producers' => $this->getActiveProducers(),
                'diseases' => $this->getActiveDiseases(),
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
    public function update(vaccineRequest $request, $id)
    {
        $current_user = User::find(Auth::user()->id);

        if ($current_user->can('viewAny', User::class)) {
            // b???t ?????u Rollback
            DB::beginTransaction();

            try {
                if (!$this->updateVaccine($request, $id)) 
                    throw new Exception();
                    //Sua du lieu bang vaccine 
                if (!$this->updateVaccineProducer($request->input('producer_id'), $id))
                    throw new Exception();
                    //Sua du lieu vao bang trung gian vaccine_producer

                if (!$this->updateVaccineDisease($request->input('disease_id'), $id))
                    throw new Exception();    
                    //Sua du lieu vao bang trung gian vaccine_disease

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['mess' => 'S???a b???n ghi l???i'], 502);
            }

            return response()->json(['mess' => 'S???a b???n ghi th??nh c??ng', 200]);
        } else {
            return response()->json(['mess' => 'S???a b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
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
        $currentUser = User::find(Auth::user()->id);

        if ($currentUser->can('viewAny', User::class)) {
            if ($this->deleteModel($id)) {
                return response()->json(['mess' => 'Xo??a ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Xo??a ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'X??a b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
        }
    }

    public function forceDelete($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('viewAny', User::class)) {

            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xo??a ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Xo??a ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'X??a b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
        }
    }

    public function restore($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('viewAny', User::class)) {

            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Kh??i ph???c ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Kh??i ph???c ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'Kh??i ph???c b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
        }
    }

    public function getVaccinesByDiseaseId ($id) {
        return response()->json([
            'status' => true,
            'data' => $this->getActiveVaccine($id),
        ]);
    }
}
