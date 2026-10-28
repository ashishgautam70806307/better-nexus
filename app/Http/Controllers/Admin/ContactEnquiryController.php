<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ContactEnquiryController extends Controller {
    public function index(Request $request) {
        $v=$request->validate(['search'=>'nullable|string|max:100','status'=>['nullable',Rule::in(array_keys(ContactEnquiry::STATUSES))]]);
        $search=trim($v['search']??'');
        $enquiries=ContactEnquiry::query()
            ->when($search, fn($q)=>$q->where(fn($q)=>$q->where('name','like',"%{$search}%")->orWhere('email','like',"%{$search}%")->orWhere('phone','like',"%{$search}%")->orWhere('subject','like',"%{$search}%")))
            ->when($v['status']??null,fn($q,$status)=>$q->where('status',$status))
            ->latest('id')->paginate(15)->withQueryString();
        return view('admin.enquiries.index', compact('enquiries','search'));
    }
    public function show(ContactEnquiry $enquiry) { return view('admin.enquiries.show',compact('enquiry')); }
    public function update(Request $request, ContactEnquiry $enquiry) {
        $data=$request->validate(['status'=>['required',Rule::in(array_keys(ContactEnquiry::STATUSES))],'admin_notes'=>'nullable|string|max:5000']);
        $enquiry->update($data);
        return redirect()->route('admin.enquiries.show',$enquiry)->with('success','Enquiry updated successfully.');
    }
    public function destroy(ContactEnquiry $enquiry) {
        $enquiry->delete();
        return redirect()->route('admin.enquiries.index')->with('success','Enquiry deleted successfully.');
    }
}
