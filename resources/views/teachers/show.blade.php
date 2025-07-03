<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>جزئیات معلم</title>
    <style>
        body {
            font-family: sans-serif;
            direction: rtl;
            padding: 40px;
            background-color: #f9f9f9;
        }
        .container {
            background: white;
            padding: 30px;
            max-width: 700px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 30px;
        }
        .row {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>👤 اطلاعات معلم</h2>
        <div class="row"><span class="label">نام:</span> {{ $teacher->first_name }}</div>
        <div class="row"><span class="label">نام خانوادگی:</span> {{ $teacher->last_name }}</div>
        <div class="row"><span class="label">کد ملی:</span> {{ $teacher->national_code }}</div>
        <div class="row"><span class="label">شماره تماس:</span> {{ $teacher->phone }}</div>
        <div class="row"><span class="label">آدرس:</span> {{ $teacher->address }}</div>
        <div class="row"><span class="label">تحصیلات:</span> {{ $teacher->education_level }}</div>
        <br>
        <a href="{{ route('teachers.index') }}">⬅ بازگشت به لیست</a>
    </div>
</body>
</html>