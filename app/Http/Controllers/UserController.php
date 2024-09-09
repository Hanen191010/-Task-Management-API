<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // الحصول على جميع المستخدمين من قاعدة البيانات وإرجاعهم كاستجابة JSON
        return response()->json(User::all());
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // التحقق من صحة البيانات الواردة في الطلب
        $request->validate([
            'name' => 'required|string', // الاسم مطلوب ونوعه نصي
            'email' => 'required|string|email|unique:users', // البريد الإلكتروني مطلوب ونوعه نصي وصحيح و فريد
            'password' => 'required|string', // كلمة المرور مطلوبة ونوعها نصي
            'role' => 'required' // الدور مطلوب 
        ]);

        // إنشاء مستخدم جديد باستخدام البيانات المصادقة
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // تشفير كلمة المرور
            'role' => $request->role
        ]);

        // إرجاع المستخدم الجديد كاستجابة JSON مع رمز 201 (تم إنشاء المورد بنجاح)
        return response()->json($user, 201);
    }

    /*
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // الحصول على المستخدم المطلوب من قاعدة البيانات باستخدام ID
        $user = User::findOrFail($id);

        // إرجاع المستخدم كاستجابة JSON
        return response()->json($user);
    }

    /*
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // الحصول على المستخدم المطلوب من قاعدة البيانات باستخدام ID
        $user = User::findOrFail($id);

        // منطق التحقق من صحة البيانات وتحديثها ...
    }

    /*
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // حذف المستخدم من قاعدة البيانات باستخدام ID
        User::destroy($id);

        // إرجاع استجابة JSON فارغة مع رمز 204 (لا يوجد محتوى)
        return response()->json(null, 204);
    }

    /*
     * Restore a soft deleted user
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        // استعادة المستخدم المحذوف باستخدام ID
        $user = User::withTrashed()->where('id', $id)->restore();

        // إرجاع المستخدم المُستعاد كاستجابة JSON
        return response()->json($user);
    }
}
