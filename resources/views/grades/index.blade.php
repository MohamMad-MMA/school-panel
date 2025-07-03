<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مدیریت پایه‌ها</title>
    @include('partials.style')
</head>
<body>
    <h2>لیست پایه‌ها</h2>
    <a class="add-button" href="{{ route('grades.create') }}">➕ افزودن پایه جدید</a>
    @include('partials.back-button')
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>نام پایه</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grades as $index => $grade)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $grade->name }}</td>
                    <td class="actions">
                        <a href="{{ route('grades.edit', $grade->id) }}">✏️ ویرایش</a>
                        <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" onsubmit="return confirm('آیا مطمئنی؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">هیچ پایه‌ای ثبت نشده است.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>