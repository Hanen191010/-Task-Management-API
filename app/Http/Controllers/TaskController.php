<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        // تأكد من أن المستخدم لديه صلاحية عرض المهام
        $this->authorize('viewAny', Task::class);

        // الحصول على المهام من قاعدة البيانات
        $tasks = Task::when($request->priority, function ($query) use ($request) {
            // إذا تم تمرير "priority" في الطلب، فقم بفلترة المهام بناءً على ذلك
            return $query->priority($request->priority);
        })
        ->when($request->status, function ($query) use ($request) {
            // إذا تم تمرير "status" في الطلب، فقم بفلترة المهام بناءً على ذلك
            return $query->status($request->status);
        })
        ->get();

        // إرجاع المهام كاستجابة JSON
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        // تأكد من أن المستخدم لديه صلاحية إنشاء مهام جديدة
        $this->authorize('create', Task::class);

        // التحقق من صحة البيانات الواردة في الطلب
        $request->validate([
            'title' => 'required|string', // العنوان مطلوب ونوعه نصي
            'priority' => 'required|string', // الأولوية مطلوبة ونوعها نصي
            'due_date' => 'nullable|date', // تاريخ الاستحقاق اختياري ونوعه تاريخ
        ]);

        // إنشاء مهمة جديدة باستخدام البيانات المصادقة
        $task = Task::create($request->all());

        // إرجاع المهمة الجديدة كاستجابة JSON مع رمز 201 (تم إنشاء المورد بنجاح)
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        // الحصول على المهمة المطلوبة من قاعدة البيانات باستخدام ID
        $task = Task::findOrFail($id);

        // تأكد من أن المستخدم لديه صلاحية عرض المهمة
        $this->authorize('view', $task);

        // إرجاع المهمة كاستجابة JSON
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // الحصول على المهمة المطلوبة من قاعدة البيانات باستخدام ID
        $task = Task::findOrFail($id);

        // تأكد من أن المستخدم لديه صلاحية تعديل المهمة
        $this->authorize('update', $task);

        // تحديث بيانات المهمة بالبيانات الواردة في الطلب
        $task->update($request->all());

        // إرجاع المهمة المُحدّثة كاستجابة JSON
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // الحصول على المهمة المطلوبة من قاعدة البيانات باستخدام ID
        $task = Task::findOrFail($id);

        // تأكد من أن المستخدم لديه صلاحية حذف المهمة
        $this->authorize('delete', $task); 

        // حذف المهمة من قاعدة البيانات
        $task->delete();

        // إرجاع استجابة JSON فارغة مع رمز 204 (لا يوجد محتوى)
        return response()->json(null, 204);
    }

    /**
     * Restore a soft deleted task
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        // استعادة المهمة المحذوفة باستخدام ID
        $task = Task::withTrashed()->where('id', $id)->restore();

        // إرجاع المهمة المُستعادة كاستجابة JSON
        return response()->json($task);
    }

    /**
     * Assign a task to a user.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request, $id)
    {
        // الحصول على المهمة المطلوبة من قاعدة البيانات باستخدام ID
        $task = Task::findOrFail($id);

        // تأكد من أن المستخدم لديه صلاحية تعديل المهمة (لأن تعيينها يعديل)
        $this->authorize('update', $task); 

        // تحديث سمة assigned_to في المهمة بـ ID المستخدم المعين
        $task->assigned_to = $request->assigned_to;

        // حفظ التغييرات على المهمة في قاعدة البيانات
        $task->save();

        // إرجاع المهمة المُحدّثة كاستجابة JSON
        return response()->json($task);
    }
}