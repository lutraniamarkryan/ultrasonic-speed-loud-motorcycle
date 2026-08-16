<h3 class="h4 mb-3 text-white fw-bold text-shadow">
    Complete System Database Logs
</h3>


<div class="table-container">


    <div class="d-flex justify-content-between align-items-center mb-3">


        <h5 class="text-dark m-0">
            All Violations
        </h5>


        <a href="{{ route('violations.create') }}"
           class="btn btn-primary">


            <i class="bi bi-plus-circle"></i>
            Add Violation


        </a>


    </div>



    <div class="table-responsive">


        <table class="table table-striped table-hover m-0">


            <thead class="table-dark">


                <tr>


                    <th>Violation ID</th>
                    <th>Plate Number</th>
                    <th>Violation Type</th>
                    <th>Recorded Speed</th>
                    <th>Decibel Level</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>


                </tr>


            </thead>



            <tbody class="table-light text-dark">


                @forelse($violations as $violation)


                    <tr>


                        {{-- ID --}}
                        <td class="text-secondary small">
                            #{{ $violation->id }}
                        </td>



                        {{-- PLATE --}}
                        <td class="fw-bold">
                            {{ $violation->plate_number ?? 'N/A' }}
                        </td>



                        {{-- TYPE --}}
                        <td>


                            @if(($violation->violation_type ?? '') == 'Both')


                                <span class="badge bg-danger">
                                    Overspeeding & Loud Pipe
                                </span>


                            @elseif(($violation->violation_type ?? '') == 'Overspeeding')


                                <span class="badge bg-warning text-dark">
                                    Overspeeding
                                </span>


                            @else


                                <span class="badge bg-info text-dark">
                                    Loud Pipe
                                </span>


                            @endif


                        </td>



                        {{-- SPEED --}}
                        <td>
                            {{ $violation->recorded_speed ?? 0 }} km/h
                        </td>



                        {{-- DECIBEL --}}
                        <td>
                            {{ $violation->decibel_level ?? 0 }} dB
                        </td>



                        {{-- LOCATION --}}
                        <td>
                            {{ $violation->location ?? 'Binalonan, Pangasinan' }}
                        </td>



                        {{-- DATE --}}
                        <td>
                            {{ $violation->created_at?->format('Y-m-d H:i:s') ?? 'N/A' }}
                        </td>



                        {{-- STATUS --}}
                        <td>


                            @if(($violation->status ?? 'Pending') == 'Pending')


                                <span class="badge bg-secondary">
                                    Pending
                                </span>


                            @else


                                <span class="badge bg-success">
                                    Resolved
                                </span>


                            @endif


                        </td>



                        {{-- ACTIONS --}}
                        <td>


                            <div class="d-flex gap-1">



                                {{-- EDIT --}}
                                <a href="{{ route('violations.edit', $violation->id) }}"
                                   class="btn btn-sm btn-warning"
                                   title="Edit">


                                    <i class="bi bi-pencil"></i>


                                </a>



                                {{-- DELETE --}}
                                <form action="{{ route('violations.destroy', $violation->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this violation?');">


                                    @csrf


                                    @method('DELETE')


                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Delete">


                                        <i class="bi bi-trash"></i>


                                    </button>


                                </form>



                                {{-- RESOLVE --}}
                                @if(($violation->status ?? 'Pending') == 'Pending')


                                    <form action="{{ route('violations.resolve', $violation->id) }}"
                                          method="POST">


                                        @csrf


                                        @method('PATCH')


                                        <button type="submit"
                                                class="btn btn-sm btn-success"
                                                title="Resolve">


                                            <i class="bi bi-check-circle"></i>


                                        </button>


                                    </form>


                                @endif



                            </div>


                        </td>


                    </tr>



                @empty


                    <tr>


                        <td colspan="9"
                            class="text-center py-4 text-muted">


                            No tracked violation items currently generated
                            in database storage.


                        </td>


                    </tr>


                @endforelse


            </tbody>


        </table>


    </div>


</div>