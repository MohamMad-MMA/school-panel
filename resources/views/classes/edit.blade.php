<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ویرایش کلاس</title>
    <style>
        body { font-family: sans-serif; direction: rtl; background: #f5f5f5; padding: 40px; }
        .form-container {
            background: white;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        label { display: block; margin-top: 20px; font-weight: bold; }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background: #3490dc;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            margin-top: 25px;
            cursor: pointer;
        }
        a { display: inline-block; margin-top: 15px; text-decoration: none; color: #555; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>✏️ ویرایش کلاس</h2>
        @if ($errors->any())
            <div style="background-color: #f8d7da; padding: 10px; border-radius: 6px; color: #721c24; margin-bottom: 15px; border: 1px solid #f5c6cb;">
                <ul style="margin: 0; padding: 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('classes.update', $class->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="name">نام یا شماره کلاس:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $class->name) }}" required>
            <label for="grade_id">پایه:</label>
            <select name="grade_id" id="grade_id" required>
                <option value="">— انتخاب کنید —</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ $class->grade_id == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit">ذخیره تغییرات</button>
            <a href="{{ route('classes.index') }}">بازگشت</a>
        </form>
    </div>
</body>
</html>