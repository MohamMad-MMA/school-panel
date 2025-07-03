<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مدیریت دانش‌آموزان</title>
    @include('partials.style')
</head>
<body>
    <h2>لیست دانش‌آموزان</h2>
    <a class="add-button" href="{{ route('students.create') }}">➕ افزودن دانش‌آموز جدید</a>
    @include('partials.back-button')
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>کد ملی</th>
                <th>کلاس</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->first_name }}</td>
                    <td>{{ $student->last_name }}</td>
                    <td>{{ $student->national_code }}</td>
                    <td>{{ $student->schoolClass->name ?? '-' }}</td>
                    <td class="actions">
                        <a href="{{ route('students.transcript', $student->id) }}">📄 کارنامه</a>
                        <a href="{{ route('students.edit', $student->id) }}">✏️ ویرایش</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('مطمئنی؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">هیچ دانش‌آموزی ثبت نشده است.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>