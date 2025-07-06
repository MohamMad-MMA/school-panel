<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مدیریت معلمان</title>
    @include('partials.style')
</head>
<body>
    <h2>لیست معلمان</h2>
    <a class="add-button" href="{{ route('teachers.create') }}">➕ افزودن معلم جدید</a>
    @include('partials.back-button')
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>کد ملی</th>
                <th>درس-کلاس</th>
                <th>میانگین نمرات دانش آموزان</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $index => $teacher)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $teacher->first_name }}</td>
                    <td>{{ $teacher->last_name }}</td>
                    <td>{{ $teacher->national_code }}</td>
                    <td>
                        @foreach($teacher->subjectClasses as $item)
                            {{ $item->subject->name }} - کلاس {{ $item->schoolClass->name }}<br>
                        @endforeach
                    </td>
                    <td>{{ $teacher->average_of_averages !== null ? number_format($teacher->average_of_averages, 2) : '---' }}</td>
                    <td class="actions">
                        <a href="{{ route('teachers.show', $teacher->id) }}">📄 مشاهده</a>
                        <a href="{{ route('teachers.edit', $teacher->id) }}">✏️ ویرایش</a>
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('مطمئنی؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">هیچ معلمی ثبت نشده است.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>