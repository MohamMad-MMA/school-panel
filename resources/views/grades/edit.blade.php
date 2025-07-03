<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ویرایش پایه</title>
    <style>
        body { font-family: sans-serif; direction: rtl; background: #f5f5f5; padding: 40px; }
        .form-container {
            background: white;
            padding: 30px;
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background: #3490dc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        a { text-decoration: none; margin-right: 15px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>✏️ ویرایش پایه</h2>
        @if ($errors->any())
            <div style="background-color: #f8d7da; padding: 10px; border-radius: 6px; color: #721c24; margin-bottom: 15px; border: 1px solid #f5c6cb;">
                <ul style="margin: 0; padding: 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('grades.update', $grade->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="name">نام پایه:</label>
            <input type="text" name="name" id="name" value="{{ $grade->name }}" required>
            <button type="submit">ذخیره تغییرات</button>
            <a href="{{ route('grades.index') }}">بازگشت</a>
        </form>
    </div>
</body>
</html>