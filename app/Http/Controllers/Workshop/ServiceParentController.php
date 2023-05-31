<?php

namespace App\Http\Controllers\Workshop;

use App\Models\ServiceParent;
use App\Models\TypeService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceParentController extends Controller {

    public function index() {
        $service = ServiceParent::all();
        $typeService = TypeService::all();
        return view('master.service-parent.index', compact('service', 'typeService'));
    }

    public function create() {
        $typeService = TypeService::all();
        return view('master.service-parent.create', compact('typeService'));
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'type_service_id' => ''
        ]);

        $s = substr(str_replace('.', '', $request->s), 3);
        $m = substr(str_replace('.', '', $request->m), 3);
        $l = substr(str_replace('.', '', $request->l), 3);
        $xl = substr(str_replace('.', '', $request->xl), 3);

        $validateData['panel'] = str_replace(',', '.', $request->panel);

        $success = true;

        DB::beginTransaction();
        try {
            $parent = ServiceParent::create($validateData);
            if ($parent) {
                if (!empty($s)) {
                    $service = new Service();
                    $service->parent_id = $parent->id;
                    $service->name = $parent->name . ' S';
                    $service->type_service_id = $parent->type_service_id;
                    $service->estimated_costs = $s;
                    $service->type = 's';
                    $service->panel = $request->panel;
                    $saved = $service->save();
                    if (!$saved) {
                        $success = false;
                    }
                }
                if (!empty($m)) {
                    $service = new Service();
                    $service->parent_id = $parent->id;
                    $service->name = $parent->name . ' M';
                    $service->type_service_id = $parent->type_service_id;
                    $service->estimated_costs = $m;
                    $service->type = 'm';
                    $service->panel = $request->panel;
                    $saved = $service->save();
                    if (!$saved) {
                        $success = false;
                    }
                }
                if (!empty($l)) {
                    $service = new Service();
                    $service->parent_id = $parent->id;
                    $service->type_service_id = $parent->type_service_id;
                    $service->name = $parent->name . ' L';
                    $service->type = 'l';
                    $service->estimated_costs = $l;
                    $service->panel = $request->panel;
                    $saved = $service->save();
                    if (!$saved) {
                        $success = false;
                    }
                }
                if (!empty($xl)) {
                    $service = new Service();
                    $service->parent_id = $parent->id;
                    $service->type_service_id = $parent->type_service_id;
                    $service->name = $parent->name . ' XL';
                    $service->type = 'xl';
                    $service->estimated_costs = $xl;
                    $service->panel = $request->panel;
                    $saved = $service->save();
                    if (!$saved) {
                        $success = false;
                    }
                }
            }
            if ($success) {
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }
        return redirect()->route('service-parent.index')
                        ->with('success', 'Service created successfully.');
    }

    public function show(Service $service) {
        return view('master.service.show', compact('service'));
    }

    public function edit(Service $service) {
        $typeService = TypeService::all();
        return view('master.service.edit', compact('service', 'typeService'));
    }

    public function editCustom() {
        $parent = ServiceParent::where('id', $_POST['id'])->first();
        $service = Service::where('parent_id', $_POST['id'])->get();
        $result = [];
        $result['name'] = $parent->name;
        $result['type'] = $parent->type_service_id;
        $result['panel'] = $parent->panel;
        $result['s'] = 0;
        $result['m'] = 0;
        $result['l'] = 0;
        $result['xl'] = 0;

        foreach ($service as $v) {
            if ($v->type == 's')
                $result['s'] = $v->estimated_costs;
            if ($v->type == 'm')
                $result['m'] = $v->estimated_costs;
            if ($v->type == 'l')
                $result['l'] = $v->estimated_costs;
            if ($v->type == 'xl')
                $result['xl'] = $v->estimated_costs;
        }
        return json_encode($result);
    }

    public function update(Request $request, Service $service) {
        $validateData = $request->validate([
            //'name' => 'required|max:255|unique:services,name,' . $service->id . ',id,deleted_at,NULL',
            'name' => 'required|max:255',
            'type_service_id' => ''
        ]);

        $validateData['estimated_costs'] = substr(str_replace('.', '', $request->estimated_costs), 3);
        $validateData['panel'] = str_replace(',', '.', $request->panel);

        $service->update($validateData);

        return redirect()->route('service.index')
                        ->with('success', 'Service updated successfully');
    }

    public function updateService() {
        $model = ServiceParent::where('id', $_POST['id'])->first();
        $service = Service::where('parent_id', $_POST['id'])->get();

        $success = true;
        $message = '';
        DB::beginTransaction();
        try {
            $model->name = $_POST['name'];
            $model->type_service_id = $_POST['type_service_id'];
            $model->panel = $_POST['panel'];

            $s = substr(str_replace('.', '', $_POST['s']), 3);
            $m = substr(str_replace('.', '', $_POST['m']), 3);
            $l = substr(str_replace('.', '', $_POST['l']), 3);
            $xl = substr(str_replace('.', '', $_POST['xl']), 3);

            $saved = $model->save();

            if (!$saved) {
                $success = false;
            }
            $arr = ['s' => 's', 'l' => 'l', 'm' => 'm', 'xl' => 'xl'];
            foreach ($service as $v) {
                if ($v->type == 's') {
                    $v->estimated_costs = $s;
                }
                if ($v->type == 'm') {
                    $v->estimated_costs = $m;
                }
                if ($v->type == 'l') {
                    $v->estimated_costs = $l;
                }
                if ($v->type == 'xl') {
                    $v->estimated_costs = $xl;
                }
                $v->name = $model->name . ' ' . strtoupper($v->type);
                $v->type_service_id = $model->type_service_id;
                $v->panel = $model->panel;
                $saved = $v->save();
                if (!$saved) {
                    $success = false;
                }
                unset($arr[$v->type]);
            }
            if (!empty($arr) && $success) {
                foreach ($arr as $v) {
                    $service = new Service();
                    $service->parent_id = $model->id;
                    $service->type_service_id = $model->type_service_id;
                    $service->name = $model->name . ' ' . strtoupper($v);
                    $service->type = $v;
                    if ($v == 's')
                        $service->estimated_costs = $s;
                    if ($v == 'm')
                        $service->estimated_costs = $m;
                    if ($v == 'l')
                        $service->estimated_costs = $l;
                    if ($v == 'xl')
                        $service->estimated_costs = $xl;
                    $service->panel = $model->panel;
                    $saved = $service->save();
                    if (!$saved) {
                        $success = false;
                    }
                }
            }
            if ($success) {
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
            $message = $e->getMessage();
        }
        return json_encode(['success' => $success, 'message' => $message]);
    }

    public function destroy(ServiceParent $ServiceParent) {
        $ServiceParent->delete();
        foreach ($ServiceParent->service as $v) {
            $v->delete();
        }
        return redirect()->route('service-parent.index')
                        ->with('success', 'Service <b>' . $ServiceParent->name . '</b> deleted successfully');
    }

}
