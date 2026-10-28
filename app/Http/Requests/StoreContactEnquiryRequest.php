<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreContactEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        $key='contact-enquiry:'.hash('sha256',(string)$this->ip());
        if(\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key,5)) {
            throw \Illuminate\Validation\ValidationException::withMessages(['form'=>'Too many attempts. Please wait a minute before trying again.']);
        }
        \Illuminate\Support\Facades\RateLimiter::hit($key,60);
        return true;
    }
    protected function prepareForValidation(): void
    {
        $values=[];
        foreach(['name','email','phone','subject','message','website'] as $key) {
            $value=$this->input($key);
            if(is_string($value)) $values[$key]=trim($value);
        }
        $this->merge($values);
    }
    public function rules(): array
    {
        return [
            'name'=>['bail','required','string','min:2','max:120','regex:/\p{L}/u'],
            'email'=>['bail','required','string','email:rfc','max:255'],
            'phone'=>['bail','nullable','string','regex:/^[0-9]{10,12}$/'],
            'subject'=>['bail','nullable','string','max:180'],
            'message'=>['bail','required','string','min:10','max:5000'],
            'website'=>['nullable','string','max:0'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'=>'Please enter your name.',
            'name.min'=>'Your name must have at least 2 characters.',
            'name.regex'=>'Please enter a name containing letters.',
            'email.required'=>'Please enter your email address.',
            'email.email'=>'Please enter a valid email address.',
            'phone.regex'=>'Enter a phone number with 10–12 digits only, without +, spaces or dashes.',
            'message.required'=>'Please tell us what you need.',
            'message.min'=>'Please write at least 10 characters.',
            'message.max'=>'Your message must be 5,000 characters or fewer.',
            'website.max'=>'Unable to submit this form. Please refresh and try again.',
        ];
    }
}
