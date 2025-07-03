<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>افزودن معلم جدید</title>
    <style>
        body {
            font-family: sans-serif;
            direction: rtl;
            padding: 30px;
            background-color: #f2f2f2;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 600px;
            margin: auto;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background: #3490dc;
            color: white;
            border: none;
            cursor: pointer;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #3490dc;
        }
    </style>
</head>
<body>
    @if ($errors->any())
        <div style="background-color: #f8d7da; padding: 10px; border-radius: 6px; color: #721c24; margin-bottom: 15px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding: 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf
        <h2>➕ افزودن معلم جدید</h2>
        <label>نام</label>
        <input type="text" name="first_name" required>
        <label>نام خانوادگی</label>
        <input type="text" name="last_name" required>
        <label>کد ملی</label>
        <input type="text" name="national_code" required>
        <label>شماره تماس</label>
        <input type="text" name="phone" required>
        <label>آدرس محل زندگی</label>
        <textarea name="address"></textarea>
        <label>تحصیلات</label>
        <input type="text" name="education_level" required>
        <label>کلاس‌ها و درس‌های تدریسی</label>
        <select name="subjects_classes[]" multiple>
            @foreach($subjects as $subject)
                @foreach($subject->grade->classes as $class)
                    @php
                        $pairKey = $subject->id . '_' . $class->id;
                        $taken = DB::table('teacher_subject_class')
                                    ->where('subject_id', $subject->id)
                                    ->where('school_class_id', $class->id)
                                    ->exists();
                    @endphp
                        <option value="{{ $pairKey }}" @if($taken) disabled @endif>
                            {{ $subject->name }} - کلاس {{ $class->name }} (پایه: {{ $subject->grade->name }})
                            @if($taken) - (قبلاً گرفته شده) @endif
                        </option>
                @endforeach
            @endforeach
        </select>
        <button type="submit">ثبت معلم</button>
        <a href="{{ route('teachers.index') }}">⬅ بازگشت</a>
    </form>
</body>
</html>