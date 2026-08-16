<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Violation - Ultrasonic</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

</head>

<body class="bg-dark">

<div class="container py-5">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h3 class="mb-0">

                <i class="bi bi-pencil"></i>

                Edit Violation #{{ $violation->id }}

            </h3>

        </div>


        <div class="card-body">

            <form action="{{ route('violations.update', $violation->id) }}"
                  method="POST">

                @csrf

                @method('PUT')


                {{-- PLATE NUMBER --}}

                <div class="mb-3">

                    <label class="form-label">
                        Plate Number
                    </label>

                    <input
                        type="text"
                        name="plate_number"
                        class="form-control"
                        value="{{ old('plate_number', $violation->plate_number) }}"
                        required
                    >

                </div>


                {{-- VIOLATION TYPE --}}

                <div class="mb-3">

                    <label class="form-label">
                        Violation Type
                    </label>

                    <select
                        name="violation_type"
                        class="form-select"
                        required
                    >

                        <option value="Overspeeding"
                            {{ old('violation_type', $violation->violation_type) == 'Overspeeding' ? 'selected' : '' }}>
                            Overspeeding
                        </option>

                        <option value="Loud Pipe"
                            {{ old('violation_type', $violation->violation_type) == 'Loud Pipe' ? 'selected' : '' }}>
                            Loud Pipe
                        </option>

                        <option value="Both"
                            {{ old('violation_type', $violation->violation_type) == 'Both' ? 'selected' : '' }}>
                            Overspeeding & Loud Pipe
                        </option>

                    </select>

                </div>


                {{-- RECORDED SPEED --}}

                <div class="mb-3">

                    <label class="form-label">
                        Recorded Speed
                    </label>

                    <input
                        type="number"
                        name="recorded_speed"
                        class="form-control"
                        value="{{ old('recorded_speed', $violation->recorded_speed) }}"
                        placeholder="km/h"
                    >

                </div>


                {{-- DECIBEL LEVEL --}}

                <div class="mb-3">

                    <label class="form-label">
                        Decibel Level
                    </label>

                    <input
                        type="number"
                        name="decibel_level"
                        class="form-control"
                        value="{{ old('decibel_level', $violation->decibel_level) }}"
                        placeholder="dB"
                    >

                </div>


                {{-- LOCATION --}}

                <div class="mb-3">

                    <label class="form-label">
                        Location
                    </label>

                    <input
                        type="text"
                        name="location"
                        class="form-control"
                        value="{{ old('location', $violation->location ?? 'Binalonan, Pangasinan') }}"
                    >

                </div>


                {{-- STATUS --}}

                <div class="mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select"
                        required
                    >

                        <option value="Pending"
                            {{ old('status', $violation->status) == 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="Resolved"
                            {{ old('status', $violation->status) == 'Resolved' ? 'selected' : '' }}>
                            Resolved
                        </option>

                    </select>

                </div>


                {{-- BUTTONS --}}

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-warning"
                    >

                        <i class="bi bi-save"></i>

                        Update Violation

                    </button>


                    <a
                        href="{{ route('dashboard') }}"
                        class="btn btn-secondary"
                    >

                        <i class="bi bi-arrow-left"></i>

                        Cancel

                    </a>

                </div>


            </form>

        </div>

    </div>

</div>

</body>
</html>