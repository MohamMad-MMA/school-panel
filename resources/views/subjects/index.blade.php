<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مدیریت درس‌ها</title>
    @include('partials.style')
</head>
<body>
    <h2>لیست درس‌ها</h2>
    <a class="add-button" href="{{ route('subjects.create') }}">➕ افزودن درس جدید</a>
    @include('partials.back-button')
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>نام درس</th>
                <th>تعداد سرفصل‌ها</th>
                <th>پایه مربوطه</th>
                <th>میانگین معدل‌ها</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjects as $index => $subject)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->topics_count }}</td>
                    <td>{{ $subject->grade->name ?? '-' }}</td>
                    <td>{{ $subject->average_score }}</td>
                    <td class="actions">
                        <a href="{{ route('subjects.edit', $subject->id) }}">✏️ ویرایش</a>
                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('مطمئنی؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">هیچ درسی ثبت نشده است.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>