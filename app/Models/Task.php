<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    // اسم الجدول في قاعدة البيانات
    protected $table = 'tasks';

    // مفتاح الجدول الأساسي
    protected $primaryKey = 'task_id';

    // الأعمدة التي يمكن ملؤها بواسطة المستخدم
    protected $fillable = ['title', 'description', 'priority', 'due_date', 'status', 'assigned_to'];

    // هل المفتاح الأساسي متزايد تلقائيًا؟
    public $incrementing = true;

    // هل يتم تتبع أوقات إنشاء وتحديث السجلات؟
    public $timestamps = true;

    // أسماء الأعمدة التي تمثل أوقات إنشاء وتحديث السجلات
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // الأعمدة التي تمثل تواريخ
    protected $dates = ['due_date'];

    // نطاق لفلترة المهام بناءً على الأولوية
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    // نطاق لفلترة المهام بناءً على الحالة
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // تحويل قيمة "due_date" إلى تنسيق d-m-Y H:i عند الحصول عليها
    public function getDueDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    // تحويل قيمة "due_date" إلى تنسيق Y-m-d H:i عند تعيينها
    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = Carbon::createFromFormat('d-m-Y H:i', $value);
    }
}
