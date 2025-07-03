<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ویرایش دانش‌آموز</title>
    <style>
        body { font-family: sans-serif; direction: rtl; background: #f9f9f9; padding: 40px; }
        form { background: white; padding: 20px; border-radius: 10px; width: 400px; margin: auto; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        input, select, button {
            width: 100%; margin-bottom: 15px; padding: 10px;
            border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            background: #3490dc; color: white; font-weight: bold;
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
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>نام</label>
        <input type="text" name="first_name" value="{{ $student->first_name }}" required>
        <label>نام خانوادگی</label>
        <input type="text" name="last_name" value="{{ $student->last_name }}" required>
        <label>کد ملی</label>
        <input type="text" name="national_code" value="{{ $student->national_code }}" required>
        <label>کلاس</label>
        <select name="school_class_id" required>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ $student->school_class_id == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
        <button type="submit">ثبت ویرایش</button>
    </form>
</body>
</html>