<h3 class="h4 mb-3 text-white fw-bold text-shadow">
    Record Logs
</h3>

<div class="table-container">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h5 class="text-dark m-0">
            System Activity Logs
        </h5>

    </div>

    <div class="table-responsive">

        <table class="table table-striped table-hover m-0">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>Violation ID</th>
                    <th>Location</th>
                    <th>Date</th>
                </tr>

            </thead>

            <tbody class="table-light text-dark">

                @forelse($logs as $log)

                    <tr>

                        <td>
                            #{{ $log->id }}
                        </td>

                        <td>
                            {{ $log->user ?? 'System' }}
                        </td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $log->action }}
                            </span>
                        </td>

                        <td>
                            {{ $log->description ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $log->violation_id ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $log->location ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $log->created_at?->format('Y-m-d H:i:s') ?? 'N/A' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="text-center py-4 text-muted">

                            No system activity logs recorded yet.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>