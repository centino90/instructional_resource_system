@if (session()->exists('status'))
    <div class="mb-4">
        @if (session()->get('status') == 'success')
            <x-real.alert>
                {{ session()->get('message') }}
            </x-real.alert>
        @elseif (session()->get('status') == 'fail')
            <x-real.alert :variant="'danger'">
                {{ session()->get('message') }}
            </x-real.alert>
        @endif
    </div>
@elseif($errors->any())
    <div class="mb-4">
        <x-real.alert :variant="'danger'">
            <div class="vstack gap-2">
                <span><strong>Attention!</strong> You have some validation errors.</span>

                <ul class="nav flex-column">
                    @foreach ($errors->all() as $error)
                        <li class="nav-item">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </x-real.alert>
    </div>
@endif
