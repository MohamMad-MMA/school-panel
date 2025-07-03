<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>افزودن دانش‌آموز</title>
    <style>
        body {
            font-family: sans-serif;
            direction: rtl;
            background-color: #f0f0f0;
            padding: 30px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            margin: auto;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">➕ افزودن دانش‌آموز</h2>
        @if ($errors->any())
            <div style="background-color: #f8d7da; padding: 10px; border-radius: 6px; color: #721c24; margin-bottom: 15px; border: 1px solid #f5c6cb;">
                <ul style="margin: 0; padding: 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <label>نام</label>
        <input type="text" name="first_name" required>
        <label>نام خانوادگی</label>
        <input type="text" name="last_name" required>
        <label>کد ملی</label>
        <input type="text" name="national_code" required>
        <label>کلاس</label>
        <select name="school_class_id" required>
            <option value="">انتخاب کلاس</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>
        <button type="submit">ثبت دانش‌آموز</button>
    </form>
</body>
</html>