<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContactEnquiry extends Model {
    public const STATUSES = ['new'=>'New', 'in_progress'=>'In progress', 'resolved'=>'Resolved', 'spam'=>'Spam'];
    protected $fillable = ['name','email','phone','subject','message','status','admin_notes'];
}
