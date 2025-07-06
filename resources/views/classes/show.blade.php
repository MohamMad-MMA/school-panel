<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>جزئیات کلاس</title>
    <style>
    body { font-family: sans-serif; direction: rtl; background: #f9f9f9; padding: 40px; }
    table {table-layout: fixed;}    
    th, td {
        padding: 12px;
        border: 1px solid #ccc;
        text-align: center;
        width: 1%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    th { background: #3490dc; color: white; }
        h2, h3 {
            color: #3490dc;
        }
        a.back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <h2>جزئیات کلاس: {{ $schoolClass->name }} (پایه: {{ $schoolClass->grade->name }})</h2>
    <a href="{{ route('school-classes.index') }}" class="back-btn">⬅️ بازگشت به لیست کلاس‌ها</a>
    <h3>دانش‌آموزان کلاس:</h3>
    <table>
        <thead>
            <tr>
                <th>نام</th>
                <th>معدل</th>
                <th>کارنامه دانش‌آموز</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ number_format($student->scores->avg('score') ?? 0, 2) }}</td>
                    <td>
                        <a href="{{ route('students.transcript', $student->id) }}">📄 مشاهده کارنامه</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">هیچ دانش‌آموزی در این کلاس وجود ندارد.</td></tr>
            @endforelse
        </tbody>
    </table>
<h3>دروس و معلمان کلاس:</h3>
<table>
    <thead>
        <tr>
            <th>درس</th>
            <th>معلم</th>
            <th>میانگین نمرات دانش آموزان کلاس در این درس</th>
        </tr>
    </thead>
    <tbody>
        @forelse($teachers as $entry)
            <tr>
                <td>{{ $entry['subject']->name }}</td>
                <td>{{ $entry['teacher']->first_name }} {{ $entry['teacher']->last_name }}</td>
                <td>
                    {{ $entry['average'] !== null ? number_format($entry['average'], 2) : '---' }}
                </td>
            </tr>
        @empty
            <tr><td colspan="3">معلمی برای این کلاس ثبت نشده است.</td></tr>
        @endforelse
    </tbody>
</table>
</body>
</html>