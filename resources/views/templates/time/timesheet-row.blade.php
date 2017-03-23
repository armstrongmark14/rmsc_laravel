<tr>
    <td>{{ substr($timesheet->in, 0, 10) }}</td>
    <td>{{ substr($timesheet->in, 10, 18) }}</td>
    <td>{{ substr($timesheet->out, 10, 18) }}</td>
    <td>{{ $timesheet->hours() }}</td>
</tr>