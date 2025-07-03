<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ویرایش درس</title>
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
            width: 500px;
            margin: auto;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
                input {
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
    <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">نام درس:</label>
        <input type="text" name="name" value="{{ $subject->name }}" required>
        <label for="topics_count">تعداد سرفصل‌ها:</label>
        <input type="number" name="topics_count" value="{{ $subject->topics_count }}" required>
        <label for="grade_id">پایه:</label>
        <select name="grade_id" required>
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}" {{ $subject->grade_id == $grade->id ? 'selected' : '' }}>
                    {{ $grade->name }}
                </option>
            @endforeach
        </select>
        <br><br>
        <button type="submit">ثبت</button>
        <a href="{{ route('subjects.index') }}">بازگشت</a>
    </form>
</body>
</html>