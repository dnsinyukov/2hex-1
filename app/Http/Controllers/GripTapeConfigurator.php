<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{GripTape, Order};
use App\Jobs\RecalculateOrders;

class GripTapeConfigurator extends Controller
{
	public function index()
    {
    	$filenames = [
            'carton'    => [],
            'backpaper' => [],
            'diecut'    => [],
            'top'       => []
        ];

        if(!auth()->check()) {
            return view('configurator.griptape', compact('filenames'));
        }

        $path = '';
        foreach (array_keys($filenames) as $value) {
            $path = public_path('uploads/' .  auth()->user()->name . '/' . $value);
            if(\File::exists($path)) {
                $filesInFolder = \File::files($path);

                foreach($filesInFolder as $filepath) { 
                      $file = pathinfo($filepath);
                      $filenames[$value][] = $file['filename'] . '.' . $file['extension'] ;
                } 
            }
        }

    	return view('configurator.griptape', compact('filenames'));
    }

    public function show($id)
    {
        $griptape = GripTape::find($id);

        $filenames = [
            'carton'    => [],
            'backpaper' => [],
            'diecut'    => [],
            'top'       => []
        ];

        if(!auth()->check()) {
            return view('configurator.griptape', compact('filenames', 'griptape'));
        }

        $path = '';
        foreach (array_keys($filenames) as $value) {
            $path = public_path('uploads/' .  auth()->user()->name . '/' . $value);
            if(\File::exists($path)) {
                $filesInFolder = \File::files($path);

                foreach($filesInFolder as $filepath) { 
                      $file = pathinfo($filepath);
                      $filenames[$value][] = $file['filename'] . '.' . $file['extension'] ;
                } 
            }
        }

        return view('configurator.griptape', compact('filenames', 'griptape'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required',
            'size'     => 'required',
        ]);

        $data = $request->all();

        if(empty($data['id'])){
            GripTape::query()->create(array_except($data, ['id']));
        } else {
            GripTape::where('id','=', $data['id'])->update($data);
        }

        dispatch(new RecalculateOrders(Order::auth()->get(), GripTape::auth()->get()));
    }

    public function destroy($id)
    {
        GripTape::where('id','=',$id)->delete();

        dispatch(new RecalculateOrders(Order::auth()->get(), GripTape::auth()->get()));  

        return redirect()->route('summary');
    }

    public function manufacturer()
    {
        return view('configurator.manufacturer');
    }
}