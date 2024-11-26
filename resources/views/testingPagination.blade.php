{{-- @dd($students) --}}
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $item)
            <tr>
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td><a>Edit</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Display pagination links -->
<div>
    {{ $students->links() }}
</div>
