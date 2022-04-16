<x-app-layout>
   <x-slot name="header">
      Reports
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item active">
         Reports
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-4">
         <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
            <x-slot name="header">Navigate to</x-slot>
            <x-slot name="body">
               <ul class="nav nav-pills nav-flush persist-default flex-column gap-2">
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.index') }}" class="nav-link active">Overview</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.submissions', ['storeType' => 'all']) }}" class="nav-link">
                        <span class="material-icons md-18 align-middle">summarize</span>
                        <small>Submissions</small>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.syllabus') }}" class="nav-link">
                        <span class="material-icons md-18 align-middle">schedule_send</span>
                        <small> Ontime and Delayed Syllabus</small>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.instructors') }}" class="nav-link">
                        <span class="material-icons md-18 align-middle">settings_accessibility</span>
                        <small>Instructor Activities</small>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.courses') }}" class="nav-link">
                        <span class="material-icons md-18 align-middle">account_tree</span>
                        <small>Courses</small>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.lessons') }}" class="nav-link">
                        <span class="material-icons md-18 align-middle">cast_for_education</span>
                        <small>Lessons</small>
                     </a>
                  </li>
               </ul>
            </x-slot>
         </x-real.card>
      </div>

      <div class="col-8">
         <div class="row g-3">
            <div class="col-12">
               <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
                  <x-slot name="header">Weekly Report</x-slot>
                  <x-slot name="action">
                     <div class="hstack gap-2">
                        <x-real.input class="cardDatePicker" value="{{ date('m-d-Y') }}" :marginBottom="'0'"
                           :size="'sm'">
                           <x-slot name="label">Date</x-slot>
                        </x-real.input>

                        <button class="btn btn-light btn-sm text-primary fw-bold left">Prev</button>
                        <button class="btn btn-light btn-sm text-primary fw-bold right">Next </button>
                     </div>
                  </x-slot>
                  <x-slot name="body">
                     <div id="chart" style="height: 300px;"></div>
                  </x-slot>
               </x-real.card>
            </div>

            <div class="col-12">
               <x-real.card :vertical="'center'" id="monthlySubmissionChartCard">
                  <x-slot name="header">Monthly Report</x-slot>
                  <x-slot name="action">
                     <div class="hstack gap-2">
                        <x-real.input class="cardDatePicker" value="{{ date('m-d-Y') }}" :marginBottom="'0'"
                           :size="'sm'">
                           <x-slot name="label">Date</x-slot>
                        </x-real.input>

                        <button class="btn btn-light btn-sm text-primary fw-bold left">Prev</button>
                        <button class="btn btn-light btn-sm text-primary fw-bold right">Next </button>
                     </div>
                  </x-slot>
                  <x-slot name="body">
                     <div id="monthlyResourcesChart" class="mt-5" style="height: 300px;"></div>
                  </x-slot>
               </x-real.card>
            </div>

            <div class="col-12">
               <x-real.card :vertical="'center'" id="yearlySubmissionChartCard">
                  <x-slot name="header">Yearly Report</x-slot>
                  <x-slot name="action">
                     <div class="hstack gap-2">
                        <x-real.input class="cardDatePicker" value="{{ date('m-d-Y') }}" :marginBottom="'0'"
                           :size="'sm'">
                           <x-slot name="label">Date</x-slot>
                        </x-real.input>

                        <button class="btn btn-light btn-sm text-primary fw-bold left">Prev</button>
                        <button class="btn btn-light btn-sm text-primary fw-bold right">Next </button>
                     </div>
                  </x-slot>
                  <x-slot name="body">
                     <div id="yearlyResourcesChart" class="mt-5" style="height: 300px;"></div>
                  </x-slot>
               </x-real.card>
            </div>
         </div>
      </div>
   </div>

   @section('script')
      <!-- Charting library -->
      <script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
      <!-- Chartisan -->
      <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

      <script>
         $(document).ready(function() {

            new Datepicker($('#weeklySubmissionChartCard .cardDatePicker')[0], {
               daysOfWeekHighlighted: [0, 1, 2, 3, 4, 5, 6],
            })
            new Datepicker($('#monthlySubmissionChartCard .cardDatePicker')[0], {
               daysOfWeekHighlighted: [0, 1, 2, 3, 4, 5, 6],
               pickLevel: 1
            })
            new Datepicker($('#yearlySubmissionChartCard .cardDatePicker')[0], {
               daysOfWeekHighlighted: [0, 1, 2, 3, 4, 5, 6],
               pickLevel: 2
            })

            const weeklyResourcesChart = new Chartisan({
               el: '#chart',
               url: "@chart('resources_weekly_chart')",
               hooks: new ChartisanHooks()
                  .legend()
                  .colors()
                  .tooltip()
                  .datasets(['bar', 'bar']),
            });

            const monthlyResourcesChart = new Chartisan({
               el: '#monthlyResourcesChart',
               url: "@chart('resources_monthly_chart')",
               hooks: new ChartisanHooks()
                  .legend()
                  .colors()
                  .tooltip()
                  .datasets(['bar', 'bar']),
            });

            const yearlyResourcesChart = new Chartisan({
               el: '#yearlyResourcesChart',
               url: "@chart('resources_yearly_chart')",
               hooks: new ChartisanHooks()
                  .legend()
                  .colors()
                  .tooltip()
                  .datasets(['bar', 'bar']),
            });

            $('#weeklySubmissionChartCard .cardDatePicker').on('changeDate', function(event) {
               weeklyResourcesChart.update({
                  url: `@chart('resources_weekly_chart')?specifiedDate=${event.target.value}`,
               })
            })
            $('#monthlySubmissionChartCard .cardDatePicker').on('changeDate', function(event) {
               monthlyResourcesChart.update({
                  url: `@chart('resources_monthly_chart')?specifiedDate=${event.target.value}`,
               })
            })
            $('#yearlySubmissionChartCard .cardDatePicker').on('changeDate', function(event) {
               yearlyResourcesChart.update({
                  url: `@chart('resources_yearly_chart')?specifiedDate=${event.target.value}`,
               })
            })

            let weekInterval = '{{ now()->format('W') }}';
            $('#weeklySubmissionChartCard .btn.left').click(function(event) {
               weekInterval--;
               weeklyResourcesChart.update({
                  url: `@chart('resources_weekly_chart')?specifiedDate=${moment().isoWeek(weekInterval).startOf('week').endOf('week').format('MM/DD/Y')}`,
               })
               $('#weeklySubmissionChartCard .cardDatePicker').val(moment().isoWeek(weekInterval).startOf(
                  'week').endOf('week').format('MM/DD/Y'))
            })
            $('#weeklySubmissionChartCard .btn.right').click(function(event) {
               weekInterval++;
               weeklyResourcesChart.update({
                  url: `@chart('resources_weekly_chart')?specifiedDate=${moment().isoWeek(weekInterval).startOf('week').endOf('week').format('MM/DD/Y')}`,
               })
               $('#weeklySubmissionChartCard .cardDatePicker').val(moment().isoWeek(weekInterval).startOf(
                  'week').endOf('week').format('MM/DD/Y'))
            })

            let monthInterval = parseInt('{{ now()->format('m') }}') - 1;
            $('#monthlySubmissionChartCard .btn.left').click(function(event) {
               monthInterval--;
               monthlyResourcesChart.update({
                  url: `@chart('resources_monthly_chart')?specifiedDate=${moment().set('month', monthInterval).format('MM/DD/Y')}`,
               })
               $('#monthlySubmissionChartCard .cardDatePicker').val(moment().set('month', monthInterval)
                  .format('MM/DD/Y'))
            })
            $('#monthlySubmissionChartCard .btn.right').click(function(event) {
               monthInterval++;
               monthlyResourcesChart.update({
                  url: `@chart('resources_monthly_chart')?specifiedDate=${moment().set('month',  monthInterval).format('MM/DD/Y')}`,
               })
               $('#monthlySubmissionChartCard .cardDatePicker').val(moment().set('month', monthInterval)
                  .format('MM/DD/Y'))
            })

            let yearInterval = parseInt('{{ now()->format('Y') }}');
            $('#yearlySubmissionChartCard .btn.left').click(function(event) {
               yearInterval--;
               yearlyResourcesChart.update({
                  url: `@chart('resources_yearly_chart')?specifiedDate=${moment().set('year', yearInterval).format('MM/DD/Y')}`,
               })
               $('#yearlySubmissionChartCard .cardDatePicker').val(moment().set('year', yearInterval)
                  .format('MM/DD/Y'))
            })
            $('#yearlySubmissionChartCard .btn.right').click(function(event) {
               yearInterval++;
               yearlyResourcesChart.update({
                  url: `@chart('resources_yearly_chart')?specifiedDate=${moment().set('year',  yearInterval).format('MM/DD/Y')}`,
               })
               $('#yearlySubmissionChartCard .cardDatePicker').val(moment().set('year', yearInterval)
                  .format('MM/DD/Y'))
            })
         })
      </script>
   @endsection
</x-app-layout>
