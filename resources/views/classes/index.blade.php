<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مدیریت کلاس‌ها</title>
    @include('partials.style')
</head>
<body>
    <h2>لیست کلاس‌ها</h2>
    <a class="add-button" href="{{ route('classes.create') }}">➕ افزودن کلاس جدید</a>
    @include('partials.back-button')
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>نام کلاس</th>
                <th>پایه</th>
                <th>تعداد دانش‌آموزان</th>
                <th>تعداد معلمان</th>
                <th>میانگین معدل</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $index => $class)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->grade->name ?? '-' }}</td>
                    <td>{{ $class->students_count }}</td>
                    <td>{{ $class->teachers_count }}</td>
                    <td>{{ $class->average_score !== null ? number_format($class->average_score, 2) : '---' }}</td>
                    <td class="actions">
                        <a href="{{ route('classes.edit', $class->id) }}">✏️ ویرایش</a>
                        <form action="{{ route('classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('مطمئنی؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">هیچ کلاسی ثبت نشده است.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>