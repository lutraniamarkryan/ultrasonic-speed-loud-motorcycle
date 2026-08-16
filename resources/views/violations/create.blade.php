<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Violation - Ultrasonic</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>

<body class="bg-dark">

<div class="container py-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3 class="mb-0">
                <i class="bi bi-plus-circle"></i>
                Add Violation
            </h3>

        </div>

        <div class="card-body">

            <form action="{{ route('violations.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Plate Number
                    </label>

                    <input
                        type="text"
                        name="plate_number"
                        class="form-control"
                        placeholder="Enter plate number"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Violation Type
                    </label>

                    <select
                        name="violation_type"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select violation
                        </option>

                        <option value="Overspeeding">
                            Overspeeding
                        </option>

                        <option value="Loud Pipe">
                            Loud Pipe
                        </option>

                        <option value="Both">
                            Overspeeding & Loud Pipe
                        </option>

                    </select>

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Recorded Speed
                    </label>

                    <input
                        type="number"
                        name="recorded_speed"
                        class="form-control"
                        placeholder="km/h"
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Decibel Level
                    </label>

                    <input
                        type="number"
                        name="decibel_level"
                        class="form-control"
                        placeholder="dB"
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Location
                    </label>

                    <input
                        type="text"
                        name="location"
                        class="form-control"
                        value="Binalonan, Pangasinan"
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select"
                        required
                    >

                        <option value="Pending">
                            Pending
                        </option>

                        <option value="Resolved">
                            Resolved
                        </option>

                    </select>

                </div>


                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-save"></i>
                        Save Violation

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