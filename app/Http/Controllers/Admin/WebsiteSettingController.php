<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use App\Support\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class WebsiteSettingController extends Controller {
    private const IMAGES=['header_logo','footer_logo','favicon'];
    public function edit() { return view('admin.settings.edit',['groups'=>config('website-settings')]); }
    public function update(Request $request, SiteSettings $settings) {
        $rules=[];
        foreach(config('website-settings') as $group=>$fields) {
            foreach($fields as $key=>$definition) {
                $rules[$key]=[$key==='website_name' ? 'required' : 'nullable','string','max:1000'];
                if(str_contains($key,'email')) $rules[$key]=['nullable','email','max:255'];
                if(in_array($key,['website_url','office_primary_map','office_secondary_map','facebook','instagram','linkedin','youtube','x_url'])) $rules[$key]=['nullable','url:http,https','max:1000'];
                if(in_array($key,['phone_primary','phone_secondary','whatsapp'])) $rules[$key]=['nullable','string','max:30','regex:/^[+0-9().\s-]{7,30}$/'];
            }
        }
        foreach(self::IMAGES as $key) {
            $rules[$key]=['nullable','image','mimes:png,jpg,jpeg,webp','max:2048','dimensions:max_width=4000,max_height=4000'];
            $rules['remove_'.$key]=['nullable','boolean'];
        }
        // PNG favicon only: avoids SVG script payloads and ambiguous ICO validation.
        $rules['favicon']=['nullable','image','mimes:png','max:512','dimensions:min_width=32,min_height=32,max_width=512,max_height=512,ratio=1/1'];
        $v=$request->validate($rules);
        $new=[]; $old=[]; $values=[];
        foreach(config('website-settings') as $fields) foreach($fields as $key=>$definition) $values[$key]=$v[$key] ?? '';
        try {
            foreach(self::IMAGES as $key) {
                if($request->hasFile($key)) {
                    $old[]=$settings->get($key);
                    $path=$request->file($key)->store('website-settings','public');
                    if(!$path) throw new \RuntimeException('Unable to store image.');
                    $new[]=$path; $values[$key]='storage/'.$path;
                } elseif($request->boolean('remove_'.$key)) {
                    $old[]=$settings->get($key); $values[$key]='';
                }
            }
            DB::transaction(function() use($values) {
                foreach($values as $key=>$value) WebsiteSetting::updateOrCreate(['key'=>$key],['value'=>$value]);
            });
        } catch(\Throwable $error) {
            foreach($new as $path) Storage::disk('public')->delete($path);
            throw $error;
        }
        $settings->forget();
        foreach(array_unique(array_filter($old)) as $path) {
            if(preg_match('~^storage/website-settings/[A-Za-z0-9_-]+\.(png|jpe?g|webp)$~i',$path) && !WebsiteSetting::where('value',$path)->exists()) Storage::disk('public')->delete(substr($path,8));
        }
        return redirect()->route('admin.settings.edit')->with('success','Website settings updated successfully.');
    }
}
