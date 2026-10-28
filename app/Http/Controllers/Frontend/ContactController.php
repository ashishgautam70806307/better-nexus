<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactEnquiryRequest;
use App\Models\ContactEnquiry;
class ContactController extends Controller
{
    public function index() { return view('frontend.pages.contact-us'); }
    public function store(StoreContactEnquiryRequest $request)
    {
        // Only approved public fields may reach the model; status/notes remain admin-only.
        $data=$request->safe()->only(['name','email','phone','subject','message']);
        // A repeated successful payload within this session is not stored twice.
        $fingerprint=hash('sha256',json_encode($data));
        $last=$request->session()->get('contact.last_submission',[]);
        if(($last['hash']??null)===$fingerprint && (time()-($last['at']??0))<120) {
            return redirect()->route('contact-us')->with('info','Your enquiry has already been received.');
        }
        ContactEnquiry::create($data);
        $request->session()->put('contact.last_submission',['hash'=>$fingerprint,'at'=>time()]);
        return redirect()->route('contact-us')->with('success','Thank you! Your enquiry has been received. Our team will contact you soon.');
    }
}
