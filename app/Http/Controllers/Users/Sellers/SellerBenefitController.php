<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\BenefitSectionElements;
use App\Models\UserBenefitSection;
use Illuminate\Http\Request;

class SellerBenefitController extends Controller
{
    public function index()
    {
        $benefit_section_id = auth()->user()->benefit_section->id;
        $benefits_elements = BenefitSectionElements::where('benefit_section_id', $benefit_section_id)->get();
        $benefit = UserBenefitSection::findOrfail($benefit_section_id);

        return view('users.sellers.pages.sections.benefits.index', compact('benefits_elements', 'benefit'));
    }

    public function edit($id)
    {
        $element = BenefitSectionElements::findOrFail($id);

        return response()->json($element);
    }

    // store
    public function store(Request $request)
    {
        $benefit_section_id = auth()->user()->benefit_section->id;
        $request->merge(['benefit_section_id' => $benefit_section_id]);
        $element = BenefitSectionElements::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم اضافة العنصر بنجاح',
            'element' => $element,
        ]);
    }

    // update
    public function update(Request $request, $id)
    {
        $element = BenefitSectionElements::findOrFail($id);
        $element->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث العنصر بنجاح',
            'element' => $element,
        ]);
    }

    // destroy
    public function destroy($id)
    {
        $element = BenefitSectionElements::findOrFail($id);

        try {
            $element->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف العنصر بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطاء اثناء الحذف: '.$e->getMessage(),
            ], 500);
        }
    }

    // benefitsEdit
    public function benefitsEdit($id)
    {
        $benefit = UserBenefitSection::findOrfail($id);

        return response()->json($benefit);
    }

    // benefitsUpdate
    public function benefitsUpdate(Request $request, $id)
    {
        $benefit = UserBenefitSection::findOrfail($id);
        $benefit->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث القسم بنجاح',
            'benefit' => $benefit,
        ]);
    }

    // updateStatus
    public function updateStatus(Request $request)
    {
        // dd($request->all());
        // get benefit section
        $benefit = UserBenefitSection::findOrfail($request->benefit_id);
        if ($request->benefit_status == 'on') {
            $benefit->status = 'active';
        } else {
            $benefit->status = 'inactive';
        }
        $benefit->save();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم تحديث حالة السلايدر بنجاح',
        // ]);
        return redirect()->back()->with('success', 'تم تحديث حالة الأقسام بنجاح');
    }
}
