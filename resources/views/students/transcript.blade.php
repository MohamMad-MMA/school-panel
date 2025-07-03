<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>کارنامه</title>
    <style>
        body {
            font-family: sans-serif;
            direction: rtl;
            background-color: #f9f9f9;
            padding: 40px;
        }
        h2 {
            margin-bottom: 20px;
        }
        a.back-button {
            display: inline-block;
            margin-bottom: 20px;
            background: #6c757d;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 6px;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            table-layout: fixed;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
            width: 1%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        th {
            background: #3490dc;
            color: white;
        }
        input[type="number"] {
            width: 80px;
            padding: 4px;
            text-align: center;
        }
        form {
            display: inline;
        }
        button {
            padding: 6px 12px;
            background-color: #38c172;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2f9e63;
        }
    </style>
</head>
<body>
    <h2>📄 کارنامه: {{ $student->first_name }} {{ $student->last_name }}</h2>
    <a class="back-button" href="{{ route('students.index') }}">⬅️ بازگشت به لیست دانش‌آموزان</a>
    <table>
        <thead>
            <tr>
                <th>نام درس</th>
                <th>نمره</th>
                <th>معلم</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjects as $subject)
                <tr>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->scores->first()->score ?? '---' }}</td>
                    <td>
                        @foreach($subject->teachers as $teacher)
                            {{ $teacher->first_name }} {{ $teacher->last_name }}<br>
                        @endforeach
                    </td>
                    <td>
                        <form method="POST" action="{{ route('students.updateScore', [$student->id, $subject->id]) }}">
                            @csrf
                            <input type="number" name="score" step="0.01" min="0" max="20" value="{{ $subject->scores->first()->score ?? '' }}" required>
                            <button type="submit">
                                {{ $subject->scores->first() ? '✏️ ویرایش' : '➕ ثبت' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">هیچ درسی برای پایه کلاس این دانش‌آموز تعریف نشده است.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
        <h3>معدل کل: {{ $average !== null ? number_format($average, 2) : '---' }}</h3>
</body>
</html>