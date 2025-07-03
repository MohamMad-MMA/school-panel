<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ویرایش معلم</title>
    <style>
        body {font-family: sans-serif; direction: rtl; padding: 30px; background-color: #f2f2f2;}
        form {background: white;    padding: 20px;   border-radius: 8px;    width: 600px; margin: auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
        label { display: block; margin-top: 10px; }
        input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; }
        button { background: #3490dc; color: white; border: none; padding: 10px 20px; border-radius: 5px; }
        .back-button { margin-top: 20px; display: inline-block; background: #6c757d; color: white; padding: 8px 15px; border-radius: 6px; text-decoration: none; }
    </style>
</head>
<body>
    <h2>✏️ ویرایش معلم</h2>
    <a class="back-button" href="{{ route('teachers.index') }}">⬅️ بازگشت</a>
    @if ($errors->any())
        <div style="background-color: #f8d7da; padding: 10px; border-radius: 6px; color: #721c24; margin-bottom: 15px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding: 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('teachers.update', $teacher->id) }}">
        @csrf
        @method('PUT')
        <label>نام</label>
        <input type="text" name="first_name" value="{{ old('first_name', $teacher->first_name) }}" required>
        <label>نام خانوادگی</label>
        <input type="text" name="last_name" value="{{ old('last_name', $teacher->last_name) }}" required>
        <label>کد ملی</label>
        <input type="text" name="national_code" value="{{ old('national_code', $teacher->national_code) }}" required>
        <label>شماره تماس</label>
        <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" required>
        <label>آدرس</label>
        <textarea name="address" required>{{ old('address', $teacher->address) }}</textarea>
        <label>تحصیلات</label>
        <input type="text" name="education_level" value="{{ old('education_level', $teacher->education_level) }}" required>
        <label>کلاس‌ها و درس‌های تدریسی</label>
        <select name="subjects_classes[]" multiple>
            @foreach($subjects as $subject)
                @foreach($subject->grade->classes as $class)
                    @php
                        $pairKey = $subject->id . '_' . $class->id;
                        $taken = DB::table('teacher_subject_class')
                                    ->where('subject_id', $subject->id)
                                    ->where('school_class_id', $class->id)
                                    ->where('teacher_id', '!=', $teacher->id)
                                    ->exists();
                    @endphp
                    <option value="{{ $pairKey }}"
                        @if(in_array($pairKey, $currentPairs)) selected @endif
                        @if($taken) disabled @endif>
                        {{ $subject->name }} - کلاس {{ $class->name }} (پایه: {{ $subject->grade->name }})
                        @if($taken) - (قبلاً گرفته شده) @endif
                    </option>
                @endforeach
            @endforeach
        </select>
        <button type="submit">💾 ذخیره</button>
    </form>
</body>
</html>