<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>پنل مدیریت مدرسه</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            direction: rtl;
        }
        header {
            background-color: #3490dc;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            padding: 30px;
        }
        .box {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .box:hover {
            background-color: #eef6ff;
        }
        .box a {
            text-decoration: none;
            color: #3490dc;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h1>پنل مدیریت مدرسه</h1>
    </header>
    <div class="container">
        <div class="box"><a href="{{ route('students.index') }}">لیست دانش‌آموزان</a></div>
        <div class="box"><a href="{{ route('teachers.index') }}">لیست معلمان</a></div>
        <div class="box"><a href="{{ route('classes.index') }}">لیست کلاس‌ها</a></div>
        <div class="box"><a href="{{ route('subjects.index') }}">لیست درس‌ها</a></div>
        <div class="box"><a href="{{ route('grades.index') }}">لیست پایه‌ها</a></div>
    </div>
</body>
</html>