<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\Supplier\SupplierPage;
use Illuminate\Http\Request;
use App\Models\UserStoreSetting;
use App\Models\UserBenefitSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SupplierSettingController extends Controller
{
    //
    public function index()
    {
        $pages=SupplierPage::where('supplier_id',get_supplier_data(auth()->user()->tenant_id)->id)->get();
        $settings=UserStoreSetting::where('user_id',auth()->user()->id)->get();
        $benefit_section=UserBenefitSection::where('user_id',auth()->user()->id)->first();
        return view('users.suppliers.settings.index',compact('pages','settings','benefit_section'));
    }
    //update theme
    public function theme_update(Request $request,$user_id)
    {
        // filter data 
        // if has file then update logo
        if($image=$request->file('image'))
        {
            $extension=explode('.',$image->getClientOriginalName())[1];
            $name=explode('.',$image->getClientOriginalName())[0];
            $image_name=$name.'-'.time().'.'.$extension;
            $store_name=get_supplier_data(auth()->user()->tenant_id)->store_name;
            $path = 'supplier/'.$store_name.'/images/logo';
            if(!Storage::disk('public')->exists($path))
            {
                Storage::disk('public')->makeDirectory($path);
            }else
            {
                Storage::disk('public')->deleteDirectory($path);
                Storage::disk('public')->makeDirectory($path);
            }
            $image->storeAs($path,$image_name ,'public');
            $supplier_logo=UserStoreSetting::where('user_id',$user_id)->where('key','store_logo')->first();
            if($supplier_logo==null)
            {
                $supplier_logo=new UserStoreSetting();
                $supplier_logo->user_id=$user_id;
                $supplier_logo->key='store_logo';
                $supplier_logo->value='/storage/tenantsupplier/app/public/'.$path.'/'.$image_name;
                $supplier_logo->save();
            }
            $supplier_logo->value='/storage/tenantsupplier/app/public/'.$path.'/'.$image_name;
            $supplier_logo->update();
        }   
        $supplier_theme=UserStoreSetting::where('user_id',$user_id)->where('key','store_theme')->first();
        if($supplier_theme==null)
        {
            $supplier_theme=new UserStoreSetting();
            $supplier_theme->user_id=$user_id;
            $supplier_theme->key='store_theme';
            $supplier_theme->value=json_encode(
                ['primarycolor'=>$request->primarycollor,
                'bodytextcolor'=>$request->bodytextcolor,
                'footertextcolor'=>$request->footertextcolor]
            );
            $supplier_theme->save();
        }
        $supplier_theme->value=json_encode(
        ['primarycolor'=>$request->primarycollor,
            'bodytextcolor'=>$request->bodytextcolor,
            'footertextcolor'=>$request->footertextcolor]);
        $supplier_theme->update();
        return redirect()->back()->with('success','تم التحديث بنجاح');
    }
        /**
     * Update store settings
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validation rules
        $rules = [
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'store_welcome_message' => 'nullable|string',
            'store_email' => 'nullable|email|max:255',
            'store_address' => 'nullable|string|max:500',
            'store_phone' => 'nullable|string|max:20',
            'store_facebook' => 'nullable|url|max:255',
            'store_telegram' => 'nullable|url|max:255',
            'store_tiktok' => 'nullable|url|max:255',
            'store_twitter' => 'nullable|url|max:255',
            'store_instagram' => 'nullable|url|max:255',
            'store_youtube' => 'nullable|url|max:255',
            'copyright' => 'nullable|string|max:255',
            'store_payment_methods' => 'required|array',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', 'store_setting'); // Add this line
        }
    //     if ($validator->fails()) {
    // return redirect(url()->previous() . '#store-setting-tab')
    //     ->withErrors($validator)
    //     ->withInput();
// }

        // Get all validated data
        $validated = $validator->validated();

        // dd($validated['store_payment_methods'],$request['store_payment_methods']);
        // $user_setting=UserStoreSetting::where('user_id',$user->id)->get();
        // $store_payment_methods=$user_setting[17]->value;
        $array=[];
        foreach ($validated['store_payment_methods'] as $key => $value) {
            if(!isset($value['status']))
            {
                $array[$key]=['name'=>$key,'status'=>'inactive'];
            }else
            {
                $array[$key]=$value;
            }
        }
        $payment_values=json_encode($array);
        // dd($array);
        $validated['store_payment_methods']=$array;

            // dd($validated['store_payment_methods'],json_decode($store_payment_methods));
        try {
            // Update or create each setting
            foreach ($validated as $key => $value) {

                UserStoreSetting::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'key' => $key
                    ],
                    [
                        'value' =>$key=='store_payment_methods'?$payment_values:$value,
                        'type' => $this->determineType($value),
                        'description' => $this->getDescription($key),
                        'status' => 'active'
                    ]
                );
            }

            return redirect()->route('supplier.settings')
                ->with('success', 'تم تحديث الإعدادات بنجاح')
                ->with('activate_store_tab', true); // Add this line
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حفظ الإعدادات: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Determine the type of the value
     */
    private function determineType($value)
    {
        if (is_bool($value)) return 'boolean';
        if (is_numeric($value)) return 'integer';
        if (is_array($value) || is_object($value)) return 'json';
        return 'string';
    }

    /**
     * Get description for setting key
     */
    private function getDescription($key)
    {
        $descriptions = [
            'store_name' => 'اسم المتجر',
            'store_description' => 'وصف المتجر',
            'store_email' => 'بريد المتجر الإلكتروني',
            'store_address' => 'عنوان المتجر',
            'store_phone' => 'هاتف المتجر',
            'store_facebook' => 'رابط فيسبوك',
            'store_telegram' => 'رابط تليجرام',
            'store_tiktok' => 'رابط تيك توك',
            'store_twitter' => 'رابط تويتر',
            'store_instagram' => 'رابط إنستجرام',
            'store_youtube' => 'رابط يوتيوب',
            'copyright' => 'حقوق النشر'
        ];

        return $descriptions[$key] ?? $key;
    }
}
