<x-app-layout>
    <x-slot name="header">
        Home
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item invisible">Home</li>
    </x-slot>

    @if (session()->exists('status'))
        <div class="mt-4">
            <x-alert-success>
                <strong>Welcome. </strong> {{ session()->get('status') }}
            </x-alert-success>
        </div>
    @endif

    <nav>
        <div class="nav nav-pills persist-default" id="nav-tab" role="tablist">
            <button class="nav-link active" id="first-year-tab" data-bs-toggle="tab" data-bs-target="#first-year"
                type="button" role="tab" aria-controls="first-year" aria-selected="true">First year</button>
            <button class="nav-link" id="nsecond-year-tab" data-bs-toggle="tab" data-bs-target="#second-year"
                type="button" role="tab" aria-controls="second-year" aria-selected="false">Second year</button>
            <button class="nav-link" id="third-year-tab" data-bs-toggle="tab" data-bs-target="#third-year"
                type="button" role="tab" aria-controls="third-year" aria-selected="false">Third year</button>
            <button class="nav-link" id="fourth-year-tab" data-bs-toggle="tab" data-bs-target="#fourth-year"
                type="button" role="tab" aria-controls="fourth-year" aria-selected="false">Fourth year</button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <!-- FIRST YEAR -->
        <div class="tab-pane fade show active" id="first-year" role="tabpanel" aria-labelledby="first-year-tab">
            <div class="py-4">
                <!-- FIRST SEMESTER -->
                <x-real.dashb-semester-course :semester="1" :courses="$firstYear"></x-real.dashb-semester-course>

                <!-- SECOND SEMESTER -->
                <x-real.dashb-semester-course :semester="2" :courses="$firstYear"></x-real.dashb-semester-course>

                <!-- THIRD SEMESTER -->
                <x-real.dashb-semester-course :semester="3" :courses="$firstYear"></x-real.dashb-semester-course>
            </div>
        </div>

        <!-- SECOND YEAR -->
        <div class="tab-pane fade" id="second-year" role="tabpanel" aria-labelledby="second-year-tab">
            <div class="py-4">
                <!-- FIRST SEMESTER -->
                <x-real.dashb-semester-course :semester="1" :courses="$secondYear"></x-real.dashb-semester-course>

                <!-- SECOND SEMESTER -->
                <x-real.dashb-semester-course :semester="2" :courses="$secondYear"></x-real.dashb-semester-course>

                <!-- THIRD SEMESTER -->
                <x-real.dashb-semester-course :semester="3" :courses="$firstYear"></x-real.dashb-semester-course>
            </div>
        </div>

        <!-- THIRD YEAR -->
        <div class="tab-pane fade" id="third-year" role="tabpanel" aria-labelledby="third-year-tab">
            <div class="py-4">
                <!-- FIRST SEMESTER -->
                <x-real.dashb-semester-course :semester="1" :courses="$thirdYear"></x-real.dashb-semester-course>

                <!-- SECOND SEMESTER -->
                <x-real.dashb-semester-course :semester="2" :courses="$thirdYear"></x-real.dashb-semester-course>

                <!-- THIRD SEMESTER -->
                <x-real.dashb-semester-course :semester="3" :courses="$firstYear"></x-real.dashb-semester-course>
            </div>
        </div>

        <!-- FOURTH YEAR -->
        <div class="tab-pane fade" id="fourth-year" role="tabpanel" aria-labelledby="fourth-yea-tab">
            <div class="py-4">
                <!-- FIRST SEMESTER -->
                <x-real.dashb-semester-course :semester="1" :courses="$fourthYear"></x-real.dashb-semester-course>

                <!-- SECOND SEMESTER -->
                <x-real.dashb-semester-course :semester="2" :courses="$fourthYear"></x-real.dashb-semester-course>

                <!-- THIRD SEMESTER -->
                <x-real.dashb-semester-course :semester="3" :courses="$firstYear"></x-real.dashb-semester-course>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            $(document).ready(function() {})
        </script>
    @endsection
</x-app-layout>
