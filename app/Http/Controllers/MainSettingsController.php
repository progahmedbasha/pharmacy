<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\MainSettingRequest;
use App\Http\Traits\Upload_Files;

class MainSettingsController extends Controller
{
    use Upload_Files;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $setting = Setting::get();

        return view('admin.settings.grid', compact('setting'));
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
        //
        $setting = Setting::first();

        return view('admin.settings.form', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MainSettingRequest $request, $id)
    {
        $setting = Setting::findOrFail($request->id);

        if($request->hasFile('logo') )
        {
            $file_name = $this->uploadFiles('setting', $request->logo, 'null');

        }
        else
        {
            $file_name = $setting->logo;
        }

        if($request->hasFile('fav_icon') )
        {
            $fav_icon = $this->uploadFiles('setting',$request->fav_icon, 'null');
        }
        else
        {
            $fav_icon = $setting->fav_icon;
        }

        $setting->update([
            'site_name'     => $request->site_name,
            'site_name_en'  => $request->site_name_en,
            'phone'         => $request->phone,
            'logo'          => $file_name,
            'fav_icon'      => $fav_icon
        ]);

        toastr()->success("تم تعديل الإعدادات بنجاح");
        return redirect()->back();
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
